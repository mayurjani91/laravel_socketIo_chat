<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socket.io chat </title>
<!-- css bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>

        ul{
            margin: 0px;
            padding: 0px;
            list-style: none;
        }
        ul li{
            padding: 8px;
            background: #928787;
            margin-bottom: 20px;
        }
        ul li:nth-child(2n-2){
            background: #c3c5c5;
        }
        .chat-section {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 10px;
  background-color: #fff;
}

.chat-row {
  display: flex;
}

.chat-input {
  flex: 1;
  padding: 10px;
  border-radius: 5px;
  border: none;
  outline: none;
}

       .message.other-user { text-align: left }
.message.this-user {text-align: right}
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
        <div class="chat-content">
            <ul>

            </ul>

        </div>


        <div class="chat-section">
            <div class="row chat-row">
                <div class="chat-input bg-dark text-white" id="chatInput" contenteditable="">

                </div>
            </div>
        </div>
        </div>
    </div>
</body>

<!-- jquery cdn -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<!-- socket cdn -->
<script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>

<script>
// This code is written in JavaScript and uses jQuery library to interact with the DOM.
// It also uses the Socket.IO library to enable real-time communication between the client and server.

$(function(){
    // Set up the IP address and port number for the Socket.IO server
    let ip_address = '127.0.0.1';
    let socket_port = '3000';

    // Create a new Socket.IO instance and connect to the server
    let socket = io(ip_address + ':' + socket_port);

    // Get a reference to the chat input element
    let chatInput = $('#chatInput');

    // Listen for keypress events on the chat input element
    chatInput.keypress(function(e){
        // Get the current message from the chat input element
        let message = $(this).html();

        // If the Enter key is pressed and Shift is not held down
        if(e.which === 13 && !e.shiftKey)
        {
            // If the message is not empty
            if(message !== "")
            {
                // Emit the message to the server with the 'sendChatToTheServer' event
                socket.emit('sendChatToTheServer',message);
            }
            // Clear the chat input element and append the message to the chat content
            chatInput.html('');
            $('.chat-content ul').append('<div class="message this-user"> Me : '+message+'</div>');
            // Prevent the form from submitting
            return false;
        }
    });

    // Listen for the 'sendChatToClient' event from the server
    socket.on('sendChatToClient',(message)=>{
        // Append the message to the chat content
        $('.chat-content ul').append('<div class="message other-user">'+message+'</div>');
    });
});

// The code sets up a Socket.IO client that listens for keypress events on a chat input element.
// When the Enter key is pressed, the message is emitted to the server with the 'sendChatToTheServer'
// event. The message is then appended to the chat content on the client side. When the server emits
// the 'sendChatToClient' event, the message is appended to the chat content on the client side as well.
</script>
</html>

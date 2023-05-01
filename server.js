// This code snippet is written in JavaScript and uses the Node.js runtime
// environment.  It requires three different Node.js packages to be installed: express,
// server, and socket.io.  Here's a breakdown of what each line of code does:

const express = require("express");

// This line of code imports the express package, which is a popular Node.js
// framework for building web applications. The require() function is a built-in Node.js
// function that is used to import modules from other files or packages. The const keyword
// is used to declare a constant variable named express that will reference the
// express package.

const app = express();

// This line of code imports the server package and calls its createServer()
// method with the app instance as an argument. This creates a new HTTP server that is
// configured to use the app instance as its request handler. The resulting server object is
// stored in a constant variable named server.

const server = require("http").createServer(app);

// This line of code imports the socket.io package and calls its function with
// two arguments: the server object that was created in the previous line, and an
// options object that specifies that any origin is allowed to access the server. This
// creates a new socket.io server that is attached to the server object, allowing the
// application to handle real-time, bidirectional communication between the client and
// server.  In summary, this code sets up an express application, creates an HTTP server
// with the express application as the request handler, and then sets up a socket.io
// server on top of the HTTP server to enable real-time communication between the client
// and server.

const io = require("socket.io")(server, {
    cors: { origin: "*" },
});

// Create a socket.io connection and log a message when a client connects or disconnects from the server
io.on("connection", (socket) => {
    console.log("connected");

    socket.on("sendChatToTheServer", (message) => {
        console.log(message);

        // io.sockets.emit('sendChatToClient',"Other User: "+message);

        // The `socket.broadcast.emit()` method sends a message to all connected clients
        // except the client that triggered the original event. In this case, the message being
        // sent is "other user: " concatenated with the `message` variable, which is
        // presumably a chat message that was sent by the client.   For example, if there are two
        // clients connected to the server and one client sends a chat message, the message will
        // be broadcasted to the other client using the `socket.broadcast.emit()` method,
        // which allows for real-time, bidirectional communication between clients without the
        // need for constant polling or refreshing of the page.  In summary, the
        // `socket.broadcast.emit()` method is used to emit events to all connected clients except the sender, and
        // is commonly used in real-time chat applications to send messages between clients.

        socket.broadcast.emit("sendChatToClient", "other user : " + message);
    });
    // Handle disconnection event and log a message
    socket.on("disconnect", (socket) => {
        console.log("disconnected");
    });
});

// Tell the server to listen on port 3000 and log a message when it starts
server.listen(3000, () => {
    console.log("server is running");
});

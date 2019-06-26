var app = require('http').createServer(handler)
var io = require('socket.io')(app);
var fs = require('fs');

app.listen(300);

function handler (req, res) {
    fs.readFile(__dirname + '/index.html', 
        function (err, data) {
            if (err) {
                res.writeHead(500);
                return res.end('Error loading index.html');
            }  

            res.writeHead(200);
            res.end(data);
    });
}

io.on('connection', function(socket) {
    socket.on('admin_message', function (msg) {
        socket.broadcast.emit('bimlib_note', {'header': msg.header, 'message': msg.message});
    });
});

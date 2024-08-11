const express = require('express');
const app = express();
const http = require('http').createServer(app);
const io = require('socket.io')(http, {
    cors: {
        origin: "*", // Izinkan semua origin
        methods: ["GET", "POST"]
    }
});
const cors = require('cors');

app.use(cors());

io.on('connection', (socket) => {
    socket.on('join_room', (room_id, username) => {
        socket.join(room_id);
        io.to(room_id).emit('user_joined', username);
        console.log(username + ' telah masuk ke dalam room ' + room_id);
        
        // Menyimpan informasi user
        socket.username = username;
        socket.room_id = room_id;

        const usersCount = io.sockets.adapter.rooms.get(room_id)?.size || 0;
        io.to(room_id).emit('update_user_count', usersCount);
    });
   
    socket.on('update_time', (data) => {
        io.to(data.room_id).emit('update_time', data.time);
    });
   
    socket.on('comment', (data) => {
        io.to(data.room_id).emit('new_comment', data);
        console.log(data.username + ' mengirim pesan: ' + data.message);
    });

    socket.on('video_control', (data) => {
        io.to(data.room_id).emit('video_control', data.action);
    });

    socket.on('disconnect', () => {
        if (socket.username && socket.room_id) {
            io.to(socket.room_id).emit('user_left', socket.username);
            console.log(socket.username + ' telah keluar dari room ' + socket.room_id);

            const usersCount = io.sockets.adapter.rooms.get(socket.room_id)?.size || 0;
            io.to(socket.room_id).emit('update_user_count', usersCount);
        }
    });
});

http.listen(3000, () => {
    console.log('WebSocket server running on port 3000');
});
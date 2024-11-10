import express from 'express';
import http from 'http';
import https from 'https';
import { Server } from 'socket.io';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';
import fs from 'fs';
dotenv.config();
const app = express();
const env = process.env;
let server;
async function connectToDatabase() {
    try {
const connection = await mysql.createConnection({
	host: env.DB_HOST,
	port: 3306,
	user: env.DB_USERNAME,
	password: env.DB_PASSWORD,
	database: env.DB_DATABASE,
});
} catch (error) {
	console.error('Error connecting to database:', error);
}
}
connectToDatabase();
if (env.SSL == "true") {
	const options = {
		key: fs.readFileSync("/home/ssl/privkey.pem", "utf8"),
    		cert: fs.readFileSync("/home/ssl/fullchain.pem", "utf8"),
	}; // you'll need to fill in the SSL options here
  	server = https.createServer(options, app);
} else {
  	server = http.createServer(app);
}

const io = new Server(server, {
	cors: {
	  origin: "https://bid.sa",
	  methods: ["GET", "POST"]
	}
});

app.get('/', (req, res) => {
  	res.send("server started successfully");
});

io.on('connection', (socket) => {
	socket.on("join", (data) => {
		socket.join(data.project_id);
	})
	socket.on("bid_place", (data) => {
		console.log(data);
		io.emit('bid_placed', data);
	})
});

server.listen(3000, () => {
  	console.log('listening on https://bid.sa:3000');
});

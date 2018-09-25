const WebSocket = require("ws");
const host = "localhost";
const port = 7483;
const wss = new WebSocket.Server({noServer: true, clientTracking:true, host:host, port:port});

wss.on("connection",function connection(ws){
	
	ws.on("message", function incoming(message) {
		var msg = JSON.parse(message);
		switch(msg.type){
			case "table_update":
				broadcast(JSON.stringify(msg));
				break;
		}
	});
	
	ws.on("error",function(err){
		console.log(err);
	});
});

// use the wss.clients property to loop through all current connections.
function broadcast(msg,except=null){
	wss.clients.forEach(client => {
		// For simplicity, provide the current web socket connection 
		// to exclude it from the broadcast.
		if(client != except){
			client.send(msg);
		}
	});
}

console.log("Started websocket on ws://"+host+":"+port);
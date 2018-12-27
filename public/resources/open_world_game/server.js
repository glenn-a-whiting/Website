const wss = require("wss");
const mysql = require("mysql");
const md5 = require('md5');
const host = "localhost";
const port = 2500;
const options = {noServer: true, clientTracking:true, host:host, port:port};

var server = wss.createServer(options,function (ws){
	var connectionHash = md5(ws);
	ws.hash = connectionHash;
	c = 0;
	server.clients.forEach(client => {
		if(client.hash === ws.hash) c++;
	});
	ws.uniqueHash = md5(ws.hash + "_" + c + String(new Date().valueOf()));

	// remove client from array when it disconnects
	ws.on('close',function(message){
		server.clients.some((client,i) => {
			if(client.uniqueHash === ws.uniqueHash){
				broadcast("player_disconnect", {"hash": ws.uniqueHash}, ws);
				server.clients.splice(i,1);
				return true;
			}
			else{
				return false;
			}
		});
	});
	
	// Send a response back to the connection that sent it
	ws.reply = function(type,obj){
		obj.type = type;
		ws.send(JSON.stringify(obj));
	}
	
	ws.on('message', function incoming(message) {
		try{ var data = JSON.parse(message);}
		catch(err){
			if(err.constructor == SyntaxError){
				ws.reply("error",{"error":"(Server) Incoming data JSON was malformed"});
				return;
			}
		}
		if(Object.keys(data).every(key => key != "type")){
			ws.reply("error",{"error":"(Server) Incoming data contained no type"});
		}
		data.source = ws.uniqueHash;
		
		switch(typeof data.filter){
			case "number":
				switch(data.filter){
					case 0:
						ws.reply(data.type,data);
						break;
					case 1:
						broadcast(data.type,data,ws);
						break;
					case 2:
						broadcast(data.type,data);
						break;
				}
				break;
			
			case "object":
				filteredBroadcast(data.type, data, data.filter);
				break;
			
			default:
				ws.reply("error",{"error":"(Server) Recipients badly defined."});
				break;
		}
	});
	
	ws.reply("initialize",{"hash":ws.uniqueHash});
	
	server.clients.push(ws);
	broadcast("player_connect",{"hash": ws.uniqueHash},ws);
	
}).listen(port,host,function(){
	server.clients = [];
	var address = this.address();
	console.log("Server listening on wss://"+address.address+":"+address.port);
});


function filteredBroadcast(type,obj,filter){
	server.clients.forEach(client => {
		if(filter.constructor == Array){
			if(filter.some(f => Object.keys(f).every(k => filter[k] === client[k]))){
				client.send(JSON.stringify(obj));
			}
		}
		else{
			if(Object.keys(filter).every(k => filter[k] === client[k])){
				client.send(JSON.stringify(obj));
			}
		}
	});
}


// use the wss.clients property to loop through all current connections.
function broadcast(type,obj,except=null){
	obj.type = type;
	server.clients.forEach(client => {
		if(except === null || except.uniqueHash !== client.uniqueHash){
			client.send(JSON.stringify(obj));
		}
	});
}
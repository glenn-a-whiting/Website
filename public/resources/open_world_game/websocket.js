var socket = new WebSocket("ws://ec2-52-14-176-148.us-east-2.compute.amazonaws.com:2500");

const SELF = 0;
const BROADCAST_EXCLUSIVE = 1;
const BROADCAST_INCLUSIVE = 2;

function sortObject(obj){
	let keys = Object.keys(obj).sort();
	let sorted = {};
	keys.forEach(k => sorted[k] = obj[k]);
	return sorted;
}

var error_callout_timeout;
var events = {
	"error": [
		function(msg){
			clearTimeout(error_callout_timeout);
			$("#error_callout").hide("fast",function(){
				var self = $(this);
				self.html(msg.error);
				self.show("fast",function(){
					self.css("pointer-events","auto");
					error_callout_timeout = setTimeout(function(){
						self.css("pointer-events","none");
						self.hide("fast",function(){
							self.css("display","none");
						});
					},5000);
				});
			});
		}
	]
};

// bind callback function to event
socket.receive = function(type, callback){
	if(Object.keys(events).every(e => e != type)){
		events[type] = [];
	}
	events[type].push(callback);
}

// call callback function bound to an event
socket.call = function(type, data = {}){
	if(Object.keys(events).some(e => e == type)){
		events[type].forEach(callback => callback(data));
	}
	else{
		console.log("Unbound event received. Type: " + type + ", Data: ", data);
	}
}

// Send outgoing data to the server
socket.emit = function(type, data = {}, filter = 0){
	data.type = type;
	data.filter = filter;
	try{
		var json = JSON.stringify(data);
	}
	catch(err){
		if(err.constructor == SyntaxError){
			socket.call("error",{"error":"(Client) Outgoing data JSON was malformed."});
			return;
		}
	}
	socket.send(json);

}

// response to incoming data
socket.onmessage = function(message){
	try{
		var data = JSON.parse(message.data);
	}
	catch(err){
		if(err.constructor == SyntaxError){
			socket.call("error",{"error":"(Client) Incoming data JSON was malformed."});
			console.log(message);
			return;
		}
	}

	if(data.type === undefined){
		socket.call("error",{"error":"Incoming data contained no event type."});
	}
	else{
		socket.call(data.type, data);
	}
}

$(document).ready(function(){
	// Error callout div.
	$("body").append("<div id='error_callout'>Error</div>");
	$("#error_callout").css("position","fixed");
	$("#error_callout").css("background-color","pink");
	$("#error_callout").css("border-radius","5px");
	$("#error_callout").css("border","1px solid red");
	$("#error_callout").css("text-align","center");
	$("#error_callout").css("pointer-events","");
	$("#error_callout").css("bottom","10px");
	$("#error_callout").css("right","10px");
	$("#error_callout").css("padding","10px");
	$("#error_callout").css("white-space","nowrap");
	$("#error_callout").css("overflow-x","hidden");
	$("#error_callout").css("cursor","pointer");
	$("#error_callout").css("display","none");

	$("#error_callout").click(function(){
		clearTimeout(error_callout_timeout);
		$(this).css("pointer-events","none");
		$(this).hide("fast",function(){
			$("#error_callout").css("display","none");
		});
	});

	// Close the server connection when tab or window is closed.
	$("body").on("unload",function(){
		socket.close();
	});
});

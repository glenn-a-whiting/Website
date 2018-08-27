var socket = new WebSocket("ws://localhost:7483");

socket.onmessage = function(event){
	var msg = JSON.parse(event.data);
	switch(msg.type){
		
	}
};
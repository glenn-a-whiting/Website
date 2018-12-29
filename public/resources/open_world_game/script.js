$(document).ready(function(){
	socket.receive("initialize",function(data){
		ownHash = data.hash;
		players[ownHash] = new Player(data.hash,w/2,h/2,0);

		socket.emit("player_data_request",{
			"x":players[ownHash].x - offset.x,
			"y":players[ownHash].y - offset.y,
			"r":players[ownHash].r
		},BROADCAST_EXCLUSIVE);
	});

	socket.receive("player_connect",function(data){
		socket.call("error",{"error":"New player joined."});
	});

	socket.receive("player_disconnect",function(data){
		socket.call("error",{"error":"Player left."});
		delete players[data.hash];
		players = sortObject(players);
	});

	socket.receive("player_data_request",function(data){
		players[data.source] = new Player(data.source,data.x,data.y,data.r);
		socket.emit("player_data_response",{
			"x":players[ownHash].x - offset.x,
			"y":players[ownHash].y - offset.y,
			"r":players[ownHash].r
		},{"uniqueHash":data.source});
	});

	socket.receive("player_data_response",function(data){
		players[data.source] = new Player(data.source,data.x,data.y,data.r);
		players = sortObject(players);
	});

	socket.receive("player_key",function(data){
		players[data.source].down[data.key] = (data.state == "down");
		players[data.source].x = data.x;
		players[data.source].y = data.y;
		players[data.source].r = data.r;
	});

	socket.receive("global",function(data){
		switch(data.action){
			case "reload": location.reload(); break;
			case "no_loop": noLoop(); break;
			case "socket_close": socket.close(); break;
		}
	});

	$("#square").on("change",function(){
		col = $(this).val();
	});

	$("#print").click(function(){
		$("#p").html(JSON.stringify(world));
	});

	$("#brushsize").on("input",function(){
		var newval = $("#brushsize").val();
		if(newval < 0) $("#brushsize").val(0);
		else brushsize = $("#brushsize").val();
	});

	$("#scale_input").on("input",function(){
		var newval = $("#scale_input").val();
		if(newval < 1) {
			$("#scale_input").val(1);
		}
		else {
			changeScale(Number($("#scale_input").val()));
		}
	});

	$.ajax({
		type: "GET",
		url: "./resources/Open_World_Game/world.json",
		success:function(data){
			world = data.world;
		}
	});
});

// termination animation on every client
function global_halt(){
	socket.emit("halt",{},BROADCAST_INCLUSIVE);
}

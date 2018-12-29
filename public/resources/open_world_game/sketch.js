var w = window.innerWidth - 10;
var h = window.innerHeight - 20;
var start = {
	"x":55,
	"y":0
};
var players = {};
var ownHash;
var world;

class Player {
	constructor(hash,x,y,r){
		this.hash = hash;
		this.x = x;
		this.y = y;
		this.r = r;
		this.down = {
			"w":false,
			"s":false,
			"a":false,
			"d":false
		};
	}

	draw(){
		if(this.hash !== ownHash) fill("white");
		else fill("lightblue");
		stroke("black");
		let t1 = {
			"x": this.x + cos(this.r + TAU * 0.5) * r,
			"y": this.y + sin(this.r + TAU * 0.5) * r
		};
		let t2 = {
			"x": this.x + cos(this.r + TAU * 0.125) * r,
			"y": this.y + sin(this.r + TAU * 0.125) * r
		};
		let t3 = {
			"x": this.x + cos(this.r + TAU * 0.875) * r,
			"y": this.y + sin(this.r + TAU * 0.875) * r
		};

		triangle(t1.x,t1.y,t2.x,t2.y,t3.x,t3.y);
	}

	move(){
		if(this.hash === ownHash){
			if(this.down.w){
				offset.x += cos(this.r) * s;
				offset.y += sin(this.r) * s;
			}
			if(this.down.s){
				offset.x -= cos(this.r) * s;
				offset.y -= sin(this.r) * s;
			}

			if(!square_properties[getSquare()].clip){
				for(let i = 0; i < 10000 && !square_properties[getSquare()].clip; i++){
					if(this.down.s){
						offset.x += cos(this.r) * s;
						offset.y += sin(this.r) * s;
					}
					else{
						offset.x -= cos(this.r) * s;
						offset.y -= sin(this.r) * s;
					}
				}
			}
		}
		else{
			if(this.down.w){
				this.x -= cos(this.r) * s;
				this.y -= sin(this.r) * s;
			}
			if(this.down.s){
				this.x += cos(this.r) * s;
				this.y += sin(this.r) * s;
			}

			if(!square_properties[getSquare(this)].clip){
				for(let i = 0; i < 10000 && !square_properties[getSquare(this)].clip; i++){
					if(this.down.s){
						this.x -= cos(this.r) * s;
						this.y -= sin(this.r) * s;
					}
					else{
						this.x += cos(this.r) * s;
						this.y += sin(this.r) * s;
					}
				}
			}
		}
		if(this.down.a){
			this.r -= 0.05;
		}
		if(this.down.d){
			this.r += 0.05;
		}
	}
}

function windowResized(){
	resizeCanvas(window.innerWidth - 10, window.innerHeight - 20);
}

function preload(){
	square_properties = {
		"0":{
			"render":"color",
			"image":200,
			"clip":true
		},
		"1":{
			"render":"color",
			"image":"white",
			"clip":true
		},
		"2":{
			"render":"image",
			"image":loadImage("/resources/Open_World_Game/images/path.jpg"),
			"clip":true
		},
		"3":{
			"render":"color",
			"image":"red",
			"clip":true
		},
		"4":{
			"render":"image",
			"image": loadImage("/resources/Open_World_Game/images/grass.jpg"),
			"clip":true
		},
		"5":{
			"render":"image",
			"image":loadImage("/resources/Open_World_Game/images/water.jpg"),
			"clip":true
		},
		"6":{
			"render":"image",
			"image":loadImage("/resources/Open_World_Game/images/brick.png"),
			"clip":false
		},
		undefined:{
			"render":"color",
			"image":200,
			"clip":true
		}
	};
}

function setup(){
	createCanvas(w,h);


	g = 64; //grid size
	r = g * 0.25; //player radius
	s = r * 0.5; //player speed
	col = "0";
	offset = {
		"x": (w / 2) - (start.x * g),
		"y": (h / 2) - (start.y * g)
	};

	border = {
		"left": width * 0.25,
		"right": width * 0.75,
		"top": height * 0.25,
		"bottom": height * 0.75
	};

	brushsize = 0;
}

function renderBuild(){
	stroke("black");
	for(let x = offset.x % g; x <= width; x += g){
		line(x,0,x,height);
	}

	for(let y = offset.y % g; y <= height; y += g){
		line(0,y,width,y);
	}
}

function getSquare(p = undefined){
	if(p === undefined){
		let x = String(floor(((width / 2) - offset.x) / g));
		let y = String(floor(((height / 2) - offset.y) / g));
		if(world[x] === undefined) return "0";
		if(world[x][y] === undefined) return "0";
		return world[x][y];
	}
	else{
		let x = String(floor(p.x / g));
		let y = String(floor(p.y / g));
		if(world[x] === undefined) return "0";
		if(world[x][y] === undefined) return "0";
		return world[x][y];
	}
}

function playerMotion(){
	Object.keys(players).forEach(hash => {
		players[hash].move();
	});
}

function renderPlayers(){
	Object.keys(players).forEach(hash => {
		players[hash].draw();
	});
}

function renderSelf(){
	players[ownHash].draw();
}

function renderWorld(){
	for(let x = floor(-offset.x / g); x <= floor((width - offset.x) / g); x++){
		for(let y = floor(-offset.y / g); y <= floor((height - offset.y) / g); y++){
			if(world[x] !== undefined && world[x][y] !== undefined){
				var prop = square_properties[world[x][y]];
				switch(prop.render){
					case "color":
						fill(prop.image);
						stroke(prop.image);
						rect(x*g,y*g,g,g);
						break;
					case "image":
						image(prop.image,x*g,y*g,g,g);
						break;
				}
			}
		}
	}
}

function renderHUD(){

}

function draw(){
	if(ownHash === undefined || world === undefined) return;
	background(200);

	playerMotion();


	translate(offset.x,offset.y);

	renderWorld();
	renderPlayers();

	translate(-offset.x,-offset.y);

	//renderBuild();
	renderSelf();
	renderHUD();

	// if(getSquare() == "6"){
	// 	ellipse(width/2,height/2,20);
	// }

	//if(mouseIsPressed) drawSquares();
}

function drawSquares(){
	//return;
	let pos = {
		"x": floor((mouseX - offset.x) / g),
		"y": floor((mouseY - offset.y) / g)
	};

	if(
		pos.x < floor(-offset.x / g) ||
		pos.x > floor((width - offset.x) / g) ||
		pos.y < floor(-offset.y / g) ||
		pos.y > floor((height - offset.y) / g)
	){
		return;
	}

	if(col == "0"){
		for(let x = -brushsize; x <= brushsize; x++){
			for(let y = -brushsize; y <= brushsize; y++){
				if(world[pos.x + x] !== undefined){
					if(world[pos.x + x][pos.y + y] !== undefined){
						delete world[pos.x + x][pos.y + y];
					}
					if(Object.keys(world[pos.x + x]).length === 0){
						delete world[pos.x + x];
					}
				}
			}
		}
	}
	else{
		for(let x = -brushsize; x <= brushsize; x++){
			for(let y = -brushsize; y <= brushsize; y++){
				if(world[pos.x + x] === undefined) world[pos.x + x] = {};
				world[pos.x + x][pos.y + y] = col;
			}
		}
	}
}

function mousePressed(){
	//drawSquares();
}

function keyPressed(){
	players[ownHash].down[key] = true;
	socket.emit("player_key",{
		"state":"down",
		"key":key,
		"x":players[ownHash].x - offset.x,
		"y":players[ownHash].y - offset.y,
		"r":players[ownHash].r
	},BROADCAST_EXCLUSIVE);
}

function keyReleased(){
	players[ownHash].down[key] = false;
	socket.emit("player_key",{
		"state":"up",
		"key":key,
		"x":players[ownHash].x - offset.x,
		"y":players[ownHash].y - offset.y,
		"r":players[ownHash].r
	},BROADCAST_EXCLUSIVE);
}

function changeScale(scl){
	g = scl;
	r = g * 0.25;
	s = r * 0.5;
}

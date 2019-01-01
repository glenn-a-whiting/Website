var w = window.innerWidth;
var h = window.innerHeight - 3;
var start = {
	"x":55,
	"y":0
};
var players = {};
var ownHash;
var world;
var entities;
var g = 64; //grid size
var r = g * 0.25; //player radius
var s = r * 0.5; //player speed
var offset = {
	"x": (w / 2) - (start.x * g),
	"y": (h / 2) - (start.y * g),
	"z": 0
};
var resourceLocation = "/resources/Open_World_Game/";


class Player {
	constructor(hash,x,y,r){
		this.hash = hash;
		this.x = x;
		this.y = y;
		this.z = "0";
		this.r = r;
		this.down = {
			"w":false,
			"s":false,
			"a":false,
			"d":false
		};
		this.touch = {
			"center":false,
			"inner":false,
			"outer":false,
			"x":w/2,
			"y":h/2
		};
		this.chat = {
			"content":"",
			"time":0
		};
		this.delta = {
			"x":0,
			"y":0,
			"z":0,
			"r":0
		}
	}

	draw(nofill = false){
		if(nofill) noFill();
		else if(this.hash !== ownHash) fill("white");
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

		/*if(this.chat !== ""){
			textAlign(TOP,LEFT);
			rect(this.x - 50, this.y - 120, 100, 100);
			text(this.chat.content, this.x - 50, this.y - 120);
		}

		this.chat.time--;
		if(this.chat.time === 0) this.chat.content = "";
		*/
	}

	move(touch=false,speed=1){
		if(this.down.a || this.down.ArrowLeft){
			this.r -= 0.05;
		}
		if(this.down.d || this.down.ArrowRight){
			this.r += 0.05;
		}
		if(this.hash === ownHash){
			let prev = {
				"x":offset.x,
				"y":offset.y,
				"z":offset.z,
				"r":this.r
			};

			if(this.down.w || this.down.ArrowUp || touch){
				offset.x += cos(this.r) * s * speed;
				offset.y += sin(this.r) * s * speed;
			}
			if(this.down.s || this.down.ArrowDown){
				offset.x -= cos(this.r) * s * speed;
				offset.y -= sin(this.r) * s * speed;
			}

			let delta = {
				"x" : offset.x - prev.x,
				"y" : offset.y - prev.y,
				"z" : offset.z - prev.z,
				"r" : this.r - this.r,
			};

			var rs = getRelativeSquare();
			var square = getSquare();

			if(Object.keys(tiles.walls).some(k => k === square)){
				for(let i = 0; i < 10000 && Object.keys(tiles.walls).some(k => k === getSquare()); i++){
					if(this.down.s || this.down.ArrowDown){
						offset.x += cos(this.r) * s * speed;
						offset.y += sin(this.r) * s * speed;
					}
					else{
						offset.x -= cos(this.r) * s * speed;
						offset.y -= sin(this.r) * s * speed;
					}
				}
			}

			let flag = false;
			if(square.startsWith("7_")){
				switch(square){
					case "7_s":
						if(rs.y < 0.5 && rs.y > (0.5 - ((delta.y)/g)) && delta.y > 0){
							offset.z++;
							flag = true;
						}
						else if(rs.y > 0.5 && rs.y < (0.5 - ((delta.y)/g)) && delta.y < 0){
							offset.z--;
							flag = true;
						}
						break;
					case "7_w":
						if(rs.x > 0.5 && rs.x < (0.5 - ((delta.x)/g)) && delta.x < 0){
							offset.z++;
							flag = true;
						}
						else if(rs.x < 0.5 && rs.x > (0.5 - ((delta.x)/g)) && delta.x > 0){
							offset.z--;
							flag = true;
						}
						break;
					case "7_n":
						if(rs.y > 0.5 && rs.y < (0.5 - ((delta.y)/g)) &&  delta.y < 0){
							offset.z++;
							flag = true;
						}
						else if(rs.y < 0.5 && rs.y > (0.5 - ((delta.y)/g)) &&  delta.y > 0){
							offset.z--;
							flag = true;
						}
						break;
					case "7_e":
						if(rs.x < 0.5 && rs.x > (0.5 - ((delta.x)/g)) && delta.x > 0){
							offset.z++;
							flag = true;
						}
						else if(rs.x > 0.5 && rs.x < (0.5 - ((delta.x)/g)) && delta.x < 0){
							offset.z--;
							flag = true;
						}
						break;
				}
			}
		}
		else{
			let prev = {
				"x":this.x,
				"y":this.y,
				"z":this.z,
				"r":this.r
			};

			if(this.down.w || this.down.ArrowUp){
				this.x -= cos(this.r) * s;
				this.y -= sin(this.r) * s;
			}
			if(this.down.s || this.down.ArrowDown){
				this.x += cos(this.r) * s;
				this.y += sin(this.r) * s;
			}

			let delta = {
				"x" : this.x - prev.x,
				"y" : this.y - prev.y,
				"z" : this.z - prev.z,
				"r" : this.r - this.r,
			};

			var square = getSquare(this);

			if(Object.keys(tiles.walls).some(k => k === square)){
				for(let i = 0; i < 10000 && Object.keys(tiles.walls).some(k => k === getSquare(this)); i++){
					if(this.down.s || this.down.ArrowDown){
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
	}

	addChat(text){
		this.chat = {"content":text,"time":600};
	}
}

class Entity {
	constructor(type,x,y,z,indirect=false){
		this.x = x;
		this.y = y;
		this.z = z;
		this.screen = {
			"x": (this.x * g) + (g/2),
			"y": (this.y * g) + (g/2)
		};
		this.type = type;
		if(indirect){
			switch(type){
				case "chest": return new Chest(x,y,z);
			}
		}
	}

	serialize(){}
	draw(){} // any special rendering we want to occur.
	onclick(){}
	locate(){
		console.log("entities["+this.x+"]["+this.y+"]["+this.z+"]");
	}
}

class Chest extends Entity {
	constructor(x,y,z){
		super("chest",x,y,z);
		this.items = [];
		this.dialog = {
			"content":"This chest\nis empty.",
			"active":false,
			"timer":null
		};
	}

	serialize(){
		return {
			"dialog":{
				"content":"This chest\nis empty.",
				"active":false,
				"timer":null
			}
		};
	}

	onclick(){
		this.dialog.active = true;
		this.dialog.timer = setTimeout(function(self){
			self.dialog.active = false;
			self.timer = null;
		},2000,this);
	}

	draw(){
		if(this.dialog.active){
			fill("black");
			stroke("black");
			textAlign(CENTER,CENTER);
			text(this.dialog.content, this.screen.x, this.screen.y);
		}
	}
}

function windowResized(){
	resizeCanvas(window.innerWidth, window.innerHeight);
}

// A Recursive promise call to load images one at a time
function loadImages(i=0,j=0){
	return new Promise(function(resolve,reject){
		if(j >= Object.keys(tiles).length){
			resolve("Loaded all images");
			return;
		}
		if(i >= Object.keys(tiles[Object.keys(tiles)[j]]).length){
			loadImages(0,j+1).then(function(msg){
				resolve(msg);
			}).catch(function(err){
				reject(err);
			});
			return;
		}
		var kind = Object.keys(tiles)[j];
		var key = Object.keys(tiles[kind])[i];
		var src = resourceLocation + "images/" + tiles[kind][key].source;
		if(tiles[kind][key].source === null){
			loadImages(i+1,j).then(function(msg){
				resolve(msg);
			}).catch(function(err){
				reject(err);
			});
		}
		else{
			loadImage(src,function(img){
				tiles[kind][key].image = img;
				tiles[kind][key].render = "image";
				loadImages(i+1,j).then(function(msg){
					resolve(msg);
				}).catch(function(err){
					reject(err);
				});
			},function(err){
				reject(err);
			});
		}
	});
}

function preload(){
	tiles = {
		"floor":{
			"0":{
				"render":"color",
				"image":200,
				"source":null,
				"onclick":function(x,y,z){}
			},
			"1":{
				"render":"color",
				"image":"white",
				"source":null,
				"onclick":function(x,y,z){}
			},
			"2":{
				"render":"color",
				"image":"lightgrey",
				"source":"path_small.jpg",
				"onclick":function(x,y,z){}
			},
			"3":{
				"render":"color",
				"image":"red",
				"source":null,
				"onclick":function(x,y,z){}
			},
			"4":{
				"render":"color",
				"image":"green",
				"source":"grass_small.jpg",
				"onclick":function(x,y,z){}
			},
			"5":{
				"render":"color",
				"image":"blue",
				"source":"water_small.jpg",
				"onclick":function(x,y,z){}
			},
			"7_n":{
				"render":"color",
				"image":"saddlebrown",
				"source":"stairs_small_n.png",
				"onclick":function(x,y,z){}
			},
			"7_e":{
				"render":"color",
				"image":"saddlebrown",
				"source":"stairs_small_e.png",
				"onclick":function(x,y,z){}
			},
			"7_s":{
				"render":"color",
				"image":"saddlebrown",
				"source":"stairs_small_s.png",
				"onclick":function(x,y,z){}
			},
			"7_w":{
				"render":"color",
				"image":"saddlebrown",
				"source":"stairs_small_w.png",
				"onclick":function(x,y,z){}
			},
			undefined:{
				"render":"color",
				"image":200,
				"source":null,
				"onclick":function(x,y,z){}
			}
		},
		"roof":{
			"8":{
				"render":"color",
				"image":"orange",
				"source":"brick_small.png",
				"onclick":function(x,y,z){}
			}
		},
		"walls":{ //any tile that is solid. All wall tiles are clip:false
			"6":{
				"render":"color",
				"image":"orange",
				"source":"brick_small.png",
				"onclick":function(x,y,z){}
			}
		},
		"entities":{
			"chest":{
				"render":"color",
				"image":"brown",
				"source":"chest.png"
			}
		}
	};
}

function setup(){
	createCanvas(w,h);

	showTouchGuides = false;
	col = "0";

	border = {
		"left": width * 0.25,
		"right": width * 0.75,
		"top": height * 0.25,
		"bottom": height * 0.75
	};

	dialog = {
		"chat":{
			"active":false,
			"content":""
		}
	};

	overlay = {
		"touch":{
			"center":{
				"active":false,
				"r1":0,
				"r2": w > h ? h * 0.4 : w * 0.4
			},
			"inner":{
				"active":false,
				"r1":w > h ? h * 0.4 : w * 0.4,
				"r2":w > h ? h * 0.7 : w * 0.7
			},
			"outer":{
				"active":false,
				"r1":w > h ? h * 0.7 : w * 0.7,
				"r2":w > h ? h * 1 : w * 1
			}
		}
	};

	textSize(20);
	brushsize = 0;

	loadImages().then(function(msg){
		//console.log(msg);
	}).catch(function(err){
		console.log(err);
	});
}

function renderGrid(){
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
		let z = String(offset.z);
		if(world[x] === undefined) return "0";
		if(world[x][y] === undefined) return "0";
		if(world[x][y][z] === undefined) return "0";
		if(world[x][y][z][0] === undefined) return "0";
		return world[x][y][z][0];
	}
	else{
		let x = String(floor(p.x / g));
		let y = String(floor(p.y / g));
		let z = String(p.z);
		if(world[x] === undefined) return "0";
		if(world[x][y] === undefined) return "0";
		if(world[x][y][z] === undefined) return "0";
		if(world[x][y][z][0] === undefined) return "0";
		return world[x][y][z][0];
	}
}

function getRelativeSquare(){
	return {
		"x": abs((offset.x - (w/2)) % g) / g,
		"y": abs((offset.y - (h/2)) % g) / g,
		"z": offset.z
	};
}

function playerMotion(){
	Object.keys(players).forEach(hash => {
		players[hash].move();
	});
}

function renderPlayers(nofill=false){
	Object.keys(players).forEach(hash => {
		if(players[hash] === offset.z){
			players[hash].draw(nofill);
		}
	});
}

function renderSelf(nofill=false){
	players[ownHash].draw(nofill);
}

function renderFloor(){
	for(let x = floor(-offset.x / g); x <= floor((width - offset.x) / g); x++){
		for(let y = floor(-offset.y / g); y <= floor((height - offset.y) / g); y++){
			if(world[x] !== undefined && world[x][y] !== undefined && world[x][y][offset.z] !== undefined){
				var key = world[x][y][offset.z][0];
				if(tiles.floor[key] === undefined) continue;
				var	prop = tiles.floor[key];
				renderTile(x,y,prop);
			}
		}
	}
}

function renderWalls(){
	for(let x = floor(-offset.x / g); x <= floor((width - offset.x) / g); x++){
		for(let y = floor(-offset.y / g); y <= floor((height - offset.y) / g); y++){
			if(world[x] !== undefined && world[x][y] !== undefined && world[x][y][offset.z] !== undefined){
				var key = world[x][y][offset.z][0];
				if(tiles.walls[key] === undefined) continue;
				var	prop = tiles.walls[key];
				renderTile(x,y,prop);
			}
		}
	}
}

function renderRoof(){
	for(let x = floor(-offset.x / g); x <= floor((width - offset.x) / g); x++){
		for(let y = floor(-offset.y / g); y <= floor((height - offset.y) / g); y++){
			if(world[x] !== undefined && world[x][y] !== undefined && world[x][y][offset.z] !== undefined){
				var key = world[x][y][offset.z][0];
				if(tiles.roof[key] === undefined) continue;
				var	prop = tiles.roof[key];
				renderTile(x,y,prop);
			}
		}
	}
}

function renderEntities(){
	for(let x = floor(-offset.x / g); x <= floor((width - offset.x) / g); x++){
		for(let y = floor(-offset.y / g); y <= floor((height - offset.y) / g); y++){
			if(world[x] !== undefined && world[x][y] !== undefined && world[x][y][offset.z] !== undefined && world[x][y][offset.z][1] !== undefined){
				var key = world[x][y][offset.z][1];
				if(tiles.entities[key] === undefined) continue;
				var	prop = tiles.entities[key];
				renderTile(x,y,prop);
				entities[x][y][offset.z].draw();
			}
		}
	}
}

function renderWorld(){
	translate(offset.x,offset.y);
	renderFloor();
	renderPlayers();
	translate(-offset.x,-offset.y);
	renderSelf();
	translate(offset.x,offset.y);
	renderWalls();
	renderEntities();
	renderRoof();
	translate(-offset.x,-offset.y);
	renderSelf(true);
}

function renderTile(x,y,prop){
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

function renderHUD(){
	/*if(dialog.chat.active){
		let box = {
			"x":10, "y":10, "w": w - 40, "h": 30
		};
		fill("white");
		stroke("black");
		rect(box.x,height-(box.y+box.h),box.w,box.h);

		fill("black");
		textAlign(LEFT,CENTER);

		text(dialog.chat.content,box.x+5,height - (box.y+(box.h/2)));
	}
	else{
		textAlign(RIGHT,BOTTOM);
		fill("white");
		stroke("black");
		text("(T)alk",w - 30,h - 20);
	}*/
}

function renderOverlays(){
	Object.keys(overlay.touch).forEach(region => {
		if(overlay.touch[region].active){
			stroke(0,0,255,25);
			thickness = (overlay.touch[region].r2 - overlay.touch[region].r1) / 2;
			strokeWeight(thickness);
			noFill();
			ellipse(w/2, h/2, overlay.touch[region].r1 + (overlay.touch[region].r2 - overlay.touch[region].r1) / 2);
			strokeWeight(1);

			switch(region){
				case "center":
					players[ownHash].move(true,0);
					break;
				case "inner":
					players[ownHash].move(true,0.5);
					break;
				case "outer":
					players[ownHash].move(true,1);
					break;
			}
		}
		strokeWeight(2);
		if(showTouchGuides){
			noFill();
			stroke(0,0,0);
			for(let i = 0; i < 4; i++){
				arc(
					w/2,
					h/2,
					overlay.touch[region].r2,
					overlay.touch[region].r2,
					(TAU/4*i) - 0.05,
					(TAU/4*i) + 0.05
				);
			}
		}
		strokeWeight(1);
	});
}

function draw(){
	if(ownHash === undefined || world === undefined) return;
	background(200);
	playerMotion();
	renderWorld();
	//renderGrid();
	renderHUD();
	renderOverlays();
	//if(mouseIsPressed) drawSquares();
}

function drawSquares(){
	let pos = {
		"x": floor((mouseX - offset.x) / g),
		"y": floor((mouseY - offset.y) / g),
		"z": offset.z
	};

	if(
		pos.x < floor(-offset.x / g) ||
		pos.x > floor((width - offset.x) / g) ||
		pos.y < floor(-offset.y / g) ||
		pos.y > floor((height - offset.y) / g)
	){
		return;
	}

	if(Number(col) <= 0){
		for(let x = -brushsize; x <= brushsize; x++){
			for(let y = -brushsize; y <= brushsize; y++){
				if(world[pos.x + x] !== undefined){
					if(world[pos.x + x][pos.y + y] !== undefined){
						if(world[pos.x + x][pos.y + y][pos.z] !== undefined){
							if(col == "0") world[pos.x + x][pos.y + y][pos.z][0] = null
							else world[pos.x + x][pos.y + y][pos.z][1] = null;
							if(world[pos.x + x][pos.y + y][pos.z][0] == null && world[pos.x + x][pos.y + y][pos.z][1] == null){
								delete world[pos.x + x][pos.y + y][pos.z];
							}
						}
						if(Object.keys(world[pos.x + x][pos.y + y]).length === 0){
							delete world[pos.x + x][pos.y + y];
						}
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
				if(col.startsWith("#")){
					if(entities[pos.x + x] === undefined) entities[pos.x + x] = {};
					if(entities[pos.x + x][pos.y + y] === undefined) entities[pos.x + x][pos.y + y] = {};
					world[pos.x + x][pos.y + y][pos.z][1] = col.substr(1);
					entities[pos.x + x][pos.y + y][pos.z] = new Entity(col.substr(1),pos.x,pos.y,pos.z,true);
				}
				else{
					if(world[pos.x + x] === undefined) world[pos.x + x] = {};
					if(world[pos.x + x][pos.y + y] === undefined) world[pos.x + x][pos.y + y] = {};
					if(world[pos.x + x][pos.y + y][pos.z] === undefined) world[pos.x + x][pos.y + y][pos.z] = [null,null];
					world[pos.x + x][pos.y + y][pos.z][0] = col;
				}
			}
		}
	}
}

function mousePressed(){
	let pos = {
		"x": floor((mouseX - offset.x) / g),
		"y": floor((mouseY - offset.y) / g),
		"z": offset.z
	};
	// if(keyIsDown(16) && mouseX >= 0 && mouseX <= w && mouseY >= 0 && mouseY <= h){
	//  	drawSquares();
	// 	return;
	// }
	// if(keyIsDown(17)){
	// 	if(entities[pos.x] !== undefined && entities[pos.x][pos.y] !== undefined && entities[pos.x][pos.y][pos.z] !== undefined){
	// 		let entity = entities[pos.x][pos.y][pos.z];
	// 		entity.locate();
	// 	}
	// 	return;
	// }

	if(world[pos.x] === undefined) return;
	if(entities[pos.x] === undefined) return;
	if(world[pos.x][pos.y] === undefined) return;
	if(entities[pos.x][pos.y] === undefined) return;
	if(world[pos.x][pos.y][pos.z] === undefined) return;
	if(entities[pos.x][pos.y][pos.z] === undefined) return;
	if(world[pos.x][pos.y][pos.z][0] == undefined) return;
 	let square = world[pos.x][pos.y][pos.z][0];
	let entity = entities[pos.x][pos.y][pos.z];
	Object.keys(tiles).some(type => {
		if(tiles[type][square] !== undefined){
			tiles[type][square].onclick(pos.x,pos.y,pos.z);
			return true;
		}
		return false;
	});
	entity.onclick();
}

function keyPressed(){
	/*if(dialog.chat.active){
		switch(keyCode){
			case ESCAPE:
				dialog.chat.active = false;
				break;

			case BACKSPACE:
				dialog.chat.content = dialog.chat.content.substr(0,dialog.chat.content.length-1);
				break;

			case ENTER:
				socket.emit("chat",{"content":dialog.chat.content},BROADCAST_INCLUSIVE);
				dialog.chat.active = false;
				break;

			default:
				dialog.chat.content += key;
				break;
		}

		return;
	}
	if(key === "t") dialog.chat.active = true;
	*/
	players[ownHash].down[key] = true;
	socket.emit("player_key",{
		"state":"down",
		"key":key,
		"x":players[ownHash].x - offset.x,
		"y":players[ownHash].y - offset.y,
		"z":offset.z,
		"r":players[ownHash].r
	},BROADCAST_EXCLUSIVE);
}

function keyReleased(){
	//if(dialog.chat.active) return;
	players[ownHash].down[key] = false;
	socket.emit("player_key",{
		"state":"up",
		"key":key,
		"x":players[ownHash].x - offset.x,
		"y":players[ownHash].y - offset.y,
		"z":offset.z,
		"r":players[ownHash].r
	},BROADCAST_EXCLUSIVE);
}

function mouseDragged(){}

function mouseWheel(event){
	// if(event.delta > 0){
	// 	offset.z++;
	// }
	// else if(event.delta < 0){
	// 	offset.z--;
	// }
}

function touchStarted(e){
	showTouchGuides = true;
	let x = touches[0].x;
	let y = touches[0].y;
	let radius = abs(dist(w/2,h/2,x,y)*2);
	players[ownHash].r = atan2((h/2) - y, (w/2) - x);

	Object.keys(overlay.touch).forEach(region => {
		overlay.touch[region].active = (radius >= overlay.touch[region].r1) && (radius < overlay.touch[region].r2);
	});
	return false;
}

function touchMoved(){
	let x = touches[0].x;
	let y = touches[0].y;
	let radius = abs(dist(w/2,h/2,x,y)*2);
	players[ownHash].r = atan2((h/2) - y, (w/2) - x);

	Object.keys(overlay.touch).forEach(region => {
		overlay.touch[region].active = (radius >= overlay.touch[region].r1) && (radius < overlay.touch[region].r2);
	});
	return false;
}

function touchEnded(e){
	Object.keys(overlay.touch).forEach(region => {
		overlay.touch[region].active = false;
	});
	return false;
}

function changeScale(scl){
	g = scl;
	r = g * 0.25;
	s = r * 0.5;
}

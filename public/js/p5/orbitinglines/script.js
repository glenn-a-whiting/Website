class Entity{  
	constructor(min,max){
		this.position = [];
		this.previous = [];
		this.momentum = [];
		
		for(let i = 0; i < dimensions; i++){ //points are placed at a random location in a hypercube
			let r = random(min,max);
			this.position.push(r);
			this.previous.push(r);
			this.momentum.push(0);
		}
	}
	
	prepare(){
		let m = [];
		for(let i = 0; i < dimensions; i++) m.push(0);
		let l = collection.length;
		
		for(let j in collection){
			let e = collection[j];
			if(e !== this){
				let d1 = [];
				let d2 = [];
				let dst = 0;
				for(let i = 0; i < dimensions; i++) {
					d1.push(this.position[i])				
					d2.push(e.position[i]);
					dst += pow(d2[i] - d1[i], 2);
				}
				dst = sqrt(dst);
				for(let i = 0; i < dimensions; i++) m[i] += (d2[i] - d1[i]) * (1/scale) / dst;
			}
		}
		
		for(let i = 0; i < dimensions; i++) this.momentum[i] += m[i] / l;
	}
  
	move(){
		let now = [];
		for(let i = 0; i < dimensions; i++){
			now.push(this.position[i]);
			this.position[i] += this.momentum[i];
		}
		
		this.previous.splice(0,0,now);
		
		if(this.previous.length > trailLength+1) this.previous.pop();
	}
  
	draw(displayX,displayY,x1,y1,x2,y2){ //parameters are used to create a picture-in-picture framing effect.
		ellipse(
			map(this.position[displayX],0,width,x1,x2),
			map(this.position[displayY],0,height,y1,y2),
			0
		);
		
		for(let t = 1; Boolean(this.previous[t]) && t < trailLength; t++){
			line(
				map(this.previous[t-1][displayX],0,width,x1,x2),
				map(this.previous[t-1][displayY],0,height,y1,y2),
				map(this.previous[t][displayX],0,width,x1,x2),
				map(this.previous[t][displayY],0,height,y1,y2)
			);
		}
	}
}

function prepare(){
	for(let i in collection){
		collection[i].prepare();
	}
}

function move(){
	for(let i in collection){
		collection[i].move();
	}
}

function display(x,y,x1=0,y1=0,x2=width,y2=height){
	for(let i in collection){
		collection[i].draw(x,y,x1,y1,x2,y2);
	}
}

function setup() {
	main = createCanvas(windowHeight, windowHeight);
	frameRate(60);
	scale = 0.1;
	depth = 800;
	dimensions = 10;
	trailLength = 10;
	
	collection = [];
	for(let i = 0; i < 20; i++){
		append(collection,new Entity(windowHeight*0.25,windowHeight*0.75));
	}
	
	textSize(20);
	textAlign(CENTER,TOP);
	
	
	stroke(255);
	noFill();
}

function draw() {
	background(0);
	prepare();
	move();
	
	display(0,1);
	
	text("("+dimensions+"D)",width/2,0);
}
class Gear{
  constructor(x,y,radius,spokes,connection=null){
    this.x = x;
    this.y = y;
    this.rotation = 0;
    this.radius = radius;
    this.spokes = spokes;
    this.connection = connection;
  }
  
  rotate(amount,except=[]){
    this.rotation += amount;
    if(this.connection != null){
      this.connection.forEach(c => {
        if(except.every(e => e != this)){
        	c.rotate(-amount * (this.radius / c.radius),except.concat([this]));
        }
      });
    }
  }

	draw(except=[]){
    ellipse(this.x,this.y,this.radius);
    for(let i = 0; i < this.spokes; i++){
      let a = TWO_PI / this.spokes * i + this.rotation;
      let x1 = this.x + cos(a) * this.radius/2.5;
    	let y1 = this.y + sin(a) * this.radius/2.5;
    	let x2 = this.x + cos(a) * this.radius/2;
    	let y2 = this.y + sin(a) * this.radius/2;
      line(x1,y1,x2,y2);
    }
  }
}

function setup() {
  createCanvas(1000, 1000);
  mid = {
    "x":width/2,
    "y":height/2
  };
  momentum = 0;
  offset = 0;
  friction = 0.0001;
  
  G5 = new Gear(mid.x + 150 + 75 + 37.5,mid.y,25,4);
  G5.rotation = TWO_PI/8;
  
  G4 = new Gear(mid.x + 150 + 75,mid.y,50,8,[G5]);
  G3 = new Gear(mid.x + 150,mid.y - 75,50,8);
  G2 = new Gear(mid.x + 150,mid.y + 75,50,8);
  
  G1 = new Gear(mid.x + 150,mid.y,100,16,[G2,G3,G4]);
  G1.rotation = (TWO_PI/32);
  
  G0 = new Gear(mid.x,mid.y,200,32,[G1]);
  
  noFill();
  colorMode(HSB);
}

function draw() {
  background(220);
  G0.rotate(momentum);
  if(mouseIsPressed){
    momentum = (mouseY - pmouseY) / 100;
  }
  else{
    if(abs(momentum) < friction) momentum = 0;
    else if(momentum > 0) momentum -= friction;
    else momentum += friction;
  }
  
  G0.draw();
  G1.draw();
  G2.draw();
  G3.draw();
  G4.draw();
  G5.draw();
}
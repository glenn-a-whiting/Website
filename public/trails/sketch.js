function setup() {
  body = select('body');
  createCanvas(body.width, body.height);
  h = []; //history
  frameRate(60);
  l = 60
  c = []; //clicks
  colorMode(HSB);
}

function draw() {
	background(220);
	append(h, {
		"x": mouseX,
		"y": mouseY
	});
	if (h.length > l) h.shift();

	h.forEach((hist,i) => {
		fill(256/l * i,120,120);
		stroke(245/l * i,120,120);
		ellipse(hist.x, hist.y, 5);
	
		if(i !== 0){
			line(h[i-1].x,h[i-1].y,hist.x,hist.y);
		}
	});
  
	noFill();
	stroke(0);
	for(let i = 0; i < c.length; i++){
		if((c[i].r > height * 3) && (c[i].r > width * 3)){
			c.pop(i);
			i--;
		}
		else{
			c[i].r += 5;
			ellipse(c[i].x, c[i].y, c[i].r);
		}
	}
}

function mousePressed(e){
	append(c,{
		"x": mouseX,
		"y": mouseY,
		"r": 0
	});
}
function windowResized(){
	resizeCanvas(windowWidth, windowHeight);
}

function setup() {
	pageWidth = max(document.documentElement.clientWidth, document.body.clientWidth);
	pageHeight = max(document.documentElement.clientHeight, document.body.clientHeight);
	canvas = createCanvas(pageWidth, pageHeight);
	canvas.position(0,0);
	canvas.style("pointer-events","none");
	canvas.style("z-index","1");
	ripples = [];
	noFill();
	noLoop();
}

function draw() {
	clear();
	ripples.forEach(r => {
		r.r++;
		let a = map(r.r,0,100,255,0);
		stroke(120,120,255,a);
		ellipse(r.x,r.y,r.r);
	});

	ripples.forEach((r,i) => {
		if(r.r > 100){
			ripples.splice(i, 1);
		}
	});
	if(ripples.length === 0){
		ripples = [];
		noLoop();
	}
}

function mousePressed(){
	append(ripples,{
		"x":mouseX,
		"y":mouseY,
		"r":0
	});
	loop();
}

function buttonPressed(button){
	let x = button.offsetLeft + (button.offsetWidth / 2);
	let y = button.offsetTop + (button.offsetHeight / 2);
	append(ripples,{
		"x":x,
		"y":y,
		"r":0
	});
	loop();
}

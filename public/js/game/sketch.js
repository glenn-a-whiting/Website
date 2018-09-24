function pointInPolygon(x, y, vs)  {
    // ray-casting algorithm based on
    // http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html
    var inside = false;
    for (var i = 0, j = vs.length - 1; i < vs.length; j = i++) {
        var xi = vs[i][0], yi = vs[i][1];
        var xj = vs[j][0], yj = vs[j][1];

        var intersect = ((yi > y) != (yj > y)) && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
        if (intersect) inside = !inside;
    }

    return inside;
}
function setup() {
  createCanvas(windowWidth, windowHeight);
  frameRate(60);

  gameMode = "mouse";

  waitTimer = 3;

  charge = 0;
  chargeMax = 100;
  chargeRate = 1;

  playerX = width/2;
  playerY = height/2;
  playerSize = 10;
  playerSpeed = 1;
  playerBaseSpeed = 1;

  angle = 0;
  enemySpeed = 0.1;
  enemySize = 5;

  cameraOffset = {
    "x":0,
    "y":0
  };

  border = {
    "top":height * 0.25,
    "bottom":height * 0.75,
    "left":width * 0.25,
    "right":width * 0.75
  };

  enemies = [];
  for(let i = 0, r1 = 100, r2 = 10000; i < 10000;){
    let a = random(0,TWO_PI);
	let s = enemySize;
	var powerup;
	if(random(50) < 1){
		powerup = random(["machineGun","bomb","turbo"]);
		s = enemySize * 2;
	}
	else{
		powerup = null;
		i++;
	}

    append(enemies,{
      "x":playerX + cos(a) * random(r1,r2),
      "y":playerY + sin(a) * random(r1,r2),
      "s":s,
      "health":100,
	  "powerup":powerup,
      "dead":false
    });

	if(i === 0){
		let a = random(0,TWO_PI);
		append(enemies,{
		  	"x":playerX + cos(a) * random(r1,r2),
		  	"y":playerY + sin(a) * random(r1,r2),
		  	"s":enemySize,
		  	"health":100,
		  	"powerup":"superBomb",
		  	"dead":false
	    });
	}
  }

  playerPowerup = null;
  powerupMax = 0;
  powerupCharge = 0;

  score = 0;
  started = false;
  textSize(20);
  textAlign(CENTER, CENTER);
  colorMode(HSB);
 	noLoop();
}

function draw() {
  background(220);
  if(frameCount > 1){
	if(playerPowerup == "turbo"){
		powerupCharge--;
		if(powerupCharge === 0) playerPowerup = null;

		if(keyIsDown(16)) playerSpeed = 2.5;
	    else playerSpeed = 15.0;
	}
	else{
		if(keyIsDown(16)) playerSpeed = 0.25;
	    else playerSpeed = 2.0;
	}

    // Player Motion
    if(keyIsPressed && gameMode == "keyboard" || gameMode == "mouse"){
		if(gameMode == "keyboard"){
		  if(keyIsDown(65)){ // A
		    angle -= playerBaseSpeed / (10);
		  }
		  if(keyIsDown(68)){ // D
		    angle += playerBaseSpeed / (10);
		  }
		}
		else{
			angle = atan2(mouseY - playerY, mouseX - playerX);
		}

      if(keyIsDown(87)){ // W
        playerX += cos(angle) * playerSpeed;
        playerY += sin(angle) * playerSpeed;
      }
      if(keyIsDown(83)){ // S
        playerX -= cos(angle) * playerSpeed;
        playerY -= sin(angle) * playerSpeed;
      }
    }

    // Screen Motion
    if(playerX < border.left){ // near the left edge
      if(keyIsDown(87)){
        playerX -= cos(angle) * playerSpeed;
        playerY -= sin(angle) * playerSpeed;
        cameraOffset.x -= cos(angle) * playerSpeed;
        cameraOffset.y -= sin(angle) * playerSpeed;
      }
      else if(keyIsDown(83)){
        playerX += cos(angle) * playerSpeed;
        playerY += sin(angle) * playerSpeed;
        cameraOffset.x += cos(angle) * playerSpeed;
        cameraOffset.y += sin(angle) * playerSpeed;
      }
    }
    if(playerX > border.right){ // near the right edge
      if(keyIsDown(87)){
        playerX -= cos(angle) * playerSpeed;
        playerY -= sin(angle) * playerSpeed;
        cameraOffset.x -= cos(angle) * playerSpeed;
        cameraOffset.y -= sin(angle) * playerSpeed;
      }
      else if(keyIsDown(83)){
        playerX += cos(angle) * playerSpeed;
        playerY += sin(angle) * playerSpeed;
        cameraOffset.x += cos(angle) * playerSpeed;
        cameraOffset.y += sin(angle) * playerSpeed;
      }
    }
    if(playerY < border.top){ // near the top edge
      if(keyIsDown(87)){
        playerX -= cos(angle) * playerSpeed;
      	playerY -= sin(angle) * playerSpeed;
        cameraOffset.y -= sin(angle) * playerSpeed;
        cameraOffset.x -= cos(angle) * playerSpeed;
      }
      else if(keyIsDown(83)){
        playerX += cos(angle) * playerSpeed;
        playerY += sin(angle) * playerSpeed;
        cameraOffset.y += sin(angle) * playerSpeed;
        cameraOffset.x += cos(angle) * playerSpeed;
      }
    }
    if(playerY > border.bottom){ // near the bottom edge
      if(keyIsDown(87)){
        playerX -= cos(angle) * playerSpeed;
      	playerY -= sin(angle) * playerSpeed;
        cameraOffset.y -= sin(angle) * playerSpeed;
        cameraOffset.x -= cos(angle) * playerSpeed;
      }
      else if(keyIsDown(83)){
        playerX += cos(angle) * playerSpeed;
        playerY += sin(angle) * playerSpeed;
        cameraOffset.y += sin(angle) * playerSpeed;
        cameraOffset.x += cos(angle) * playerSpeed;
      }
    }


    ///////////////////////////
    /// Draw World Elements ///
    ///////////////////////////

    translate(cameraOffset.x,cameraOffset.y);

    // Draw enemies
    swarm();
    enemies.forEach(e => {
    	if(!e.dead && ((e.x + cameraOffset.x) > 0 && (e.x + cameraOffset.x) < width && (e.y + cameraOffset.y) > 0 && (e.y + cameraOffset.y) < height)){
			switch(e.powerup){
				case "machineGun":
				  	fill("blue");
					rect(e.x - e.s/2, e.y - e.s/2, e.s, e.s);
				  	break;
				case "bomb":
					fill("grey");
					rect(e.x - e.s/2, e.y - e.s/2, e.s, e.s);
					break;
				case "superBomb":
						fill("black");
						rect(e.x - e.s/2, e.y - e.s/2, e.s, e.s);
						break;
				case "turbo":
					fill("magenta");
					rect(e.x - e.s/2, e.y - e.s/2, e.s, e.s);
					break;
				case null:
				  	fill(e.health,127,127);
		        	ellipse(e.x,e.y,e.s);
					break;
			}
      	}
    });


    /////////////////////////////
    /// Draw Static Elements ///
    /////////////////////////////

    translate(-cameraOffset.x,-cameraOffset.y);
    text("score: "+score,50,15);
	switch(playerPowerup){
		case "machineGun":
			text(playerPowerup + ": ", 60, 40);
			text(powerupCharge, 150, 40);
			break;
		case "turbo":
			text(playerPowerup + ": ", 60, 40);
			text(floor(powerupCharge/60), 150, 40);
			break;
	}

    // Draw gun shot
    fill("white");
    stroke("black");
    if(mouseIsPressed || (keyIsPressed && keyIsDown(32))){
		if(playerPowerup == "machineGun"){
			powerupCharge--;
			if(powerupCharge === 0){
				playerPowerup = null;
			}
			let x1 = playerX + cos(angle+HALF_PI) * 5;
	        let y1 = playerY + sin(angle+HALF_PI) * 5;
	        let x2 = playerX + cos(angle-HALF_PI) * 5;
	        let y2 = playerY + sin(angle-HALF_PI) * 5;
	        let x3_ = playerX + cos(angle) * 1000;
	        let y3_ = playerY + sin(angle) * 1000;
	        let x3 = x3_ + cos(angle+HALF_PI) * 5;
	        let y3 = y3_ + sin(angle+HALF_PI) * 5;
	        let x4 = x3_ + cos(angle-HALF_PI) * 5;
	        let y4 = y3_ + sin(angle-HALF_PI) * 5;

			fill("red");
	        quad(x1,y1,x2,y2,x4,y4,x3,y3);
	        kill();
		}
	   	else if(charge < chargeMax){
	    	charge += chargeRate;
	    }
    }
    else{
    	if(charge > 0){
	        let x1 = playerX + cos(angle+HALF_PI) * charge/2;
	        let y1 = playerY + sin(angle+HALF_PI) * charge/2;
	        let x2 = playerX + cos(angle-HALF_PI) * charge/2;
	        let y2 = playerY + sin(angle-HALF_PI) * charge/2;
	        let x3_ = playerX + cos(angle) * 1000;
	        let y3_ = playerY + sin(angle) * 1000;
	        let x3 = x3_ + cos(angle+HALF_PI) * charge/2;
	        let y3 = y3_ + sin(angle+HALF_PI) * charge/2;
	        let x4 = x3_ + cos(angle-HALF_PI) * charge/2;
	        let y4 = y3_ + sin(angle-HALF_PI) * charge/2;

	        quad(x1,y1,x2,y2,x4,y4,x3,y3);
	        kill();
	        charge = 0;
	    }
    }

    // Draw player
    triangle(
    	playerX + cos(angle) * playerSize,
    	playerY + sin(angle) * playerSize,
    	playerX + cos(angle+HALF_PI) * playerSize/2,
    	playerY + sin(angle+HALF_PI) * playerSize/2,
    	playerX + cos(angle-HALF_PI) * playerSize/2,
    	playerY + sin(angle-HALF_PI) * playerSize/2
    );


    // Draw dotted line for aiming
    for(let x = playerX, y = playerY; x < width && y < height && x > 0 && y > 0; x += cos(angle) * 5, y += sin(angle) * 5){
      point(x,y);
    }


    // Draw charge bubble
    noFill();
    ellipse(playerX,playerY,charge);

	// draw powerup bubble
	if(playerPowerup !== null){
		arc(playerX,playerY,60,60,-HALF_PI,(TWO_PI - TWO_PI*((powerupMax - powerupCharge)/powerupMax)) - HALF_PI);
	}
  }
  else{
    // Pre-game screen
    fill("white");
    stroke("black");
    triangle(
    	playerX + cos(angle) * playerSize,
    	playerY + sin(angle) * playerSize,
    	playerX + cos(angle+HALF_PI) * playerSize/2,
    	playerY + sin(angle+HALF_PI) * playerSize/2,
    	playerX + cos(angle-HALF_PI) * playerSize/2,
    	playerY + sin(angle-HALF_PI) * playerSize/2
    );
    enemies.forEach(e => {
    	fill(100,127,127);
    	ellipse(e.x,e.y,e.s);
    });

    fill("black");
    stroke("black");
    text("Press Spacebar or click to begin\n\nControls:\n"+
         "W/S: forward/backward\n"+
         "A/D: turn\nspace: charge gun"+
         "\n\n"+
         "higher charge covers more area, but does less damage\n\nPowerups:\nPurple: Turbo\nBlue: Machine Gun\nGrey: Bomb\nBlack: Super Bomb",width/2,height/2 + 30);

  }
}

function keyPressed(){
  if(keyCode == 32 && !started){
    started = true;
	gameMode = "keyboard";
    loop();
  }
}

function mousePressed(){
  if(!started){
    start = true;
	gameMode = "mouse";
  	loop();
  }
}

function swarm(){
  enemies.forEach(e => {
    if(!e.dead){
	    let x = playerX - cameraOffset.x;
	    let y = playerY - cameraOffset.y;
		if(e.powerup === null){
	      	let a = atan2(e.y - y, e.x - x);
	      	e.x += cos(a+PI) * enemySpeed;
	      	e.y += sin(a+PI) * enemySpeed;
	  	}

	    if(dist(e.x,e.y,x,y) < e.s){
			switch(e.powerup){
				case "machineGun":
					e.dead = true;
					playerPowerup = "machineGun";
					powerupCharge = 1000;
					powerupMax = 1000;
					break;
				case "bomb":
					e.dead = true;
					fill("red");
					ellipse(e.x,e.y,1000);
					enemies.forEach(e2 => {
						if(e2.powerup === null && dist(e.x,e.y,e2.x,e2.y) < 500){
							e2.dead = true;
							enemySpeed += 0.001;
							score++;
						}
					});
					break;
				case "superBomb":
						e.dead = true;
						fill("red");
						ellipse(e.x,e.y,10000);
						enemies.forEach(e2 => {
							if(e2.powerup === null && dist(e.x,e.y,e2.x,e2.y) < 5000){
								e2.dead = true;
								enemySpeed += 0.001;
								score++;
							}
						});
						break;
				case "turbo":
					e.dead = true;
					playerPowerup = "turbo";
					powerupCharge = 60 * 20;
					powerupMax = 60 * 20;
					break;
				case null:
					if(playerPowerup != "turbo"){
						noLoop();
						stroke("red");
						fill("red");
						text("Game Over",(width/2) - cameraOffset.x,(height/2) - cameraOffset.y);
					}
					break;
			}
	    }
    }
  });
}

function kill(){
  let x1 = playerX + cos(angle+HALF_PI) * ((charge/2) + enemySize);
  let y1 = playerY + sin(angle+HALF_PI) * ((charge/2) + enemySize);
  let x2 = playerX + cos(angle-HALF_PI) * ((charge/2) + enemySize);
  let y2 = playerY + sin(angle-HALF_PI) * ((charge/2) + enemySize);
  let x3_ = playerX + cos(angle) * 1000;
  let y3_ = playerY + sin(angle) * 1000;
  let x3 = x3_ + cos(angle+HALF_PI) * ((charge/2) - enemySize);
  let y3 = y3_ + sin(angle+HALF_PI) * ((charge/2) - enemySize);
  let x4 = x3_ + cos(angle-HALF_PI) * ((charge/2) - enemySize);
  let y4 = y3_ + sin(angle-HALF_PI) * ((charge/2) - enemySize);
  enemies.forEach((e,i) => {
    if(!e.dead && e.powerup === null){
      let inBlast = pointInPolygon(e.x,e.y,[
        [x1 - cameraOffset.x, y1 - cameraOffset.y],
        [x2 - cameraOffset.x, y2 - cameraOffset.y],
        [x3 - cameraOffset.x, y3 - cameraOffset.y],
        [x4 - cameraOffset.x, y4 - cameraOffset.y]
      ]);
      if(inBlast){
        e.health -= 110 - (charge/2);
        if(e.health <= 0){
        	e.dead = true;
        	enemySpeed += 0.001;
          score++;
        }
      }
    }
  });
}

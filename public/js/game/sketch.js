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

  waitTimer = 3;

  charge = 0;
  chargeMax = 100;
  chargeRate = 1;

  playerX = width/2;
  playerY = height/2;
  playerSize = 10;
  playerSpeed = 1;

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
  for(let i = 0, r1 = 100, r2 = 2000; i < 1000; i++){
    let a = random(0,TWO_PI);
    append(enemies,{
      "x":playerX + cos(a) * random(r1,r2),
      "y":playerY + sin(a) * random(r1,r2),
      "s":enemySize,
      "health":100,
      "dead":false
    });
  }

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
    if(keyIsDown(16)) playerSpeed = 0.25;
    else playerSpeed = 1.0;

    // Player Motion
    if(keyIsPressed){
      if(keyIsDown(65)){ // A
        angle -= playerSpeed / 10;
      }
      if(keyIsDown(68)){ // D
        angle += playerSpeed / 10;
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
    swarm(keyIsDown(69));
    enemies.forEach(e => {
      if(!e.dead){
        fill(e.health,127,127);
      	ellipse(e.x,e.y,e.s);
      }
    });


    /////////////////////////////
    /// Draw Static Elements ///
    /////////////////////////////

    translate(-cameraOffset.x,-cameraOffset.y);
    text("score: "+score,50,15);

    // Draw gun shot
    fill("white");
    stroke("black");
    if(mouseIsPressed || (keyIsPressed && keyIsDown(32))){
      if(charge < chargeMax){
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
    fill("white");
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
         "higher charge covers more area, but does less damage",width/2,height/2 + 30);

  }
}

function keyPressed(){
  if(keyCode == 32 && !started){
    started = true;
    loop();
  }
}

function mousePressed(){
  if(!started){
    start = true;
  	loop();
  }
}

function swarm(hit){
  enemies.forEach(e => {
    if(!e.dead){
      let x = playerX - cameraOffset.x;
      let y = playerY - cameraOffset.y;

      let a = atan2(e.y - y, e.x - x);
      e.x += cos(a+PI) * enemySpeed;
      e.y += sin(a+PI) * enemySpeed;
	  // holding E makes you invulnerable
      if(dist(e.x,e.y,x,y) < playerSize/2 && hit){
        noLoop();
        stroke("red");
        fill("red");
        text("Game Over",(width/2) - cameraOffset.x,(height/2) - cameraOffset.y);
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
    if(!e.dead){
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
        	enemySpeed += 0.01;
          score++;
        }
      }
    }
  });
}

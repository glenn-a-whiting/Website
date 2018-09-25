function setup() {
  createCanvas(800, 800);
  points = [];
  low = 100;
  high = 700;
  count = 25;
  mid = {
    "x": width / 2,
    "y": height / 2
  };
  r = 200;

  for (let x = 0; x < count; x += 1) {
    for (let y = 0; y < count; y += 1) {
      let px = low + (((high - low) / (count - 1)) * x);
      let py = low + (((high - low) / (count - 1)) * y);

      if (x == 0 || x == count - 1 || y == 0 || y == count - 1) {
        append(points, {
          "x": px,
          "y": py
        });
        
      }
    }
  }
}

function draw() {
  background(220);
  for(let i in points) {
    let p = points[i];
    ellipse(p.x, p.y, 3);
    
    let a = atan2(mouseY - p.y, mouseX - p.x);
    let lx = mid.x+cos(a)*r;
    let ly = mid.y+sin(a)*r;
    
    ellipse(lx,ly,3);
  }
  
  //noLoop();
}
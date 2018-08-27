function setup() {
  createCanvas(800, 800);
  size = 10;
  count = 0;
  fallSpeed = 10;
  rate = 10;
  columns = [];
  for(let i = 0; i < width/size; i++){
    append(columns,[]);
  }
  frameRate(30);
  
  clr = "red";
  
  stroke(clr);
  fill(clr);
}

function draw() {
  background(220);
  for(let i = 0; i < columns.length; i++){
    for(let j = 0; j < columns[i].length; j++){
      let d = height - (size * (Number(j)+1));
      
      rect(i * size, columns[i][j], size, size);
	  
      if(columns[i][j] < (d - fallSpeed)){
      	columns[i][j] += fallSpeed;
      }
      else if(columns[i][j] > (d + fallSpeed)){
        columns[i][j] -= fallSpeed;
      }
	  else{
		columns[i][j] = d;
	  }
    }
  }
  
  if(count < ((width/size+1) * (height/size+1))){
	for(let c = 0; c < rate; c++){
		var flag = true;
		var col;
		while(flag){ //keep trying random columns until a non-full is found
		  col = floor(random(columns.length));
		  if(columns[col].length >= (height/size)){
			flag = true;
		  }
		  else{
			columns[col].push(-size - c);
				count++;
			flag = false;
		  }
		}
	}
  }
}
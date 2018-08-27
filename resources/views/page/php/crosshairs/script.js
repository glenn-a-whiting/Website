function fetchImage(){
	var dest = document.getElementById("destination");
	var img = document.crateElement("IMG");
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange(function(){
		if(this.readyState == 4 && this.status == 200){
			img.src;
			dest.appendChild(img);
		}
	});
	xhttp.open("GET", "image.php", true);
	xhttp.send();
}
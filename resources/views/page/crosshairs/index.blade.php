<html>
	<head>
		<style>
			img {
				border: 1px black solid;
			}

			#left {
				float:left;
			}

			#right {
				float:left;
			}
		</style>
		<script>
			function changeSrc(event,elem){
				elem.src = "http://localhost:8000/images/image.php?xpos="+event.offsetX+"&ypos="+event.offsetY;
			}

			function resetSrc(){
				document.getElementById("image").src = "http://localhost:8000/images/image.php?reset=true";
			}
		</script>
	</head>
	<body>
		<div id="left">
			<img id="image" src="{{asset('images/image.php')}}?reset=true" onclick="changeSrc(event,this)"/>
			<button onclick="resetSrc()">Reset</button>
		</div>

		<div id="right">
			<p>
				How it works:
				<br/><br/>
				When the image is clicked, the image src is changed to include your click position as form parameters.
				<br/>
				Changing the source means the server must fetch the image again, where it must re-render it.
				<br/>
				Your click positions are stored as a session variable, which is updated with each re-render.
				<br/>
				Until you click the reset button below.
			</p>
			<p>
				<h2>Below is the code for the interactive image. <br/>All rendering is done through the custom Canvas class, which uses the GD image library</h2>
				<code>
					require_once("Canvas.php");
					session_start();<br/>
<br/>
					// setup session //<br/><br/>
					if(isset($_GET["reset"])){<br/>
						$_SESSION["points"] = array();<br/>
					}<br/>
<br/>
					if(isset($_GET["xpos"]) && isset($_GET["ypos"])){<br/>
						if(!isset($_SESSION["points"])) $_SESSION["points"] = array();<br/>
						array_push($_SESSION["points"], $_GET["xpos"]);<br/>
						array_push($_SESSION["points"], $_GET["ypos"]);<br/>
					}<br/>
<br/>
					// render image //<br/><br/>
					$c = new Canvas(null,800,800,"png");<br/>
					$c->fill([255,255,255]);<br/>
					$c->background();<br/>
<br/>
					$c->stroke([0,0,0]);<br/>
					for($i = 1; $i < count($_SESSION["points"]); $i+=2){<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;$x = (int)$_SESSION["points"][$i-1];<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;$y = (int)$_SESSION["points"][$i];<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;$c->circle($x,$y,20);<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;$c->line($x,$y-20,$x,$y+20);<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;$c->line($x-20,$y,$x+20,$y);<br/>
					}<br/>
<br/>
					$c->draw();<br/>
				</code>
			</p>
		</div>

	</body>
</html>

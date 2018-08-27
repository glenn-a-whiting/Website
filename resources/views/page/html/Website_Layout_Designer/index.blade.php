<html onclick="mousePressed(event)" onmousemove="mouseMoved(event)">
	<head>
		<title>Bootstrap Layouter</title>
		<script src="{{('js/Website_Layout_Designer/script.js')}}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="{{asset('css/Website_Layout_Designer/style.css')}}"/>
	</head>
	<body onresize="screenResized(this)" onload="afterLoad(this)">
		<div id="main" class="every" onclick="execute(this,event)">

		</div>
	<!-- Fixed elements -->
		<div id="ch1" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch2" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch3" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch4" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="options" class="container-fluid options-top-left">
		</div>
	</body>
</html>

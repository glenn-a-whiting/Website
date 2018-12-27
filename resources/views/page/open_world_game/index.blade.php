<!doctype html>
<html>
	<head>
		<title>
			Game
		</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/p5.js"></script>
		<script src="{{asset('resources/'.$page.'/websocket.js')}}"></script>
		<script src="{{asset('resources/'.$page.'/sketch.js')}}"></script>
		<script src="{{asset('resources/'.$page.'/script.js')}}"></script>
	</head>
	<body>
		<select id="square">
			<option value="0" selected>none</option>
			<option value="1">white</option>
			<option value="2">black</option>
			<option value="3">red</option>
			<option value="4">green</option>
			<option value="5">blue</option>
		</select>
		<button id="print">Print</button>
		<input id="brushsize" type="number" value="0"/>
		<input id="scale_input" type="number" value="25"/>
		<p id="p"></p>
	</body>
</html>

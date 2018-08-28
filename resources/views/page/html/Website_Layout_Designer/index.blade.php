<html onclick="mousePressed(event)" onmousemove="mouseMoved(event)">
	<head>
		<title>Bootstrap Layouter</title>
		<script src="{{asset('js/Website_Layout_Designer/script.js')}}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="{{asset('css/Website_Layout_Designer/style.css')}}"/>
	</head>
	<body onresize="screenResized(this)" onload="afterLoad(this)">
		<!-- User-created elements -->
		<div id="main" class="every" onclick="execute(this,event)">

		</div>
	<!-- Fixed elements -->
		<div id="ch1" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch2" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch3" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch4" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="options" class="container-fluid options-top-left">
		</div>
		<div id="status-indicator" class="alert isinvisible">Operation: None</div>
		<div id="modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
	          			<h4 class="modal-title" id="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">
						<p id="modal-body"></p>
					</div>
					<div class="modal-footer">
						<button id="modal_accept" type="button" class="btn btn-success" data-dismiss="modal">Accept</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

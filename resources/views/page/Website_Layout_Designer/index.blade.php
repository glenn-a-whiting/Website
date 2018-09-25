<html onclick="mousePressed(event)" onmousemove="mouseMoved(event)">
	<head>
		<title>Bootstrap Layouter</title>
		<script src="{{asset($page.'/script.js')}}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="{{asset($page.'/style.css')}}"/>
	</head>
	<body onresize="screenResized(this)" onload="afterLoad(this)">
		<!-- User-created elements -->
		<div id="main" class="every" onclick="execute(this,event)">
			<div class="container every" onclick="execute(this,event)">
				one
				<div class="container every" onclick="execute(this,event)">
					<div class="container every" onclick="execute(this,event)">
						eu justo vehicula pellentesque id ut arcu. Maecenas et est commodo, tempor leo at, finibus lacus. Ut tristique, ligula ut malesuada ultrices, metus sem viverra
					</div>
				</div>
				<br>
				two
				<br>
				<div class="container every" onclick="execute(this,event)">
					gravida mi pretium. Aenean massa tortor, porttitor in neque sit amet, cursus vestibulum ligula. Praesent at sollicitudin lorem, lacinia commodo diam. Sed auctor interdum ullamcorper. Vestibulum varius ligula quis orci tincidunt, vehicula aliquet elit consequat. Quisque elementum augue
					<div class="container every" onclick="execute(this,event)">
						nisl, non efficitur erat nisi nec dui. Nunc non cursus mi, vitae ultrices enim. Integer laoreet congue dui sed consequat.
					</div>
					<div class="container every" onclick="execute(this,event)">
						In nec imperdiet eros. Sed auctor urna in imperdiet iaculis. Etiam ipsum
					</div>
				</div>
				<br>
				three
				<br>
				<div class="container every" onclick="execute(this,event)">
					<div class="container every" onclick="execute(this,event)">
						risus, vulputate in odio quis, vehicula condimentum leo. Fusce vitae dapibus enim. Vivamus efficitur risus
					</div>
					<div class="container every" onclick="execute(this,event)">
						at lectus gravida, consequat rhoncus odio convallis. Aliquam ut iaculis turpis. Aenean varius justo eget erat pulvinar, sed luctus dui elementum. Vestibulum ante ipsum
					</div>
					<div class="container every" onclick="execute(this,event)">
						eu justo vehicula pellentesque id ut arcu. Maecenas et est commodo, tempor leo at, finibus lacus. Ut tristique, ligula ut malesuada ultrices, metus sem viverra
					</div>
				</div>
				<br>
				four
			</div>

		</div>
	<!-- Fixed elements -->
		<!-- Crosshairs -->
		<div id="ch1" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch2" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch3" style="top:0px; left:0px; width:0px; height:0px;"></div>
		<div id="ch4" style="top:0px; left:0px; width:0px; height:0px;"></div>

		<!-- Options Menu -->
		<div id="options" class="container-fluid options-top-left"></div>

		<!-- Status Indicator -->
		<div id="status-indicator" class="alert isinvisible">Operation: None</div>

		<!-- Modal Popup Menu -->
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
						<button id="modal-accept" type="button" class="btn btn-success" data-dismiss="modal" title="This does not currently work.">Accept</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

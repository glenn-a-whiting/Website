<?php
?>
<html>
	<head>
		@include ("partials.bootstrap")
	</head>
	<body>
		<div class="jumbotron text-center"><h1>Canvas</h1></div>
		<div class="container">
			@foreach ($data["methods"] as $categoryName => $methods)
				<div class="well text-center"><h2>{{ $categoryName }}</h2></div>
					@foreach ($methods as $methodName => $method)
						<div class="panel panel-default">
							<div class="panel-heading">
								{{ $methodName }}
							</div>
								@if (count($method["parameters"]) > 0)
									@foreach ($method["parameters"] as $parameterName => $properties)
										<div class="panel-body">
											<span class="label label-default">
												{{ $parameterName }}
											</span>
											&nbsp;&nbsp;
											<span class="label label-primary">
												{{ $properties["type"] }}
											</span>
											@if (!is_null($properties["default"]))
												<span class="label label-info">{{ " = " . $properties["default"] }}</span>
											@endif
										</div>
									@endforeach
								@endif
							<div class="panel-footer">
								{{ $method["description"] }}
							</div>
						</div>

					@endforeach
			@endforeach
		</div>
	</body>
</html>

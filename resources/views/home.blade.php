<!doctype html>
<html lang="{{ app()->getLocale() }}">
	@include ("partials.head")
	<body>
		<!--	
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">WebSiteName</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a class="text-center" href="#">Home</a></li>
					<li><a class="text-center" href="#">Page 1</a></li>
					<li><a class="text-center" href="#">Page 2</a></li>
					<li><a class="text-center" href="#">Page 3</a></li>
				</ul>
			</div>
		</nav> 
		-->

		<div class="jumbotron text-center">
			<h1>Glenn Whiting's Portfolio</h1>
			<h4>A collection of created content in several languages</h4>
		</div>

		@foreach ($pages as $language => $page)
			<div class="well text-center">
				<h2>{{ $language }}</h2>
				@if (strlen($page["description"]) > 0)
				<h4>{{ $page["description"] }}</h4>
				@endif
			</div>
			<div class="row sampleRow">
				<div class="col-sm-11 sampleImage">
					<a href="/home/{{ $language }}">
						<img src="{{ $page[array_keys($page)[1]]['thumbnail'] }}" width="100%">
					</a>
				</div>
				<a href="/home/{{ $language }}">
					<div class="hidden-md-down col-sm-1 btn btn-info sampleButton">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
				</a>
			</div>
		@endforeach
	</body>
</html>

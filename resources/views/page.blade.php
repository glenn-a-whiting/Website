<!doctype html>
<html>
	@include ("partials.head")
	<body>
		<div class="jumbotron text-center">
			<h1>{{ $heading }}</h1>
			<h3>{{ $pages["description"] }}</h3>
		</div>
			@foreach (array_slice($pages,1) as $name => $page)
				<div class="well text-center">
					<h2>{{ $name }}</h2>
					@if (strlen($page["description"]) > 0)
					<h4>{{ $page["description"] }}</h4>
					@endif
				</div>
				<div class="row sampleRow">
					<div class="col-sm-11 sampleImage">
						<a href="/home/{{ $heading }}/{{ $name }}">
							<img src="{{ $page['thumbnail'] }}" width="100%"/>
						</a>
					</div>
					<a href="/home/{{ $heading }}/{{ $name }}">
						<div class="hidden-md-down col-sm-1 btn btn-info sampleButton">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</div>
					</a>
				</div>
			@endforeach
	</body>
</html>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
	@include ("partials.head")
	<style>
		#main {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
		}
		.content {
			display: inline-flex;
			flex-wrap: nowrap;
			align-items: center;
			justify-content: center;
			width: 250px;
			height: 180px;

			background-color: white;
			margin: 20px;
			border-radius: 5px;
			border: 1px solid black;

			cursor: pointer;

			transition: border-radius 0.25s, background-color 0.25s;
			text-decoration: none;
		}

		.content:hover {
			border-radius: 10px;
		}

		.content span {
			position: absolute;
			pointer-events: none;
			text-align: center;
			color: black;
			font-weight: bold;
			text-shadow: 0px 0px 5px #ffffff;
		}

		.content img {
			width: 100%;
			height: 100%;

			filter: opacity(25%);
			border-radius: 5px;
			border: 1px solid black;
			transition: border-radius 0.25s, background-color 0.25s, filter 0.25s;
		}

		.content img:hover {
			filter: opacity(90%);
			border-radius: 10px;
			background-color: black;
			text-decoration: none;
		}
	</style>
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

		<div class="well text-center">
			<h1>Glenn Whiting's Portfolio</h1>
			<h4>A collection of created content in several languages</h4>
		</div>

		<div id="main" class="container">
			@foreach ($pages as $title => $page)
				<a href="/{{$title}}" class="container content">
					<img src="{{ $page['thumbnail'] }}"/>
					<span>
						{{ implode(" ", explode("_", $title)) }}
					</span>
				</a>
			@endforeach
		</div>
	</body>
</html>

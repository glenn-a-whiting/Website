<!doctype html>
<html lang="{{ app()->getLocale() }}">
	@include ("partials.head")
	<link rel="stylesheet" href="{{asset('resources/'.$page.'/style.css')}}"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/p5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.dom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.sound.min.js"></script>
	<script src="{{asset('resources/'.$page.'/sketch.js')}}"></script>
	<body>
		<div class="well text-center">
			<h1>Glenn Whiting's Portfolio</h1>
			<h4>A collection of created content in several languages</h4>
		</div>

		<div id="main" class="container">
			@foreach ($pages as $title => $p)
				<a href="/{{$title}}" class="container content">
					@for($a = array('animated','interactive'), $i = 0, $top = 10; $i < count($a); $i++)
						@if(isset($p[$a[$i]]) && $p[$a[$i]])
							<div class="badge badge-{{$a[$i]}}" style="top:{{$top}}px;">
								{{$a[$i]}}
							</div>
							<?php $top += 20;?>
						@endif
					@endfor
					<img src="{{ $p['thumbnail'] }}"/>
					<span>
						{{ implode(" ", explode("_", $title)) }}
					</span>
				</a>
			@endforeach
		</div>
		<div style="color:lightgrey;" class="text-center">Transparent animation overlay running on this page.</div>
	</body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="{{asset($page.'/stylesheet.css')}}">
        <title>
            Cap's Cutlery Gallery Page
        </title>
    </head>
    <body>
        <div class="banner">
            <img/>
        </div>
		<h1>Cap's Cutlery</h1>
        <div>
        <navbar class="navbar">
            <div style="text-align:center">
                <span class="menu"><a href='index'>Home</a></span>
                <span class="menu"><a href='gallery'>Gallery</a></span>
                <span class="menu"><a href='contact'>Contact</a></span>
                <span class="menu"><a href='info'>Info</a></span>
                <span class="menu"><a href='http://pirates.disney.com/'>Other Ventures</a></span>
            </div>
        </navbar>
        </div>
        <div style="text-align:center">
            <p>
                Have a great gander at my store! but once you're done mate, come buy some stuff.
            </p>
            <img src="{{asset('css/Caps_Cutlery/StoreInterior1.JPG')}}" style="height:200px"/>
            <img src="{{asset('css/Caps_Cutlery/StoreInterior2.jpg')}}" style="height:200px"/>
        </div>
        <div style="text-align:center">
            <img src="{{asset($page.'/KnifeAndFork.png')}}"/>
        </div>
    </body>
</html>

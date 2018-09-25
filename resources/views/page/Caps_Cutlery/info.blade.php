<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="{{asset($page.'/stylesheet.css')}}">
        <title>
            Cap's Cutlery Info Page
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
                See where I'm at!
            </p>

            <p>
                Store location: London, Picadilly (next to the yellowey Thames)
                <br/>
                Started: About a 4 months ago, give or take
                <br/>
                Store owner: The greatest most best pirate of the seven seas, Captain Jack Sparrow.
            </p>
        </div>
        <div style="text-align:center">
            <img src="{{asset($page.'/KnifeAndFork.png')}}"/>
        </div>
    </body>
</html>


<!-- All PHP Things will be written above the doctype declaration -->

<!DOCTYPE html>
<html>
    <head>
        <title>
            Jack's Pancakes Home page
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="(min-device-width:300px)" href="{{asset('resources/'.$page.'/astyle.css')}}">
        <link rel="stylesheet" media="(max-device-width:299px)" href="{{asset('resources/'.$page.'/amobile.css')}}">
    </head>
    <body>
        <div class ="banner">
            <div class="titleContainer">
                <div class="title">
                    <div class="titleSpan">
                    Jack's
                    </div>
                    <div class="titleImage">
                        <img src="{{asset('resources/'.$page.'/pancakes.png')}}"/>
                    </div>
                    <div class="titleSpan">
                    Pancakes
                    </div>
                </div>
            </div>
        </div>
        <div class="beam">
        </div>
        <div class="navbarAndContent">
            <div class="navbar">
                <ul>
                    <li><a href="/{{$page}}/index">Home</a></li>
                    <li><a href="/{{$page}}/menu">Menu</a></li>
                    <li><a href="/{{$page}}/gallery">Gallery</a></li>
                    <li><a href="/{{$page}}/contact">Contact</a></li>
                    <li><a href="/{{$page}}/about">About</a></li>
                </ul>
            </div>
            <div class="contentContainer">
                <div class="content" id="homepage">
                    <div class="contentImage">
                        <img src="{{asset('resources/'.$page.'/pancakes.png')}}" height="200px"/>
                    </div>
                    <div class="contentText">
                        <h2>
                            Welcome, to the homepage of Jack's Pancakes!
                        </h2>
                        <br>
                        With many thanks to our web developer, we
                        now have a functional and responsive website,
                        with several pages of information relating to
                        our resturant, including:
                        <br><br><br>
                        <ul>
                            <li>A menu, to see what's cooking.</li>
                            <li>A gallery, with samples of our fine dishes</li>
                            <li>A contact page, with information on how to reach
                            us and book a table.</li>
                            <li>An about page, containing a list of our stores, and a short snippet of our history.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">

        </div>
    </body>
</html>

@include ('class.queryDb')
<?php
	$images = getImages();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Jack's Pancakes Gallery
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="(min-device-width:300px)" href="{{asset('resources/'.$page.'/astyle.css')}}">
        <link rel="stylesheet" media="(max-device-width:200px)" href="{{asset('resources/'.$page.'/amobile.css')}}">
    </head>
    <body>
        <div class ="banner">
            <div class="title">
                <div class="titleSpan">
                Jack's
                </div>
                <img src="{{asset('resources/'.$page.'/pancakes.png')}}" height="75"/>
                <div class="titleSpan">
                Pancakes
                </div>
            </div>
            <div class="beam">
            </div>
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
                <div class="content">
                    <table class="table">
                        <tbody>
                            <?php
                            foreach ($images as $image)
                            {
                                echo "<tr>";
                                echo '<td id="' . $image['PRODID'] . '">';
                                echo $image['DESCRIPTION'];
                                echo "</td>";
                                echo "<td>";
                                echo '<img src="' . $image['URL'] . '" height="150px"';
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </body>
                    </table>
                </div>
            </div>
        </div>
        <div class="footer">
        </div>
    </body>
</html>

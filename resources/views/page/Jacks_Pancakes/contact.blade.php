@include ('class.queryDb')
<?php
	$stores = getStores(null);
?>
<!-- PHP things above here -->
<!DOCTYPE html>
<html>
    <head>
        <title>
            Jack's Pancakes Contact
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
                        <thead>
                            <tr>
                                <th colspan="2">
                                Table Bookings
                                </th>
                            </tr>
                            <tr>
                                <th>Store</th>
                                <th><img src="{{asset('resources'.$page.'phone-512.png')}}" height="30px"/></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($stores as $store)
                            {
                            echo '<tr>';
                            echo '<td>';
                            echo $store['ADDRESS'];
                            echo '</td>';
                            echo '<td>';
                            echo $store['PHONE'];
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    Social Media & Email
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{asset('resources/'.$page.'/facebook.png')}}" height="50px"/>
                                </td>
                                <td>
                                    www.facebook.com/jackspancakes
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{asset('resources/'.$page.'/instagram.png')}}" height="50px"/>
                                </td>
                                <td>
                                    www.instagram.com/jackspancakes
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{asset('resources/'.$page.'/twitter.png')}}" height="50px"/>
                                </td>
                                <td>
                                    www.twitter.com/jackspancakes
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{asset('resources/'.$page.'/gmail.png')}}" height="50px"/>
                                </td>
                                <td>
                                    jacks.pancakes@gmail.com
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="footer">
        </div>
    </body>
</html>

@include ('class.queryDb')
<?php
	$products = getProducts(null);
	$drinks = getDrinks(null);
?>
<!-- PHP things above here -->
<!DOCTYPE html>
<html>
    <head>
        <title>
            Jack's Pancakes Menu
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="(min-device-width:300px)" href="{{asset('resources/'.$page.'/astyle.css')}}">
        <link rel="stylesheet" media="(max-device-width:200px)" href="{{asset('resources/'.$page.'/amobile.css')}}">
    </head>
    <body>
        <div class="banner">
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
                                <th colspan="3">
                                    Food
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    Item
                                </th>
                                <th>
                                    Description
                                </th>
                                <th class="priceColumn">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($products as $product)
                            {
                                echo "<tr>";
                                echo '<td><a href="https://workspace-1621ict-01-s5046715.c9users.io/Assignment/gallery.php#'
                                    . $product["PRODID"] . '">' . $product["PRODUCTNAME"] .
                                    "</a></td>";
                                echo "<td>". $product["DESCRIPTION"] ."</td>";
                                echo "<td>". $product["PRICE"] ."</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    Drinks
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    Item
                                </th>
                                <th class="priceColumn">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($drinks as $drink)
                            {
                                echo "<tr>";
                                echo "<td>". $drink["DRINKNAME"] ."</td>";
                                echo "<td>". $drink["PRICE"] ."</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="footer">
        </div>
    </body>
</html>

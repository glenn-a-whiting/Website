<?php
require_once "queryDb.php";
$search = $_GET["postcode"];

if ($search >= 4400 && $search <= 5000)
{
    $stores = getStores(4810);
}
elseif ($search >= 4000 && $search <= 4399)
{
    $stores = getStores(4225);
}
elseif ($search >= 3000 && $search <= 3999)
{
    $stores = getStores(3000);
}
elseif ($search >= 2300 && $search <= 2999)
{
    $stores = getStores(2450);
}
elseif ($search >= 2000 && $search <= 2399)
{
    $stores = getStores(2000);
}

else
$stores = getStores($search);
?>

<!-- PHP things above here -->
<!DOCTYPE html>
<html>
    <head>
        <title>
            About Jack's Pancakes
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="(min-device-width:300px)" href="astyle.css">
        <link rel="stylesheet" media="(max-device-width:200px)" href="amobile.css">
    </head>
    <body>
        <div class ="banner">
            <div class="title">
                <div class="titleSpan">
                Jack's 
                </div>
                <img src="pancakes.png" height="75"/>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </div>
            <div class="contentContainer">
                <div class="content">
                    <div class="forcelimit">
                        <p>
                            Our business is provide a delicious meal
                            in a warm ans welcoming enviroment.
                            <br><br>
                            Established 2014 our first store was opened,
                            in Main Street, Coolangatta. We have since expanded
                            to many other Australian cities, each store
                            giving a new group of people the opportunity to
                            taste one of our many signature recipes.
                            <br><br>
                            
                            Below, you
                            can enter your postcode (if in australia)
                            and the store closest to you will be displayed.
                        </p>
                    </div>
                    <form>
                        <fieldset class="fieldset">
                            <label>
                                <input type="text" name="postcode" placeholder="Enter your postcode"/>
                            </label>
                            <label>
                                <input type="submit" value="search"/>
                            </label>
                        </fieldset>
                    </form>
                    <div>
                        <table class="table">
                            <tbody>
                                <th>
                                    Our stores:
                                </th>
                            </tbody>
                            <tbody>
                            <?php
                                foreach ($stores as $store)
                                {
                                echo '<tr>';
                                echo '<td>';
                                echo $store["ADDRESS"];
                                echo '</td>';
                                echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
        </div>
    </body>
</html>
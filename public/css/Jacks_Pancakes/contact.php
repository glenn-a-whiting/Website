<?php
require_once "queryDb.php";
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                Table Bookings
                                </th>
                            </tr>
                            <tr>
                                <th>Store</th>
                                <th><img src='phone-512.png' height="30px"/></th>
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
                                    <img src='facebook.png' height="50px"/>
                                </td>
                                <td>
                                    www.facebook.com/jackspancakes
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src='instagram.png' height="50px"/>
                                </td>
                                <td>
                                    www.instagram.com/jackspancakes
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src='twitter.png' height="50px"/>
                                </td>
                                <td>
                                    www.twitter.com/jackspancakes
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src='gmail.png' height="50px"/>
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
<?php
	require_once("../Canvas.php");

	$host = "localhost";
	$port = 3306;
	$username = "";
	$password = "";
	$database = "Restaurant";

	$db = new mysqli($host.":".$port,$username,$password,$database);
	$results = $db->query("SELECT * FROM Dishes ORDER BY category ASC");
	$menu = array(); // The menu we will be using to build the image
	while($row = $results->fetch_assoc()){
		array_push($menu,$row);
	}
	$db->close();


	$background = new Canvas(2400,800,"png");

?>

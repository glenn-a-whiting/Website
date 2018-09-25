<?php
	$host = "localhost";
	$port = 3306;
	$username = "root";
	$password = "";
	$database = "Restaurant";
	$db = new mysqli($host, $username, $password, $database, $port);
	
	// Find the maximum quantity of all menu dishes.
	function get_dishes(){
		global $db;
		$dish_names = $db->query("SELECT name, price FROM Dishes");
		$dishes = array();
		
		while($row = $dish_names->fetch_assoc()){
			$dish_name = $row["name"];
			$dish_price = $row["price"];
			
			array_push($dishes,array(
				"name" => $dish_name,
				"price" => $dish_price,
				"quantity" => get_dish_quantity($dish_name)
			));
		}
		
		return $dishes;
	}
	
	// Find the maximum quantity of a specific dish that can be made given current stocks.
	function get_dish_quantity($dish_name){
		global $db;
		// Where we will store our results
		$results = array(); 
		
		// Get the stocks of each ingredient used in the dish
		$stock_query = "SELECT i.stock AS stock ".
			"FROM Ingredients i, Dish_Ingredients di, Dishes d ".
			"WHERE di.dish = d.id ".
			"AND di.ingredient = i.id ".
			"AND d.name = \"" . $dish_name . "\"";
		$stocks = $db->query($stock_query);
		
		// for each ingredient, determine how much more stock is available than is needed for the dish.
		while($row = $stocks->fetch_assoc()){
			$needed_quantity_query = "".
				"SELECT di.quantity ".
				"FROM Dish_Ingredients di, Dishes d ".
				"WHERE di.dish = d.id ".
				"AND d.name = \"" . $dish_name . "\"";
			$needed_quantity = $db->query($needed_quantity_query)->fetch_assoc()["quantity"];
			$results[$dish_name] = floor($row["stock"] / $needed_quantity);
		}
		
		// Determine which stock has the smallest proportion to quantity needed for the dish.
		$lowest = INF;
		foreach($results as $dish => $qty){
			if($qty < $lowest){
				$lowest = $qty;
			}
		}
		
		return $qty;
	}
?>
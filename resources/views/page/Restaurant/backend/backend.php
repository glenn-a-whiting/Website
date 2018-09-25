<?php
	require("getDishes.php");
	
	$table_numbers = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];
	
	function get_dish_ingredients($name){
		global $db;
		$results = $db->query("SELECT i.name FROM Ingredients i, Dishes d, Dish_Ingredients di WHERE di.dish = d.id AND di.ingredient = i.id AND d.name = \"" . $name . "\"");
		
		$ingredients = array();
		
		while($row = $results->fetch_assoc()){
			array_push($ingredients, $row["name"]);
		}
		
		return $ingredients;
	}

	function place_order($table_number,$dishes){
		global $db;
		
		// Prepare very long insertion queries.
		$order_query = ("INSERT INTO orders (`table_number`, `complete`) VALUES (" . $table_number . ", 0)");
		$dishes_query = "INSERT INTO order_dishes (`order`, `dish`, `ready`) VALUES ";
		$ingredients_query = "INSERT INTO order_dish_ingredients (`order`, `dish_ingredient`, `change`) VALUES";
		
		foreach($dishes as $dish){
			$dishes_query .= "(";
			$dishes_query .= "(SELECT id FROM orders ORDER BY id DESC LIMIT 1)" . ",";
			$dishes_query .= "(SELECT id FROM dishes WHERE name = '" . $dish["name"] . "')" . ",";
			$dishes_query .= "0";
			$dishes_query .= ")";
			
			$ingredients_query .= "(";
			// Add all dish ingredient changes //
			foreach($dish["changes"] as $change){
				$ingredients_query .= "(";
				$ingredients_query .= "(SELECT id FROM orders WHERE table_number = " . $table_number . " AND complete = 0 ORDER BY id DESC LIMIT 1)" . ",";
				$ingredients_query .= "(SELECT di.id FROM dish_ingredients di, dishes d, ingredients i WHERE di.ingredient = i.id AND di.dish = d.id AND i.name = '" . $change["ingredient"] . "' AND d.name = '" . $dish["name"] . "'),";
				$ingredients_query .= "'" . $change["change"] . "'";
				$ingredients_query .= ")";
				if($change !== end($dish["changes"])) $ingredients_query .= ",";
			}
			$ingredients_query .= ")";
			if($dish !== end($dishes)) $dishes_query .= ",";
		}
		$db->query($order_query);
		$db->query($dishes_query);
		$db->query($ingredients_query);
		
		return $dishes_query . "\n" . $ingredients_query;
	}
	
	function update_order($table_number, $new_dishes){
		global $db;
		$query1 = "INSERT INTO order_dishes (`order`, `dish`, `ready`) VALUES ";
		$query2 = "INSERT INTO order_dish_ingredients (`order`,`dish_ingredient`,`change`) VALUES ";
		
		foreach($new_dishes as $dish){
			$query1 .= "(";
			
			$query1 .= "(SELECT id FROM orders WHERE table_number = " . $table_number . " AND complete = 0 ORDER BY id DESC LIMIT 1)" . ",";
			
			$query1 .= ")";
			if($dish !== end($dishes)) $query1 .= ",";
			
			foreach($dish["changes"] as $change){
				$query2 .= "(";
				
				//
				
				$query2 .= ")";
				if($change !== end($dish["changes"])) $query2 .= ",";
			}
		}
		return true;
	}
	
	function get_table_orders($table_number){
		global $db;
		$query = "SELECT d.name, i.name, odi.change FROM orders o, dishes d, ingredients i, order_dishes od, dish_ingredients di, order_dish_ingredients odi WHERE od.order = o.id AND od.dish = d.id AND di.dish = d.id AND di.ingredient = i.id AND odi.order = o.id AND odi.dish_ingredient = di.id AND o.table_number = " . $table_number;
		$results = $db->query($query);
		$res = array();
		while($row = $results->fetch_assoc()){
			array_push($row);
		}
		return $res;
	}
	
	// Finish table orders. Set table as free.
	function conclude_table($table_number){
		global $db;
		$conclusion_query = "UPDATE orders SET complete = 1 WHERE table_number = " . $table_number;
		$bill_query = "SELECT SUM(d.price) AS Bill FROM dishes d, order_dishes od, orders o WHERE od.order = o.id AND od.dish = d.id AND o.table_number = " . $table_number;
		$db->execute($conclusion_query);
		$bill_result = $db->query($bill_query);
		return $bill_result->fetch_assoc()["Bill"];
	}
	
	function get_active_tables(){
		global $db;
		$query = "SELECT table_number, (SELECT od.ready FROM order_dishes od, orders o WHERE o.complete = 0 AND od.order = o.id ORDER BY od.ready ASC LIMIT 1) AS ready FROM Orders WHERE complete = 0";
		$results = $db->query($query);
		
		$ret = array();
		while($row = $results->fetch_assoc()){
			$row["table_number"] = $row["ready"];
		}
		return $ret;
	}
	
	if(isset($_POST["command"])){
		switch($_POST["command"]){
			case "place_order":
				$dishes = json_decode($_POST["data"],true);
				$table = $_POST["tableNumber"];
				
				echo place_order((int)$table,$dishes);
				break;
			
			case "get_dishes":
				echo json_encode(get_dishes());
				break;
			
			case "get_dish_ingredients":
				echo json_encode(get_dish_ingredients($_POST["data"]));
				break;
			
			case "get_table_orders":
				echo json_encode(get_table_orders((int)$_POST["data"]));
				break;
			
			case "get_active_tables":
				echo json_encode(get_active_tables());
				break;
		}
	}
?>
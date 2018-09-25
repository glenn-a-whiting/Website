<?php
	require_once("backend.php");
	
	$dishes = get_dishes();
	
	$table_number = isset($_GET["table_number"]) ? $_GET["table_number"] : 3;
	if($_GET["new_order"] == "error"){
		$err = " disabled";
		$new_order = true;
	}
	else{
		$err = "";
		$new_order = (bool)$_GET["new_order"];
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<style>
			.menu-item div {
				color: black;
			}
			
			.menu-item {
				background-color: white;
			}
			
			.menu-item:hover {
				background-color: lightskyblue;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="animate.css"/>
		<script>
			var order = [];
			
			/* 
			[
				{
					name:String,
					suffix:String,
					changes:[
						{
							ingredient:String,
							change:String ('more','less','none')
						}
					]
				}
			]
			*/
			
			function ajax(script,method,data,callback=undefined){
				if(data.constructor == Object){
					let temp = "";
					Object.keys(data).forEach((key,index) => {
						temp += key + "=" + data[key];
						if(index <= Object.keys(data).length){
							temp += "&";
						}
					});
					data = temp;
				}
				
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						if(callback == undefined){
							return this.responseText;
						}
						else{
							callback(this.responseText);
						}
					}
				};
				
				xhttp.open(method.toUpperCase(), script, (callback !== undefined));
				if(method.toUpperCase() == "POST")
					xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhttp.send(data);
			}
			
			function refresh(){
				var children = document.getElementById("list").children;
				for(let i = 0; i < children.length; i++){
					let child = children[i];
					if(order.length === 0 || order.every(dish => {
						let check = "dish%" + dish.name + dish.suffix;
						return child.id != check;
					})){
						child.parentNode.removeChild(child);
					}
				}
				
				
				order.forEach(dish => {
					var dishElement = document.getElementById("dish%"+dish.name+dish.suffix);
					if(dishElement == null){
						let main = document.createElement("DIV");
						main.className = "row list-group-item list-group-item-danger slideInRight animated";
						main.setAttribute("id","dish%"+dish.name+dish.suffix);
						
						let leftCol = document.createElement("A");
						leftCol.className = "col-md-10";
						leftCol.innerHTML = dish.name;
						leftCol.setAttribute("href","#");
						leftCol.setAttribute("onclick","removeFromOrder(this.parentNode,'"+dish.name+"')");
						
						
						// Edit Button
						let rightCol = document.createElement("A");
						rightCol.className = "col-md-2 text-center";
						rightCol.setAttribute("href","#");
						rightCol.setAttribute("onclick","displayDishIngredients(this.parentNode)");
						
						// Pencil icon
						let glyphicon = document.createElement("SPAN");
						glyphicon.setAttribute("class","glyphicon glyphicon-pencil");
						
						// Edit Button
						let badge = document.createElement("SPAN");
						badge.setAttribute("class","badge");
						
						badge.appendChild(glyphicon);
						rightCol.appendChild(badge);
						
						main.appendChild(leftCol);
						main.appendChild(rightCol);
						document.getElementById("list").appendChild(main);
					}
				});
			}
			
			function removeFromOrder(element,name){
				let suffix = "_" + element.id.split("_")[1]; //Get number to right of underscore
				order.every(function(dish,index){
					if(dish.name == name && dish.suffix == suffix){
						order.pop(index);
						return false;
					}
					else{
						return true;
					}
				});
				
				var ingredientId = "ingredients%"+name+suffix;
				var listChildren = document.getElementById("list").children;
				for(let i = 0; i < listChildren.length; i++){
					let child = listChildren[i];
					if(child.id == ingredientId){
						child.parentNode.removeChild(child);
					}
				}
				
				refresh();
			}
			
			function addToOrder(name){
				var suffix = 1;
				var children = document.getElementById("list").children;
				for(let i = 0; i < children.length; i++){
					let child = children[i];
					if(child.id.startsWith("dish%"+name)){
						suffix++;
					}
				}
				
				let c = [];
				getDishIngredients(name,function(r){
					r.forEach(function(ing){
						c.push({
							"ingredient":ing,
							"change":"Default"
						});
					});
				});
				
				
				order.push({
					"name":name,
					"suffix":"_"+String(suffix),
					"changes":c
				});
				refresh();		
			}
			
			function changeOrder(name,suffix,ingredient,change){
				order.some(function(dish){
					if(dish.name == name && dish.suffix == suffix){
						if(dish.changes.every(function(c,index){
							if(c.ingredient == ingredient){
								c.change = change;
								return false;
							}
							else{
								return true;
							}
						})){
							if(change != "Default"){
								dish.changes.push({
								"ingredient":ingredient,
								"change":change
								});
							}
						}
						var s = "changes: [";
						dish.changes.forEach(change => {
							s += "\n    { ingredient: " + change.ingredient + ", change: " + change.change + " }";
						});
						console.log(s + "\n]");
						return true;
					}
					else{
						return false;
					}
				});
			}
			
			function displayDishIngredients(element){
				
				// We need to keep track of ingredients for each order individually.
				var name = element.id.split("_")[0].split("%")[1];
				var suffix = "_" + element.id.split("_")[1];
				var ingredientId = "ingredients%"+name+suffix;
				
				// Test to see if the order dish editing menu is open 
				// for the specific order dish first, in order to avoid
				// sending an ajax request unnecessarily.
				var isOpen = false;
				var listChildren = document.getElementById("list").children;
				for(let i = 0; i < listChildren.length; i++){
					let child = listChildren[i];
					if(child.id == ingredientId){
						isOpen = true;
						break;
					}
				}
				
				if(!isOpen){
					getDishIngredients(name,function(ingredients){
						// The order dish the ingredients are associated with.
						var associatedWith = document.getElementById("dish%"+name+suffix);
						var list_group = document.createElement("DIV");
						list_group.id = ingredientId;
						list_group.className = "list-group";
						
						ingredients.forEach(ingredient_name => {
							var group_item = document.createElement("DIV");
							group_item.className = "list-group-item row";
							
							var item_name = document.createElement("DIV");
							var item_default = document.createElement("A");
							var item_less = document.createElement("A");
							var item_more = document.createElement("A");
							var item_none = document.createElement("A");
							
							item_name.className = "col-md-8";
							item_name.innerHTML = ingredient_name;
							
							item_default.className = "col-md-1 btn btn-default"
							item_default.innerHTML = "Default";
							item_default.setAttribute("href","#");
							item_default.setAttribute("onclick","changeOrder('"+name+"','"+suffix+"','"+ingredient_name+"','Default')");
							
							item_less.className = "col-md-1 btn btn-warning";
							item_less.innerHTML = "Less";
							item_less.setAttribute("href","#");
							item_less.setAttribute("onclick","changeOrder('"+name+"','"+suffix+"','"+ingredient_name+"','Less')");
							
							item_more.className = "col-md-1 btn btn-success";
							item_more.innerHTML = "More";
							item_more.setAttribute("href","#");
							item_more.setAttribute("onclick","changeOrder('"+name+"','"+suffix+"','"+ingredient_name+"','More')");
							
							item_none.className = "col-md-1 btn btn-danger";
							item_none.innerHTML = "None";
							item_none.setAttribute("href","#");
							item_none.setAttribute("onclick","changeOrder('"+name+"','"+suffix+"','"+ingredient_name+"','None')");
							
							group_item.appendChild(item_name);
							group_item.appendChild(item_default);
							group_item.appendChild(item_more);
							group_item.appendChild(item_less);
							group_item.appendChild(item_none);
							
							list_group.appendChild(group_item);
						});
						
						element.parentNode.insertBefore(list_group, element.nextSibling);
					});
				}
				// toggle the edit menu off if it exists
				else{
					var m = document.getElementById(ingredientId);
					m.parentNode.removeChild(m);
				}
			}
			
			function getDishIngredients(dishname,callback){
				ajax("backend.php","POST",{"command":"get_dish_ingredients","data":dishname},function(res){
					callback(JSON.parse(res));
				});
			}
			
			function getDishQuantity(dishname){
				ajax("backend.php","POST",{"command":"get_dish_quantity"},function(res){
					return JSON.parse(res);
				});
			}
			
			function send_to_kitchen(command){
				ajax("backend.php","POST",{"command":"place_order","tableNumber":document.getElementById("tablenum").value,"data":JSON.stringify(order)},function(res){
					console.log(res);
					order = [];
					document.getElementById("list").innerHTML = "";
					refresh();
				});
			}
			
			function test(){
				ajax("backend.php","POST",{"command":"get_table_orders","data":document.getElementById("tablenum").value},function(res){
					console.log(res);
				});
			}
		</script>
	</head>
	<body onload="test()">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-sm-6">
				<div class="list-group">
					<?php
						foreach($dishes as $row){
							echo "<a href='#' onclick='addToOrder(\"".$row['name']."\",1)' class='list-group-item menu-item".$err."'".$err."><div class='row'>";
								foreach($row as $key => $value){
									$r = ["name","price"];
									if(in_array($key,$r)){
										echo "<div class='col-md-" . (string)(12 / count($r)) . "'".$err.">";
										if($key == "price"){
											echo "$" . number_format($value,2,".","");
										}
										else{
											echo $value;
										}
										
										echo "</div>";
									}
								}
							echo "</div></a>";
						}
					?>
				</div>
				<label for="tablenum">Table Number</label>
				<input type="number" class="form-control input-lg" id="tablenum" value="<?php echo $table_number; ?>" disabled/>
			</div>
			<div class="col-md-6 col-sm-6 col-sm-6">
				<div class="list-group" id="list">
				</div>
				<input type="hidden" value="<?php echo $new_order; ?>">
				<button class="btn btn-lg btn-primary" onclick="send_to_kitchen()">
					Send to Kitchen
				</button>
			</div>
		</div>
	</body>
</html>
<?php
	$db->close();
?>

	@include("public\php\Restaurant\backend.php")

<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<style>
			.tablenumber {
				margin: 20px;
				height: 20%;
				font-size: 100px;
			}

			.keypad {
				padding: 50px;
				font-size: 50px;
			}
		</style>
		<script src="websocket.js"></script>
		<script>
			var number = "";
			var tables = <?php echo json_encode(get_active_tables(),JSON_FORCE_OBJECT); ?>;
			var table_numbers = <?php echo "[" . implode(", ",$table_numbers) . "]"; ?>;
			var columns = 4;

			function changeNumberOutput(e){
				let v = e.innerHTML;
				if(v == "DEL"){
					if(number.length > 0)
						number = number.substring(0,number.length-1);
				}
				else{
					number += e.innerHTML;
				}
				let pad = document.getElementById("numberOutput");
				pad.innerHTML = number === "" ? "..." : number;

				switch(tableStatus()){
					case true:
						pad.disabled = false;
						pad.className = "keypad text-center col-md-12 btn btn-lg btn-success";
						pad.parentNode.setAttribute("href","main.php?table_number=" + number + "&new_order=false");
						break;
					case false:
						pad.disabled = false;
						pad.className = "keypad text-center col-md-12 btn btn-lg btn-primary";
						pad.parentNode.setAttribute("href","main.php?table_number=" + number + "&new_order=true");
						break;
					case null:
						pad.disabled = true;
						pad.className = "keypad text-center col-md-12 btn btn-lg btn-danger";
						pad.parentNode.setAttribute("href","main.php?table_number=" + number + "&new_order=error");
						break;
				}
			}

			function tableStatus(){
				if(Number(number) in table_numbers){
					return Number(number) in tables;
				}
				else{
					return null;
				}
			}

			function getActiveTables(){
				console.log("getActiveTables");

				var list = document.getElementById("table_list");
				var row;

				Object.keys(tables).forEach((table_number, index) => {
					var active = tables[table_number];

					if(index % columns == 0){
						if(row == undefined){
							row = document.createElement("DIV");
							row.setAttribute("class","row");
						}
						list.appendChild(row);
					}

					let btn = document.createElement("BUTTON");
					btn.setAttribute("type","button");
					btn.setAttribute("class","col-md-"+String(12/columns) + " tablenumber btn btn-lg " + (active ? "btn-success" : "btn-default"));
					btn.innerHTML = table_number;

					let a = document.createElement("A");
					a.setAttribute("href","main.php?table_number="+table_number+"&new_order=false");
					a.appendChild(btn);

					row.appendChild(a);
				});
			}


		</script>
	</head>
	<body onload="getActiveTables()">
		<div class="row">
			<div class="col-md-8" id="table_list" >
			</div>
			<div class="col-md-4" id="keypad">
				<div class="row">
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">1</a>
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">2</a>
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">3</a>
				</div>
				<div class="row">
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">4</a>
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">5</a>
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">6</a>
				</div>
				<div class="row">
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">7</a>
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">8</a>
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">9</a>
				</div>
				<div class="row">
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-4 btn btn-lg btn-default">0</a>
					<a href="#" onclick="changeNumberOutput(this)" class="keypad text-center col-md-8 btn btn-lg btn-default">DEL</a>
				</div>
				<div class="row">
					<a>
						<button class="keypad text-center col-md-12 btn btn-lg btn-danger" id="numberOutput" disabled>...</button>
					</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	$db->close();
?>

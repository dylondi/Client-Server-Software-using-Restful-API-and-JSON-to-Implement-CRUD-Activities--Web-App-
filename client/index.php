<!DOCTYPE html>
<html>
<head>
	<title>Rest API CRUD using PHP Mysql</title>
	<link rel="stylesheet" type="text/css" href="a5css.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1//jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

	<div class="table-res">
		<table class="table" id="tableorig">
			<thead style="background-color: #aaaaaa;">
				<tr>
					<th>ID</th>
					<th>Date</th>
					<th>Name</th>
					<th>URL</th>
					<th>Description</th>

				</tr>

			</thead>
			<tbody>
				<?php
				//connect db 
				$con = mysqli_connect("localhost", "root", "", "data");
				//if connection fail 
				if($con->connect_error){
					die("Connection failed: ".$con->connect_error);
				}
				//receive data from db 
				$sql = "SELECT id, date, name, url, description FROM userdata";
				$result = $con-> query($sql);

				//if there is data in the database display the data on web page 
				if($result->num_rows>0){
					while($row = $result->fetch_assoc()){
						echo"<tr><td>".$row["id"] ."</td><td>".$row["date"] ."</td><td>".$row["name"]."</td><td>".$row["url"]."</td><td>".$row["description"]."</td></tr>";

					}
					echo "</table>";
				}
				else{
					echo "0 result";
				}
				$con-> close();
				?>
			</tbody>
		</table>
		<div align="center">
			<button class="buttons" id="create" style="background-color: blue; color:white;">Add</button>
			<button class="buttons" id="retrieve" style="background-color: blue; color:white;">Retrieve</button>
			<button class="buttons" id="edit" style="background-color: blue; color:white;">Edit</button>
			<button class="buttons" id="delete" style="background-color: blue; color:white;">Delete</button>
		</div>



		<div id="containerAdd" style="display: none;">
			<table id="table2" cellpadding="40" border="1" align="center"
				style="margin-top:100px;">
				<thead style="background-color: #aaaaaa;">
					<tr>
						<th>Name</th>
						<th>URL</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th contenteditable="true" id="addName"></th>
						<th contenteditable="true" id="addURL"></th>
						<th contenteditable="true" id="addDesc"></th>
					</tr>
				</tbody>
			</table>
			<div class="editButtons" align="center">
				<button class="btn" style="background-color: green;color:white;" id="goAdd">Add</button>
				<button class="btn" style="background-color: red;color:white;" id="noAdd">Exit</button>
			</div>
		</div>


		<div id="containerRetrieve" style="display: none;">
			<table id="table3" style="margin-top:100px;" cellpadding="40" border="1" align="center">

				<thead style="background-color: #aaaaaa;">
					<tr>
						<th>ID</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th contenteditable="true" id="retrieveID"></th>
					</tr>
				</tbody>

			</table>
			<div class="retrieveButtons" align="center">
				<button class="btn" style="background-color: green;color:white;" id="goRetrieve">Complete</button>
				<button class="btn" style="background-color: red;color:white;" id="noRetrieve">Exit</button>
				
			</div>

			<div align="center" class="retrieveButtons">
				<button id="retAll">Retrieve All</button>
			</div>
		</div>



		<div id="containerEdit" style="display: none;">
			<table id="table4" cellpadding="40" border="1" align="center" style="margin-top:100px;">
				<thead style="background-color: #aaaaaa;">
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>URL</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th contenteditable="true" id="editID"></th>
						<th contenteditable="true" id="editName"></th>
						<th contenteditable="true" id="editURL"></th>
						<th contenteditable="true" id="editDesc"></th>
					</tr>
				</tbody>
			</table>
			<div class="editButtons" align="center">
				<button class="btn" style="background-color: green;color:white;" id="goEdit">Complete</button>
				<button class="btn" style="background-color: red;color:white;" id="noEdit">Exit</button>
			</div>
		</div>


		<div id="containerDelete" style="display: none;">
			<table id="table5" cellpadding="40" border="1" align="center" style="margin-top:100px;">

				<thead style="background-color: #aaaaaa;">
					<tr>
						<th>ID</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th contenteditable="true" id="deleteID"></th>
					</tr>
				</tbody>

			</table>
			<div class="retrieveButtons" align="center">
				<button class="btn" style="background-color: green;color:white;" id="goDelete">Delete</button>
				<button class="btn" style="background-color: red;color:white;" id="noDelete">Exit</button>
			</div>
		</div>
	</div>
	<p style="text-align:center;" id="result">result</p>

	<a href="https://www.phpflow.com/php/create-php-restful-api-without-rest-framework-dependency/
	">
		Link to page that helped with rest api
	</a>
</body>
</html>

<script type="text/javascript">

	$(document).ready(function () {

		//if create button is clicked give option to create row 
		$('#create').on('click', function () {
			$("#containerAdd").show(); $(".table").hide(); $(".buttons").hide();
		});
		//button clicked once you finish inputting data
		$('#goAdd').on('click', function () {
			//data taken in 
			var name = document.getElementById("addName").innerText;
			var url = document.getElementById("addURL").innerText;
			var description = document.getElementById("addDesc").innerText;

			//if a field is empty show this alert
			if (name == '' || url == '' || description == '') {
				alert("Please check all fields.");
			}
			//else add to data to db and table 
			else {
				$("#containerAdd").hide(); $(".table").show(); $(".buttons").show();
				console.log(name + " " + description + " " + url);
				//groups 3 pieces of data into one variable
				var data = { 'name': name, 'url': url, 'description': description }
				console.log(data);
				//Stringifies data set into json format
				var stringPackage = JSON.stringify(data);
				console.log(stringPackage);
				//create XMLHttpRequest Object
				var request = new XMLHttpRequest();
				//.open specifies the type of request which is POST in this case
				request.open("POST", "../service/userdata.php?json=" + stringPackage, true);
				//.onreadystatechange defines a function to be executes when the readyState changes
				//.readyState holds the status of the XMLHttpRequest
				//.status holds the status of the XMLHttoRequest object
				request.onreadystatechange = function () {
					if (request.readyState == 4 && request.status == 200) {
						//data to update html with as the web app is single page application and 
						//we would have to refresh the page reconnecting to the db to grab out new row to display, 
						//instead we just add it to the html and it is instant with no page refresh
						var resp = this.responseText;
						document.getElementById("result").innerHTML = resp;
						var count = $('#tableorig tr').length;
						var today = new Date();
						var dd = String(today.getDate()).padStart(2, '0');
						var mm = String(today.getMonth() + 1).padStart(2, '0');
						var yyyy = today.getFullYear();
						today = yyyy + '-' + mm + '-' + dd;
						console.log(count);
						console.log(today);
						//html added 
						$("#tableorig tbody").append(
							"<tr>" +
							"<td>" + (count) + "</td>" +
							"<td>" + today + "</td>" +
							"<td>" + name + "</td>" +
							"<td>" + url + "</td>" +
							"<td>" + description + "</td>" +
							"<td></td>" +
							"</tr>"
						);
						document.getElementById("addName").innerText = "";
						document.getElementById("addURL").innerText = "";
						document.getElementById("addDesc").innerText = "";
					}
				}
				//.send() sends the request to the server
				request.send(stringPackage);
			}
		});

		//if you decide not to confrim adding the data youve inputted -> back to main screen and scrap inputted data 
		$('#noAdd').on('click', function () {
			$("#containerAdd").hide(); $(".table").show(); $(".buttons").show();
			document.getElementById("addName").innerText = "";
			document.getElementById("addURL").innerText = "";
			document.getElementById("addDesc").innerText = "";
		});

		//if you wish to look at just one row 
		$('#retrieve').on('click', function () {
			$("#containerRetrieve").show(); $(".table").hide(); $(".buttons").hide();
		});

		//once row id entered click complete to retrieve that row
		$('#goRetrieve').on('click', function () {
			//grabbing id entered by user
			var id = document.getElementById("retrieveID").innerText;
			var found = false;
			//if id field is empty 
			if (id == '') {
				alert("Please enter an ID");
			}
			//if user not found so far check db for matching id
			else if (!found) {
				var table = document.getElementById("tableorig");
				var tid = 0;
				for (var i = 1; i < table.rows.length; i++) {
					if (id == parseInt(table.rows[i].cells[0].innerHTML)) {
						found = true;
					}
				}
			}
			//if then found 
			if (found) {
				$(".table").show(); $(".buttons").show(); $("#containerRetrieve").hide();
				var data = { 'id': id };
				var stringPackage = JSON.stringify(data);
				//create XMLHttpRequest Object
				var request = new XMLHttpRequest();
				//.open specifies the type of request which is GET in this case
				request.open("GET", "../service/userdata.php?json=" + stringPackage, true);
				//.onreadystatechange defines a function to be executes when the readyState changes
				//.readyState holds the status of the XMLHttpRequest
				//.status holds the status of the XMLHttoRequest object
				request.onreadystatechange = function () {
					if (request.readyState == 4 && request.status == 200) {
						var resp = this.responseText;
						document.getElementById("result").innerHTML = resp;
					}
				}
				//.send() sends the request to the server
				request.send(stringPackage);
				found = false;
				document.getElementById("retrieveID").innerText = "";
			}
			else {
				alert("Please enter a valid ID.");
			}
		});

		//if you wish to retreive all data in JSON format
		$('#retAll').on('click', function () {
			var id = '';
			$(".table").show(); $(".buttons").show(); $("#containerRetrieve").hide();
			var data = { 'id': id };
			var stringPackage = JSON.stringify(data);
			//create XMLHttpRequest Object
			var request = new XMLHttpRequest();
			//.open specifies the type of request which is GET in this case
			request.open("GET", "../service/userdata.php?json=" + stringPackage, true);

			//.onreadystatechange defines a function to be executes when the readyState changes
			//.readyState holds the status of the XMLHttpRequest
			//.status holds the status of the XMLHttoRequest object
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var resp = this.responseText;
					document.getElementById("result").innerHTML = resp;
				}
			}
			//.send() sends the request to the server
			request.send(stringPackage);
			document.getElementById("retrieveID").innerText = "";
		});

		//if user decides not to retrieve anything ie. exit is clicked
		$('#noRetrieve').on('click', function () {
			$("#containerRetrieve").hide(); $(".table").show(); $(".buttons").show();
			document.getElementById("retrieveID").innerText = "";
		});

		//if button is clicked to allow user to pick a row to edit
		$('#edit').on('click', function () {
			$("#containerEdit").show(); $(".table").hide(); $(".buttons").hide();
		});

		//if button is clicked by user to edit data in the row inputted 
		$('#goEdit').on('click', function () {
			var id = document.getElementById("editID").innerText;
			var name = document.getElementById("editName").innerText;
			var url = document.getElementById("editURL").innerText;
			var description = document.getElementById("editDesc").innerText;
			var found = false;
			//if id field is empty 
			if (id == '') {
				alert("Please enter an ID");
			}
			//if user not found so far check db for matching id
			else if (!found) {
				var table = document.getElementById("tableorig");
				var tid = 0;
				for (var i = 1; i < table.rows.length; i++) {

					if (id == parseInt(table.rows[i].cells[0].innerHTML)) {
						found = true;
					}
				}
			}
			//if then found
			if (found) {
				//if all other inputs are not entered 
				if (name == '' || url == '' || description == '') {
					alert("Please check all fields.");
				}
				//else everything is entered correctly and then update db...
				else {
					//packages all the data entered into one variable
					var data = { 'name': name, 'url': url, 'description': description, 'id': id };
					//the data is then stringified into JSON format 
					var stringPackage = JSON.stringify(data);
					//create XMLHttpRequest Object
					var request = new XMLHttpRequest();
					//.open specifies the type of request which is PUT in this case
					request.open("PUT", "../service/userdata.php?json=" + stringPackage, true);

					//.onreadystatechange defines a function to be executes when the readyState changes
					//.readyState holds the status of the XMLHttpRequest
					//.status holds the status of the XMLHttoRequest object
					request.onreadystatechange = function () {
						if (request.readyState == 4 && request.status == 200) {
							var resp = this.responseText;
							document.getElementById("result").innerHTML = resp;
						}
					}
					//.send() sends the request to the server
					request.send(stringPackage);
					found = false;
					$("#containerEdit").hide(); $(".table").show(); $(".buttons").show();
					document.getElementById("editID").innerHTML = "";
					document.getElementById("editName").innerHTML = "";
					document.getElementById("editURL").innerHTML = "";
					document.getElementById("editDesc").innerHTML = "";
					var table = document.getElementById("tableorig");
					var tid = 0;
					//update the table with new data
					for (var i = 0; i < table.rows.length; i++) {
						console.log(table.rows[i].cells[0].innerHTML);
						if (id == parseInt(table.rows[i].cells[0].innerHTML)) {
							table.rows[i].cells[2].innerHTML = name;
							table.rows[i].cells[3].innerHTML = url;
							table.rows[i].cells[4].innerHTML = description;
						}
					}
				}
			}
			//else enter valid id
			else {
				alert("Please enter a valid ID.");
			}
		});
		//if user decides not to go ahead with his edit then back to main screen and inputted data scrapped 
		$('#noEdit').on('click', function () {
			$("#containerEdit").hide(); $(".table").show(); $(".buttons").show();
			document.getElementById("editID").innerHTML = "";
			document.getElementById("editName").innerHTML = "";
			document.getElementById("editURL").innerHTML = "";
			document.getElementById("editDesc").innerHTML = "";
		});

		//if user wishes to delete a row
		$('#delete').on('click', function () {
			$("#containerDelete").show(); $(".table").hide(); $(".buttons").hide();
		});

		//if user decides to delete specified row ie. delete button pressed -> id entered -> complete button pressed
		$('#goDelete').on('click', function () {
			var found = false;
			var id = document.getElementById("deleteID").innerText;
			//if id field is empty
			if (id == '') {
				alert("Please enter an ID");
			}
			//if user not found so far check db for matching id
			else if (!found) {
				var table = document.getElementById("tableorig");
				for (var i = 0; i < table.rows.length; i++) {
					if (id == parseInt(table.rows[i].cells[0].innerHTML)) {
						found = true;
					}
				}
			}
			//if then found delete from db and html
			if (found) {
				$(".table").show(); $(".buttons").show(); $("#containerDelete").hide();
				var data = { 'id': id };
				var stringPackage = JSON.stringify(data);
				//create XMLHttpRequest Object
				var request = new XMLHttpRequest();
				//.open specifies the type of request which is DELETE in this case
				request.open("DELETE", "../service/userdata.php?json=" + stringPackage, true);
				//.onreadystatechange defines a function to be executes when the readyState changes
				//.readyState holds the status of the XMLHttpRequest
				//.status holds the status of the XMLHttoRequest object
				request.onreadystatechange = function () {
					if (request.readyState == 4 && request.status == 200) {
						var resp = this.responseText;
						document.getElementById("result").innerHTML = resp;
					}
				}
				//.send() sends the request to the server
				request.send(stringPackage);
				document.getElementById("deleteID").innerHTML = "";
				found = false;

				//delete row in html 
				for (var i = 0; i < table.rows.length; i++) {
					if (id == parseInt(table.rows[i].cells[0].innerHTML)) {
						document.getElementById("tableorig").deleteRow(i);
					}
				}
			} else {
				alert("Please enter a valid ID.");
			}
		});
		//if user decides not to carry out the deletion of a row
		$('#noDelete').on('click', function () {
			$("#containerDelete").hide(); $(".table").show(); $(".buttons").show();
			document.getElementById("deleteID").innerHTML = "";
		});
	});
</script>




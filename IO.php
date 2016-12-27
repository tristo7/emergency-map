<?php
	session_name("login");
	session_start();
	require("config.php");
	
	//setup for database access
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Cannot connect to database."); 
	
	if(isset($_POST['latlng'])){
		verifyAuthentication();
		save($_POST['latlng'], $_POST['expires'], $_POST['desc'], $_POST['type']);
	} else {
		load();
	}
	
	//Saves data into the mySQL database.
	function save($coords, $expiration, $description, $type){
		global $conn;
		$sql = "INSERT INTO data (latLngArray, expiration, description, type)
			VALUES('".$coords."','".$expiration."','".$description."','".$type."');";
			
		mysqli_query($conn,$sql);
		mysqli_close($conn);
	}
	
	//Loads data (as a JSON array) from the mySQL database.
	function load(){
		global $conn;
		$sql = "SELECT data.latLngArray, data.expiration, data.description, data.type, types.Color 
				FROM data 
				RIGHT JOIN types 
				ON data.type = types.TypeName 
				WHERE expiration > NOW();";
		$result = mysqli_query($conn,$sql);
		$to_encode = array();
		while($row = $result->fetch_assoc()) {
		  $to_encode[] = $row;
		}
		echo json_encode($to_encode);
		mysqli_close($conn);
	}
	
	//Verifies that the user has authenticated with the system.
	function verifyAuthentication(){
		if(!isset($_SESSION['username'])){
			header("location:EmergencyAreaAdmin.html");
		}
	}
?>
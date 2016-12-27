<?php
	//verify user is authenticated.
	session_name("login");
	session_start();
	require("config.php");
	
	if(!isset($_SESSION['username'])){
		header("location:EmergencyAreaAdmin.html");
	}
	//setup for database access
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE) or die("Cannot connect to database."); 
		
	//Checks the database for active type names.
	global $conn;
	$sql = "SELECT TypeName FROM types;";
	$result = mysqli_query($conn,$sql);
	$to_encode = array();
	while($row = $result->fetch_assoc()) {
	  $to_encode[] = $row;
	}
	echo json_encode($to_encode);
	
	mysqli_close($conn);
?>
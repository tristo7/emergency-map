<?php
	//verify user is authenticated.
	session_name("login");
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:EmergencyAreaAdmin.html");
	}
	//setup for database access
	$servername = 	"localhost";
	$username 	= 	"root";
	$password 	= 	"G@m3c0ck$01";
	$database 	=	"emergencyarea";
	$conn = new mysqli($servername, $username, $password, $database) or die("Cannot connect to database."); 
		
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
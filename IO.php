<?php
	session_name("login");
	session_start();
	if(empty('username')){
		header("location:EmergencyAreaAdmin.html");
	}
	$servername = 	"localhost";
	$username 	= 	"root";
	$password 	= 	"G@m3c0ck$01";
	$database 	=	"emergencyarea";
	$conn = new mysqli($servername, $username, $password, $database);
	// Verify connection to database
	if (!$conn) {
		die("Connection failed: " . mysqli_error($conn));
	} // else we are connected.
	
	//Saves data into the mySQL database.
	function save($coords, $expiration, $description, $type){
		global $conn;
		$sql = "INSERT INTO data (latLngArray, expiration, description, type)
			VALUES('".$coords."','".$expiration."','".$description."','".$type."');";
			
		mysqli_query($conn,$sql);
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
	}
	if(isset($_POST['latlng'])){
		save($_POST['latlng'], $_POST['expires'], $_POST['desc'], $_POST['type']);
	} else {
		load();
	}
	
	
	mysqli_close($conn);
?>
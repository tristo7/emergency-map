<?php
	$servername = 	"localhost";
	$username 	= 	"root";
	$password 	= 	"G@m3c0ck$01";
	$database 	=	"emergencyarea";
	$conn = new mysqli($servername, $username, $password, $database);
	// Verify connection to database
	if (!$conn) {
		die("Connection failed: " . mysqli_error($conn));
	} // else we are connected.
	
	function save($coords, $expiration, $description, $type){
		global $conn;
		$sql = "INSERT INTO data (latLngArray, expiration, description, type)
			VALUES('".$coords."','".$expiration."','".$description."','".$type."');";
			
		mysqli_query($conn,$sql);
	}
	
	function load(){
		global $conn;
		$sql = "SELECT latLngArray, expiration, description, type FROM data WHERE expiration > NOW();";
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
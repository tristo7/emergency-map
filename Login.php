<?php
session_name("login");
session_start();
require("config.php");

$loginLocation = "EmergencyAreaAdmin.html"; //form where data comes from.

// Connect to server and select databse.
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE)or die("Cannot connect to database."); 

// username and password sent from form 
$myusername=$_POST['username']; 
$mypassword=$_POST['password']; 

//pull the salt and password hash from the database
$sql1="Select * from ".DB_TABLE." where Username='$myusername'";
$result1 = mysqli_query($conn,$sql1);
if(mysqli_num_rows($result1)==1){
	$row = mysqli_fetch_assoc($result1);
	$salt = $row['PasswordSalt'];
	$hash = $row['PasswordHash'];
	mysqli_free_result($result1);
	$mypassword = crypt($mypassword, $salt);
	//compare $mypassword to $hash
	//if same, then user authenticated successfully.

	if($mypassword == $hash){
		// Register username and redirect to file "login_success.php"
		$_SESSION["username"]= "yes";
		header("location:Login_success.php");
		exit();
	} else {
		//header("location:$loginLocation");
		echo "Wrong Username or Password";
	}
} else {
	//header("location:$loginLocation");
	echo "Wrong Username or Password";
}
mysqli_close($conn);
exit();
?>
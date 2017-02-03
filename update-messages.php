<?php


$db = new mysqli("localhost","root","zeroarch","msg" );

if ( $db->connect_error) {
	die("Could not connect to DB");
}



$username= stripslashes(htmlspecialchars($_GET['username']));
$message=stripslashes(htmlspecialchars($_GET['message']));

	if ( $username == "" || $message == "" ) {
		die("null username passwd");
	}

	
	$result= $db->prepare("INSERT INTO messages values('',?,?)") ;
	$result->bind_param("ss",$username,$message);
	$result->execute();
	

?>



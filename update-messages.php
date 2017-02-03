<?php


$db = new mysqli("us-cdbr-iron-east-04.cleardb.net","b9f2685c23460a","ccecffbb","heroku_027762730c360f1" );

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



<?php

$db = new mysqli("us-cdbr-iron-east-04.cleardb.net","b9f2685c23460a","ccecffbb","heroku_027762730c360f1" );

if ( $db->connect_error) {
	die("Could not connect to DB");
}



$username= stripslashes(htmlspecialchars($_GET['username']));
	$result= $db->prepare("SELECT * from messages") ;
	$result->execute();


$result = $result->get_result();

while($r = $result->fetch_row()) {
	echo $r[1];
	echo "\\";
	echo $r[2];
	echo "\n";
}

?>

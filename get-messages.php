<?php

$db = new mysqli("","","","" );

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

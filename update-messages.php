<?php


$db = new mysqli("localhost","root","zeroarch","msg" );

if ( $db->connect_error) {

	die("Could not connect to DB");

} else {

	die("connection successful");

}



?>



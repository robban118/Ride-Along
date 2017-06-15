<?php
	$host = "localhost";
	$username = "php";
	$password = "123456";
	$database = "bachelor";

	$db = pg_connect("host=$host dbname=$database user=$username password=$password");
 ?>
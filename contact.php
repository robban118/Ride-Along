<?php
	include("funksjoner.php");
	$navn = $_POST["name"];
	$fra = $_POST["email"];
	$melding = $_POST["message"];
	
	//sender epost til ridealong
	kontaktEpost($navn, $fra, $melding);
	
	header('Location: http://ridealong.top/');
?>
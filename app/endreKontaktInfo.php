<?php 

include("db.php");
include("../funksjoner.php");

$id = $_POST["id"];
$email = strtolower($_POST["email"]);
$telefon = $_POST["telefon"];

$Sql01 = "SELECT * FROM bruker where id = $id";
$resultat01 = pg_query($Sql01) or die ("ingen kontakt gitt");
$telle01 = pg_num_rows($resultat01);
if($telle01 == 0){
	
}

//hender kontaktinformasjon
else if ($telle01 != 0){
$sql02 = "SELECT email FROM bruker where email='$email';";
$resultat02 = pg_query($sql02) or die ("FinnesFrafor");
$telle02 = pg_num_rows($resultat02);
if($telle02 != 0){
	echo "Finnes";
}
else if($telle02 == 0){
		
			$sql03 = "UPDATE bruker SET email ='$email', telefon ='$telefon' WHERE id = $id";
			pg_query($sql03) or die ("kan ikke oppdatere info..");
			echo "OppdaterOK";

		}
}

 ?>
<?php 

include("../db.php");
include("../funksjoner.php");
//
$email = $_POST["email"];
$passord = $_POST["passord"];
$fornavn = $_POST["fornavn"];
$etternavn = $_POST["etternavn"];
$telefon = $_POST["telefon"];

// Sjekker om bruker finnes
$sql1 ="Select * from bruker where email = '$email';";
$sqlResultat = pg_query($db,$sql1) or die ("feil");
$sqlSjekk = pg_fetch_array($sqlResultat);

$t = pg_num_rows($sqlResultat);

//epost er registrert fra før
if($t == 1){
	echo "finnes";

}
else if ($t != 1){
	
	$tid = time();
            $verifiseringskode = md5($epost.$tid);
    $passord = password_hash($_POST["passord"], PASSWORD_DEFAULT);
    $email = strtolower($email);
    // lagt til nylig
    $fornavn = strtolower($fornavn);
    $etternavn = strtolower($etternavn);
    

    $sql2 = "INSERT INTO bruker (email,passord,fornavn,etternavn,telefon,verifiseringskode) VALUES ('$email','$passord','$fornavn','$etternavn','$telefon','$verifiseringskode');";
    pg_query($sql2);
	sendVerif($email, $verifiseringskode);
    pg_close($db);
    echo "rega";
	
}
else {
	echo "feil";
}




 ?>
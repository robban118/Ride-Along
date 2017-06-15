<?php 

include("db.php");
include("../funksjoner.php");

$id = $_GET["id"];
$key = $_GET["key"];
$sql01 = "SELECT salt from salt where key ='$key';";
$resultat01 = pg_query($sql01) or die ("noe galt skjedde");

$telle = pg_num_rows($resultat01);
if($telle == 0){

}
else if ($telle != 0){

//henter informasjon om bil
$sql02 = "SELECT bilnr, modell from bil where id=$id";
$resultat02 = pg_query($sql02) or die ("kan ikke hente ut bilinformasjon..");


$kjoretoy = array();
while ($row = pg_Fetch_array($resultat02)) {
	$bilnr = $row["bilnr"];
	$modell = $row["modell"];

	array_push($kjoretoy, array("bilnr"=>$bilnr,"modell"=>$modell));
}

echo json_encode(array("kjoretoy"=>$kjoretoy));
}

 ?>
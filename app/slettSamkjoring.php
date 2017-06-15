<?php 
include("../funksjoner.php");
include("db.php");
$samID = $_POST["samID"];

$sql ="SELECT * FROM resbil WHERE resid=$samID";
$res = pg_query($db,$sql) or die ("feil ved tilkobling");
$count = pg_num_rows($res);


if($count == 0){
	
}
else if($count != 0){
	$sqlmail ="SELECT bruker.fornavn, bruker.email FROM bruker, resbruker WHERE resbruker.resid=$samID AND resbruker.id = bruker.id;";
	$result = pg_query($sqlmail) or die ("kan ikke hente info");

	$info = "SELECT fra, til, tidspunkt FROM resbil WHERE resid = $samID";
	$infoResultat = pg_query($info) or die ("kan ikke hente info om samkjøring");

	while($row = pg_fetch_assoc($infoResultat)){
    				$fornavn = ucfirst($row["fornavn"]);
        			$fra = ucfirst($row["fra"]);
        			$til = ucfirst($row["til"]);
        			$tidspunkt = $row["tidspunkt"];
        			
        			$tid = date("d.m.Y H:i", $tidspunkt);
					$temptid = explode(" ", $tid);
					$dato = $temptid[0];
					$klokkeslett = $temptid[1];
    			}


				$brukerepost = array();
				while($row = pg_fetch_assoc($result)){
					$fornavn = ucfirst($row["fornavn"]);
					$epost = $row["email"];
					array_push($brukerepost, $epost);

				}

	$subject = "Ridelong - Samkjøring kansellert";
					$melding = "Hei! Samkjøringen fra $fra og til $til klokken $klokkeslett ($dato), er dessverre blitt kansellert. Vi beklager om dette skaper problemer for deg.";

					foreach ($brukerepost as $epost){

						sendEpost($epost, $subject, $melding);
						

					}
					
	$sql01 ="DELETE FROM resbruker where resid = $samID";
	pg_query($sql01) or die ("kan ikke slette samkjøring");
	$sql02 ="DELETE FROM resbil WHERE resid = $samID";
	pg_query($sql02) or die ("feil ved sletting..");
	echo "samkjoringSlettet";
}


 ?>
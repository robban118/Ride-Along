<?php 
include("../funksjoner.php");
include ("db.php");

$my = $_GET["my"];
$key = $_GET["key"];

$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);



if($count == 0){
	
}
else if($count !=0){

//henter dine samkjøringer
$sqlSetning ="SELECT * FROM resbil WHERE id=$my AND (tidspunkt > cast(extract(epoch from current_timestamp) as integer)) ORDER BY tidspunkt ASC;";

$sqlResultat = pg_query($db,$sqlSetning) or die ("feil");

//date_default_timezone_set("Europe/Stockholm");
$response = array();
$currdate = date("d.m.Y");
// kan være et problem
$time = date('H:i', strtotime('- 10 minutes'));

while($row = pg_fetch_array($sqlResultat)){
	$tidspunkt = $row['tidspunkt'];
	//$rdate = date('d.m.Y',$rtimestamp);
	//$rtime = date('H:i',$rtimestamp);
	$tid = date("d.m.Y H:i", $tidspunkt);
					$temptid = explode(" ", $tid);
					$dato = $temptid[0];
					$klokkeslett = $temptid[1];
	
	//echo "Tid: $tid, $tidspunkt";
	
array_push($response, array("resid"=>$row["resid"],"fra"=>mb_ucfirst($row["fra"]),"til"=>mb_ucfirst($row["til"]),"moteplass"=>mb_ucfirst($row["moteplass"]),"tidspunkt"=>$klokkeslett,"dato"=>$dato,"opptatt"=>$row["opptatt"],"maxplasser"=>$row["maxplasser"]));
	if ($dato >= $currdate){
		if($klokkeslett >= $time){
	
		}
	}

	


}


echo json_encode(array("Samkjoring"=>$response));



pg_close();


}
else{
	echo "Feil";
}

 ?>
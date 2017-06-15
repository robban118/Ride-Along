<?php 

//finner samkjøringer du er påmeldt i

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
// tester ut denne 
//$sqlSetning ="SELECT resbil.resid, resbil.fra, resbil.til, resbil.maxplasser, resbil.moteplass,resbil.tidspunkt, count(resbruker.resid) as opptatte from resbil inner join resbruker on resbil.id = resbruker.id where resbil.id != $my group by resbil.resid order by resbil.tidspunkt asc;";
// denne er den reelle
//$sqlSetning ="SELECT distinct resbil.resid, resbil.fra,resbil.til, resbil.moteplass,resbil.tidspunkt from resbil join resbruker on resbil.id = resbruker.id where resbruker.id = '$my' order by resbil.tidspunkt asc;";
	//$sqlSetning = "SELECT resbil.resid,resbil.fra,resbil.til,resbil.maxplasser, resbil.moteplass,resbil.tidspunkt, count(resbruker.resid) as opptatt from resbil join resbruker on resbil.resid = resbruker.resid where resbruker.id=$my and group by resbil.resid ,resbil.fra,resbil.til,resbil.maxplasser, resbil.moteplass,resbil.tidspunkt order by tidspunkt asc;";
//resbil.tidspunkt > cast(extract(epoch from current_timestamp) as integer)
//$sqlSetning ="SELECT resbil.resid, resbil.fra, resbil.til, resbil.tidspunkt FROM resbil, resbruker WHERE resbil.resid = resbruker.resid AND resbruker.id=$my ORDER BY tidspunkt ASC;";
$sqlSetning ="SELECT resbil.resid, resbil.fra, resbil.til, resbil.moteplass, resbil.tidspunkt FROM resbil, resbruker WHERE resbil.resid = resbruker.resid AND (resbil.tidspunkt > cast(extract(epoch from current_timestamp) as integer)) AND resbruker.id=$my ORDER BY tidspunkt ASC";
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
	

	
		
	array_push($response, array("resid"=>$row["resid"],"fra"=>mb_ucfirst($row["fra"]),"til"=>mb_ucfirst($row["til"]),"moteplass"=>mb_ucfirst($row["moteplass"]),"tidspunkt"=>$klokkeslett,"dato"=>$dato,"opptatt"=>$row["opptatt"],"maxplasser"=>$row["maxplasser"]));
		
	

	


}


echo json_encode(array("Samkjoring"=>$response));



pg_close();


}
else{
	echo "Feil";
}

 ?>
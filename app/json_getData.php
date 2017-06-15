<?php 

include ("db.php");
//henter info om smakjøring


$sqlSetning ="SELECT resid,fra,til,maxplasser,moteplass,tidspunkt FROM resbil order by tidspunkt asc;";
$sqlResultat = pg_query($db,$sqlSetning);

$response = array();
$currdate = date("d.m.Y");
$time = date('H:i', strtotime('1 hour'));

while($row = pg_fetch_array($sqlResultat)){
	$rtimestamp = $row['tidspunkt'];
	$rdate = date('d.m.Y',$rtimestamp);
	$rtime = date('H:i',$rtimestamp);
	
	

if ($rdate >= $currdate){
	if($rtime < $time){
array_push($response, array("resid"=>$row["resid"],"fra"=>$row["fra"],"til"=>$row["til"],"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$rtime,"dato"=>$rdate));
	}
	else{
		if($rtime >= $time){
			
		}
	}
}

}

echo json_encode(array("Samkjoring"=>$response));


pg_close();




 ?>



<?php 

include ("db.php");

$ignore = $_GET["ignore"];
$key = $_GET["key"];
$sok = strtolower($_GET["search"]);

$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);



if($count == 0){
	
}
else if($count !=0){

$sqlSetning ="SELECT * FROM resbil WHERE resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) AND (tidspunkt > cast(extract(epoch from current_timestamp) as integer)) AND (lower(resbil.fra) LIKE '%$sok%' OR lower(resbil.til) LIKE '%$sok%') AND id !=$ignore ORDER BY tidspunkt ASC;";
$sqlResultat = pg_query($db,$sqlSetning) or die ("feil");

$count = pg_num_rows($sqlResultat);


$response = array();
$currdate = date("d.m.Y");
// kan være et problem
$time = date('H:i', strtotime('2 hour'));

while($row = pg_fetch_array($sqlResultat)){
	$tidspunkt = $row['tidspunkt'];
	//$rdate = date('d.m.Y',$rtimestamp);
	//$rtime = date('H:i',$rtimestamp);
	$tid = date("d.m.Y H:i", $tidspunkt);
					$temptid = explode(" ", $tid);
					$dato = $temptid[0];
					$klokkeslett = $temptid[1];
	
			

/*
if ($rdate >= $currdate){

	if($rtime < $time){

	}

	else{
		if($rtime >= $time){
//array_push($response, array("resid"=>$row["resid"],"fra"=>$row["fra"],"til"=>$row["til"],"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$rtime,"dato"=>$rdate));			
		}
	}
}
*/


	array_push($response, array("resid"=>$row["resid"],"fra"=>ucfirst($row["fra"]),"til"=>ucfirst($row["til"]),"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$klokkeslett,"dato"=>$dato));	
/*
if ($dato > $currdate){
	
array_push($response, array("resid"=>$row["resid"],"fra"=>ucfirst($row["fra"]),"til"=>ucfirst($row["til"]),"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$klokkeslett,"dato"=>$dato));	
	
	
}
else if($dato >= $currdate && $klokkeslett >= $time){
	array_push($response, array("resid"=>$row["resid"],"fra"=>ucfirst($row["fra"]),"til"=>ucfirst($row["til"]),"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$klokkeslett,"dato"=>$dato));	
}
*/
}

echo json_encode(array("Samkjoring"=>$response));


pg_close();


}
else{
	echo "Feil";
}

 ?>


 
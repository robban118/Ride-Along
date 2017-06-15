<?php 

include ("db.php");
$ignore = $_GET["my"];
$key = $_GET["key"];



$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);



if($count == 0){
	
}

else if($count !=0){
//henter dagens samkjøringer
//$sqlSetning ="SELECT * FROM resbil WHERE resbil.id ='$ignore' ORDER BY tidspunkt ASC;";
	$sqlSetning ="SELECT * from resbil join resbruker on resbil.resid = resbruker.resid where resbruker.id = $ignore order by resbil.tidspunkt;";
$sqlResultat = pg_query($db,$sqlSetning) or die ("feil");

date_default_timezone_set("Europe/Stockholm");



$response = array();
$currdate = date("d.m.Y");
// kan være et problem
$time = date('H:i', strtotime('- 15 minutes'));



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



if ($dato == $currdate){
		if($klokkeslett > $time){
		array_push($response, array("resid"=>$row["resid"],"fra"=>ucfirst($row["fra"]),"til"=>ucfirst($row["til"]),"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$klokkeslett,"dato"=>$dato));
	}
	
	
	
}

}

echo json_encode(array("dagensSamkjoring"=>$response));


pg_close();


}
else{
	echo "Feil";
}

 ?>
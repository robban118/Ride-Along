<?php 
include ("db.php");

$id = $_GET["id"];
$key = $_GET["key"];

//$sqlGet = "SELECT key from salt where key='$key'";
//$query = pg_query($sqlGet) or die("kan ikke hente noe..");

//$count = pg_num_rows($query);



//if($count == 0){
	
//}
//else if($count !=0){
$sqlSetning ="SELECT * FROM resbil WHERE id='89';";

$sqlResultat = pg_query($db,$sqlSetning) or die ("feil");

$response = array();


while($row = pg_fetch_array($sqlResultat)){
	$rtimestamp = $row['tidspunkt'];
	$rdate = date('d.m.Y',$rtimestamp);
	$rtime = date('H:i',$rtimestamp);
	
	

array_push($response, array("resid"=>$row["resid"],"fra"=>$row["fra"],"til"=>$row["til"],"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$rtime,"dato"=>$rdate));
	

}

echo json_encode(array("Samkjoring"=>$response));


pg_close();


//}
//else{
//	echo "Feil";
//}


?>
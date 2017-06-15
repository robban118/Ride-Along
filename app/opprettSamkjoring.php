<?php 

//lager samkjøring

include("db.php");

$bilnr = $_POST["bilnr"];
$maxplasser = $_POST["maxplasser"];
$dato = $_POST["dato"];
$fra = $_POST["fra"];
$til = $_POST["til"];
$id = $_POST["id"];
$kommentar = $_POST["kommentar"];
$moteplass = $_POST["moteplass"];
$start = $_POST["start"];


$tid = strtotime("$dato$start");
//echo date('d/m/Y H:i:s', $timeStamp);

$sqlSjekk ="SELECT tidspunkt from resbil where id='$id' and tidspunkt='$tid'";
$resSjekk = pg_query($sqlSjekk) or die("kan ikke hente");
//$countSjekk = pg_fetch_array($resSjekk);
$countSjekk = pg_num_rows($resSjekk);

$countSjekk = pg_num_rows($resSjekk);
if($countSjekk != 0){
	echo "samFinnes";
}
else if($countSjekk == 0){
	$fra = strtolower($fra);
	$til = strtolower($til);
	$kommentar = strtolower($kommentar);
	$moteplass = strtolower($moteplass);
	$sql = "INSERT INTO resbil (bilnr,maxplasser,fra,til,id,kommentar,moteplass,tidspunkt) VALUES ('$bilnr','$maxplasser','$fra','$til','$id','$kommentar','$moteplass','$tid')"; 
	pg_query($sql);
	echo "SamReg";
}



//$sql = "INSERT INTO resbil (bilnr,maxplasser,dato,fra,til,id,kommentar,moteplass,start) VALUES ('$bilnr','$maxplasser','$dato','$fra','$til','$id','$kommentar','$moteplass','$start')"; 
//$sqlres = pg_query($sql) or die ("");
//echo "SamReg";
 ?>
<?php 
include("db.php");


$resid = $_POST["resid"];
$id = $_POST["id"];
$key = $_POST["key"];


$sql01 = "SELECT * from salt where key = '$key';";
$res01 = pg_query($sql01) or die ("feil.");
$count = pg_num_rows($res01);
if($count == 0){
header("Location: https://ridealong.top");
die();
}
else if($count != 0){
	
	$sql02 = "SELECT resid,id FROM resbruker where resid= $resid AND id = $id";
	$res02 = pg_query($sql02) or die ("kan ikke");
	$count02 = pg_num_rows($res02);

	if($count02 == 0){
		echo "telle2";
	}
	else if ($count02 != 0){
		//hopper av samkjøring
	$sql03 ="DELETE FROM resbruker where resid = $resid AND id = $id";
	pg_query($sql03) or die ("kan ikke slette samkjøring");
	
	echo "HoppetAv";
	}
	
	

}


 ?>
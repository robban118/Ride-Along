<?php 

//if($_SERVER['REQUEST_METHOD']=='GET'){
include("db.php");
$userID = $_GET["userID"];
$sql = "SELECT bilnr, modell, seter FROM bil where id='$userID' order by bilnr asc";
$sqlres = pg_query($sql) or die("kan ikke noe");
$count = pg_num_rows($sqlres);
if($count != 0){
$res = array();
while($raw = pg_fetch_array($sqlres)){
	$bilnr = $raw["bilnr"];
	$modell = $raw["modell"];
	$seter = $raw["seter"];

	$seter = $seter -1;
	
	
	
	
			array_push($res, array("bilnr"=>$bilnr,"modell"=>$modell,"seter"=>$seter));

	
	
	
}
//sender bildata til spinner
echo json_encode(array("WorldPopulation"=>$res));
pg_close($db);
}
else if ($count == 0){

}


//}
 ?>
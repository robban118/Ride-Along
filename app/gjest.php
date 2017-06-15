<?php 
$key = $_GET['key'];
$id = $_GET['id'];
include("db.php");
$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);

//80de2d06741e9a7c25378e5f25c450d1

if($count == 0){
	echo "count = 0";
}
else if($count !=0){

	$ResID = pg_num_rows($sqlRes);
	//henter informasjon om folk som sitter på
	$sqlgjest = "SELECT bruker.fornavn, bruker.email, bruker.telefon FROM bruker, resbruker WHERE resbruker.resid=$id AND resbruker.id = bruker.id;";
				$result = pg_query($db, $sqlgjest) or die ("Ikke mulig å hente passasjerer");

	
		

$gjest = array();
while($rad = pg_fetch_array($result)){
	$fornavn = $rad["fornavn"];
	$epost = $rad["email"];
	$telefon = $rad["telefon"];
	array_push($gjest, array("fornavn"=>$rad["fornavn"],"epost"=>$rad["email"],"telefon"=>$rad["telefon"]));
}








echo json_encode(array("gjest"=>$gjest));

pg_close($db);
	




}
 

 ?>
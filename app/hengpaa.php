<?php 
include ("db.php");

$samid = $_POST["samid"];
$id = $_POST["id"];

$sql = "SELECT resid,id FROM resbruker where resid ='$samid' and id ='$id';";
$query = pg_query($sql) or die ("Feil...");
$count = pg_num_rows($query);
if($count > 0){
echo "registrertfrafor";
}
else if($count == 0){
	//registrerer bruker på samkjøring
	$insertsql = "INSERT INTO resbruker (resid, id) VALUES ('$samid','$id');";
	pg_query($insertsql) or die ("kan ikke registrere");
	echo "tilknyttet";
	pg_close();
}



 ?>
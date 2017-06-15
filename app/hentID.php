<?php 
//henter id og sjekker om bruker er verifisert
include("db.php");
$email = strtolower($_POST["email"]);
$sql = "SELECT verifisert,id FROM bruker where email='$email'";
$sqlRes = pg_query($sql) or die ("kunne ikke noe..");
$count = pg_fetch_array($sqlRes);
if($count["verifisert"]==1){
	echo $count["id"];
}
else if($count["verifisert"]!= 1){
	echo "bruker er ikke verifisert";
}

 ?>
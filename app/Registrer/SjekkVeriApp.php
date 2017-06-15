<?php 

include("db.php");


$email = $_POST["email"];
echo "$epost";

$sql = "SELECT * from bruker where email='$email'";
$res = pg_query($sql) or die ("noe gikk galt");

$i = pg_fetch_array($res);

if($i["verifisert"] == 1){
	echo $i["id"];
	//echo "berver";
}
else if($i["verifisert"] !=1){
echo "berikkever";
}

 ?>


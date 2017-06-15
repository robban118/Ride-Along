<?php 

include ("db.php");

$key = $_GET["key"];



$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);



if($count == 0){
	
}

else if($count !=0){

//$sqlSetning ="SELECT * FROM resbil WHERE resbil.id ='$ignore' ORDER BY tidspunkt ASC;";
	$sqlSetning ="SELECT tekst FROM info ORDER BY RANDOM() LIMIT 1;";
$sqlResultat = pg_query($db,$sqlSetning) or die ("feil");

$quotes = array();



while($row = pg_fetch_array($sqlResultat)){
	
	


		array_push($quotes, array("tekst"=>$row["tekst"]));
	

}

echo json_encode(array("quotes"=>$quotes));


pg_close();


}
else{
	echo "Feil";
}

 ?>
<?php 

//henter brukerdata til instillinger siden

include("../funksjoner.php");
include ("db.php");

$id = $_GET["id"];
$key = $_GET["key"];

$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);



if($count == 0){
	
}
else if($count !=0){

$sqlSetning ="SELECT email,fornavn,etternavn,telefon FROM bruker WHERE id=$id;";

$sqlResultat = pg_query($db,$sqlSetning) or die ("Kan ikke hente informasjon");
$telle02 = pg_num_rows($sqlResultat);
if($telle02 == 0){

}
else if ($telle02 != 0){

$brukerinfo = array();




while($row = pg_fetch_array($sqlResultat)){

	
array_push($brukerinfo, array("email"=>mb_ucfirst($row["email"]),"fornavn"=>mb_ucfirst($row["fornavn"]),"etternavn"=>mb_ucfirst($row["etternavn"]),"telefon"=>$row["telefon"]));

}


echo json_encode(array("Info"=>$brukerinfo));



pg_close();

}
}
else{
	echo "Feil";
}

 ?>
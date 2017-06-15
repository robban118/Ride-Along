<?php  

include("../funksjoner.php");
include("db.php");
$key = $_GET['key'];
$resid = $_GET['id'];

$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);


if($count == 0){
	echo "count = 0";
}
else if($count !=0){

	/*$sql ="SELECT bruker.fornavn,bruker.etternavn, bruker.telefon,
resbil.fra, resbil.til, resbil.kommentar, resbil.maxplasser,resbil.kommentar, resbil.moteplass, resbil.tidspunkt,
count(resbruker.resid) as opptatt, 
bil.modell, bil.farge
FROM bruker
JOIN resbil
ON bruker.id =resbil.id
join resbruker
ON resbil.id = resbruker.id 
join bil
ON resbil.bilnr = bil.bilnr
WHERE resbil.resid=$id group by resbruker.id,bruker.fornavn,bruker.etternavn, bruker.telefon, resbil.fra, resbil.til, resbil.kommentar, resbil.maxplasser, resbil.moteplass, resbil.tidspunkt,bil.modell,bil.farge;";*/

	$sql = "SELECT bruker.fornavn, bruker.etternavn, bruker.telefon, resbil.id, resbil.fra, resbil.til, resbil.tidspunkt, resbil.moteplass, bil.modell, resbil.maxplasser, resbil.kommentar, bil.farge FROM bruker, resbil, bil WHERE resbil.id = bruker.id AND resbil.bilnr = bil.bilnr AND resbil.resid = '$resid';";
	$sqlRes = pg_query($db, $sql);

	$ResID = pg_num_rows($sqlRes);



	//$sqlgjest = "SELECT bruker.fornavn, bruker.email FROM bruker, resbruker WHERE resbruker.resid=$id AND resbruker.id = bruker.id;";
	//			$result = pg_query($db, $sqlgjest) or die ("Ikke mulig å hente passasjerer");

	if($ResID == 0){
		echo "ingenting...";
	}
	else if ($ResID != 0){
		$response = array();

while($row = pg_fetch_array($sqlRes)){
	$rtimestamp = $row['tidspunkt'];
	$rdate = date('d.m.Y',$rtimestamp);
	$rtime = date('H:i',$rtimestamp);

	$opptatt = "SELECT * FROM resbruker WHERE resid='$resid';";
	$optattres = pg_query($opptatt) or die ("Ikke mulig å hente opptatte plasser");
	$opptatt = pg_num_Rows($optattres);

        //array_push($response, array("id"=>$row[0]));
	array_push($response, array("fornavn"=>mb_ucfirst($row["fornavn"]),"etternavn"=>mb_ucfirst($row["etternavn"]), "telefon"=>$row["telefon"], "fra"=>mb_ucfirst($row["fra"]), "til"=>mb_ucfirst($row["til"]), "maxplasser"=>$row["maxplasser"],"kommentar"=>mb_ucfirst($row["kommentar"]), "moteplass"=>mb_ucfirst($row["moteplass"]), "dato"=>$rdate, "tid"=>$rtime, "opptatt"=>$opptatt, "modell"=>$row["modell"], "farge"=>$row["farge"]));
	//array_push($response,array("iId"=>$row[0], "image"=>$row[1],"kID"=>$row[3]));

}
/*
$gjest = array();
while($rad = pg_fetch_array($result)){
	$fornavn = $rad["fornavn"];
	$epost = $rad["email"];
	array_push($gjest, array("fornavn"=>ucfirst($rad["fornavn"]),"epost"=>$rad["email"]));
}
*/






echo json_encode(array("bilinfo"=>$response));
//echo json_encode(array("gjest"=>$gjest));

pg_close($db);
	}




}
 

 ?>
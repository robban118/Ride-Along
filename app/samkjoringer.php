<?php 
include("../funksjoner.php");
include ("db.php");

$ignore = $_GET["ignore"];
$key = $_GET["key"];

$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);



if($count == 0){
	
}
else if($count !=0){
//$sqlSetning ="SELECT * FROM resbil WHERE resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) and id!=$ignore order by tidspunkt;";
//$sqlSetning ="SELECT resid,fra,til,maxplasser,moteplass,tidspunkt FROM resbil where id !='$ignore' order by tidspunkt asc;";
//$sqlSetning = "SELECT resid,fra,til,maxplasser,moteplass,tidspunkt FROM resbil WHERE id !='$ignore' and resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) order by tidspunkt asc;";
//$sqlSetning ="SELECT distinct resbil.resid, resbil.fra, resbil.til, resbil.maxplasser, resbil.moteplass, resbil.tidspunkt from resbil join resbruker on resbil.id = resbruker.id where resbil.id !='$ignore' and resbruker.id !='$ignore' and resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) order by resbil.tidspunkt asc;";
//$sqlSetning ="SELECT distinct bil.id,bil.resid,bil.til,bil.fra,bil.maxplasser, bil.moteplass, bil.tidspunkt, bruker.id FROM (SELECT * from resbil) as bil, (SELECT * FROM resbruker) as bruker where bruker.id !='$ignore' and bil.id !='$ignore';";
//$sqlSetning ="SELECT distinct bruker.id,bil.resid,bil.til,bil.fra,bil.maxplasser, bil.moteplass, bil.tidspunkt, bruker.id FROM (SELECT * from resbil) as bil, (SELECT * FROM resbruker) as bruker where bruker.id !='$ignore' and bil.id !='$ignore' and bil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE bil.resid = bruker.resid) order by bil.tidspunkt asc;";
//$sqlSetning ="SELECT resbil.id,resbil.resid,resbil.fra, resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar, resbil.maxplasser, count(resbruker.resid) as opptatt from resbruker join resbil on resbruker.resid = resbil.resid where resbil.id !='$ignore' group by resbil.maxplasser,resbil.fra,resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar,resbil.id,resbil.resid having count(resbruker.resid) <= resbil.maxplasser;";

//$sqlSetning ="SELECT distinct bil.resid, bil.fra, bil.til, bil.maxplasser, bil.moteplass, bil.tidspunkt FROM (SELECT * from resbil) as bil, (SELECT * from resbruker) as bruker where bruker.id !=$ignore and bil.id !=$ignore;";

	//SELECT distinct bruker.id, bil.id,bil.resid, bil.fra, bil.til, bil.maxplasser, bil.moteplass, bil.tidspunkt FROM (SELECT * from resbil where id!=89) as bil, (SELECT * from resbruker where id!=89) as bruker;
	//$sqlSetning ="SELECT distinct bruker.id, bil.id,bil.resid, bil.fra, bil.til, bil.maxplasser, bil.moteplass, bil.tidspunkt FROM (SELECT * from resbil where id!=$ignore) as bil, (SELECT * from resbruker where id!=$ignore) as bruker;";
	//$sqlSetning ="select resbil.id,resbil.resid,resbil.fra, resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar, resbil.maxplasser, count(resbruker.resid) as opptatt from resbruker join resbil on resbruker.resid = resbil.resid where resbil.id !=$ignore group by resbil.maxplasser,resbil.fra,resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar,resbil.id,resbil.resid having count(resbruker.resid) < resbil.maxplasser;";
$sqlSetning ="SELECT * FROM resbil WHERE resbil.id !='$ignore' AND resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) AND (tidspunkt > cast(extract(epoch from current_timestamp) as integer)) ORDER BY tidspunkt ASC;";
$sqlResultat = pg_query($db,$sqlSetning) or die ("feil");

//date_default_timezone_set("Europe/Stockholm");
$response = array();
$currdate = date("d.m.Y");
// kan være et problem
$time = date('H:i', strtotime('- 10 minutes'));

while($row = pg_fetch_array($sqlResultat)){
	$tidspunkt = $row['tidspunkt'];
	//$rdate = date('d.m.Y',$rtimestamp);
	//$rtime = date('H:i',$rtimestamp);
	$tid = date("d.m.Y H:i", $tidspunkt);
					$temptid = explode(" ", $tid);
					$dato = $temptid[0];
					$klokkeslett = $temptid[1];
	
			
array_push($response, array("resid"=>$row["resid"],"fra"=>mb_ucfirst($row["fra"]),"til"=>mb_ucfirst($row["til"]),"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$klokkeslett,"dato"=>$dato));	
/*
if ($rdate >= $currdate){

	if($rtime < $time){

	}

	else{
		if($rtime >= $time){
//array_push($response, array("resid"=>$row["resid"],"fra"=>$row["fra"],"til"=>$row["til"],"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$rtime,"dato"=>$rdate));			
		}
	}
}
*/

//if ($dato >= $currdate){
	
	//	array_push($response, array("resid"=>$row["resid"],"fra"=>mb_ucfirst($row["fra"]),"til"=>mb_ucfirst($row["til"]),"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$klokkeslett,"dato"=>$dato));	

	
//}
/*
if($dato >= $currdate){
	if($klokkeslett >= $time){
		array_push($response, array("resid"=>$row["resid"],"fra"=>mb_ucfirst($row["fra"]),"til"=>mb_ucfirst($row["til"]),"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$klokkeslett,"dato"=>$dato));	
	}
	
}
*/
}

echo json_encode(array("Samkjoring"=>$response));


pg_close();


}
else{
	echo "Feil";
}

 ?>
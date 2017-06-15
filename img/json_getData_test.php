<?php 

include ("db.php");

$ignore = $_GET["ignore"];
$key = $_GET["key"];

$sqlGet = "SELECT key from salt where key='$key'";
$query = pg_query($sqlGet) or die("kan ikke hente noe..");

$count = pg_num_rows($query);



if($count == 0){
	
}
else if($count !=0){
//$sqlSetning ="SELECT * FROM resbil WHERE resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid);";
//$sqlSetning ="SELECT resid,fra,til,maxplasser,moteplass,tidspunkt FROM resbil where id !='$ignore' order by tidspunkt asc;";
//$sqlSetning = "SELECT resid,fra,til,maxplasser,moteplass,tidspunkt FROM resbil WHERE id !='$ignore' and resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) order by tidspunkt asc;";
//$sqlSetning ="SELECT distinct resbil.resid, resbil.fra, resbil.til, resbil.maxplasser, resbil.moteplass, resbil.tidspunkt from resbil join resbruker on resbil.id = resbruker.id where resbil.id !='$ignore' and resbruker.id !='$ignore' and resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) order by resbil.tidspunkt asc;";
//$sqlSetning ="SELECT distinct bil.id,bil.resid,bil.til,bil.fra,bil.maxplasser, bil.moteplass, bil.tidspunkt, bruker.id FROM (SELECT * from resbil) as bil, (SELECT * FROM resbruker) as bruker where bruker.id !='$ignore' and bil.id !='$ignore';";
//$sqlSetning ="SELECT distinct bruker.id,bil.resid,bil.til,bil.fra,bil.maxplasser, bil.moteplass, bil.tidspunkt, bruker.id FROM (SELECT * from resbil) as bil, (SELECT * FROM resbruker) as bruker where bruker.id !='$ignore' and bil.id !='$ignore' and bil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE bil.resid = bruker.resid) order by bil.tidspunkt asc;";
//$sqlSetning ="SELECT resbil.id,resbil.resid,resbil.fra, resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar, resbil.maxplasser, count(resbruker.resid) as opptatt from resbruker join resbil on resbruker.resid = resbil.resid where resbil.id !='$ignore' group by resbil.maxplasser,resbil.fra,resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar,resbil.id,resbil.resid having count(resbruker.resid) <= resbil.maxplasser;";

//$sqlSetning ="SELECT distinct bil.resid, bil.fra, bil.til, bil.maxplasser, bil.moteplass, bil.tidspunkt FROM (SELECT * from resbil) as bil, (SELECT * from resbruker) as bruker where bruker.id !=$ignore and bil.id !=$ignore;";

	//SELECT distinct bruker.id, bil.id,bil.resid, bil.fra, bil.til, bil.maxplasser, bil.moteplass, bil.tidspunkt FROM (SELECT * from resbil where id!=89) as bil, (SELECT * from resbruker where id!=89) as bruker;
	//$sqlSetning ="SELECT distinct bruker.id, bil.id,bil.resid, bil.fra, bil.til, bil.maxplasser, bil.moteplass, bil.tidspunkt FROM (SELECT * from resbil where id!=$ignore) as bil, (SELECT * from resbruker where id!=$ignore) as bruker;";
	$sqlSetning ="select resbil.id,resbil.resid,resbil.fra, resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar, resbil.maxplasser, count(resbruker.resid) as opptatt from resbruker join resbil on resbruker.resid = resbil.resid where resbil.id !=$ignore group by resbil.maxplasser,resbil.fra,resbil.til, resbil.moteplass, resbil.tidspunkt, resbil.kommentar,resbil.id,resbil.resid having count(resbruker.resid) < resbil.maxplasser;";
$sqlResultat = pg_query($db,$sqlSetning) or die ("feil");

$response = array();
$currdate = date("d.m.Y");
// kan være et problem
$time = date('H:i', strtotime('1 hour'));

while($row = pg_fetch_array($sqlResultat)){
	$rtimestamp = $row['tidspunkt'];
	$rdate = date('d.m.Y',$rtimestamp);
	$rtime = date('H:i',$rtimestamp);
	
	array_push($response, array("resid"=>$row["resid"],"fra"=>$row["fra"],"til"=>$row["til"],"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$rtime,"dato"=>$rdate));	

if ($rdate >= $currdate){
	if($rtime < $time){

	}

	else{
		if($rtime >= $time){
//array_push($response, array("resid"=>$row["resid"],"fra"=>$row["fra"],"til"=>$row["til"],"maxplasser"=>$row["maxplasser"],"moteplass"=>$row["moteplass"],"tidspunkt"=>$rtime,"dato"=>$rdate));			
		}
	}
}

}

echo json_encode(array("Samkjoring"=>$response));


pg_close();


}
else{
	echo "Feil";
}

 ?>
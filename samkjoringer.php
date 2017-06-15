<?php
    $header = "Samkjøringer";
    include("head.php");
    include("navbar.php");

    if(!isset($_SESSION["id"])){
    	include("directscript.html");
    }
    else{

		echo  "<div class='section-title'>
   		   <h2>Samkjør</h2>
  		   <p>Her kan du henge deg på!</p>
           </div>";

    	$id = $_SESSION["id"];
    	include_once("class_lib.php");

    	//henter aktive samkjøringer
    	$sql = "SELECT * FROM resbil WHERE resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) AND (tidspunkt > cast(extract(epoch from current_timestamp) as integer)) AND resbil.id != $id ORDER BY tidspunkt ASC;";
    	$sqlresultat = pg_query($db, $sql) or die ("Ikke mulig å hente fra databasen");
		$antallrader=pg_num_rows($sqlresultat);

		$samkjoringarray = array();

		for ($r=1; $r<=$antallrader; $r++){
			$rad = pg_fetch_array($sqlresultat);
			$tidspunkt=$rad["tidspunkt"];
			$resid = trim($rad["resid"]);
			$plasser = $rad["maxplasser"];
			$fra = $rad["fra"];
			$til = $rad["til"];
			$id = $rad["id"];
			$kommentar = $rad["kommentar"];
			$moteplass = $rad["moteplass"];

			//henter de som har hengt seg på samkjøring
			$sqlsetning = "SELECT COUNT(*) AS plasser FROM resbruker WHERE resid='$resid';";
			$resultat = pg_query($db, $sqlsetning) or die ("Ikke mulig å hente antall plasser");

			while($row = pg_fetch_array($resultat)){
				$maxplasser = $row["plasser"];
			}


			$verdier = array($tidspunkt, $resid, $plasser, $fra, $til, $id, $kommentar, $moteplass, $maxplasser);
			//lager en Samkjøring med et array av verdier
			$samkjoring = new Samkjoring($verdier);
			//putter samkjøringen inn i et array
			array_push($samkjoringarray, $samkjoring);
	    }
		
		$i=0;
		//printer ut 2 og 2 samkjøringer på linje
		echo "<div class='container'><div class='row'>";
	    foreach($samkjoringarray as &$sk){
	    	echo $sk->vis();
			

			if($i==1){
				echo "</div><div class='row'>";
				$i=0;
			}
			else{
				$i++;
			}
			
	    }echo "</div></div>";

    }
	echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
?>


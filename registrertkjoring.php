<?php
    $header = "Samkjøring";
    include("head.php");
    include("navbar.php");
    echo "<div class='container'>";

	echo "<ol class='breadcrumb'>
  		<li class='breadcrumb-item'><a href='dinside.php'>Din side</a></li>
		  <li class='breadcrumb-item'><a href='dinesamkjoringer.php'>Påmeldte samkjøringer</a></li>
  		<li class='breadcrumb-item active'>Påmeldt samkjøring</li>
		</ol>";

    if(!isset($_SESSION["id"])){
    	include("directscript.html");
    }
    else{
    	if(empty($_GET)){
    		include("directscript.html");
    	}
    	else{
    		$resid = $_GET["id"];
    		$id = $_SESSION["id"];
    		//ser om du henger på samkjøirngen
    		$sql = "SELECT * FROM resbruker where resid=$resid AND id=$id;";
    		$result = pg_query($db,$sql) or die ("Ikke mulig å hente informasjon");

    		//hvis det er noen rader så printer den ut, eller så får du beskjed om at du ikke henger på
    		if(pg_num_rows($result) > 0){
    			//henter informasjon om samkjøringen
	    		$sql = "SELECT bruker.fornavn, bruker.telefon, resbil.fra, resbil.til, resbil.tidspunkt, resbil.moteplass, bil.modell, resbil.maxplasser, resbil.kommentar FROM bruker, resbil, bil WHERE resbil.id = bruker.id AND resbil.bilnr = bil.bilnr AND resbil.resid = '$resid';";
	    		$result = pg_query($db, $sql) or die ("Ikke mulig å hente i 	nformasjon om reisen");

	    		if (pg_num_rows($result) > 0) {
	    			while($row = pg_fetch_assoc($result)) {
	        			$fornavn = ucwords($row["fornavn"]);
	        			$telefon = $row["telefon"];
	        			$fra = ucwords($row["fra"]);
	        			$til = ucwords($row["til"]);
	        			$tidspunkt = $row["tidspunkt"];
	        			$moteplass = ucfirst($row["moteplass"]);
	        			$modell = $row["modell"];
	        			$maxplasser = $row["maxplasser"];
	        			$kommentar = mb_ucfirst($row["kommentar"]);
	    			}
				}
				else {
	    			echo "<div class='alert alert-danger' role='alert'>Ingen samkjøringer matcher denne reservasjonsid</div>";
				}
				//gjør om timestamp til dato og klokkeslett
				$tid = date("d/m/Y H:i", $tidspunkt);
				$temptid = explode(" ", $tid);
				$dato = $temptid[0];
				$klokkeslett = $temptid[1];

				//printre ut informasjonen
				echo "<div class='container'><h3>$fra - $til</h3><br>
				<Table style='width=100%'>
				<tr><td>Sjåfør:</td><td> $fornavn</td></tr>
				<tr><td>Telefonnummer:</td><td> $telefon</td></tr>
				<tr><td>  Dato:</td><td> $dato </td></tr>
				<tr><td>  Tid:</td><td>  $klokkeslett</td></tr>
				<tr><td> Møteplass:</td><td> $moteplass</td></tr>
				<tr><td> Bilmodell<br>kjennetegn:</td><td> $modell</td></tr>
				";

				if (strlen(trim($kommentar)) > 0){
					echo "<tr><td> Kommentar:</td><td><i>" . $kommentar . "</i></td></tr>";
				}
				echo "</table></br>";

				//printer ut antall ledige plasser
				$sqlsetning = "SELECT COUNT(*) AS plasser FROM resbruker WHERE resid='$resid';";
				$resultat = pg_query($db, $sqlsetning) or die ("Ikke mulig å hente antall plasser");

				while($row = pg_fetch_array($resultat)){
					$plasser = $row["plasser"];
				}

				echo "<div class='alert alert-warning' role='alert'>Det er " . ($maxplasser - $plasser) . " ledig(e) plasser igjen.</div></br>";

				//knapp og funksjon for å hoppe av kjøringen
				echo "<form method='post' action=''>";
				echo "<input type='submit' class='btn btn-danger' value='Hopp av' name='hoppav'/>";
				echo "</form></br>";

				@$hoppav = $_POST["hoppav"];
				if($hoppav){
					$sql = "DELETE FROM resbruker WHERE resid=$resid AND id=$id;";
					pg_query($db, $sql) or die ("Ikke mulig å hoppe av samkjøring");

					Echo "<div class='alert alert-danger' role='alert'>Du har nå hoppet av denne samkjøringen, trykk <a href='dinside.php'>her</a> for å gå tilbake til din side.</div>";
				}	
			}
			else {
				Echo "<div class='alert alert-danger' role='alert'>Du er ikke registrert i denne samkjøringen</div>";
			}
    	}
    }
    echo "</div>";
?>

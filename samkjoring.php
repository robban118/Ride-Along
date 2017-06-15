<?php
    $header = "Samkjøring";
    include("head.php");
    include("navbar.php");

    if(!isset($_SESSION["id"])){
    	include("directscript.html");
    }
    else{
    	if(empty($_GET)){
    		include("directscript.html");
    	}
    	else{
    		$resid = $_GET["id"];
    		//henter informasjon om samkjøringen
    		$sql = "SELECT bruker.fornavn, resbil.id, resbil.fra, resbil.til, resbil.tidspunkt, resbil.moteplass, bil.modell, resbil.maxplasser, resbil.kommentar FROM bruker, resbil, bil WHERE resbil.id = bruker.id AND resbil.bilnr = bil.bilnr AND resbil.resid = '$resid';";
    		$result = pg_query($db, $sql) or die ("Ikke mulig å hente informasjon om reisen");

    		if (pg_num_rows($result) > 0) {
    			while($row = pg_fetch_assoc($result)) {
        			$fornavn = ucfirst($row["fornavn"]);
        			$fra = ucfirst($row["fra"]);
        			$til = ucfirst($row["til"]);
        			$tidspunkt = $row["tidspunkt"];
        			$moteplass = ucfirst($row["moteplass"]);
        			$modell = $row["modell"];
        			$maxplasser = $row["maxplasser"];
        			$resbilid = $row["id"];
        			$tid = date("d/m/Y H:i", $tidspunkt);
					$temptid = explode(" ", $tid);
					$dato = $temptid[0];
					$klokkeslett = $temptid[1];
					$kommentar = mb_ucfirst($row["kommentar"]);
    			}
			}
			else {
    			echo "<div class='alert alert-danger' role='alert'>Ingen samkjøringer matcher denne reservasjonsid</div>";
			}
			//sjekkero m du er gjest eller eier
			if ($_SESSION["id"] === $resbilid){
				echo "Du eier denne samkjøringen, ønsker du å se denne trykk <a href='eier.php?resid=$resid'>her</a>";
			}
			else{
				
				echo "<div class='container'>
				<h3>$fra - $til</h3><br><br>
				<Table style='width:60%'><tr><td>Sjåfør:</td><td> $fornavn</td></tr>
				<tr><td>Dato:</td><td> $dato</td></tr>
				<tr><td>Tid:</td><td>$klokkeslett</td></tr>
				<tr><td> Møteplass:</td><td> $moteplass</td></tr>
				<tr><td> Bilmodell/kjennetegn:</td><td> $modell</td></tr>";
				
				

				if (strlen(trim($kommentar)) > 0){
					echo "<tr><td> Kommentar:</td><td><i>" . $kommentar . "</i></td></tr>";
				}
				echo "</table></br>";
				echo "<script>
             $('#popform').modal('hide')
                                </script>";

                //henter plasser
				$sqlsetning = "SELECT COUNT(*) AS plasser FROM resbruker WHERE resid='$resid';";
				$resultat = pg_query($db, $sqlsetning) or die ("Ikke mulig å hente antall plasser");

				while($row = pg_fetch_array($resultat)){
					$plasser = $row["plasser"];
				}

				echo "<div class='alert alert-warning' role='alert'>Det er " . ($maxplasser - $plasser) . " ledig(e) plasser igjen, vil du sitte på kan du trykke knappen under</div>";

				//hvis du er registert på samkjøring, linker deg til siden med mer informasjon
				$id = $_SESSION["id"];
				$sql = "SELECT * FROM resbruker WHERE id='$id' AND resid='$resid';";
				$resultat = pg_query($db, $sql) or die ("Noe gikk galt");
				if(pg_num_rows($resultat) > 0){
					echo "<div class='alert alert-info' role='alert'>Du har allerede hengt på! Gå til samkjøringen for mer informasjon.</div>";
					echo "<a class='btn btn-info' href='registrertkjoring.php?id=" . $resid ."'>Gå til samkjøringen</a>";
				}
				else{
					if(($maxplasser - $plasser) > 0){
						echo "<form method='post' action=''>";
						echo "<br><input type='submit' class='btn btn-success' name='knapp' value='Heng på'/><br>";
						echo "</form> </br>";
						@$knapp = $_POST["knapp"];
						if($knapp){
							$sql = "INSERT INTO resbruker (resid, id) VALUES ('$resid', '$id');";
							pg_query($db, $sql) or die ("Noe skjedde, samkjøringen ble ikke registrert");
							echo "<div class='alert alert-success' role='alert'>Du er nå med på denne samkjøringen!</div>";
							echo "<a class='btn btn-success' href='registrertkjoring.php?id=" . $resid ."'>Gå til samkjøringen</a>";
						}
					}
					else{
						Echo "<div class='alert alert-danger' role='alert'>Denne samkjøringen er full</div>";
					}
				}
			}
    	}
    }
    echo "</div>";

	echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";


?>

<?php
    $header = "Samkjøring";
    include("head.php");
    include("navbar.php");

	

	echo "<div class='container'>";

	echo "<ol class='breadcrumb'>
  		<li class='breadcrumb-item'><a href='dinside.php'>Din side</a></li>
		<li class='breadcrumb-item'><a href='samkjoringeier.php'>Dine Samkjøringer</a></li>
  		<li class='breadcrumb-item active'>Din samkjøring</li>
		</ol>";
    if(!isset($_SESSION["id"])){
    	include("directscript.html");
    }

    else{
    	if(empty($_GET)){
    		echo "<div class='alert alert-warning' role='alert'>Fant ikke samkjøringen</div>";
    	}
    	else{
    		//henter kjøringen som matcher id
    		$resid = $_GET["resid"];
    		$sql = "SELECT * FROM resbil WHERE resid=$resid;";
    		$resultat = pg_query($db,$sql) or die("<div class='alert alert-warning' role='alert'>Fant ikke samkjøringen, er du sikker på at den eksiterer</div></br><div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>");

    		while($rad = pg_fetch_row($resultat)){
    			$dbid=$rad[5];
    		}
    		$id = $_SESSION["id"];
    		//hvis id ikke matcher den som er registrert for bruker beskjed om at han ikke er ansvarlig for samkjøringen
    		if($dbid != $id){
    			echo "<div class='alert alert-warning' role='alert'>Du er ikke eier av denne samkjøringen</div>";
    		}
    		else{
    			//henter resten av informasjonen om samkjøringen
    			$sql = "SELECT bruker.fornavn, resbil.fra, resbil.til, resbil.tidspunkt, resbil.moteplass, bil.modell, resbil.maxplasser FROM bruker, resbil, bil WHERE resbil.id = bruker.id AND resbil.bilnr = bil.bilnr AND resbil.resid = $resid;";
    			$resultat = pg_query($db, $sql) or die ("Fikk ikke hentet informasjon om reisen");

    			while($row = pg_fetch_assoc($resultat)){
    				$fornavn = ucfirst($row["fornavn"]);
        			$fra = ucfirst($row["fra"]);
        			$til = ucfirst($row["til"]);
        			$tidspunkt = $row["tidspunkt"];
        			$moteplass = ucfirst($row["moteplass"]);
        			$modell = $row["modell"];
        			$maxplasser = $row["maxplasser"];

        			$tid = date("d/m/Y H:i", $tidspunkt);
					$temptid = explode(" ", $tid);
					$dato = $temptid[0];
					$klokkeslett = $temptid[1];
    			}

    			//henter info om de som har hengt seg på
				$sqlgjest = "SELECT bruker.fornavn, bruker.email FROM bruker, resbruker WHERE resbruker.resid=$resid AND resbruker.id = bruker.id;";
				$result = pg_query($db, $sqlgjest) or die ("Ikke mulig å hente passasjerer");

				$navn = array();
				$brukerepost = array();
				while($row = pg_fetch_assoc($result)){
					$fornavn = ucfirst($row["fornavn"]);
					$epost = $row["email"];
					array_push($navn, $fornavn);
					array_push($brukerid, $bruker);	
					array_push($brukerepost, $epost);				
				}

				echo "<div class='formboks'>";
				
				

				echo "<div class='row'><div class='col-sm-12'>
				<table>
				<tr><td><h4>$fra - $til</td></tr>
				<tr><td> $dato - $klokkeslett</td></tr>
				<tr><td> $moteplass</td></tr>
				<tr><td> $modell</td></tr>
				</table>";
				echo "<form method='post' action=''><input type='submit' class='btn btn-danger float-right' value='Slett samkjøring' name='slett'/>";
				echo "</form>";
				echo "</div></div></div><br>";
				echo "<div class='row'>";
				
				echo"<div class='col-sm-6'>
				<table class='table table-striped table-info'>
				<thead>
				<tr>
				<th>Plasser</th>
				</tr>
				</thead>";

				$passasjerer = count($navn);
				
				echo "<tbody>";
				for ($i=0; $i<$maxplasser;$i++){
					if($i>=$passasjerer){
						
						echo "<tr><td><i>Ledig plass</i></td></tr>";
					}
					
					else{
						echo "<tr><td>" . $navn[$i] . "</td></tr>";
					}
				
				}
				echo "</tbody></table></div>";
					

				echo "<div class='col-sm-6'>";
				echo "<form method='post' class='form-group' action=''>";
				echo "<textarea style='background-color:rgb(242,242,242);' id='mailtekst' name='mailtekst' rows='7' cols='20' class='form-control contact_input_box' placeholder='Send melding til dine passasjerer'></textarea>";
				echo "<input type='submit' class='btn btn-success contact_button' value='Send' name='sendmail'>";
				echo "</form>";
				
				

				@$sendmail = $_POST["sendmail"];
				if($sendmail){
					$tekst = $_POST["mailtekst"];
					if("" == trim($tekst)){
						echo "<br><div class='alert alert-warning'>Du må fylle inn meldingsfeltet</div>";
					}
					else{
						//sender melding til alle som har meldt seg på samkjøringen
						$melding = ucfirst($tekst);
						$subject = "Melding angående " . $fra . " - " . $til . " den " . $dato . " klokken " . $klokkeslett; 

						foreach($brukerepost as $epost){
							sendEpost($epost, $subject, $melding);
						}

						echo "<br><div class='alert alert-success'>Epost er sendt</div>";
					}
				}
    		}
				
				@$slett = $_POST["slett"];
				if($slett){
					//sletter samkjøring og sender mail til alle som har hengt seg på
					$subject = "Ridelong - Samkjøring kansellert";
					$melding = "Samkjøringen fra $fra til $til den $dato klokken $klokkeslett er nå kansellert, vi beklager om dette skaper problemer for deg.";

					foreach ($brukerepost as $epost){
						sendEpost($epost, $subject, $melding);
					}
					
					$sql = "DELETE FROM resbruker WHERE resid=$resid;";
					pg_query($db, $sql) or die ("Ikke mulig å slette brukerreservasjoner");

					$sql = "DELETE FROM resbil WHERE resid=$resid;";
					pg_query($db, $sql) or die ("IKke mulig å sltete reservasjon");

					echo "<div class='alert alert-danger'>Samkjøringen er nå kansellert</div>";
				}
			

    	}
    }
	echo "</div></div><div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
?>
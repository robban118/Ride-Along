<?php
	$header = "Dine samkjøringer";
    include("head.php");
    include("navbar.php");
	echo "<div class='container'>";

	

    if(!isset($_SESSION["id"])){
    	include("directscript.html");
    }

    else{
	
	echo "<div class='section-title'>
   		   <h2>Dine samkjøringer</h2>
  		   <p>Her kan du administrere dine <br> registrerte samkjøringer</p>
           </div>";

	echo "<ol class='breadcrumb'>
  		<li class='breadcrumb-item'><a href='dinside.php'>Din side</a></li>
  		<li class='breadcrumb-item active'>Dine samkjøringer</li>
		</ol>";

		//sjekker om du har registrert noen samkjøringer som ikke har kjørt
    	$id = $_SESSION["id"];
    	$sql = "SELECT * FROM resbil WHERE id=$id AND (tidspunkt > cast(extract(epoch from current_timestamp) as integer)) ORDER BY tidspunkt ASC;";

    	$resultat = pg_query($db, $sql) or die ("Noe gikk galt, fikk ikke hentet samkjøringer");
		$numrows = pg_num_rows($resultat);
		
		if ($numrows==0){
			echo "<div class='alert alert-info' role='alert'><strong>Du har ikke registrert noen aktive samkjøringer</div>";
		}

		else {
			//henter informasjon fra query
			while($rad = pg_fetch_array($resultat)){
				$resid = $rad["resid"];
				$fra = ucfirst($rad["fra"]);
				$til = ucfirst($rad["til"]);
				$tidspunkt = $rad["tidspunkt"];

				$tid = date("d/m/Y H:i", $tidspunkt);
				$temptid = explode(" ", $tid);
				$dato = $temptid[0];
				$klokkeslett = $temptid[1];

				//printer ut informasjon
				echo "
				<div class='jumbotron'>
				<a style=margin-left:1%; class='btn btn-info float-right' href='eier.php?resid=".$resid."'>Se kommentarer</a> 
				<table class='mobiltabell'>
				<tr><td><h4> $fra - $til </h4></td></tr>
				<tr><td><h6> $dato </h6></td></tr>
				<tr><td><h6> $klokkeslett</h6></td></tr>
				</table>
				</div>";
			}

		}
    }
	echo "</div>";
	echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
?>




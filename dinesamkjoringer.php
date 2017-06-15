<?php
	
    $header = "Registrerte samkjøringer";
    include("head.php");
    include("navbar.php");
    echo "<div class='container'>";
    echo "<div class='section-title'><h2>påmeldte samkjøringer</h2><p>Her kan du administrere aktive påmeldte samkjøringer</p></div>";

	echo "<ol class='breadcrumb'>
  		<li class='breadcrumb-item'><a href='dinside.php'>Din side</a></li>
  		<li class='breadcrumb-item active'>Påmeldte samkjøringer</li>
		</ol>";

    if(!isset($_SESSION["id"])){
    	include("directscript.html");
    }
    else {
    	$id = $_SESSION["id"];
        //henter de samkjøringer som du har meldt deg på som ikke har dratt enda
    	$sql = "SELECT resbil.resid, resbil.fra, resbil.til, resbil.tidspunkt FROM resbil, resbruker WHERE resbil.resid = resbruker.resid AND (resbil.tidspunkt > cast(extract(epoch from current_timestamp) as integer)) AND resbruker.id=$id ORDER BY tidspunkt ASC;";
    	$result = pg_query($db, $sql) or die ("Ikke mulig å hente informasjon om samkjøringer");

    	if (pg_num_rows($result) > 0) {
    		while($row = pg_fetch_assoc($result)) {
        		$resid = $row["resid"];
        		$fra = ucfirst($row["fra"]);
        		$til = ucfirst($row["til"]);
        		$tidspunkt = $row["tidspunkt"];

       			$tid = date("d/m/Y H:i", $tidspunkt);
				$temptid = explode(" ", $tid);
				$dato = $temptid[0];
				$klokkeslett = $temptid[1];

				echo "<div class='jumbotron'>
				<a class='btn btn-info float-right' href='registrertkjoring.php?id=".$resid."'> Mer informasjon</a>
				<table>
				<tr><td><h4>$fra - $til</h4></tr></td>
				<tr><td><h5> $dato - $klokkeslett </h5></td></tr>
				</table>

				</div>";
   			}
		}
		else{
			echo "<div class='alert alert-info' role='alert'><strong>Du er ikke registrert i noen samkjøringer</div>";
		}
    }
    echo "</div>";
?>

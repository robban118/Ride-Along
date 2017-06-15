<?php
	$header = "Glemt passord";
	include("head.php");
	include("navbar.php");

	if(isset($_SESSION["id"])){
		echo "<div class='container'>";
		echo "<div class='alert alert-danger' role='alert'>Du er allerede innlogget</div>";
	}
	else{

		echo '<div class="section-title">
   		      <h2>Glemt passord</h2>
   			  <p>Her kan du få hjelp til å endre ditt passord</p>
 		      </div>';
		echo "<div class='container'>";
		echo "<div class='row'><div class='col-sm-6'>";
		echo "<div class='formboks'>";
		echo "<form method='post' class='form-group' action='' onsubmit='return valGlemtPW()'>";
		echo "<input type='text' class='form-control' placeholder='E-postadresse' autocomplete='off' id='epost' name='epost' required/>";
		echo "<input type='submit' style='margin:1% 0 0 0' value='Glemt passord' class='btn btn-primary' name='glemtpw' id='glemtpw'/>";
		echo "</form></div></div><div class='col-sm-6'>";

		@$glemtpw = $_POST["glemtpw"];
		if($glemtpw){
			$epost = $_POST["epost"];
			$sql = "SELECT id, fornavn FROM bruker WHERE email='$epost';";
			$result = pg_query($db, $sql) or die ("<div class='alert alert-danger' role='alert'>Ikke mulig å koble til databasen</div>");
			if(pg_num_rows($result) > 0){
				//lager en ny kode som den gir til bruker
				$kode = md5($epost.time());
				
				while($rad = pg_fetch_array($result)){
					$id = $rad["id"];
					$fornavn = $rad["fornavn"];
				}
				$sql = "UPDATE bruker SET verifiseringskode = '$kode' WHERE id = $id;";
				pg_query($db, $sql) or die ("<div class='alert alert-danger' role='alert'>Ikke mulig å endre i databasen</div>");

				$subject = "RideAlong glemt passord";

				$melding = "Hei, $fornavn \r\n \r\n";
				$melding .= "Trykk på linken under for å endre passord, dersom du ikke har bedt om dette bare ignorer meldingen \r\n";
				$melding .= "https://ridealong.top/nyttpassord.php?kode=$kode \r\n \r\n";
				$melding .= "Hilsen RideAlong.top";

				//sender en epost med link og litt info
				sendEpost($epost, $subject, $melding);

				echo "<div class='alert alert-info' role='alert'>Du har nå fått en epost med en link der du kan endre passord.</div>";
			}
			else{
				echo "<div class='alert alert-danger' role='alert'>Denne eposten er ikke registrert hos Ride Along</div>";
			}
		}
		echo "</div></div>";
	}

	echo "<div id='melding'></div>";
	echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
 ?>
<?php
	$header = "Endre passord";
	include("head.php");
	include("navbar.php");

	echo "<div class='container'>";
	if(isset($_SESSION["id"])){
		//sier ifra om bruker er innlogget og stopper der
		echo "<br><strong><div class='alert alert-info' role='alert'>Du er innlogget</strong></div>";
	}
	else{

		echo '<div class="section-title">
   			  <h2>Bytt passord</h2>
 			  </div>';

		if (!isset($_GET["kode"])){
			echo "<br><div class='alert alert-info' role='alert'>Trykk på lenken du fikk på mail</div>"; 
		}
		else{
			//sjekker om verifiseringskoden eksiterer i databsaen
			$kode = $_GET["kode"];
			$sql = "SELECT id FROM bruker where verifiseringskode = '$kode';";
			$resultat = pg_query($db, $sql) or die ("<br><div class='alert alert-warning' role='alert'>Ikke mulig å hente fra databasen</div>");

			if(pg_num_rows($resultat) > 0){
				//setter opp et form for endrepassord
				echo "<div class='row'><div class='col-sm-6'><div class='formboks'>";
				echo "<form method='post' class='form-group' action='' onsubmit='return valNyPw()'>";
				echo "<input type='password' class='form-control' required placeholder='Nytt passord' name='pw' id='pw'/></br>";
				echo "<input type='password' class='form-control' required placeholder='Gjenta passord' name='verpw' id='verpw'/></br>";
				echo "<input type='submit' style='1% 0 0 0' class='btn btn-primary' value='Endre passord' name='endrepw'/>";
				echo "</form></div></div><div class='col-sm-6'>";
				echo "<div style='visibility:hidden' class='alert alert-danger' role='alert' id='melding'></div>";
				
				@$endrepw = $_POST["endrepw"];
				if($endrepw){
					while($rad = pg_fetch_array($resultat)){
						$id = $rad["id"];
					}

					$pw = $_POST["pw"];
					$verpw = $_POST["verpw"];
					//ser om passordene er like og eksisterer
					if($pw === $verpw && strlen($pw) > 0){
						//hasher passordet og lager ny verifiseringskode
						$passord =  password_hash($pw, PASSWORD_DEFAULT);
						$nyverif = md5($id . time());
						//legger inn passord og verifisert til database dersom brukeren ikke er verifisert
						$sql = "UPDATE bruker SET verifisert = '1', passord = '$passord', verifiseringskode = '$nyverif' WHERE id = $id;";
						pg_query($db, $sql) or die ("Ikke mulig å endre passord");

						echo "<div class='alert alert-success' role='alert'><strong>Passordet ditt er nå endret, trykk <a data-toggle='modal' href='#popform'>her</a> for å logge inn</strong></div>";
					}
					else{
						echo "<div class='alert alert-info' role='alert'><strong>Passordene matcher ikke</strong></div>";
					}
				}
				echo "</div>";
			}
			else{
				echo "<div class='alert alert-warning' role='alert'><strong>Denne henvendelsen er ikke aktiv</strong></div>";
			}
		}
	}
	
	echo "</div><div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
 ?>
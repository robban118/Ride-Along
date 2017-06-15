<?php
    $header = "Registrer bil";
    include("head.php");
    include("navbar.php");
    $fornavn=$_SESSION['fornavn'];
    
    if(!isset($_SESSION["id"])){
    	include("directscript.html");
    }
    else{
		echo "<div class='section-title'>
   		   	  <h2>Manuell registrering av kjøretøy</h2>
  		      <p></p>
              </div>";
		echo "<div class='container'>";
		echo "<div class='row'>";
		echo "<div class='col-sm-6'>";
		echo "<div class='formboks'>";
    	echo "<form method='post' class='form-group' action='' onsubmit='return valManBil()'>";
    	echo "<input type='text' class='form-control' placeholder='Registreringsnummer' required name='bilnr' id='bilnr'/></br>";
    	echo "<input type='text' class='form-control' placeholder='Merke og modell' required name='merke' id='merke'/></br>";
    	echo "<input type='text' class='form-control' placeholder='Farge' required name='farge' id='farge'/></br>";
    	echo "<input type='text' class='form-control' placeholder='Antall seter' required name='seter' id='seter'/></br>";
    	echo "<input type='submit' style='margin:1% 0 0 0' class='btn btn-primary' value='Registrer' name='reg'/></form></div></div>";

		echo "<div class='col-sm-6'>";

    	@$reg = $_POST["reg"];
    	if($reg){
            //legger inn alle felter i array og sjekekr om de har fått post verdi
    		$required = array("bilnr", "merke", "farge", "seter");
    		$error = validerFelter($required);
				
				if($error){
                    echo "<div class='alert alert-info' role='alert'> Du må fylle inn alle feltene</div>";
                }
                else{
                	$feilmeldinger = array();
                	$bilnr = strtoupper($_POST["bilnr"]);
                	$merke = $_POST["merke"];
                	$farge = $_POST["farge"];
                	$seter = $_POST["seter"];

                	if(!valReg($bilnr)){
                		array_push($feilmeldinger, "<div class='alert alert-warning' role='alert'>Bilnummeret er ikke i gyldig format</div>");
                	}
                	if (!is_numeric($seter)){
                		array_push($feilmeldinger, "<div class='alert alert-warning' role='alert'>Antall seter må være et tall</div>");
                	}
                    //legger bilen inn i databasen
                	if(count($feilmeldinger) == 0){
                		$sql = "SELECT * FROM bil WHERE bilnr='$bilnr';";
                		$res = pg_query($db, $sql) or die ("Ikke mulig å hente bil fra database");
                		if(pg_num_rows($res) == 0){
                			$id = $_SESSION["id"];
                			$sql = "INSERT INTO bil (bilnr, modell, seter, farge, id) VALUES ('$bilnr', '$merke', '$seter', '$farge', '$id');";
                			pg_query($db, $sql) or die ("Ikke mulig å registrere bil i DB");

                			echo "<div class='alert alert-info' role='alert'>Følgende bil er registrert</div>
							   <table class='table table-striped table-info'>
							   <tr><td>Registreringsnummer:</td><td> $bilnr</td></tr>
							   <tr><td>Modell:</td><td> $merke</td></tr>
							   <tr><td>Antall Seter:</td><td> $seter</td></tr>
							   <tr><td>Farge:</td><td> $farge</td></tr>
							   </table>";
                		}
                		else{
                			echo "<div class='alert alert-danger' role='alert'>Bilen er registrert fra før</div>";
                		}
                	}
                	else{
                        //printer eventuelle feilmeldinger
                		foreach($feilmeldinger as $mld){
                			echo $mld;
                		}
                	}
                }
    	}
    }
    echo "<div style='visibility:hidden' class='alert alert-danger' role='alert' id='melding'></div>";
	echo "</div></div><div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
?>
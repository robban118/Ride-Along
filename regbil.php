<?php
    session_start();
    $header = "Behandle kjøretøy";
    include("db.php");
    include("funksjoner.php");
    include("head.php");
    //include("cover.html");
    $fornavn=$_SESSION['fornavn'];
    include("navbar.php");

	if(!isset($_SESSION["fornavn"])){
    include("directscript.html");
	}
	else{
		
		
		echo "<div class='section-title'>
   		   	  <h2>Administrer kjøretøy</h2>
  		      <p>Her kan du registrere og slette kjøretøy!</p>
              </div>";

	    echo "<div class='container'><div class='row'><div class='col-sm-6'><div class='formboks'>";
		echo "<h5>Registrer kjøretøy</h5>";
		echo "<form action='' class='form-group inline' method='post' name='regform' onsubmit='return valRegBil()'> ";
	    echo "<input type='text' required class='form-control' name='bilnr' id='bilnr' maxlength='8' placeholder='Registreringsnummer'> </br>";
		echo "<input type='submit' value='Registrer kjøretøy' class='btn btn-primary' name='reg'>";
		echo "</form></div></br>";

		@$reg = $_POST["reg"];
		if($reg){
	        $required = array("bilnr");
	        $error = validerFelter($required);

	        if($error){
	            echo "<br><div class='alert alert-info' role='alert'> Du må fylle inn alle feltene</div>";
	        }
	        else{
	            $bilnr = $_POST["bilnr"];
	            //validerer bilnummre og henter data fra vegvesenet
	            if(valReg($bilnr)){
	                $bilinfo = hentBilData($bilnr);
	                $regnr = str_replace(" ", "", $bilinfo[0]);
	                $modell = $bilinfo[1];
	                $seter = $bilinfo[2];
	                $farge = $bilinfo[3];
	                $id = $_SESSION["id"];

	                //hvis noe går galt så sender den deg til et manuelt registreringsform
	                if(strlen($regnr) == 0 || strlen($modell) == 0|| strlen($seter) == 0 || strlen($farge) == 0){
	                	echo "<div class='alert alert-danger' role='alert'>Her gikk noe galt, <a href='manregbil.php'><strong>trykk her</strong></a> for å bruke vår manuell registrering av kjøretøyopplysninger</div>";
	                }
	                else{
	                	//sjekker om bilen er registrert fra før
	                	$sqlsetning = "SELECT * FROM bil WHERE bilnr='$regnr';";
	                	$resultat = pg_query($db,$sqlsetning) or die ("Ikke mulig å hente bilder fra DB");
	                	if(pg_num_rows($resultat) == 0){

	                		//putter bilen inn i databasen og printer ut info om at bilen er registrert
			                $sqlsetning = "INSERT INTO bil (bilnr, modell, seter, farge, id) VALUES ('$regnr', '$modell', '$seter', '$farge', '$id');";
			                $query = pg_query($db, $sqlsetning) or die ("<div class='alert alert-danger' role='alert'>Beklager, noe gikk galt, vennligst prøv igjen senere</div>");

		               		echo "<div class='alert alert-info' role='alert'>Følgende bil er registrert</div>
							   <table class='table table-striped table-info'>
							   <tr><td>Registreringsnummer:</td><td> $regnr</td></tr>
							   <tr><td>Modell:</td><td> $modell</td></tr>
							   <tr><td>Antall Seter:</td><td> $seter</td></tr>
							   <tr><td>Farge:</td><td> $farge</td></tr>
							   </table>
							   </br>";
		            	}
		            	else{
		            		echo "<div class='alert alert-danger' role='alert'>Bilen er registrert fra før</div>";
		            	}
		            }
	            }
	            else{
	                echo "<div class='alert alert-danger' role='alert'>Finner ikke bilnummer</div>";
	            }
	        }
	    }

		echo "<div class='alert alert-danger' role='alert' style='visibility:hidden' id='melding'></div>";
			echo "</div>";

			echo "<div class='col-sm-6'><div class='formboks'>";
			echo "<h5>Slett kjøretøy</h5>";
        //SLETT KJØRETØY
		$id = $_SESSION["id"];
        $sqlsetning="SELECT * FROM bil WHERE id=$id;";
        $sqlresultat=pg_query($db,$sqlsetning) or die ('Ikke mulig å hente fra database');
        $antallrader=pg_num_rows($sqlresultat);
        if($antallrader == 0){
            echo "</div></div><br><div class='alert alert-danger' role='alert'>Ingen biler er registrert</div>";
        }
        else{ 
            echo ("<form method='post' action='' name='bilsletting'>");
            include("listeboksslettbil.php");
            echo ("<input type='submit' class='btn btn-danger' name='slettbil' value='Slett kjøretøy'>");
            echo ("</form> </br>");

            @$slettbil = $_POST["slettbil"];
            if($slettbil){
                $biltilslett = $_POST["biltilslett"];
                $bilarray = explode(";", $biltilslett);
                if($bilarray[1] != 0){
                    echo "</div></div><br><div class='alert alert-warning' role='alert'>Vennligst slett samkjøring(er) som er registrert til denne bilen</div>";
                }
                else{
                    $bilnr = $bilarray[0];
                    $sql = "DELETE FROM resbil WHERE bilnr='$bilnr';
                    DELETE FROM bil WHERE bilnr='$bilnr';";
                    pg_query($db, $sql) or die ("Ikke mulig å slette bil fra DB");

                    echo "</div></div><br><div class='alert alert-success' role='alert'>Bilen er nå slettet</div>";
                }
            }
        }
		echo "</div></div></div></div>";
	}
	

	
	echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
?>

<?php
	$header="Registrer bruker";
	include("head.php");
	include("navbar.php");
	
    if(!isset($_SESSION["id"])){

        	echo "<div class='container'>";
            echo  "<div class='section-title'>
           		   <h2>Registrer bruker!</h2>
          		   <p>Her kan du registrere deg!</p>
                   </div>";
            
        	echo "<div class='row'>
            <div class='col-sm-6'>
            <div class='formboks'>";
        	
        	echo "<form action='' class='form-group' method='post' onsubmit='return valRegBruker()'> ";
            echo "<input type='text' required class='form-control' id='epost' name='epost' placeholder='E-postadresse'> </br>";
            echo "<input type='password' required class='form-control' id='passord' name='passord' placeholder='Passord'> </br>";
        	echo "<input type='text' required id='fornavn' class='form-control' name='fornavn' placeholder='Fornavn'></br> ";
        	echo "<input type='text' required class='form-control' id='etternavn' name='etternavn' placeholder='Etternavn'> </br>";
            echo "<input type='text' required class='form-control' id='telefon' name='telefon' placeholder='Telefon' maxlength='8' size='8'> </br>";
            echo "<input type='checkbox' required name='betingelser' value='betingelser'> Jeg godtar <a target='_blank' href='betingelser.php'><strong>betingelsene</strong></a> til RideAlong<br></br>";
        	echo "<input type='submit' class='btn btn-primary' value='Registrer' name='reg'>";
        	echo "</form> 
            
            </div></div>";
            
            echo "<div class='col-sm-6'>";
            echo "<div style='visibility:hidden' class='alert alert-danger' role='alert' id='melding'></div>";

        	@$reg = $_POST["reg"];
        	if($reg){
                //sjekker om alle feltene har verdier
                $feilmeldinger = array();
                $required = array("epost", "passord", "fornavn", "etternavn", "telefon");
                $error = validerFelter($required);

                if($error){
                    echo "<div class='alert alert-info' role='alert'> Du må fylle inn alle feltene</div>";
                }
                else{
                    $epost = strtolower($_POST["epost"]);
                    
                    //sjekker om eposten er registrert i database
                    $sjekkepost = "SELECT * FROM bruker WHERE lower(email) = lower('$epost');";
                    $sjekkepostresult = pg_query($db, $sjekkepost) or die ("Ikke mulig å hente epost fra databasen");
                    if (pg_num_rows($sjekkepostresult) != 0){
                        array_push($feilmeldinger, "Eposten er registrert fra før");
                    }
                    //henter betingelse checkbox
                    if(!isset($_POST["betingelser"])){
                        array_push($feilmeldinger, "Du må godta betingelsene til RideAlong");
                    }

                    //henter data og hasher passord
                    $passord = password_hash($_POST["passord"], PASSWORD_DEFAULT);
                    $fornavn = strtolower($_POST["fornavn"]);
                    $etternavn = strtolower($_POST["etternavn"]);
                    $telefon = $_POST["telefon"];

                    //lager en unik verifiseringskode med epost og timestamp
                    $tid = time();
                    $verifiseringskode = md5($epost.$tid);

                    //validerer telefon og epost
                    if(!filter_var($epost, FILTER_VALIDATE_EMAIL)){
                        array_push($feilmeldinger, "Din epost er ikke gyldig ");
                    }

                    if(!is_numeric($telefon) || strlen($telefon) != 8){
                        array_push($feilmeldinger, "Telefonnummeret er ikke i gyldig format");
                    }

                }

                //hvis alt er ok putter dataen inn i databse og sender verifiseringskoden på mail
                if (count($feilmeldinger) == 0){
                    $sqlsetning = "INSERT INTO bruker (email, passord, fornavn, etternavn, telefon, verifiseringskode) VALUES (lower('$epost'), '$passord', lower('$fornavn'), lower('$etternavn'), '$telefon', '$verifiseringskode');";

                    pg_query($db, $sqlsetning) or die ("");

                    sendVerif($epost, $verifiseringskode);

        			echo "<div class='alert alert-success' role='alert'>Bruker er registrert </div>";
        			echo "<div class='alert alert-info' role='alert'>En verifiseringskode er sent til ". $epost . "</div>";
                }
                else{
                    foreach ($feilmeldinger as $melding){
                        echo "<div class='alert alert-danger' role='alert'>$melding </div>";
                    }
                }
            }
            //info på siden
                echo "<div class='formboks'><h6>Viste du at...</h6><p>For å kunne registrere reise må man også registrere et kjøretøy.. Dette registreres for kjennemerke, og for deres egen sikkerhet. Registrer krever at du er innlogget, så registrer deg først!</p>
            <a href='regbil.php' class='btn btn-warning'>Registrer bil</a>
            </div><br>";
        		echo ("</div></div></div>");
                


                //robert


                

                echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
    }
    else{
        echo "<div class='container'>";
        echo "<div class='alert alert-danger' role='alert'> Du har allerede en buker, hva gjør du her?</div></div>";
    }
?>
<?php
    $header = "Endre bruker";
    include("head.php");
    $fornavn=$_SESSION['fornavn'];
    include("navbar.php");

    if(!isset($_SESSION["id"])){
        include("directscript.html");
    }
    else{
        $id = $_SESSION["id"];
        $sql = "SELECT email, telefon, passord FROM bruker WHERE id=$id;";
        $resultat = pg_query($db, $sql) or die ("Ikke mulig å hente brukerinformasjon");
        
        while ($rad = pg_fetch_assoc($resultat)){
            $epost = $rad["email"];
            $tlf = $rad["telefon"];
            $passord = $rad["passord"];
        }

        //form venstre/info
        echo  "<div class='section-title'>
   		       <h2>Endre bruker</h2>
  		       <p>Her kan du endre din brukerinformasjon</p>
               </div>";
        echo "<div class='container'><div class='row'><div class='col-sm-6'><div class='formboks'>";
        echo "<h3>Brukerinfo</h3>";
        echo "<form method='post' class='form-group' action='' onsubmit='return valEndreBruker()'>";
        echo "<input type='text' class='form-control' name='nyepost' id='nyepost' value='$epost'/></br>";
        echo "<input type='text' class='form-control' value='$tlf' id='nytlf' name='nytlf' placeholder='Telefon'/></br>";
        echo "<input type='submit' class='btn btn-primary' value='Endre brukerinformasjon' name='endre'/></br>";
        echo "</form></div>";

        //endrer epost og/eller telefonnummer
        @$endre = $_POST["endre"];
        if($endre){
            $feilmeldinger = array();

            $required = array("nyepost", "nytlf");

            $error = validerFelter($required);

            if($error){
                echo "<br><div class='alert alert-info' role='alert'> Du må fylle inn alle feltene</div>";
            }
            else{
                $nyepost = strtolower($_POST["nyepost"]);
                $nytlf = strtolower($_POST["nytlf"]);
                
                if(!filter_var($nyepost, FILTER_VALIDATE_EMAIL)){
                    array_push($feilmeldinger, "Din epost er ikke gyldig ");
                }

                if(!is_numeric($nytlf) || strlen($nytlf) != 8){
                    array_push($feilmeldinger, "Telefonnummeret er ikke i gyldig format");
                }
                
                $sql = "SELECT * FROM bruker WHERE email= '$nyepost' AND id != $id;";
                $res = pg_query($db, $sql) or die ("Ikke mulig å hente epost fra database");
                if (pg_num_Rows($res) > 0){
                    array_push($feilmeldinger, "Eposten er registrert fra før");
                }

                if (count($feilmeldinger) == 0){
                    $sql = "UPDATE bruker SET email = '$nyepost', telefon = '$nytlf' WHERE id=$id;";                        
                    pg_query($db, $sql) or die ("Ikke mulig å oppdatere brukerinformasjon");
                    echo "<br><div class='alert alert-success' role='alert'>Du har nå oppdatert din brukerinformasjon</div>";
                }
                else{
                    foreach ($feilmeldinger as $melding){
                        echo "<br><div class='alert alert-danger' role='alert'>$melding </div>";
                    }
                }

            }
        }
        echo "<br><div style='visibility:hidden' class='alert alert-danger' role='alert' id='melding'></div>";
        
    
        //form høyre/passord
        echo "</div><div class='col-sm-6'><div class='formboks'>";
        echo "<h3>Passord</h3>";
        echo "<form method='post' class='form-group' action='' onsubmit='return valEndrePw()'>";
        echo "<input type='password' class='form-control' id='pw' name='passord' placeholder='Gammelt passord' required/></br>";
        echo "<input type='password' required class='form-control' id='nypw' name='nypassord' placeholder='Nytt passord'/></br>";
        echo "<input type='password' required class='form-control' id='verpw' name='verpassord' placeholder='Gjenta nytt passord'/></br>";
        echo "<input type='submit' value='Endre passord' class='btn btn-primary' name='endrepw' placeholder='Endre passord'><br>";
        echo "</form></div>";

        
        //endrer passord
        @$endrepw = $_POST["endrepw"];
        if($endrepw){
            $required = array("passord", "nypassord", "verpassord");
            $error = validerFelter($required);
            if($error){
                echo "<br><div class='alert alert-info' role='alert'> Du må fylle inn alle feltene</div>";
            }
            else{
                $oldpw = $_POST["passord"];
                $nypw = $_POST["nypassord"];
                $verpw = $_POST["verpassord"];

                if(password_verify($oldpw, $passord)){
                    if($nypw === $verpw){
                        $pw = password_hash($verpw, PASSWORD_DEFAULT);
                        $sql = "UPDATE bruker SET passord='$pw' WHERE id = $id;";
                        pg_query($db, $sql) or die ("Ikke mulig å endre passord");
                        
                        echo "<br><div class='alert alert-success' role='alert'>Passordet er nå endret</div>";
                    }
                    else {
                        echo "<br><div class='alert alert-warning' role='alert'>De nye passordene matcher ikke</div>";
                    }
                }
                else{
                    echo "<br><div class='alert alert-danger' role='alert'>Feil passord</div>";
                }
            }
        }
        
    }
    echo "<br><div style='visibility:hidden' class='alert alert-danger' role='alert' id='melding2'></div>";
    echo "</div></div></div>";
    echo "</div></div><div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
    ?>


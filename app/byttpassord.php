<?php 

include("../db.php");
include("../funksjoner.php");
//
$id = $_POST["id"];
$oldpw = $_POST["oldpw"];
$nypw = $_POST["nypw"];
$verpw = $_POST["verpw"];

//bytter passord
$sql = "SELECT passord FROM bruker WHERE id=$id;";
        $resultat = pg_query($db, $sql) or die ("");
        
        while ($rad = pg_fetch_assoc($resultat)){
            $passord = $rad["passord"];
        }
                

                if(password_verify($oldpw, $passord)){
                	
                    

                    if($nypw === $verpw){
                        $pw = password_hash($verpw, PASSWORD_DEFAULT);
                        $sql = "UPDATE bruker SET passord='$pw' WHERE id = $id;";
                        pg_query($db, $sql) or die ("Ikke mulig å endre passord");
                        
                        echo "PassordEndret";
                    }
                    else{
                    	echo "feil";
                    }

}





 ?>

<?php 

//registerer bil


include("db.php");
include("../funksjoner.php");

$id = $_POST["id"];
$bilnr = strtoupper($_POST["bilnr"]);
    if(valReg($bilnr)){
        $bilinfo = hentBilData($bilnr);
        $regnr = str_replace(" ", "", $bilinfo[0]);
        $modell = $bilinfo[1];
        $seter = $bilinfo[2];
        $farge = $bilinfo[3];

        if(strlen($regnr) == 0 || strlen($modell) == 0|| strlen($seter) == 0 || strlen($farge) == 0){
        	echo "Ukjentbilnummer";
        }
        else{
        	$sqlsetning = "SELECT * FROM bil WHERE lower(bilnr)=lower('$regnr');";
        	$resultat = pg_query($db,$sqlsetning) or die ("Ikke mulig å hente bilder fra DB");
        	if(pg_num_rows($resultat) == 0){

                $sqlsetning = "INSERT INTO bil (bilnr, modell, seter, farge, id) VALUES ('$regnr', '$modell', '$seter', '$farge', '$id');";
                $query = pg_query($db, $sqlsetning) or die ("Kan ikke sette inn i DB");

           		echo "Bilregistrert";
        	}
    }
}

 ?>
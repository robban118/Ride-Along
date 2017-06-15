<?php
    $kode = $_GET["kode"];
    
    if(!$kode){
        header("Location: index.php");
    }
    else{
        //setter verifisert 1 dersom koden matcher og sender deg til forsiden
        include("db.php");
        $sqlsetning = "UPDATE bruker SET verifisert = '1' WHERE lower(verifiseringskode) = lower('$kode');";
        pg_query($db, $sqlsetning) or die ("Noe gikk galt");
        header("Location: index.php");
    }
?>
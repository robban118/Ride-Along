<?php 

function hentBilData($brukerID, $regnr){

    include("db.php");


$sqlSetning = "SELECT * FROM bruker where id='$brukerID'";
    $sqlRes = pg_query($db, $sqlSetning) or die ("");
    $count = pg_num_rows($sqlRes);
    $array = pg_fetch_array($sqlRes);

   if($count == 1 && $array["verifisert"]== 1){

        $regnr = str_replace(" ", "", $regnr);
        @$page = file_get_contents('http://www.vegvesen.no/kjoretoy/Kjop+og+salg/Kjøretøyopplysninger?registreringsnummer='.$regnr);
        

        $doc = new DOMDocument();

        @$doc->loadHTML('<?xml encoding="UTF-8">'. $page);
        $node = $doc->getElementsByTagName('td');

        foreach($doc->getElementsByTagName('td') as $node){
            @$keywords[] = strtoupper($node->nodeValue);
            @$reg = $keywords[0];
            @$type = ucwords(strtolower($keywords[1]));
            @$dorer = $keywords[4];
            @$farge = ucwords(strtolower($keywords[5]));

        }

        $te = str_replace(" ", "", $reg);
        $dorer = $dorer -1;
        
        $sqlInsert ="INSERT INTO bil (bilnr,modell,seter,id,farge) VALUES ('$te','$type','$dorer','$brukerID','$farge')";
        pg_query($sqlInsert);
        
        echo "BilRegOK";

        
    }
    else if($count != 1 && $array["verifisert"]!=1){
        echo "BilRegIkkeOK";
    }

    }

function brukerUtenBil(){

}


    $brukerID = $_POST["brukerID"];
    $regnr = $_POST["regnr"];
    
    hentBilData($brukerID,$regnr);
    
    

    
    
    
 ?>
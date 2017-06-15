<?php
    session_start();
    include("db.php");
    //valider    bilnummer
    function valReg($bilnr){
        $valreg = false;

        $bilnr = str_replace(" ", "", $bilnr);
        @$page = file_get_contents('http://www.vegvesen.no/kjoretoy/Kjop+og+salg/Kjøretøyopplysninger?registreringsnummer='.$bilnr);

        $doc = new DOMDocument();

        @$doc->loadHTML('<?xml encoding="UTF-8">'. $page);
        $node = $doc->getElementsByTagName('td');

        foreach($doc->getElementsByTagName('td') as $node){
            @$keywords[] = strtoupper($node->nodeValue);
            @$reg = $keywords[0];
            @$type = $keywords[1];
            //@$klasse = $keywords[2];
            @$seter = $keywords[4];
            @$farge = $keywords[5];
        }

        if(strlen(str_replace(" ", "", $reg)) == 7){
            $valreg = true;
        }
        else {
            $valreg = false;
        }
        return $valreg;
    }
    //hent bildata
    function hentBilData($bilnr){
        $bilnr = str_replace(" ", "", $bilnr);
        @$page = file_get_contents('http://www.vegvesen.no/kjoretoy/Kjop+og+salg/Kjøretøyopplysninger?registreringsnummer='.$bilnr);

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
        $bilinfo = array();
        array_push($bilinfo, $reg, $type, $dorer, $farge);

        return $bilinfo;
    }

    //valider felter
    function validerFelter($array){
        $error = false;
        foreach($array as $field){
            if (empty($_POST["$field"])){
                $error = true;
	       }
        }
        return $error;
    }

    //send verifieringskode på epost
    function sendVerif($epost, $kode) {
        $to = $epost;

        $subject = "Ridealong - Verifiser din bruker";
        $message = "http://ridealong.top/bekreftelse.php?kode=$kode";
        $headers = "From: Ridealong";

        mail($to,$subject,$message,$headers);
    }
    //kontaktform
    function kontaktEpost($navn, $fra, $melding){
        $to = "samkjoring@gmail.com";

        $subject = "Kontakt oss - Ridealong";
        $message = $melding . "\r\n" . $fra;
        $headers = "From: $fra";

        mail($to, $subject, $message, $headers);
    }
    //sendepost
    function sendEpost($epost, $subject, $melding){
        $to = $epost;

        $subject = $subject;
        $message = $melding;
        $headers = "From: Ridealong";

        mail($to,$subject,$message,$headers);
    }
?>
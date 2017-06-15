<?php
    session_start();
    include("db.php");
    
    //valider    bilnummer
    function valReg($bilnr){
        $valreg = false;
        if(strlen(str_replace(" ", "", $bilnr)) == 7){
            $valreg = true;
        }
        else {
            $valreg = false;
        }
        return $valreg;
    }

    //henter inforamsjon om bil fra vegvesenet
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

    //sjekk tomme felter.
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
        $message .= "\r\n" . "Velkommen til Ride Along! Klikk på lenken for å verifisere brukeren... Du vil da også bli fraktet tilbake til forsiden.";
        $headers = "From: Ridealong";

        mail($to,$subject,$message,$headers);
    }

    //Contact form, sender med navn og epost til bruker så vi kan svare
    function kontaktEpost($navn, $fra, $melding){
        $to = "samkjoring@gmail.com";

        $subject = "Kontakt oss - Ridealong";
        $message = $melding . "\r\n" . $fra;
        $headers = "From: $fra";

        mail($to, $subject, $message, $headers);
    }

    //generell send epost funksjon
    function sendEpost($epost, $subject, $melding){
        $to = $epost;

        $subject = $subject;
        $message = $melding;
        $headers = "From: Ridealong";

        mail($to,$subject,$message,$headers);
    }

    //multibyte ucfirst så vi kan æ ø å i stor bokstav dersom behovet er der
    function mb_ucfirst($string, $encoding='UTF-8') {
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, mb_strlen($string, $encoding)-1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
?>
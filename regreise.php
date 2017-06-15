<?php
    //TODO BLOKKE CASUALS UTEN BIL
    session_start();
    $header = "Registrer reise";
    include("db.php");
    include("funksjoner.php");
    include("head.php");
    $fornavn=$_SESSION['fornavn'];
    include("navbar.php");

	 if (!isset($_SESSION["id"])){
		  include("directscript.html");
	 }
	else{

    echo "<div class='container'>";
    echo  "<div class='section-title'>
   		   <h2>Registrer reise</h2>
  		   <p>Her kan du tilby andre å sitte på!</p>
           </div>";

    echo "<div class='container'>";
    echo "<div class='row'><div class='col-sm-6'><div class='formboks'>";
    echo "<form action='' class='form-group' method='post' onsubmit='return valRegReise()'>";
    echo "<input type='text' required class='form-control' name='fra' placeholder='Fra' id='fra'> </br>";
    echo "<input type='text' required class='form-control' name='til' placeholder='Til' id='til'> </br>";
    echo "<input type='text' required class='form-control' name='moteplass' placeholder='Møteplass' id='moteplass'> </br>";
    echo "Dato:<br>";
    echo "<br>";
    include("listeboksdato.php");
    echo "</br>";
    echo "Reiser klokka: </p>";
	  include('listebokstid.php');
    echo "</br>";
    include('listeboksbil.php');
    echo "</br>";
    echo "<input type='text' class='form-control' name='kommentar' placeholder='Legg til kommentar... (Kan stå tomt)'> </br>";
    echo "<input type='submit' class='btn btn-primary' name='reg'>";
    echo "</form></div></div>";
  
    echo "<div class='col-sm-6'>";
    
      


    @$reg = $_POST["reg"];
    if($reg){
      //sjekker om felter er fylt
      $feilmeldinger = array();
			$required = array("til", "fra", "dag", "maned", "ar", "moteplass", "plasser", "time", "minutt", "bilnr");
      $error = validerFelter($required);

      if($error){
        echo "<div class='alert alert-info' role='alert'> Du må fylle inn alle feltene. Kommentarfeltet kan være tomt</div>";
      }
      else{
        $fra = strtolower($_POST["fra"]);
        $til = strtolower($_POST["til"]);
        $plasser = $_POST["plasser"];
        $dag = $_POST["dag"];
        $mnd = $_POST["maned"];
        $year = $_POST["ar"];
        $timer = $_POST["time"];
        $minutter = $_POST["minutt"];
        $kommentar = strtolower($_POST["kommentar"]);
		    $bilnr = $_POST["bilnr"];
		    $moteplass = strtolower($_POST["moteplass"]);
        //sjekker om datoen er en ovlig dato
        $lovligdato = checkdate($mnd, $dag, $year);

        $dato = strtotime("$year-$mnd-$dag $timer:$minutter");
        //sjekker om datoen har vært
        if($dato < time()){
          array_push($feilmeldinger, "Vennligst velg en dato som ikke har vært");
        }

        if(!$lovligdato){
          array_push($feilmeldinger, "Du må velge en gyldig dato");
        }
      }

      if(count($feilmeldinger) == 0){
        //gjør om dato til timestamp
        $id=$_SESSION["id"];
		    $timestamp = strtotime("$year-$mnd-$dag $timer:$minutter");

        //putter reisen inn i databasen
        $sqlsetning = "
        INSERT INTO resbil (fra, til, maxplasser, tidspunkt, bilnr, id, moteplass, kommentar) VALUES ('$fra', '$til', '$plasser', '$timestamp', '$bilnr', '$id', '$moteplass', '$kommentar');
        SELECT currval('resbil_resid_seq');";
		    $sqlresultat = pg_query($db, $sqlsetning) or die ("<div class='alert alert-alert' role='alert'>Noe gikk galt</div>");

        //henter reservasjonsid og linker til bruker
        while($row = pg_fetch_array($sqlresultat)){
          $resid = $row[0];
        }        
        echo "<div class='alert alert-success' role='alert'>Reisen er nå publisert!</div>";
        echo "<a class='btn btn-success' href='eier.php?resid=" . $resid ."'>Din nye reise</a><br>";
      }
      else{
        foreach ($feilmeldinger as $melding){
          echo "<div class='alert alert-danger' role='alert'>$melding </div>";
        }
      }
    }
    echo "<br><div class='formboks'>";
    echo "<h6>Viste du at...</h6><p>For å kunne registrere reise må man også registrere et kjøretøy.. Dette registreres for kjennemerke, og for deres egen sikkerhet!</p>
    <a href='regbil.php' class='btn btn-warning'>Registrer bil</a>
    </div><br>";

    
    echo "</div></div>";
}
echo "<div class='alert alert-danger' role='alert' style='visibility:hidden' id='melding'></div>";
    
    echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
  ?>
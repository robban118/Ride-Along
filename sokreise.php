<?php
session_start();
$header = "Søk";
include("head.php");
include("navbar.php");
echo "<div class='container'>";

$fornavn=$_SESSION['fornavn'];

$sok = strtolower($_GET["sok"]);

if(!isset($_SESSION["id"])) {
  echo"<div class='container'><div class='alert alert-warning' role='alert'>Du må logge inn for å se denne siden</div><a data-toggle='modal' class='btn btn-warning' href='#popform'>Logg inn</a></div>";
}
else {
   
	if(!$_GET){
		echo "<div class='alert alert-danger' role='alert'>Du har ikke noen søkestreng</div>";
    
	}
	else{

    echo "<div class='section-title'>
   		   <h2>Hvor vil du reise?</h2>
  		   <p>Søk og reis</p>
          </div>";

    echo "<script>
             $('#popform').modal('hide')
                                </script>";
    
      $id = $_SESSION["id"];
  		include_once("class_lib.php");
      //henter aktive samkjøringer som matcher med søk
      $sql = "SELECT * FROM resbil WHERE resbil.maxplasser > (SELECT COUNT(*) FROM resbruker WHERE resbil.resid = resbruker.resid) AND (tidspunkt > cast(extract(epoch from current_timestamp) as integer)) AND (lower(resbil.fra) LIKE '%$sok%' OR lower(resbil.til) LIKE '%$sok%') AND id != $id ORDER BY tidspunkt ASC;";
      $sqlresultat = pg_query($db, $sql) or die ("Ikke mulig å hente fra databasen");
    $antallrader=pg_num_rows($sqlresultat);

    echo '
      <div class="sokbar">
      <form method="get" action="sokreise.php">
      <div class="input-group">
      <input type="text" class="form-control" data-target="#sok" placeholder="Trykk her for å søke på nytt?" value="'.$sok.'" required id="sok" name="sok">
      <span class="input-group-btn">
      <button class="btn btn-secondary" type="submit">Kjør!</button>
      </span>
      </div>
      </form>
      </div> </br>';


    if ($antallrader == 0){
      echo "<div class='alert alert-warning'>Ingen samkjøringer matchet $sok</div>";
      
    }
    else{
      $samkjoringarray = array();
      //henter informasjon fra query
      for ($r=1; $r<=$antallrader; $r++){
        $rad = pg_fetch_array($sqlresultat);
        $tidspunkt=$rad["tidspunkt"];
        $resid = trim($rad["resid"]);
        $plasser = $rad["maxplasser"];
        $fra = $rad["fra"];
        $til = $rad["til"];
        $id = $rad["id"];
        $kommentar = $rad["kommentar"];
        $moteplass = $rad["moteplass"];

        //henter seter
        $sqlsetning = "SELECT COUNT(*) AS plasser FROM resbruker WHERE resid='$resid';";
        $resultat = pg_query($db, $sqlsetning) or die ("Ikke mulig å hente antall plasser");

        while($row = pg_fetch_array($resultat)){
          $maxplasser = $row["plasser"];
        }


        $verdier = array($tidspunkt, $resid, $plasser, $fra, $til, $id, $kommentar, $moteplass, $maxplasser);
        //lager en Samkjrøing med veridre
        $samkjoring = new Samkjoring($verdier);

        array_push($samkjoringarray, $samkjoring);
        }
      //printer ut 2 og 2 på 
      $i=0;
      echo "<div class='row'>";
        foreach($samkjoringarray as &$sk){
          echo $sk->vis();
        if($i==1){
          echo "</div><div class='row'>";
          $i=0;
        }
        else{
          $i++;
        }
      }
      echo "<script>
             $('#popform').modal('hide')
                                </script>";
    }echo "</div></div>";
	 }
  }

  echo "<div class='section-title'><h2><i class='fa fa-car fa-lg'></i></h2></div>";
?>
<?php
	$id = $_SESSION["id"];
	$sqlsetning="SELECT * FROM bil WHERE id=$id;";
	$sqlresultat=pg_query($db,$sqlsetning) or die ('Ikke mulig å hente fra database');
	$antallrader=pg_num_rows($sqlresultat);
	print('<div class="form-group"><label for="Bil">Kjøretøy</label>');
	//lager en listebox med ajax som henter seter til bilen 
	print('<select class="form-control" name="bilnr" id="bilnr" onchange="hentseter(this.value)">');
	for ($r=1; $r<=$antallrader; $r++){
			if($r == 1){
				echo "<option value=''>Velg bil</option>";
			}
			$rad = pg_fetch_array($sqlresultat);
			$bilnr=$rad["bilnr"];
			$modell = $rad["modell"];
			print("<option value='$bilnr'>$modell - $bilnr</option>");
    }
	print('</select> </br>');

	$sql = "SELECT seter FROM bil WHERE lower(bilnr)=lower('$bilnr');";
    $result = pg_query($db, $sql) or die ("Ikke mulig å hente antall seter");

    while ($rad = pg_fetch_row($result)){
        $seter = $rad[0];
    }

    //listeboks seter per bil
    echo "<div id='txtHint'>";
		echo "<label for='plasser'>Hvor mange har du plass til?</label>";
    echo "<select class='form-control' name='plasser' id='plasser'>";
    for ($i = 1; $i<$seter; $i++){
       echo "<option value='$i'>$i</option>";
    }
    echo "</select>";
	echo "</div></div>";
?>

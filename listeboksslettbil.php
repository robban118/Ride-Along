<?php
	$id = $_SESSION["id"];
	//$sqlsetning="SELECT * FROM bil WHERE id=$id;";
	//$sqlresultat=pg_query($db,$sqlsetning) or die ('Ikke mulig å hente fra database');
	//$antallrader=pg_num_rows($sqlresultat);
	print('<div class="form-group">');
	print('<select class="form-control" name="biltilslett" id="biltilslett">');
	for ($r=1; $r<=$antallrader; $r++){
			$rad = pg_fetch_array($sqlresultat);
			$bilnr=$rad["bilnr"];
			$modell = $rad["modell"];

			$sql = "SELECT * FROM resbil WHERE bilnr='$bilnr' AND (tidspunkt > cast(extract(epoch from current_timestamp) as integer));";
			$res = pg_query($db, $sql) or die ("Ikke mulig å hente info om bil");
			$kjoringexist = pg_num_rows($res);

			$verdi = $bilnr . ";" . $kjoringexist;

			print("<option value='$verdi'>$bilnr - $kjoringexist aktive samkjøring(er)</option>");
    }
	print('</select> </br>');
?>

<?php
    include("db.php");
    $bilnr = $_GET['bilnr'];

    //henter seter fra bil og putter inn i listeboks
    $sql = "SELECT seter FROM bil WHERE lower(bilnr)=lower('$bilnr');";
    $result = pg_query($db, $sql) or die ("Ikke mulig å hente antall seter");

    while ($rad = pg_fetch_row($result)){
        $seter = $rad[0];
    }

    echo "<label for='plasser'>Antall seter</label>";
    echo "<select class='form-control' name='plasser' id='plasser'>";
    //fjerner setet til sjåføren
    for ($i = 1; $i<$seter; $i++){
       echo "<option value='$i'>$i</option>";
    }
    echo "</select>";
    echo "</div>";
?>
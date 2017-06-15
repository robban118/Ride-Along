<?php 
include("db.php");

$bilnr = $_POST["bilnr"];

                if(strlen($bilnr) == 7){
                    $sql = "SELECT * FROM resbil WHERE lower(bilnr) = lower('$bilnr');";
                    $res = pg_query($db, $sql) or die ("Ikke mulig å hente fra DB");
                    while($rad = pg_fetch_assoc($res)){
                        $resid = $rad["resid"];
                        $sql = "DELETE FROM resbruker WHERE resid='$resid';";
                        pg_query($db, $sql) or die ("Ikke mulig å slette bruker"); 
                    }

                    $sqldel = "DELETE FROM resbil WHERE lower(bilnr) = lower('$bilnr');
                            DELETE FROM bil WHERE lower(bilnr) = lower('$bilnr');";
                    pg_query($db, $sqldel) or die ("Ikke mulig å slette bil fra DB");

                    echo "slettet";
                }

 ?>

   <!-- Modal -->
   <div class="modal fade" id="popform" role="dialog">
     <div class="modal-dialog">

       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Vennligst logg inn</h4>
         </div>
         <div class="modal-body">

           <?php


           if(!isset($_SESSION["id"])){
           echo "";
           echo "<h3>Logg inn</h3>";
           echo "<form method='post' id='check' class='form-group'  action=''>";
           echo "<input type='text' class='form-control' placeholder='E-postadresse' required name='epost'></br>";
           echo "<input type='password' class='form-control' placeholder='Passord' required name='passord'></br>";
           echo "<input type='submit' value='Logg inn' class='btn btn-primary' name='login'>";
           /*echo "<button type='button' class='btn btn-info' href='regbruker.php'>Registrer deg her!</button>";*/
           echo "</form>";
           echo "<br><center><p>Er du ikke registrert, <a href='regbruker.php'>klikk her</a></p></center>";
          // echo "<a href='glemtpassord.php' class='btn btn-secondary knapp'>Glemt passord?</a>";
           //echo "<a href='regbruker.php' class='btn btn-secondary knapp'>Registrer bruker</a>";
         }


         @$login = $_POST["login"];
         if($login){
             $required = array("epost", "passord");
             $error = validerFelter($required);
             if($error){
                 echo "<div class='alert alert-warning' role='alert'>Alle felter må fylles ut</div>";
                 echo "<script>
             $('#popform').modal({'backdrop': 'staic'})
                                </script>";
             }
             else{
                 include("db.php");
                 $email = $_POST["epost"];
                 $passord = $_POST["passord"];

                 $sql = "SELECT id, fornavn, verifisert, passord FROM bruker WHERE email='$email';";
                 $resultat = pg_query($db, $sql) or die ("Noe gikk galt");

                 $info = pg_fetch_array($resultat);

                 if(password_verify($passord, $info["passord"])){
                     if($info["verifisert"] == 0){
                         echo "<div class='alert alert-danger' role='alert'>Bruker er ikke verifisert</div>";

                         echo "<script>
             $('#popform').modal({'backdrop': 'staic'})
                                </script>";
                     }
                     else{
                         $_SESSION["id"] = $info["id"];
                         $_SESSION["fornavn"] = $info["fornavn"];

                         echo "<div class='alert alert-info' id='victory' role='alert'> Hei " . $_SESSION["fornavn"];
                         echo("</div>");
                         echo "<script>
             $('#popform').modal('hide')
                                </script>";


                         //SJEKK MEG HVIS SHIT IKKE FUNGERER

                         if(isset($_GET["sok"])){
                           $sok = $_GET["sok"];
                           header ("Location: sokreise.php?sok=".$sok);
                         }
                         else{
                           echo "<meta http-equiv='refresh' content='0'>";
                         }
                     }
                 }
                 else {

                   echo "<script>
                    $('#popform').modal({'backdrop': 'staic'})
                                </script>";
                   echo "<div class='alert alert-danger' id='error' role='alert'>Brukernavn og passord stemmer ikke!";
                 }
                 
             }
         }
         ?>
         </div>
         <div class="modal-footer">
           
           <a href='glemtpassord.php' class='btn btn-secondary knapp'>Glemt passord?</a>
           
           <button type="button" class="btn btn-danger"  data-dismiss="modal">Lukk</button>
         </div>

         

       </div>

     </div>
   </div>

 </div>

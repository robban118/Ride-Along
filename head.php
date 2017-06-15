<?php require_once("funksjoner.php");
$fornavn = $_SESSION["fornavn"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta name="description" content="Ride Along er din optimale mellommann for å planlegge å samkjøre med andre. Registrer en bil, tilby andre å sitte på eller velg selv å sitte på med andre.">
  <meta name="keywords" content="Samkjøre,Ridealong,Ride,Along,Reise,USN,HSN,Bachelor">
    <link rel="shortcut icon" type="image/ico" href="img/litenlogo.png" />
    <!--<meta charset="utf-8">-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <!-- petter kuka litt -->
    <title>Ride Along | <?php echo htmlentities($header) ?></title>
    <!--Viewport device etc-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--fontawesome-->
<script src="https://use.fontawesome.com/c73716577b.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!--Bootstrap-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<!--Egen css-->
<link rel="stylesheet" href="css/styles.css" type="text/css">
<link rel="stylesheet" href="stylesheet.css" type="text/css">
    <!--Jquery js-->

    

    <!--Kalender-->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">
</script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous">
</script>
<!--jquery calendar-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!--jquery calendar slutt-->

    <!--Kalender slutt-->

<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

<!--Egendefinert javascript-->
<script src="js/funksjoner.js"></script>
<script src="js/validation.js"></script>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#f3f3f3"
    },
    "button": {
      "background": "#5cb6d1",
      "text": "#ffffff"
    }
  },
  "theme": "classic",
  "position": "bottom-left",
  "content": {
    "message": "Denne nettsiden bruker cookies for å forbedre brukeropplevelsen.\n",
    "dismiss": "OK!",
    "link": "Les mer!"
  }
})});
</script>
  
  </head>
<?php include_once("analyticstracking.php") ?>
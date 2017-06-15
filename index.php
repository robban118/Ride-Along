<?php
    session_start();
    $header = "Forsiden";
    include("head.php");
    include("cover.html");
    $fornavn=$_SESSION['fornavn'];
    include("navbar.php");
    
  include("bodyfooter.html");

?>

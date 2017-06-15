<?php include("modal.php"); ?>
<nav class="navbar navbar-toggleable-md navbar-inverse bg-info navbar-full" id="nav-main">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php"><img src="img/litenlogo.png"></a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link active" href="index.php"><i class="fa fa-home fa-lg"></i> Hjem <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="omoss.php"><i class="fa fa-info-circle fa-lg"></i> Om oss</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="index.php"><i class="fa fa-search fa-lg"></i> Finn ny reise</a>
      </li>



    </ul>
    <ul class="nav navbar-nav navbar-right">


    <?php
     if(!isset($_SESSION["fornavn"])) {
      echo "<li class='nav-item active'>";
      echo "<a class='nav-link' href='regbruker.php'>Registrer bruker <i class='fa fa-user-plus fa-lg'></i></a>";
      echo "</li> <li class='nav-item active'>";

      /*echo "<a class='nav-link' href='login.php'>Logg inn</a>";*/
      echo "<a class='nav-link' data-toggle='modal' href='#popform'>Logg inn <i class='fa fa-sign-in fa-lg'></i></a>";
      echo "</li>";
    }
    else {

      echo "<li class='nav-item active'><a class='nav-link' href='dinside.php'>".mb_ucfirst($fornavn)." <i class='fa fa-user fa-lg'></i> Din side</a></li>";
      echo "<li class='nav-item active'><a class='nav-link' href='logut.php'>Logg ut <i class='fa fa-sign-out fa-lg'></i></a></li>";
    }
  ?>


    </ul>
  </div>

</nav>

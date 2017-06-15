<?php
	//avslutter session og sender bruker til index
	session_start();
  	session_destroy();
  	header("Location:index.php");
  ?>

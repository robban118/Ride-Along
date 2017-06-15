<?php

//logger inn bruker
include ("db.php");
/*$_POST["user_name"]  $_POST["password"]*/
@$user = strtolower($_POST["user_name"]);
@$passord = $_POST["password"];
$sql = "SELECT * FROM bruker where email like '$user'";
$result = pg_query($db, $sql) or die("Feil....");

$info = pg_fetch_array($result);

if(password_verify($passord, $info["passord"])){
	if ($info["verifisert"] == 1){
		//echo "Velkommen";
		echo "Velkommen";

	}
	else if($info["verifisert"] == 0){
		echo "IkkeVerifisertBruker";
	}
	
	
}
else{
	echo "LoginMisslyktes";
}
/*
if(mysqli_num_rows($result) > 0){
	$row = mysqli_fetch_array($result);
	//$name = $row["fornavn"];
	//echo"<div class='borteborte'>";
	echo "Velkommen";
	//echo "</div>";
}

else{
	//echo"<div class='borteborte'>";
	echo "feil";
	//echo "</div>";
}
*/

?>
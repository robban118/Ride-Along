//validering endrebuker.php
function valEndreBruker() {
	var epost = document.getElementById("nyepost").value;
	var tlf = document.getElementById("nytlf").value;
	var lovligepost = true;
	var lovligtlf = true;
	var feilmelding = "";

	if(!epost || !tlf){
		feilmelding = feilmelding + "Du må fylle inn alle feltene </br>";
	}

	if(!validateEmail(epost)){
		lovligepost = false;
		feilmelding = feilmelding + "Du må fylle inn en gyldig epostadresse </br>";
	}
	if(isNaN(tlf) || tlf.length > 8 || tlf.length < 8){
		lovligtlf = false;
		feilmelding = feilmelding + "Du må fylle inn et gyldig telefonnummer";
	}

	if(epost && tlf && lovligepost && lovligtlf){
		document.getElementById("melding").style.visibility='hidden';
		return true;
	}
	else{
		document.getElementById("melding").innerHTML = feilmelding;
		document.getElementById("melding").style.visibility='visible';
		return false;
	}
}

function valEndrePw() {
	var pw = document.getElementById("pw").value;
	var nypw = document.getElementById("nypw").value;
	var verpw = document.getElementById("verpw").value;
	var feilmelding = "";
	var lovlig = true;

	if(!pw || !nypw || !verpw){
		feilmelding = feilmelding + "Du må fylle inn alle feltene </br>";
		lovlig = false;
	}
	if(nypw !== verpw){
		feilmelding = feilmelding + "De nye passordene matcher ikke </br>";
		lovlig = false;
	}

	if(lovlig){
		document.getElementById("melding2").style.visibility='hidden';
		return true;
	}
	else{
		document.getElementById("melding2").innerHTML = feilmelding;
		document.getElementById("melding2").style.visibility='visible';
		return false;
	}
}

//valider glemtpassord
function valGlemtPW(){
	var epost = document.getElementById("epost").value;
	var lovlig = true;
	var feilmelding = "";

	if(!validateEmail(epost)){
		lovlig = false;
		feilmelding = feilmelding + "Du må velge en gyldig epostadresse</br>";
	}

	if(epost && lovlig){
		document.getElementById("melding").style.visibility='hidden';
		return true;
	}
	else{
		document.getElementById("melding").innerHTML = feilmelding;
		document.getElementById("melding").style.visibility='visible';
		return false;
	}
}

//valider registrer bil
function valManBil(){
	var bilnr = document.getElementById("bilnr").value;
	var merke = document.getElementById("merke").value;
	var farge = document.getElementById("farge").value;
	var seter = document.getElementById("seter").value;
	var lovlig = true;
	var feilmelding = "";

	var	bilnr = bilnr.replace(" ", "");

	if(bilnr.length > 7 || bilnr.length < 7){
		lovlig = false;
		feilmelding = feilmelding + "Du må putte inn et gyldig bilnummer </br>";
	}
	if(isNaN(seter)){
		lovlig = false;
		feilmelding = feilmelding + "Antall seter må være et tall </br>";
	}
	if(hasNumbers(farge)){
		lovlig=false;
		feilmelding = feilmelding + "Fargen din kan ikke være et tall";
	}

	if(bilnr && merke && farge && seter && lovlig){
		document.getElementById("melding").style.visibility='hidden';
		return true;
	}
	else{
		document.getElementById("melding").innerHTML = feilmelding;
		document.getElementById("melding").style.visibility='visible';
		return false;
	}
}

//valider nyttpassord
function valNyPw(){
	var pw = document.getElementById("pw").value;
	var verpw = document.getElementById("verpw").value;
	var lovlig = true;
	var feilmelding = "";

	if(pw !== verpw){
		lovlig = false;
		feilmelding = feilmelding + "Passordene er ikke like";
	}

	if(pw && verpw && lovlig){
		document.getElementById("melding").style.visibility='hidden';
		return true;
	}
	else{
		document.getElementById("melding").innerHTML = feilmelding;
		document.getElementById("melding").style.visibility='visible';
		return false;
	}
}

//valider regbil
function valRegBil(){
	var bilnr = document.getElementById("bilnr").value;
	var lovlig = true;
	var feilmelding = "";

	var	bilnr = bilnr.replace(" ", "");

	if(bilnr.length > 7 || bilnr.length < 7){
		lovlig = false;
		feilmelding = feilmelding + "Du må putte inn et gyldig bilnummer </br>";
	}

	if(bilnr && lovlig){
		document.getElementById("melding").style.visibility='hidden';
		return true;
	}
	else{
		document.getElementById("melding").innerHTML = feilmelding;
		document.getElementById("melding").style.visibility='visible';
		return false;
	}
}

//valider registrer bruker
function valRegBruker(){
	var epost = document.getElementById("epost").value;
	var passord = document.getElementById("passord").value;
	var fornavn = document.getElementById("fornavn").value;
	var etternavn = document.getElementById("etternavn").value;
	var tlf = document.getElementById("telefon").value;
	var lovlig  = true;
	var feilmelding = "";

	if(isNaN(tlf) || tlf.length > 8 || tlf.length < 8){
		lovlig = false;
		feilmelding = feilmelding + "Du må fylle inn et gyldig telefonnummer </br>";
	}
	if(!validateEmail(epost)){
		lovlig = false;
		feilmelding = feilmelding + "Du må fylle inn en gyldig epostadresse </br>";
	}
	if(hasNumbers(fornavn) || hasNumbers(etternavn)){
		lovlig = false;
		feilmelding = feilmelding + "Fornavn og etternavn kan ikke ha tall i seg </br<";
	}

	if(epost && passord && fornavn && etternavn && tlf && lovlig){
		document.getElementById("melding").style.visibility='hidden';
		return true;
	}
	else{
		document.getElementById("melding").innerHTML = feilmelding;
		document.getElementById("melding").style.visibility='visible';
		return false;
	}
}

function valRegReise(){
	var dag = document.getElementById("dag").value;
	var mnd = document.getElementById("mnd").value;
	var ar = document.getElementById("ar").value;
	var time = document.getElementById("time").value;
	var minutt = document.getElementById("minutt").value;
	var fra = document.getElementById("fra").value;
	var til = document.getElementById("til").value;
	var moteplass = document.getElementById("moteplass").value;
	var idag = Date.now();
    var dato = new Date(ar, mnd, dag, time, minutt, 0, 0).getTime();
	var lovlig = true;
	var feilmelding = "";

	if(!fra || !til || !moteplass){
		feilmelding = feilmelding + "Du må fylle inn alle feltene, men kommentarer kan stå tomt";
		lovlig = false;
	}

	if (dato < idag){
		feilmelding = feilmelding + "Du må velge et tidspunkt som ikke har vært</br>";
		lovlig = false;
	}
	if(fra && til && moteplass && lovlig){
		document.getElementById("melding").style.visibility='hidden';
		return true;
	}
	else {
		document.getElementById("melding").innerHTML = feilmelding;
		document.getElementById("melding").style.visibility='visible';
		return false;
	}
}

//valider epost
function validateEmail(elementValue) {      
   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
   return emailPattern.test(elementValue); 
 }

function hasNumbers(t) {
	var regex = /\d/g;
	return regex.test(t);
}    
<?php
	$header = "Din side"; 
	include("head.php");
	include("navbar.php");
$fornavn=$_SESSION['fornavn'];

if(!isset($_SESSION["id"])){
  echo "<div class='container'><div class='alert alert-warning' role='alert'>Du må logge inn for å se denne siden</div><a data-toggle='modal' class='btn btn-warning' href='#popform'>Logg inn</a></div>";

}
else{
 ?>


 <div class="section-title">
   <h2>Din side</h2>
   <p>Dette er ditt personlige dashboard</p>
 </div>

 <div class="container">
 <div class="sokbar">
  <form method="get" action="sokreise.php">
    <div class="input-group">
  <input type="text" class="form-control" data-target='#sok' placeholder="Hvor vil du reise?" required id="sok" name="sok">
  <span class="input-group-btn">
    <button class="btn btn-secondary" type="submit">Kjør!</button>
  </span>
</div>
</form>
</div>
 
  <div class="row">
	<!--Finn samkjøring-->
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <div class="card">
      <a href="samkjoringer.php"><img class="card-img-top img-fluid" src="img/nysamkjoring.jpg" width="100%" alt="Card Trafikk"></a>
      <div class="card-block">
        <h4 class="card-title"><a href="samkjoringer.php">Finn samkjøring</a></h4>
        <p class="card-text">Her registrerer du ditt kjørertøy, vi sjekker om bilen eksisterer for vår og deres sikkerhet.</p>
      </div>
    </div>
  </div>



 

<!--Dine samkjøringer-->
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
   <div class="card">
     <a href="samkjoringeier.php"><img class="card-img-top img-fluid" href="regreise.php.php" src="img/sjoafor.jpg" width="100%" alt="Card mann i bil"></a>
     <div class="card-block">
       <h4 class="card-title"><a href="samkjoringeier.php">Dine samkjøringer</a></h4>
       <p class="card-text">Her ser du hvilke samkjøringer du selv har registrert. Like eller dislike spørsmål fra de som har hengt på.</p>
     </div>
   </div>
 </div>
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
   <div class="card">
     <a href="dinesamkjoringer.php"><img class="card-img-top img-fluid" src="img/sammen.jpg" width="100%" alt="Card Sykkel kjærestepar"></a>
     <div class="card-block">
       <h4 class="card-title"><a href="dinesamkjoringer.php">Påmeldte samkjøringer</a></h4>
       <p class="card-text">De samkjøringene du har hengt på. Her kan du velge å legge inn spørsmål om akutelle saker.</p>
     </div>
   </div>
 </div>

</div>

<div class="row">
<!--Påmeldte samkjøringer-->
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
   <div class="card">
     <a href="regreise.php"><img class="card-img-top img-fluid" src="img/Finnsamkjoring.jpg" width="100%" alt="Card Taxi, tafikk, storby"></a>
     <div class="card-block">
       <h4 class="card-title"><a href="regreise.php">Legg til ny samkjøring</a></h4>
       <p class="card-text">Her kan du legge til ny samkjøring hvor du tilbyr andre å sitte på.</p>
     </div>
   </div>
</div>
 


<!--Registrer ny samkjøring-->
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
   <div class="card">
     <a href="regbil.php"><img class="card-img-top img-fluid"  src="img/regkjoretoy.jpg" width="100%" alt="Card moped, kjøretøy, flerfeltsvei"></a>
     <div class="card-block">
       <h4 class="card-title"><a href="regbil.php">Administrer kjøretøy</a></h4>
       <p class="card-text">Vi sjekker om bilen eksisterer for vår og deres sikkerhet.</p>
     </div>
   </div>
   </div>

   


<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
   <div class="card">
     <a href="endrebruker.php"><img class="card-img-top img-fluid" src="img/brukerinformasjon.jpg" width="100%" alt="Card åpen vei"></a>
     <div class="card-block">
       <h4 class="card-title"><a href="endrebruker.php">Endre bruker</a></h4>
       <p class="card-text">Her kan du endre dine brukeropplysninger.</p>
     </div>
   </div>
 </div>
</div>
</div>

  <!-- Contact/footer Section Start -->
	<section id="contact_section">
		<div class="contact_section">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<div class="section-title">
							<h2>Kontakt oss</h2>
							<p>Kontakt oss gjerne om du finner feil eller mangler</p>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								
								<ul class="nav flex-column">
									<li class="nav-item">
										<a class="nav-link active" href="omoss.php">Om oss</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="betingelser.php">Betingelser</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="regbruker.php">Registrer bruker</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="regbil.php">Registrer bil</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="regreise.php">Registrer samkjøring</a>
									</li>
									</ul>

								
								<div class='section-title'><h2><a href="#" class="btn btn-secondary" role="button">Til toppen <i class="fa fa-arrow-up" aria-hidden="true"></i></a></h2></div>
								
								</div>

						
							
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div style="padding-bottom:20%" class="contact_form">
									<div id="show_contact_msg"></div>
								<!-- Contact Form Start -->
									<form method="post" id="contact_form" action="contact.php">
										<input type="text" id="contact_name" name="name" class="form-control contact_input_box wow fadeInUp" placeholder="Navn" required/>
										<input type="email" id="contact_email" name="email" class="form-control contact_input_box wow fadeInUp" placeholder="E-post" required/>
										<textarea id="contact_text" name="message" rows="10" cols="30" class="form-control contact_input_box wow fadeInUp" placeholder="Melding" required></textarea>
										<button type="submit" class="btn btn-success contact_button wow fadeInUp"> <i class="fa fa-send-o"></i>  Send </button>
									</form>

									
								<!-- Contact Form End -->

               </div>
             </div>
         </div>
       </div>
     </div>
     </div>
   </div>
 </section>
<?php
  }
?>
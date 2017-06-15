<?php
	class Samkjoring {
		public $tidspunkt;
		public $resid;
		public $plasser;
		public $maxplass;
		public $fra;
		public $til;
		public $id;
		public $kommentar;
		public $moteplass;
		public $opptatt;


		public function __construct($values){
			$this->tidspunkt = $values[0];
			$this->resid = $values[1];
			$this->plasser = $values[2];
			$this->fra = mb_ucfirst($values[3]);
			$this->til = mb_ucfirst($values[4]);
			$this->id = $values[5];
			$this->kommentar = $values[6];
			$this->moteplass = mb_ucfirst($values[7]);
			$this->opptatt = $values[8];
		}
		//viser samkjøringer
		public function vis(){
			$tid = date("d/m/Y H:i", $this->tidspunkt);
			$temptid = explode(" ", $tid);
			$dato = $temptid[0];
			$klokkeslett = $temptid[1];


			$ledigeplasser = ($this->plasser - $this->opptatt);
			if($ledigeplasser > 0){
				$getid = $this->resid;
				
			return "<div class='col-sm-6'><div class='jumbotron'>" . "<h3>" . $this->fra . " - " . $this->til . "</h3>" . "</br><strong>" . $ledigeplasser. " </strong>ledige plass(er)<br><table style='width:20%; margin=5%'><tr><td>Dato:</td><td>" . $dato . "</td></tr> </strong></br><tr><td>Tid:</td><td> " . $klokkeslett . "</td></tr></table><a class='btn btn-secondary float-right' href='samkjoring.php?id=$getid'>Les mer</a></br></br></div></div>";

		}
	}
	}
?>

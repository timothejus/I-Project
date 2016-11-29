<?php

    class Voorwerp
    {

        private $voorwerpnummer;
        private $titel;
        private $beschrijving;
        private $startprijs;
        private $betalingswijze;
        private $betalingsinstructie;
        private $plaatsnaam;
        private $land;
        private $looptijd;
        private $looptijdBegindagTijdstip;
        private $verzendkosten;
        private $verzendInstructies;
        private $verkoper;  // user class
        private $koper;    //user class
        private $looptijdEindeDag;
        private $veilingGesloten;
        private $verkoopPrijs;

        //afbeeldingen
        private $afbeeldingen;
        //rubriek
        private $rubriek;


		//construcor
        function __construct($voorwerpnummer,$titel,$beschrijving,$startprijs,$betalingswijze,$betalingsinstructie,$plaatsnaam,$land,$looptijd,$looptijdBegindagTijdstip,$verzendkosten,$verzendInstructies,$verkoper,$koper,$looptijdEindeDag,$veilingGesloten,$verkoopPrijs,$rubriek)
        {
            $this->$voorwerpnummer = $voorwerpnummer;
            $this->$titel = $titel;
            $this->$beschrijving = $beschrijving;
            $this->$startprijs = $startprijs;
            $this->$betalingswijze = $betalingswijze;
            $this->$betalingsinstructie = $betalingsinstructie;
            $this->$plaatsnaam = $plaatsnaam;
            $this->$land = $land;
            $this->$looptijd = $looptijd;
            $this->$looptijdBegindagTijdstip = $looptijdBegindagTijdstip;
            $this->$verzendkosten = $verzendkosten;
            $this->$verzendInstructies = $verzendInstructies;
            $this->$verkoper = $verkoper;
            $this->$koper = $koper;
            $this->$looptijdEindeDag = $looptijdEindeDag;
            $this->$veilingGesloten = $veilingGesloten;
            $this->$verkoopPrijs = $verkoopPrijs;
        }

        //properties
        public function getVoorwerpnummer()
        {
            return $this->voorwerpnummer;
        }

        public function getTitel(){
	        return $this->titel;
        }

        public function getBeschrijving(){
	        return $this->beschrijving;
        }

        public function getStartprijs(){
        	return $this->startprijs;
        }

        public function getBetalingswijze(){
        	return $this->betalingswijze;
        }

	    public function getBetalingsInstructie(){
		    return $this->betalingsinstructie;
	    }

	    public function getPlaatsnaam(){
		    return $this->plaatsnaam;
	    }

	    public function getLand(){
		    return $this->land;
	    }

	    public function getLooptijd(){
		    return $this->looptijd;
	    }

	    public function getLooptijdBegindagTijdstip(){
		    return $this->looptijdBegindagTijdstip;
	    }

	    public function getVerzendkosten(){
		    return $this->verzendkosten;
	    }

	    public function getVerzendInstructies(){
		    return $this->verzendInstructies;
	    }

	    public function getVerkoper(){
		    return $this->verkoper;
	    }

	    public function getKoper(){
		    return $this->koper;
	    }

	    public function getLooptijdEindedag(){
		    return $this->looptijdEindeDag;
	    }

	    public function getVeilingGesloten(){
		    return $this->looptijdEindeDag;
	    }

	    public function getVerkoopprijs(){
		    return $this->verkoopPrijs;
	    }

	    //functies

	    public function getVoorwerpen()
	    {
		   /* $query = query("SELECT * FROM deelnemers WHERE deelnemerID=:id", array(
			    "id" => $deelnemerID
		    ));
		   */

		   $DB = getConnection();
		   $DB->query("SELECT * FROM Voorwerp");
		    # setting the fetch mode
		    $DB->setFetchMode(PDO::FETCH_ASSOC);

		    while($row = $DB->fetch()) {
		    	$voorwerp = new Voorwerp($row["Voorwerpnummer"],$row["Titel"],$row["Beschrijving"],$row["Startprijs"],$row["Betalingswijze"],$row["Betalingsinstructie"],);

		    }



		    if ($query->rowCount() > 0) {

		    }
		    else {
			    die("deelnemer not found!");
		    }
	    }

	    private function fill(array $row)
	    {
		    $this->voorwerpnummer = $row["Voorwerpnummer"];
		    $this->titel = $row["Titel"]);
		    $this->beschrijving = $row["Beschrijving"];
		    $this->startprijs = $row["Startprijs"];

	    }

    }

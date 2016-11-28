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


        function __construct($voorwerpnummer,$titel,$beschrijving,$startprijs,$betalingswijze,$betalingsinstructie,$betalingsinstructie,$plaatsnaam,$land,$looptijd,$looptijdBegindagTijdstip,$verzendkosten,$verzendInstructies,$verkoper,$koper,$looptijdEindeDag,$veilingGesloten,$verkoopPrijs,$rubriek)
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

        public function getVoorwerpnummer()
        {
            return this->$this->voorwerpnummer;
        }
    }

<?php

/**
 * Created by IntelliJ IDEA.
 * User: Jip Brouwer
 * Date: 28-11-2016
 * Time: 14:40
 * Class user
 */
class user
{
	//instance variabelen
	private $gebruikersnaam;
	private $voornaam;
	private $achternaam;
	private $adresregel1;
	private $adresregel2;
	private $postcode;
	private $plaatsnaam;
	private $land;
	private $geboortenaam;
	private $mailadres;
	private $isVerkoper;
	private $geheimeVraag;
	private $antwoordGV;
	private $telefoonNummer;


	/**
	 * @return mixed
	 */
	public function getTelefoon()
	{
		return $this->telefoonNummer;
	}

	/**
	 * @param mixed $telefoonNummer
	 */
	public function setTelefoon()
	{
		$this->telefoonNummer = getTelefoonNummer($this->gebruikersnaam);
	}




	/**
	 * @return mixed
	 */
	public function getAntwoordGV()
	{
		return $this->antwoordGV;
	}

	/**
	 * @param mixed $antwoordGV
	 */
	public function setAntwoordGV($antwoordGV)
	{
		$this->antwoordGV = $antwoordGV;
	}

	/**
	 * @return mixed
	 */
	public function getGeheimeVraag()
	{
		return $this->geheimeVraag;
	}

	/**
	 * @param mixed $geheimeVraag
	 */
	public function setGeheimeVraag($geheimeVraag)
	{
		$this->geheimeVraag = $geheimeVraag;
	}

	/**
	 * user constructor.
	 * @param $gebruikersnaam
	 * @param $voornaam
	 * @param $achternaam
	 * @param $adresregel1
	 * @param $postcode
	 * @param $plaatsnaam
	 * @param $land
	 * @param $geboortenaam
	 * @param $mailadres
	 * @param $isVerkoper
	 */
	function __construct($gebruikersnaam,$voornaam,$achternaam,$adresregel1,$adresregel2,$postcode,$plaatsnaam,$land,$geboortenaam,$mailadres,$geheimeVraag,$antwoordGV)
	{
		$this->gebruikersnaam = $gebruikersnaam;
		$this->voornaam = $voornaam;
		$this->achternaam = $achternaam;
		$this->adresregel1 = $adresregel1;
		$this->adresregel2 = $adresregel2;
		$this->postcode = $postcode;
		$this->plaatsnaam = $plaatsnaam;
		$this->land = $land;
		$this->geboortenaam = $geboortenaam;
		$this->mailadres = $mailadres;
		$this->geheimeVraag = $geheimeVraag;
		$this->antwoordGV = $antwoordGV;

		$this->setTelefoon();
	}

	/**
	 * @return mixed
	 */
	public function getAdresregel2()
	{
		return $this->adresregel2;
	}

	/**
	 * @param mixed $adresregel2
	 */
	public function setAdresregel2($adresregel2)
	{
		$this->adresregel2 = $adresregel2;
	}

	/**
	 * @return mixed
	 */
	public function getGebruikersnaam()
	{
		return $this->gebruikersnaam;
	}

	/**
	 * @param mixed $gebruikersnaam
	 */
	public function setGebruikersnaam($gebruikersnaam)
	{
		$this->gebruikersnaam = $gebruikersnaam;
	}

	/**
	 * @return mixed
	 */
	public function getVoornaam()
	{
		return $this->voornaam;
	}

	/**
	 * @param mixed $voornaam
	 */
	public function setVoornaam($voornaam)
	{
		$this->voornaam = $voornaam;
	}

	/**
	 * @return mixed
	 */
	public function getAchternaam()
	{
		return $this->achternaam;
	}

	/**
	 * @param mixed $achternaam
	 */
	public function setAchternaam($achternaam)
	{
		$this->achternaam = $achternaam;
	}

	/**
	 * @return mixed
	 */
	public function getAdresregel1()
	{
		return $this->adresregel1;
	}

	/**
	 * @param mixed $adresregel1
	 */
	public function setAdresregel1($adresregel1)
	{
		$this->adresregel1 = $adresregel1;
	}

	/**
	 * @return mixed
	 */
	public function getPostcode()
	{
		return $this->postcode;
	}

	/**
	 * @param mixed $postcode
	 */
	public function setPostcode($postcode)
	{
		$this->postcode = $postcode;
	}

	/**
	 * @return mixed
	 */
	public function getPlaatsnaam()
	{
		return $this->plaatsnaam;
	}

	/**
	 * @param mixed $plaatsnaam
	 */
	public function setPlaatsnaam($plaatsnaam)
	{
		$this->plaatsnaam = $plaatsnaam;
	}

	/**
	 * @return mixed
	 */
	public function getLand()
	{
		return $this->land;
	}

	/**
	 * @param mixed $land
	 */
	public function setLand($land)
	{
		$this->land = $land;
	}

	/**
	 * @return mixed
	 */
	public function getGeboortenaam()
	{
		return $this->geboortenaam;
	}

	/**
	 * @param mixed $geboortenaam
	 */
	public function setGeboortenaam($geboortenaam)
	{
		$this->geboortenaam = $geboortenaam;
	}

	/**
	 * @return mixed
	 */
	public function getMailadres()
	{
		return $this->mailadres;
	}

	/**
	 * @param mixed $mailadres
	 */
	public function setMailadres($mailadres)
	{
		$this->mailadres = $mailadres;
	}

	/**
	 * @return mixed
	 */
	public function getIsVerkoper()
	{
		return $this->isVerkoper;
	}

	/**
	 * @param mixed $isVerkoper
	 */
	public function setIsVerkoper($isVerkoper)
	{
		$this->isVerkoper = $isVerkoper;
	}

	public function updateContacten($voornaam,$achternaam,$geboortedatum,$adres,$postcode,$plaatsnaam,$land,$telefoonnummer){

	}



}
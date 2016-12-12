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
	private $postcode;
	private $plaatsnaam;
	private $land;
	private $geboortenaam;
	private $mailadres;
	private $isVerkoper;

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
	function __construct($gebruikersnaam,$voornaam,$achternaam,$adresregel1,$postcode,$plaatsnaam,$land,$geboortenaam,$mailadres,$isVerkoper)
	{
		$this->gebruikersnaam = $gebruikersnaam;
		$this->voornaam = $voornaam;
		$this->achternaam = $achternaam;
		$this->adresregel1 = $adresregel1;
		$this->postcode = $postcode;
		$this->plaatsnaam = $plaatsnaam;
		$this->land = $land;
		$this->geboortenaam = $geboortenaam;
		$this->mailadres = $mailadres;
		$this->isVerkoper = $isVerkoper;
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

}
<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 28-11-2016
 * Time: 14:40
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

	//Constructor
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

	public function getGebruikersnaam(){
		return $this->gebruikersnaam;
	}

	public function getVoornaam(){
		return $this->voornaam;
	}

	public function getAchternaam(){
		return $this->achternaam;
	}

	public function getAdresregel1(){
		return $this->adresregel1;
	}

	public function getPostcode(){
		return $this->postcode;
	}

	public function getPlaatsnaam(){
		return $this->plaatsnaam;
	}

	public function getLand(){
		return $this->land;
	}

	public function getGeboortenaam(){
		return $this->geboortenaam;
	}

	public function getMailadres(){
		return $this->mailadres;
	}

	public function getIsVerkoper(){
		return $this->isVerkoper;
	}






}
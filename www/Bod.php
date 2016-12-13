<?php

require ("scripts/DB.php");

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 30-11-2016
 * Time: 10:50
 */

//require("scripts/mssql.inc.php");

class Bod
{
	private $voorwerpnummer;
	private $bodbedrag;
	private $gebruiker;
	private $bodDagTijdstip;

	//constructor
	function __construct($voorwerpnummer,$bodbedrag,$gebruiker,$bodDagTijdstip)
	{
		$this->voorwerpnummer = $voorwerpnummer;
		$this->bodbedrag = $bodbedrag;
		$this->gebruiker = $gebruiker;
		$this->bodDagTijdstip = $bodDagTijdstip;
	}

	//properties
	public function getBodbedrag(){
		return $this->bodbedrag;
	}

	public function getGebruiker(){
		return $this->gebruiker;
	}

	public function getBodDagTijdstip(){
		return $this->bodDagTijdstip;
	}

	public function getVoorwerpNummer(){

	}

	//functies
	public function plaatsBod(){
		plaatsBod($this->voorwerpnummer,$this->bodbedrag,$this->gebruiker);
	}
}


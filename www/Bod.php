<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 30-11-2016
 * Time: 10:50
 */
class Bod
{
	private $voorwerp;
	private $bodbedrag;
	private $gebruiker;
	private $bodDagTijdstip;

	//constructor
	function __construct($voorwerp,$bodbedrag,$gebruiker,$bodDagTijdstip)
	{
		$this->voorwerpnummer = $voorwerp;
		$this->bodbedrag = $bodbedrag;
		$this->gebruiker = $gebruiker;
		$this->bodDagTijdstip = $bodDagTijdstip;
	}

	//properties
	public function getVoorwerpnummer(){
		return $this->voorwerpnummer;
	}

	public function getBodbedrag(){
		return $this->bodbedrag;
	}

	public function getGebruiker(){
		return $this->gebruiker;
	}

	public function getBodDagTijdstip(){
		return $this->bodDagTijdstip;
	}

	//functies
	public function plaatsBod(){

	}
}


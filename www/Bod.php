<?php

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



		try
		{
			$db = getConnection();
			$stmt = $db->prepare("INSERT INTO Bod(Voorwerp,Bodbedrag,Gebruiker)VALUES (:Voorwerp,:Bodbedrag,:Gebruiker)");
			$stmt->bindParam("Voorwerp", $this->voorwerpnummer);
			$stmt->bindParam("Bodbedrag", $this->bodbedrag);
			$stmt->bindParam("Gebruiker", $this->gebruiker);

			$stmt->execute();
			$db = null;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			echo $e->errorInfo;
		}




		/*
		$insertQuery = query("INSERT INTO Bod (Voorwerp, Bodbedrag, Gebruiker) value (:voorwerp, :Bodbedrag, :Gebruiker)", array(
			"voorwerp" => $this->voorwerpnummer, "Bodbedrag" => $this->bodbedrag,"Gebruiker" => $this->gebruiker));

		try
		{
			$db = getConnection();
			$stmt = $db->prepare($insertQuery);
			$stmt->execute();

			$db = null;
		}
		catch(PDOException $e)
		{
			die($e->getCode());
		}
*/

	}
}


<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 30-11-2016
 * Time: 10:50
 */
class Bod
{
	private $bodbedrag;
	private $gebruiker;
	private $bodDagTijdstip;

	//constructor
	function __construct($bodbedrag,$gebruiker,$bodDagTijdstip)
	{
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

	//functies
	public function plaatsBod(){
		try {
			$dbh = getConnection();
			$sql = "SELECT * FROM Voorwerp";

			$stmt = $dbh->prepare($sql);
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$voorwerp = new Voorwerp($row["Voorwerpnummer"], $row["Titel"], $row["Beschrijving"], $row["Startprijs"], $row["Betalingswijze"], $row["Plaatsnaam"], $row["Land"], $row["Looptijd"], $row["LooptijdBeginDagTijdstip"], $row["VerzendKosten"], $row["VerzendInstructies"], $row["LooptijdEindeDagTijdstip"], $row["VeilingGesloten"], $row["VerkoopPrijs"]);
				$voorwerpen[] = $voorwerp;


			}
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
}


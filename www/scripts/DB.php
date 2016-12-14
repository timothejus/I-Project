<?php

/**
 * User: Jip Brouwer
 * Date: 29-11-2016
 * Time: 10:49
 */

require("voorwerp.php");
require("mssql.inc.php");
require("Bod.php");

/**
 * @return array|Voorwerp
 */


function getVoorwerpen()
{
	$voorwerpen = array();

	try {
		$dbh = getConnection();
		$sql = "EXEC spKrijgVoorwerpen";

		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$voorwerp = new Voorwerp(
				$row["Voorwerpnummer"],
				$row["Titel"], '',
				$row["Startprijs"], '', '', '', '', '', '', '', '', '', '',
				$row["LooptijdEindeDagTijdstip"], '', '', ''
			);
			$voorwerp->setHoogsteBod($row['hoogsteBod']);
			$voorwerp->setAfbeeldingen($row['afbeelding']);
			$voorwerpen[] = $voorwerp;
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	return $voorwerpen;

}

/**
 * @return Voorwerp|Voorwerp
 */
function getProductGroot()
{
	$voorwerp = null;

	$dbh = getConnection();

	$sql = "EXEC spKrijgVoorwerpGroot";

	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$voorwerp = new Voorwerp(
			$row["Voorwerpnummer"],
			$row["Titel"], '',
			$row["Startprijs"], '', '', '', '', '', '', '', '', '', '',
			$row["LooptijdEindeDagTijdstip"], '', '', ''
		);
		$voorwerp->setHoogsteBod($row['hoogsteBod']);
		$voorwerp->setAfbeeldingen($row['afbeelding']);
	}
	return $voorwerp;
}

/**
 * @param $voorwerpNummer
 * @return Voorwerp|Voorwerp
 */
function getProduct($voorwerpNummer)
{
	$voorwerp =  getProductData($voorwerpNummer);
	$biedingen = getBiedingen($voorwerpNummer);

	if ($biedingen != null) {
		$voorwerp->setBiedingen($biedingen);
	}
	$voorwerp->setAfbeeldingen(getVoorwerpAfbeeldingen($voorwerpNummer));

	return $voorwerp;
}

/**
 * @param $voorwerpNummer
 * @return Voorwerp|Voorwerp
 */
function getProductData($voorwerpNummer){
	try {
		$dbh = getConnection();

		$sql = "EXEC spKrijgProductData :voorwerp";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':voorwerp', $voorwerpNummer, PDO::PARAM_INT);
		$stmt->execute();


		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$voorwerp = new Voorwerp(
				$row["Voorwerpnummer"],
				$row["Titel"],
				$row["Beschrijving"],
				$row["Startprijs"],
				$row["Betalingswijze"],
				$row["Betalingsinstructie"],
				$row["Plaatsnaam"],
				$row["Land"],
				$row["Looptijd"],
				$row["LooptijdBeginDagTijdstip"],
				$row["VerzendKosten"],
				$row["VerzendInstructies"],
				$row["Verkoper"],
				$row["Koper"],
				$row["LooptijdEindeDagTijdstip"],
				$row["VeilingGesloten"],
				$row["VerkoopPrijs"],
				$row["ResterendeSeconden"]
			);
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	return $voorwerp ? $voorwerp : null;
}

/**
 * @param $voorwerpNummer
 * @return array|Bod
 */
function getBiedingen($voorwerpNummer){
	$Biedingen = Array();
	try {
		$dbh = getConnection();

		$sql = "EXEC spKrijgBiedingen :voorwerp";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':voorwerp', $voorwerpNummer, PDO::PARAM_INT);
		$stmt->execute();


		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$Bod = new Bod($row["Voorwerp"],$row["Bodbedrag"],$row["Gebruikersnaam"],$row["BodDagTijdStip"]);
			$Biedingen[] = $Bod;
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	return $Biedingen ? $Biedingen : null;
}

/**
 * @param $voorwerpNummer
 * @return array
 */
function getVoorwerpAfbeeldingen($voorwerpNummer){
	$afbeeldingen = Array();
	try {
		//database connection
		$dbh = getConnection();
		//sql with named placeholder
		$sql = "EXEC spKrijgVoorwerpAfbeeldingen :voorwerp";
		//prepare statement
		$stmt = $dbh->prepare($sql);
		//bind parameters named placeholder to variable
		$stmt->bindParam(':voorwerp', $voorwerpNummer, PDO::PARAM_INT);
		//execute statement
		$stmt->execute();


		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$afbeeldingen[] = $row["filenaam"];
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	return $afbeeldingen ? $afbeeldingen : null;
}


function plaatsBod($voorwerp,$bodbedrag,$gebruiker){

	try
	{
		$db = getConnection();
		$sql = "EXEC spPlaatsBod :Voorwerp,:Bodbedrag,:Gebruiker";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':Voorwerp', $voorwerp, PDO::PARAM_INT);
		$stmt->bindParam(':Bodbedrag', $bodbedrag, PDO::PARAM_INT);
		$stmt->bindParam(':Gebruiker', $gebruiker, PDO::PARAM_INT);

		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		echo $e->errorInfo;
	}
}
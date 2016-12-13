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
		$sql = "SELECT TOP 20
V.Voorwerpnummer,
V.Titel,
V.LooptijdEindeDagTijdstip,
(SELECT TOP 1 Bodbedrag FROM Bod WHERE Voorwerp = V.Voorwerpnummer ORDER BY Bodbedrag DESC) AS hoogsteBod,
V.Startprijs,
(SELECT TOP 1 filenaam FROM Bestand WHERE voorwerp = V.Voorwerpnummer)AS afbeelding
FROM Voorwerp V 
WHERE V.Voorwerpnummer NOT IN (SELECT voorwerp FROM ProductVanDeDag PVVD WHERE PVVD.voorwerp = V.Voorwerpnummer AND PVVD.ProductVanDag = FORMAT(GETDATE (),'d','af'));";

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

function getVoorwerpen2()
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
	$dsn = 'sqlsrv:server=192.168.0.20;Database=EenmaalAndermaal';
	$user = 'sa';
	$password = 'iproject4';
	$dbh = new PDO($dsn, $user, $password);

	$sql = "exec sp_getDing :nr";
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

		$sql = "
SELECT
V.Voorwerpnummer,
V.Titel,
V.Startprijs,
V.Beschrijving,
BTW.Betalingswijze,
BTW.Betalingsinstructie,
V.Plaatsnaam,
V.Koper,
V.Looptijd,
V.LooptijdBeginDagTijdstip,
V.VerzendKosten,
V.VerzendInstructies,
V.Verkoper,
V.LooptijdEindeDagTijdstip,
V.VeilingGesloten,
V.VerkoopPrijs,
LDN.Land,
DATEDIFF (second, getDate (), V.LooptijdEindeDagTijdstip) AS ResterendeSeconden  

FROM Voorwerp V

INNER JOIN Landen LDN ON V.Land = LDN.ISO
INNER JOIN Betalingswijzen BTW ON V.Betalingswijze = BTW.Betalingswijze

WHERE V.Voorwerpnummer =(:voorwerp);";
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

		$sql = "SELECT
B.Voorwerp,
B.Bodbedrag, 
GB.Gebruikersnaam, 
B.BodDagTijdStip
FROM Bod B
INNER JOIN Gebruiker GB ON B.Gebruiker = GB.Gebruikersnaam WHERE B.Voorwerp = (:voorwerp)
ORDER BY B.Bodbedrag DESC;";
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
		$sql = "SELECT filenaam FROM Bestand WHERE voorwerp = (:voorwerp);";
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
		$stmt = $db->prepare("INSERT INTO Bod(Voorwerp,Bodbedrag,Gebruiker)VALUES (:Voorwerp,:Bodbedrag,:Gebruiker)");
		$stmt->bindParam("Voorwerp", $voorwerp);
		$stmt->bindParam("Bodbedrag", $bodbedrag);
		$stmt->bindParam("Gebruiker", $gebruiker);

		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		echo $e->errorInfo;
	}
}
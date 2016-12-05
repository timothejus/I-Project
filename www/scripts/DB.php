<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 29-11-2016
 * Time: 10:49
 */
require("voorwerp.php");
require("mssql.inc.php");
require("Bod.php");


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
FROM Voorwerp V";

		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$voorwerp = new Voorwerp(
				$row["Voorwerpnummer"],
				$row["Titel"], '',
				$row["Startprijs"], '', '', '', '', '', '', '', '', '', '',
				$row["LooptijdEindeDagTijdstip"], '', '', ''
			);
			$voorwerp->setAfbeeldingen($row['afbeelding']);
			$voorwerpen[] = $voorwerp;
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	return $voorwerpen;

}

function getProductGroot()
{
	$dsn = 'sqlsrv:server=192.168.0.20;Database=EenmaalAndermaal';
	$user = 'sa';
	$password = 'iproject4';
	$dbh = new PDO($dsn, $user, $password);

	$sql = "SELECT
V.Voorwerpnummer,
V.Titel, 
V.LooptijdEindeDagTijdstip,
V.Startprijs,
(SELECT TOP 1 Bodbedrag FROM Bod WHERE Voorwerp = V.Voorwerpnummer ORDER BY Bodbedrag DESC) AS hoogsteBod,
(SELECT TOP 1 filenaam FROM Bestand WHERE voorwerp = V.Voorwerpnummer ) AS afbeelding
FROM ProductVanDeDag PVVD 
JOIN Voorwerp V ON PVVD.Voorwerp = V.Voorwerpnummer
WHERE PVVD.ProductVanDag = FORMAT(GETDATE (),'d','af')
;";
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

WHERE V.Voorwerpnummer =" . $voorwerpNummer . ";";
		$stmt = $dbh->prepare($sql);
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
INNER JOIN Gebruiker GB ON B.Gebruiker = GB.Gebruikersnaam WHERE B.Voorwerp = " . $voorwerpNummer . "
ORDER BY B.Bodbedrag DESC;";
		$stmt = $dbh->prepare($sql);
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

function getVoorwerpAfbeeldingen($voorwerpNummer){
	$afbeeldingen = Array();
	try {
		$dbh = getConnection();

		$sql = "SELECT filenaam FROM Bestand WHERE voorwerp = " . $voorwerpNummer . ";";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();


		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$afbeeldingen[] = $row["filenaam"];
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
	return $afbeeldingen ? $afbeeldingen : null;
}

?>

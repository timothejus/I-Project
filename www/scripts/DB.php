<?php

/**
 * User: Jip Brouwer
 * Date: 29-11-2016
 * Time: 10:49
 */

require("voorwerp.php");
require("mssql.inc.php");
require("Bod.php");
require ("user.php");
require ("vraag.php");

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
				$row["Eindtijd"], '', '', ''
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
			$row["Eindtijd"], '', '', ''
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
	$biedingen = getBiedingen((float)$voorwerpNummer);

	if ($biedingen != null) {
		$voorwerp->setBiedingen($biedingen);
	}
	if(isset($voorwerp)){
		$voorwerp->setAfbeeldingen(getVoorwerpAfbeeldingen((float)$voorwerpNummer));
	}


	return $voorwerp;
}

/**
 * @param $voorwerpNummer
 * @return Voorwerp|Voorwerp
 */
function getProductData($voorwerpNummer){
	$voorwerp = null;
	try {
		$dbh = getConnection();

		$sql = "EXEC spKrijgProductData :VoorwerpNummer";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':VoorwerpNummer', $voorwerpNummer, PDO::PARAM_STR);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$voorwerp = new Voorwerp(
				$row["Voorwerpnummer"],
				$row["Titel"],
				$row["Beschrijving"],
				$row["Startprijs"],
				$row["Betaalwijze"],
				$row["Betaalinstructie"],
				$row["Plaatsnaam"],
				$row["LandNaam"],
				$row["Looptijd"],
				$row["Starttijd"],
				$row["VerzendKosten"],
				$row["VerzendInstructies"],
				$row["Verkoper"],
				$row["Koper"],
				$row["Eindtijd"],
				$row["VeilingGesloten"],
				$row["VerkoopPrijs"]
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
		$sql = "EXEC spKrijgBiedingen :VoorwerpNummer";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':VoorwerpNummer', $voorwerpNummer, PDO::PARAM_STR);
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
		$sql = "EXEC spKrijgVoorwerpAfbeeldingen :VoorwerpNummer";
		//prepare statement
		$stmt = $dbh->prepare($sql);
		//bind parameters named placeholder to variable
		$stmt->bindParam(':VoorwerpNummer', $voorwerpNummer, PDO::PARAM_STR);
		//execute statement
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$afbeeldingen[] = $row["FileNaam"];
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

function getHoofdrubrieken () {

	$rubrieken = null;

	try {
		$db = getConnection ();
		$sql = "SELECT ID, Rubrieknaam, Parent, Volgnr FROM Rubriek WHERE parent = -1 ORDER BY Rubrieknaam ASC";
		$stmt = $db->prepare ($sql);

		$stmt->execute ();
		$db = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$rubriek = new Rubriek ($row ['ID'], $row ['Rubrieknaam'], $row ['Volgnr'], $row ['Parent']);
			$rubrieken [] = $rubriek;
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $rubrieken ? $rubrieken : null;
}

function getRubriekParent ($id) {
	$rubrieken = null;

	try {
		$db = getConnection ();
		$sql = "SELECT Parent FROM Rubriek WHERE ID = " . $id;
		$stmt = $db->prepare ($sql);

		$stmt->execute ();
		$db = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$rubriek = $row ['Parent'];
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $rubriek ? $rubriek : null;
}

function getSubrubrieken ($parent) {

	$rubrieken = null;

	try {
		$db = getConnection ();
		$sql = "EXEC spKrijgSubRubrieken :RubriekNummer";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':RubriekNummer', $parent, PDO::PARAM_INT);

		$stmt->execute ();
		$db = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$rubriek = new Rubriek ($row ['ID'], $row ['Rubrieknaam'], $row ['Volgnr'], $row ['Parent']);
			$rubrieken [] = $rubriek;
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $rubrieken ? $rubrieken : null;
}

function getRubriek ($id) {

	$rubrieken = null;

	try {
		$db = getConnection ();
		$sql = "EXEC spKrijgRubriek :RubriekNummer";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':RubriekNummer', $id, PDO::PARAM_INT);

		$stmt->execute ();
		$db = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$rubriek = new Rubriek ($row ['ID'], $row ['Rubrieknaam'], $row ['Volgnr'], $row ['Parent']);
			$rubrieken [] = $rubriek;
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $rubrieken ? $rubrieken : null;
}

function getVoorwerpenVanRubriek ($id) {

	$rubrieken = null;

	try {
		$voorwerpen = null;
		$db = getConnection ();
		$sql = "EXEC spGetVoorwerpenVanRubriek :RubriekNummer";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':RubriekNummer', $id, PDO::PARAM_INT);

		$stmt->execute ();
		$db = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$voorwerp = new Voorwerp(
				$row["Voorwerpnummer"],
				$row["Titel"], '',
				$row["Startprijs"], '', '', '', '', '', '', '', '', '', '',
				$row["Eindtijd"], '', '', ''
			);
			$voorwerp->setHoogsteBod($row['hoogsteBod']);
			$voorwerp->setAfbeeldingen($row['afbeelding']);
			$voorwerpen[] = $voorwerp;
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $voorwerpen ? $voorwerpen : null;
}

function insertCode($code,$email){
	try
	{
		$db = getConnection();
		$sql = "INSERT INTO RegistratieCode(Mailadres,RegistratieCode) VALUES  (:mailadres,:registratiecode)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':mailadres', $email, PDO::PARAM_INT);
		$stmt->bindParam(':registratiecode', $code, PDO::PARAM_INT);

		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		echo $e->errorInfo;
	}
}

function verify($email){
	try {
		//database connection
		$dbh = getConnection();
		//sql with named placeholder
		$sql = "SELECT * FROM RegistratieCode WHERE Mailadres = (:mailadres)";
		//prepare statement
		$stmt = $dbh->prepare($sql);
		//bind parameters named placeholder to variable
		$stmt->bindParam(':mailadres', $email, PDO::PARAM_INT);

		//execute statement
		$stmt->execute();


		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			return false;
		}

		return true;

	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
}

function verifyUser($email){
	try {
		//database connection
		$dbh = getConnection();
		//sql with named placeholder
		$sql = "SELECT * FROM Gebruiker WHERE Mailadres = (:mailadres)";
		//prepare statement
		$stmt = $dbh->prepare($sql);
		//bind parameters named placeholder to variable
		$stmt->bindParam(':mailadres', $email, PDO::PARAM_INT);

		//execute statement
		$stmt->execute();


		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			return false;
		}

		return true;

	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}
}

function getAccountgegevens($gebruikersnaam){

	try {

		$db = getConnection ();
		$sql = "EXEC spKrijgContactgegevens :Gebruikersnaam";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':Gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);

		$stmt->execute ();
		$user = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$user = new user(
				$row["Gebruikersnaam"],
				$row["Voornaam"],
				$row["Achternaam"],
				$row["Adresregel1"],
				$row["Adresregel2"],
				$row["Postcode"],
				$row["Plaatsnaam"],
				$row["LandNaam"],
				$row["Geboortedatum"],
				$row["Mailadres"],"",""
			);
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $user ? $user : null;
}

function getLoginGegevens($gebruikersnaam){

	try {

		$db = getConnection ();
		$sql = "EXEC spKrijgInloggegevens :Gebruikersnaam";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':Gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);

		$stmt->execute ();
		$user = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$user = new user(
				$row["Gebruikersnaam"],
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				$row["TekstVraag"],
				$row["Antwoordtekst"]
			);
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $user ? $user : null;
}

function getQuestions()
{
	$vragen = null;

	try{

		$dbh = getConnection();
		$sql = "SELECT Vraagnummer, TekstVraag FROM GeheimeVraag";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$vraag = new vraag($row['Vraagnummer'],$row['TekstVraag']);
			$vragen[] = $vraag;
		}

	} catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $vragen ? $vragen : null;
}

function getTelefoonNummer($gebruiker){
	try {

		$telefoon = null;

		$db = getConnection ();
		$sql = "SELECT Telefoon FROM Gebruikerstelefoon WHERE Gebruiker = (:Gebruiker)";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':Gebruiker', $gebruiker, PDO::PARAM_STR);

		$stmt->execute ();
		$user = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$telefoon = $row["Telefoon"];
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $telefoon ? $telefoon : null;
}

function geefFeedback (
	$verkoper,
	$koper,
	$voorwerp,
	$communicatiebeoordeling,
	$communicatieopmerking,
	$leveringbeoordeling,
	$leveringopmerking,
	$levertijdbeoordeling,
	$levertijdopmerking,
	$algemeneopmerking
) {
	try
	{
		$db = getConnection();
		$sql = "EXEC spPlaatsFeedback :Verkoper,:Koper,:Voorwerp,:CommunicatieBeoordeling,:CommunicatieOpmerking,:LeveringBeoordeling,:LeveringOpmerking,:LevertijdBeoordeling,:LevertijdOpmerking,:AlgemeneOpmerking";
		$stmt = $db->prepare($sql);
		$stmt->bindParam (':Verkoper', $verkoper, PDO::PARAM_STR);
		$stmt->bindParam (':Koper', $koper, PDO::PARAM_STR);
		$stmt->bindParam (':Voorwerp', $voorwerp, PDO::PARAM_INT);
		$stmt->bindParam (':CommunicatieBeoordeling', $communicatiebeoordeling, PDO::PARAM_INT);
		$stmt->bindParam (':CommunicatieOpmerking', $communicatieopmerking, PDO::PARAM_STR);
		$stmt->bindParam (':LeveringBeoordeling', $leveringbeoordeling, PDO::PARAM_INT);
		$stmt->bindParam (':LeveringOpmerking', $leveringopmerking, PDO::PARAM_STR);
		$stmt->bindParam (':LevertijdBeoordeling', $levertijdbeoordeling, PDO::PARAM_INT);
		$stmt->bindParam (':LevertijdOpmerking', $levertijdopmerking, PDO::PARAM_STR);
		$stmt->bindParam (':AlgemeneOpmerking', $algemeneopmerking, PDO::PARAM_STR);

		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		echo $e->errorInfo;
	}
}

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
 *
 * @return array|Voorwerp
 */

function getTeVerzendenMails () {
	$items = array ();

	try {
		$dbh = getConnection ();
		$sql = "EXEC spTeVersturenMails";

		$stmt = $dbh->prepare ($sql);
		$stmt->execute();

		while ($row = $stmt->fetch (PDO::FETCH_ASSOC)) {
			$items[] = $row;
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage ();
	}
	return $items;
}

function verwijderTeVerzendenMail ($voorwerpnummer) {
	try {
		$dbh = getConnection ();
		$sql = "EXEC spVerwijderTeVersturenMail :VoorwerpNummer";

		$stmt = $dbh->prepare ($sql);
		$stmt->bindParam(':VoorwerpNummer', $voorwerpnummer, PDO::PARAM_INT);
		$stmt->execute ();

		$db = null;
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage ();
	}
}

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

function getCountZoekresultaten($search){
	/*
		$db = getConnection ();
		// Get the keyword from query string
		$keyword = $_GET['keyword'];
	// Prepare the command
		$sth = $db->prepare('SELECT * FROM `users` WHERE `firstname` LIKE :keyword');
	// Put the percentage sing on the keyword
		$keyword = "%".$keyword."%";
	// Bind the parameter
		$sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
	*/




	try {
		$voorwerpen = null;
		$db = getConnection ();

		$queried = $search;

		$keys = explode(" ",$queried);


		$sql = "SELECT Count(voorwerpnummer) as count FROM Voorwerp V 
WHERE V.Voorwerpnummer NOT IN (SELECT voorwerp FROM ProductVanDag PVVD WHERE PVVD.voorwerp = V.Voorwerpnummer AND PVVD.ProductVanDag = FORMAT(GETDATE (),'d','af'))
AND V.VeilingGesloten = 0 AND V.Starttijd <GETDATE() AND Titel LIKE :keyword0";

		$totalKeywords = count($keys);

		for($i=1 ; $i < $totalKeywords; $i++){
			$sql .= " OR Titel LIKE :keyword".$i;
		}
		//$sql .= " ORDER BY V.Eindtijd ASC";

		$stmt = $db->prepare ($sql);

		foreach($keys as $key => $keyword){
			$keyword = "%".$keyword."%";
			$stmt->bindParam("keyword".$key, $keyword, PDO::PARAM_STR);
		}

		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			Return $row["count"];
		}

		$db = null;




	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return 0;

}

function getZoekresultaten($search, $top){
/*
	$db = getConnection ();
	// Get the keyword from query string
	$keyword = $_GET['keyword'];
// Prepare the command
	$sth = $db->prepare('SELECT * FROM `users` WHERE `firstname` LIKE :keyword');
// Put the percentage sing on the keyword
	$keyword = "%".$keyword."%";
// Bind the parameter
	$sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
*/




	try {
		$voorwerpen = null;
		$db = getConnection ();

		$queried = $search;

		$keys = explode(" ",$queried);


		$sql = "  SELECT TOP 18
V.Voorwerpnummer,
V.Titel,
V.Eindtijd,
(SELECT TOP 1 Bodbedrag FROM Bod WHERE Voorwerp = V.Voorwerpnummer ORDER BY Bodbedrag DESC) AS hoogsteBod,
V.Startprijs,
(SELECT TOP 1 FileNaam FROM Bestand WHERE voorwerp = V.Voorwerpnummer)AS afbeelding
FROM Voorwerp V 
WHERE V.Voorwerpnummer NOT IN (SELECT voorwerp FROM ProductVanDag PVVD WHERE PVVD.voorwerp = V.Voorwerpnummer AND PVVD.ProductVanDag = FORMAT(GETDATE (),'d','af'))
AND V.VeilingGesloten = 0 AND V.Starttijd <GETDATE() AND V.Titel LIKE :keyword0";

		$totalKeywords = count($keys);
		$sqlpaginering = " AND V.Titel NOT IN (SELECT TOP (:top) Titel FROM Voorwerp WHERE Titel LIKE :keywoord0";
		for($i=1 ; $i < $totalKeywords; $i++){
			$sql .= " OR Titel LIKE :keyword".$i;
			$sqlpaginering .= " OR Titel LIKE :keywoord".$i;
		}
		$sqlpaginering .= " AND VeilingGesloten = 0 AND Starttijd <GETDATE() AND Voorwerpnummer NOT IN (SELECT voorwerp FROM ProductVanDag PVVD WHERE PVVD.voorwerp = Voorwerpnummer AND PVVD.ProductVanDag = FORMAT(GETDATE (),'d','af')) ORDER BY Eindtijd ASC)";
		$sql .= $sqlpaginering;
		$sql .= " ORDER BY V.Eindtijd ASC";
		$stmt = $db->prepare ($sql);
		foreach($keys as $key => $keyword){
			$keyword = "%".$keyword."%";
			$stmt->bindParam("keyword".$key, $keyword, PDO::PARAM_STR);
			$stmt->bindParam("keywoord".$key, $keyword, PDO::PARAM_STR);
		}
		$stmt->bindParam(":top", $top, PDO::PARAM_INT);
		$stmt->execute();

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

//TODO: Change to Stored Procedure
function getHoofdrubrieken () {

	$rubrieken = null;

	try {
		$db = getConnection ();
		$sql = "SELECT ID, Rubrieknaam, Parent, Volgnr FROM Rubriek WHERE parent = -1 ORDER BY Rubrieknaam ASC";
		$stmt = $db->prepare ($sql);

		$stmt->execute ();
		//$db = null;

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

//TODO: Change to Stored Procedure
function getRubriekParent ($id) {
	$rubrieken = null;

	try {
		$db = getConnection ();
		$sql = "SELECT Parent FROM Rubriek WHERE ID = :ID";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':ID', $id, PDO::PARAM_INT);

		$stmt->execute ();
		//$db = null;

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
		//$db = null;

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
		//$db = null;

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

function getVoorwerpenVanRubriekCount($id){
	$rubrieken = null;

	try {
		$voorwerpen = null;
		$db = getConnection ();
		$sql = "EXEC spGetVoorwerpenVanRubriekCount :RubriekNummer";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':RubriekNummer', $id, PDO::PARAM_INT);
		$stmt->execute ();
		//$db = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			return $row["count"];
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $voorwerpen ? $voorwerpen : null;
}

function getVoorwerpenVanRubriek ($id, $top, $filter = null) {

	$rubrieken = null;

	try {
		$voorwerpen = null;
		$db = getConnection ();
		if ($filter == null) {
			$sql = "EXEC spGetVoorwerpenVanRubriek :RubriekNummer, :TopNummer";
		} else {
			$sql = "EXEC spGetVoorwerpenVanRubriek :RubriekNummer, :TopNummer, :Filter";
		}
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':RubriekNummer', $id, PDO::PARAM_INT);
		$stmt->bindParam(':TopNummer', $top, PDO::PARAM_INT);
		if ($filter != null) {
			$stmt->bindParam (':Filter', $top, PDO::PARAM_STR);
		}
		$stmt->execute ();
		//$db = null;

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

//TODO: Change to Stored Procedure
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

//TODO: Change to Stored Procedure
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

//TODO: Change to Stored Procedure
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

function getEmailFromUser($username){
	$email = null;

	try {
		$email = null;
		$db = getConnection ();
		$sql = "SELECT Mailadres FROM Gebruiker WHERE Gebruikersnaam = (:gebruikersnaam)";
		//prepare statement
		$stmt = $db->prepare($sql);
		//bind parameters named placeholder to variable
		$stmt->bindParam(':gebruikersnaam', $username, PDO::PARAM_INT);

		//execute statement
		$stmt->execute();

		$db = null;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$email = $row['Mailadres'];
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $email ? $email : null;
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

//TODO: Change to Stored Procedure
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

//TODO: Change to Stored Procedure
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

function checkResetpassword($gebruikersnaam,$geheimeVraag,$antwoord){
	try {

		$check = null;

		$db = getConnection ();
		$sql = "SELECT * FROM Gebruiker WHERE Gebruikersnaam = (:Gebruiker) AND GeheimeVraag = (:GeheimeVraag) AND antwoordtekst = (:antwoordtekst)";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':Gebruiker', $gebruikersnaam, PDO::PARAM_STR);
		$stmt->bindParam(':GeheimeVraag', $geheimeVraag, PDO::PARAM_STR);
		$stmt->bindParam(':antwoordtekst', $antwoord, PDO::PARAM_STR);

		$stmt->execute ();
		$db = null;

		$matches = 0;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$matches += 1;
		}

		if($matches == 1){
			return 1;
		}
		else{
			return 0;
		}

	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	//return $telefoon ? $telefoon : null;
}

function sendNewPassword($email,$gebruiker,$achternaam){

	try {


		$code=substr(md5(mt_rand()),0,7);
		$hashedpassword = hash('sha256', $achternaam . $code);

		$check = null;

		$db = getConnection ();
		$sql = "UPDATE Gebruiker SET Wachtwoord=(:wachtwoord) WHERE Gebruikersnaam=(:gebruikersnaam)";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':wachtwoord', $hashedpassword, PDO::PARAM_STR);
		$stmt->bindParam(':gebruikersnaam', $gebruiker, PDO::PARAM_STR);


		$stmt->execute ();
		$db = null;

		$matches = 0;

/*
		if($matches == 1){
			return 1;
		}
		else{
			return 0;
		}
*/

		$to=$email;
		$subject="New password for EenmaalAndermaal";
		$from = 'noreacteenmaalandermaal@gmail.com';
		$body='Your new password is '.$code.' Please Click On This link  http://iproject4.icasites.nl/www/login.php';
		$headers = "From:".$from;

		mail($to,$subject,$body,$headers);

	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}

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

function updateVerkoper($gebruikersnaam){
	try {

		$check = null;

		$db = getConnection ();
		$sql = "UPDATE Gebruiker SET Verkoper=1 WHERE Gebruikersnaam=(:gebruikersnaam)";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);

		$stmt->execute ();
		$db = null;

	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
}

function registreerVerkoperViaCreditcard($gebruikersnaam,$bank,$rekeningnummer,$creditcard){
	try
	{
		$db = getConnection();
		$sql = "UPDATE Gebruiker SET Bank=(:bank),Rekeningnummer=(:rekeningnummer),Creditcardnummer=(:creditcard)  WHERE Gebruikersnaam = (:gebruiker)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':bank', $bank, PDO::PARAM_STR);
		$stmt->bindParam(':rekeningnummer', $rekeningnummer, PDO::PARAM_STR);
		$stmt->bindParam(':creditcard', $creditcard, PDO::PARAM_STR);
		$stmt->bindParam(':gebruiker', $gebruikersnaam, PDO::PARAM_STR);

		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		echo $e->errorInfo;
	}
}

function insertBankRekeningNummer($rekeningnummer,$gebruikersnaam,$bank){
	try
	{
		$db = getConnection();
		$sql= "UPDATE Gebruiker SET Rekeningnummer=(:rekeningnummer), Bank = (:bank) WHERE Gebruikersnaam=(:gebruikersnaam)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':rekeningnummer', $rekeningnummer, PDO::PARAM_STR);
		$stmt->bindParam(':bank', $bank, PDO::PARAM_STR);
		$stmt->bindParam(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);

		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		echo $e->errorInfo;
	}
}


function isVerkoper($user){
	$dbh = getConnection();
	$sql = "SELECT Verkoper FROM Gebruiker WHERE Gebruikersnaam=:gebruiker";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($row["Verkoper"] == 1){
			return true;
		}
	}
	return false;
}


// Cees
//TODO: Change to Stored Procedure AND place in DB.php
function getRubriekNaam($id){
	$dbh = getConnection();
	$sql = "SELECT RubriekNaam FROM Rubriek WHERE ID=:rubriek";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':rubriek', $id, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$ret = $row["RubriekNaam"];
	}
	return $ret;
}

//TODO: Change to Stored Procedure AND place in DB.php
function getPlaats($user){
	$dbh = getConnection();
	$sql = "SELECT Plaatsnaam FROM Gebruiker WHERE Gebruikersnaam=:gebruiker";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return $row["Plaatsnaam"];
	}
	return $ret;
}

//TODO: Change to Stored Procedure AND place in DB.php
function getGba($user){
	$dbh = getConnection();
	$sql = "SELECT GbaCode FROM Gebruiker WHERE Gebruikersnaam=:gebruiker";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return $row["GbaCode"];
	}
	return $ret;
}

//TODO: Change to Stored Procedure AND place in DB.php
function veilingPlaatsen(
	$titel,
	$beschrijving,
	$startprijs,
	$betaalwijze,
	$plaatsnaam,
	$GbaCode,
	$Looptijd,
	$verzendkosten,
	$verzendinstructies,
	$verkoper,
	$rubriek
){
	if ($verzendkosten == ""){
		$verzendkosten = NULL;
	}
	if ($verzendinstructies == ""){
		$verzendinstructies = NULL;
	}
	if ($_GET["rubriek2"] == ""){
		$rubriek2 = NULL;
	} else {
		$rubriek2 = $_GET["rubriek2"];
	}
	$dbh = getConnection();
	$sql = "INSERT INTO Voorwerp(Titel,
 								Beschrijving, 
 								Startprijs, 
 								Betaalwijze, 
 								Plaatsnaam, 
 								GbaCode, 
 								Looptijd,
 								VerzendKosten, 
 								VerzendInstructies, 
 								Verkoper, 
 								Rubriek,
 								Rubriek2) VALUES (:titel,
 													:beschrijving,
 													:startprijs,
 													:betaalwijze,
 													:plaatsnaam,
 													:gbacode,
 													:looptijd,
 													:verzendkosten,
 													:verzendinstructies,
 													:verkoper,
 													:rubriek,
 													:rubriek2)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':titel', $titel);
	$stmt->bindParam(':beschrijving', $beschrijving);
	$stmt->bindParam(':startprijs', $startprijs);
	$stmt->bindParam(':betaalwijze', $betaalwijze);
	$stmt->bindParam(':plaatsnaam', $plaatsnaam);
	$stmt->bindParam(':gbacode', $GbaCode);
	$stmt->bindParam(':looptijd', $Looptijd);
	$stmt->bindParam(':verzendkosten', $verzendkosten);
	$stmt->bindParam(':verzendinstructies', $verzendinstructies);
	$stmt->bindParam(':verkoper', $verkoper);
	$stmt->bindParam(':rubriek', $rubriek);
	$stmt->bindParam(':rubriek2', $rubriek2);
	$stmt->execute();
}

//TODO: Change to Stored Procedure AND place in DB.php
function getVoorwerpNummer($user)
{
	$dbh = getConnection();
	$sql = "select Voorwerpnummer from Voorwerp where Verkoper=:gebruiker order by Voorwerpnummer DESC;";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return $row["Voorwerpnummer"];
	}
	return $ret;
}

function telefoonRegistreren($telephone,$username,$volgnr){
	$dbh = getConnection();
	$sql = "INSERT INTO Gebruikerstelefoon VALUES (:volgnr,:username,:telephone)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("username", $username);
	$stmt->bindParam("volgnr", $volgnr);
	$stmt->bindParam("telephone", $telephone);
	$stmt->execute();
}

//TODO: Change to Stored Procedure AND place in DB.php
function registreren(
	$mail,
	$username,
	$password,
	$fname,
	$lname,
	$day,
	$month,
	$year,
	$street,
	$postcode,
	$place,
	$land,
	$question,
	$answer
){
	try
	{
		if (!empty($_GET["street2"])){
			$street2 = $_GET["street2"];
		} else {
			$street2 = NULL;
		}
		$verkoper = 0;
		$db = getConnection();
		$date = $year."-".$month."-".$day;
		$hashedpassword = hash('sha256', $lname . $password);
		$stmt = $db->prepare("INSERT INTO Gebruiker(Gebruikersnaam, 
											Voornaam,
											Achternaam, 
											Adresregel1, 
											Postcode, 
											Plaatsnaam, 
											GbaCode, 
											Geboortedatum, 
											Mailadres, 
											Wachtwoord, 
											GeheimeVraag, 
											Antwoordtekst, 
											Verkoper,
											Adresregel2)
											VALUES (:Gebruikersnaam,
													:Voornaam,
													:Achternaam,
													:Adresregel1,
													:Postcode,
													:Plaatsnaam,
													:Land,
													:Geboortedatum,
													:Mailadres,
													:Wachtwoord,
													:Vraag,
													:Antwoordtekst,
													:Verkoper,
													:Adresregel2
													)
													");
		$stmt->bindParam("Gebruikersnaam", $username);
		$stmt->bindParam("Voornaam", $fname);
		$stmt->bindParam("Achternaam", $lname);
		$stmt->bindParam("Adresregel1", $street);
		$stmt->bindParam("Postcode", $postcode);
		$stmt->bindParam("Plaatsnaam", $place);
		$stmt->bindParam("Land", $land);
		$stmt->bindParam("Geboortedatum", $date);
		$stmt->bindParam("Mailadres", $mail);
		$stmt->bindParam("Wachtwoord", $hashedpassword);
		$stmt->bindParam("Vraag", $question);
		$stmt->bindParam("Antwoordtekst", $answer);
		$stmt->bindParam("Verkoper", $verkoper);
		$stmt->bindParam("Adresregel2", $street2);
		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

//TODO: Change to Stored Procedure AND place in DB.php
function checkUsername($username){
	$dbh = getConnection();
	$username = strtolower($username);
	$sql = "SELECT LOWER(Gebruikersnaam) FROM Gebruiker WHERE Gebruikersnaam=(:username)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':username', $username, PDO::PARAM_INT);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Gebruikersnaam bestaat al, kies een andere gebruikersnaam!</div></div></div>';
		return false;
	}
	return true;
}

//TODO: Change to Stored Procedure AND place in DB.php
function codeInDatabase($code){
	$dbh = getConnection();
	$sql = "SELECT Mailadres FROM RegistratieCode WHERE RegistratieCode=(:code)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':code', $code, PDO::PARAM_INT);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		return $row['Mailadres'];
	}
	echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">De ingevoerde code is fout!</div></div></div>';
}

//TODO: Change to Stored Procedure AND place in DB.php
function isValid($mail){
	$dbh = getConnection();
	$sql = "SELECT Mailadres FROM Gebruiker WHERE Mailadres=(:mail)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':mail', $mail);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Deze code is niet valid!</div></div></div>';
		return false;
	}
	return true;

}

//TODO: Change to Stored Procedure AND place in DB.php
function changePassword($pw)
{
	$login = strtolower($_SESSION["user"]);
	$dbh = getConnection();

	$sql = "SELECT Achternaam FROM Gebruiker WHERE Gebruikersnaam=(:login)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':login', $login, PDO::PARAM_INT);
	$stmt->execute();
	$achternaam = "";
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$achternaam = $row['Achternaam'];
	}
	$dbh = getConnection();
	$wachtwoord = hash('sha256', $achternaam . $pw);
	$stmt = $dbh->prepare("UPDATE Gebruiker SET Wachtwoord=(:password) WHERE Gebruikersnaam=(:username)");
	$stmt->bindParam("password",$wachtwoord);
	$stmt->bindParam("username", $login);
	$stmt->execute();
	$dbh = null;
}
function oldPasswordCheck($login, $wachtwoord){
	$login = strtolower($login);
	$dbh = getConnection();

	$sql = "SELECT Achternaam FROM Gebruiker WHERE Gebruikersnaam=(:login)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':login', $login, PDO::PARAM_INT);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$achternaam = $row['Achternaam'];
	}
	if (isset($achternaam)) {
		$sql = "SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam=(:login) AND Wachtwoord=(:wachtwoord)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':login', $login, PDO::PARAM_INT);
		$wachtwoord = hash('sha256', $achternaam . $wachtwoord);
		$stmt->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_INT);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			if (isset($row)) {
				return true;
			}
		}
		echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">Uw oude wachtwoord klopt niet!</div></div></div>';
		return false;
	}
}

//TODO: Change to Stored Procedure AND place in DB.php
function veranderVraag($vraag, $antwoord){
	$login = strtolower($_SESSION["user"]);
	$dbh = getConnection();
	$stmt = $dbh->prepare("UPDATE Gebruiker SET GeheimeVraag=(:vraag), Antwoordtekst=(:antwoord)  WHERE Gebruikersnaam=(:username)");
	$stmt->bindParam("vraag",$vraag);
	$stmt->bindParam("antwoord",$antwoord);
	$stmt->bindParam("username", $login);
	$stmt->execute();
	$dbh = null;

}

function isVerkoperVanVoorwerp($user,$voorwerp){
	$dbh = getConnection();
	$sql = "SELECT * FROM Voorwerp WHERE Verkoper=:gebruiker AND Voorwerpnummer=:voorwerp";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->bindParam(':voorwerp', $voorwerp, PDO::PARAM_INT);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return true;
	}
	return false;
}

function setFileSQL($path,$vn){
	$dbh = getConnection();
	$sql = "INSERT INTO Bestand(FileNaam,Voorwerp) 
						VALUES (:path,
 								:vn)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':path', $path);
	$stmt->bindParam(':vn', $vn);
	$stmt->execute();
}

function uploadImage($img_ff, $dst_path, $dst_img, $naam){
	$dst_ext = strtolower(end(explode(".", $dst_img)));
	$dst_img = $naam . '.' . $dst_ext;
	$dst_cpl = $dst_path . $dst_img;
	echo $dst_cpl;
	move_uploaded_file($_FILES[$img_ff]['tmp_name'], $dst_cpl);
	$dst_type = exif_imagetype($dst_cpl);
	if(( (($dst_ext =="jpg") && ($dst_type =="2")) || (($dst_ext =="jpeg") && ($dst_type =="2")) || (($dst_ext =="gif") && ($dst_type =="1")) || (($dst_ext =="png") && ($dst_type =="3") )) == false){
		unlink($dst_cpl);
		die('<p>The file "'. $dst_img . '" with the extension "' . $dst_ext . '" and the imagetype "' . $dst_type . '" is not a valid image. Please upload an image with the extension JPG, JPEG, PNG or GIF and has a valid image filetype.</p>');
		header("Location: /I-Project/www/fileupload.php?voorwerpNummer=" . getVoorwerpNummer($_SESSION["user"]));
	}
	setFileSQL($dst_cpl, $_GET["voorwerpNummer"]);
}

//TODO: Change to Stored Procedure AND place in DB.php
function getGbaList($land)
{
	$dbh = getConnection();
	$sql = "SELECT GbaCode, LandNaam FROM Land ORDER BY LandNaam ASC";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($row["LandNaam"] == $land){
			$ret .= '<option value="' . $row['GbaCode'] . '" Selected="selected">' . $row['LandNaam'] . '</option>';
		} else {
			$ret .= '<option value="' . $row['GbaCode'] . '">' . $row['LandNaam'] . '</option>';
		}
	}
	return $ret;
}

//TODO: Change to Stored Procedure AND place in DB.php
function telefoonUpdate($telephone, $tele){
	$dbh = getConnection();
	$sql = "UPDATE Gebruikerstelefoon SET Telefoon=(:telephone) WHERE Telefoon=(:tele) AND Gebruiker=(:gebruiker)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("telephone", $telephone);
	$stmt->bindParam("tele", $tele);
	$stmt->bindParam("gebruiker", $_SESSION["user"]);
	$stmt->execute();
}

//TODO: Change to Stored Procedure AND place in DB.php
function accountUpdate(
	$fname,
	$lname,
	$day,
	$month,
	$year,
	$street,
	$postcode,
	$place,
	$land
){
	try
	{
		$db = getConnection();
		$date = $year."-".$month."-".$day;
		$stmt = $db->prepare("UPDATE Gebruiker SET 
											Voornaam=(:Voornaam),
											Achternaam=(:Achternaam),
											Adresregel1=(:Adresregel1), 
											Postcode=(:Postcode),
											Plaatsnaam=(:Plaatsnaam), 
											GbaCode=(:Land), 
											Geboortedatum=(:Geboortedatum)
											WHERE Gebruikersnaam=(:Gebruikersnaam)");
		$stmt->bindParam("Voornaam", $fname);
		$stmt->bindParam("Achternaam", $lname);
		$stmt->bindParam("Adresregel1", $street);
		$stmt->bindParam("Postcode", $postcode);
		$stmt->bindParam("Plaatsnaam", $place);
		$stmt->bindParam("Land", $land);
		$stmt->bindParam("Geboortedatum", $date);
		$stmt->bindParam("Gebruikersnaam", $_SESSION["user"]);
		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

//TODO: place in DB.php
function toonBiedingen(){

	try {

		$db = getConnection();
		$sql = "EXEC spGetGebruikerBiedingen :Gebruikersnaam";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':Gebruikersnaam', $_SESSION["user"], PDO::PARAM_STR);
		$stmt->execute ();
		$user = null;
		$ret = "";

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ret .= 	'							<tr>
									<td style="overflow: hidden"><a href="productDetailPagina.php?voorwerpNummer='. $row["Voorwerpnummer"] .'">'. $row["Titel"] .'</a></td>
									<td>&euro;'. number_format ($row["GebodenBedrag"],2,',','.') .'</td>
									<td>&euro;'. number_format ($row["HoogsteBod"],2,',','.') .'</td>';
			if ($row["Status"] == 0){
				$ret .= '<td>Open</td>';
			} else {
				$ret .= '<td>Gesloten</td>';
			}
			if ($row["HoogsteBod"] != $row["GebodenBedrag"]) {
				$ret .= '
									<td><a href="?voorwerp=' . $row["Voorwerpnummer"] . '&bod=' . number_format (minimaleBedrag($row["HoogsteBod"]),2,',','.') . '" class="btn btn-danger btn-xs">Bied &euro;' . minimaleBedrag($row["HoogsteBod"]) . ',-</a></td>
								</tr>';
			} else {
				$ret .= '<td><a class="btn btn-danger btn-xs" disabled>Bied &euro;' . number_format (minimaleBedrag($row["HoogsteBod"]),2,',','.') . ',-</a></td>
								</tr>';
			}
		}

	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $ret;
}


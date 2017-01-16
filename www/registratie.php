<?php
//require "scripts/mssql.inc.php";
require "scripts/header.php";
if (!empty($_GET["emailadres"]) &&
	!empty($_GET["username"]) &&
	!empty($_GET["password"]) &&
	!empty($_GET["password2"]) &&
	!empty($_GET["fname"]) &&
	!empty($_GET["lname"]) &&
	!empty($_GET["day"]) &&
	!empty($_GET["month"]) &&
	!empty($_GET["year"]) &&
	!empty($_GET["street"]) &&
	!empty($_GET["postcode"]) &&
	!empty($_GET["place"]) &&
	!empty($_GET["land"]) &&
	!empty($_GET["telephone1"]) &&
	!empty($_GET["question"]) &&
	!empty($_GET["answer"])
	&& checkPassword($_GET["password"], $_GET["password2"])){
	if (checkUsername($_GET["username"]) && checkDatum($_GET["day"],$_GET["month"],$_GET["year"])) {
		registreren(
			$_GET["emailadres"],
			$_GET["username"],
			$_GET["password"],
			$_GET["fname"],
			$_GET["lname"],
			$_GET["day"],
			$_GET["month"],
			$_GET["year"],
			$_GET["street"],
			$_GET["postcode"],
			$_GET["place"],
			$_GET["land"],
			$_GET["question"],
			$_GET["answer"]
		);
		for ($i = 1;$i < 10; $i++ ) {
			if (isset($_GET["telephone" . $i])) {
				telefoonRegistreren($_GET["telephone" . $i], $_GET["username"], $i);
			}
		}
		header("Location: ../www/login.php?registratie=1");
	}
}

function checkPassword($pw,$pw2) {
	if ($pw == $pw2){
		return true;
	} else {
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">De wachtwoorden zijn niet gelijk aan elkaar! Probeer het opnieuw</div></div></div>';
		return false;
	}
}

function checkDatum($day,$month,$year){
	if (checkdate($month,$day,$year) && hogerDan18($year,$month,$day)){
		return true;
	} else {
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">De geboortedatum klopt niet!</div></div></div>';
		return false;
	}
}

function hogerDan18($year,$month,$day){
	$d1 = new DateTime($year.'-'.$month.'-'.$day);
	$dd = getdate();
	$d2 = new DateTime($dd["year"].'-'.$dd["mon"].'-'.$dd["mday"]);
	$diff = $d1->diff($d2);

	if ($diff->y-18 < 0) {
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Uw geboortedatum is lager dan 18. Onze site mag alleen bezocht worden door mensen die 18+ zijn.</div></div></div>';
		return false;
	} else {
		return true;
	}

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

function returnNul(){
	return "0";
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

?>

<?php

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

if (isset($_GET["code"])) {
	$mail = codeInDatabase($_GET["code"]);
	if ($mail != "" && isValid($mail)) {
		?>

		<div class="container">

			<!--Registreren-->
			<div class="row">

				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">Registratieformulier</div>
						<form action="registratie.php" method="get">
							<div class="panel-body">
								<div class="col-sm-6">
									<input type="hidden" value="<?php echo $_GET["code"]; ?>"  name="code">
									E-mail adres
									<input type="text" value="<?php echo codeInDatabase($_GET["code"])?>" class="form-control" name="emailadres" readonly><br/>
									Gebruikersnaam
									<input type="text" pattern="^[a-zA-Z0-9_]{5,25}$" required="required" title="Er mogen alleen kleine letters en cijfers hier staan. er mogen 6 tot 25 tekens hier staan." class="form-control" name="username"><br/>
									Wachtwoord
									<input type="password" pattern="(?=^.{7,64}$)^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" required="required" title="er mogen 6 tot 64 tekens hier staan." class="form-control" name="password"><br/>
									Wachtwoord herhalen
									<input type="password" pattern="(?=^.{7,64}$)^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" required="required" title="er mogen 6 tot 64 tekens hier staan." class="form-control" name="password2"><br/>
									Voornaam
									<input type="text" pattern="[a-zA-Z\s]{0,20}" required="required" title="Er mogen hier alleen kleine letters, hoofd letters en spatie's staan. er mogen 1 tot 20 tekens hier staan." class="form-control" name="fname"><br/>
									Achternaam
									<input type="text" pattern="[a-zA-Z\s]{0,25}" required="required" title="Er mogen hier alleen kleine letters, hoofd letters en spatie's staan. er mogen 1 tot 25 tekens hier staan." class="form-control" name="lname"><br/>
									Geboortedatum
									<div class="form-inline">
										<input type="text" pattern="^[0-9]{1,2}$" title="Er mogen hier alleen cijfers staan. er mogen hier 1 tot 2 tekens staan." required="required" placeholder="Dag"
										       class="form-control text-center" style="width: 72px;" name="day">
										<input type="text" pattern="^[0-9]{1,2}$" title="Er mogen hier alleen cijfers staan. er mogen hier 1 tot 2 tekens staan." required="required" placeholder="Maand" class="form-control text-center"
										       style="width: 72px;" name="month">
										<input type="text" pattern="^[0-9]{4,4}$" title="Er mogen hier alleen cijfers staan. er mogen hier 4 tekens staan." required="required" placeholder="Jaar" class="form-control text-center"
										       style="width: 72px;" name="year">
									</div>
									<br/>
									Straatnaam en huisnummer
									<input type="text" pattern="[a-zA-Z0-9\s]{0,50}" maxlength="50" title="Er mogen hier alleen kleine letters, hoofd letters, cijfers en spatie's staan. er mogen hier 1 tot 50 tekens staan." required="required" class="form-control" name="street"><br/>
									Extra adresregel
									<input type="text" pattern="[a-zA-Z0-9\s]{0,50}" maxlength="50" title="Er mogen hier alleen kleine letters, hoofd letters, cijfers en spatie's staan. er mogen hier 1 tot 50 tekens staan." class="form-control" name="street2"><br/>
									<div class="col-sm-6" style="padding: 0px; padding-right: 3px;">
										Postcode
										<input type="text" maxlength="6" class="form-control" required="required" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" title="Zet hier een valide nederlandse postcode neer bestaande uit 4 cijfers en 2 letters" name="postcode"><br/>
									</div>
									<div class="col-sm-6" style="padding: 0px; padding-left: 3px;">
										Plaatsnaam
										<input type="text" class="form-control" maxlength="30" required="required" pattern="[a-zA-Z\s]{1,30}" title="Er mogen hier alleen kleine letters, hoofd letters en spatie's staan. Er morgen hier 1 tot 30 tekens staan." name="place"><br/>
									</div>
									Land
									<select name="land" required="required" class="form-control">
										<?php
										//TODO: Change to Stored Procedure AND place in DB.php
										function getGba()
										{
											$dbh = getConnection();
											$sql = "SELECT GbaCode, LandNaam FROM Land ORDER BY LandNaam ASC";
											$stmt = $dbh->prepare($sql);
											$stmt->execute();
											$ret = "";
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$ret .= '<option value="' . $row['GbaCode'] . '">' . $row['LandNaam'] . '</option>';
											}
											return $ret;
										}
										echo getGba();



										?>
									</select><br/>
									Telefoonnummer
									<input type="text" class="form-control" required="required" pattern="[0-9]{10,10}" title="er mogen hier alleen cijfers staan. Er mogen hier 10 tekens staan dus bijvoorbeeld 0612345678" name="telephone1"><br/>
									Geheime vraag
									<select name="question" required="required" class="form-control">
										<?php
										//TODO: Change to Stored Procedure AND place in DB.php
										function getQuestion()
										{
											$dbh = getConnection();
											$sql = "SELECT Vraagnummer, Tekstvraag FROM GeheimeVraag";
											$stmt = $dbh->prepare($sql);
											$stmt->execute();
											$ret = "";
											while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												$ret .= '<option value="' . $row['Vraagnummer'] . '">' . $row['Tekstvraag'] . '</option>';
											}
											return $ret;
										}
										echo getQuestion();



										?>
									</select><br>
									Antwoord
									<input type="text" pattern="[a-zA-Z0-9\s]{0-20}" maxlength="20" required="required" title="Er mogen hier alleen kleine letters, hoofd letters, cijfers en spatie's staan. Er mogen hier 1 tot 20 tekens staan." class="form-control" name="answer"><br/>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-sm-6">
										<input type="submit" class="btn btn-default" value="Registreer">
									</div>
									<div class="col-sm-6 text-right">
										<a href="#">Wachtwoord vergeten?</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>

		</div>

		<div class="container">
			<footer class="footer text-right">
				<span class="text-muted">&copy; 2016 Ubera</span>
			</footer>
		</div>

		</body>
		</html>
		<?php
	}
}
else{
	echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Er is geen code ingevoerd. Klik op registreren of haal de code op, op uw ingevoerde mail.</div></div></div>';

}
?>
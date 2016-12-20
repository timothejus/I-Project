<?php
require "scripts/mssql.inc.php";
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
	&& $_GET["password"] === $_GET["password2"]){
	if (checkUsername($_GET["username"])) {
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
											Verkoper)
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
													:Verkoper
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

function checkUsername($username){
	$dbh = getConnection();
	$sql = "SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam=(:username)";
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

function isValid($mail){
	$dbh = getConnection();
	$sql = "SELECT Mailadres FROM Gebruiker WHERE Mailadres=(:mail)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':mail', $mail);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		header("Location: ../www/login.php?geregistreerd=1");
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
									<input type="hidden" value="<?php echo $_GET["code"]; ?>" name="code">
									E-mail adres
									<input type="text" value="<?php echo codeInDatabase($_GET["code"])?>" class="form-control" name="emailadres" readonly><br/>
									Gebruikersnaam
									<input type="text" pattern="^[a-z0-9_]{5,25}$" class="form-control" name="username"><br/>
									Wachtwoord
									<input type="password" pattern=".{5,64}" class="form-control" name="password"><br/>
									Wachtwoord herhalen
									<input type="password" pattern=".{5,64}" class="form-control" name="password2"><br/>
									Voornaam
									<input type="text" pattern="[a-zA-Z]{0,20}" class="form-control" name="fname"><br/>
									Achternaam
									<input type="text" pattern="[a-zA-Z\s]{0,25}" class="form-control" name="lname"><br/>
									Geboortedatum
									<div class="form-inline">
										<input type="text" pattern="^[0-9]{1,2}$" placeholder="Dag"
										       class="form-control text-center" style="width: 72px;" name="day">
										<input type="text" pattern="^[0-9]{1,2}$" placeholder="Maand" class="form-control text-center"
										       style="width: 72px;" name="month">
										<input type="text" pattern="^[0-9]{4,4}$" placeholder="Jaar" class="form-control text-center"
										       style="width: 72px;" name="year">
									</div>
									<br/>
									Straatnaam en huisnummer
									<input type="text" pattern="[a-zA-Z0-9\s]{0,50}" class="form-control" name="street"><br/>
									<div class="col-sm-6" style="padding: 0px; padding-right: 3px;">
										Postcode
										<input type="text" class="form-control" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" name="postcode"><br/>
									</div>
									<div class="col-sm-6" style="padding: 0px; padding-left: 3px;">
										Plaatsnaam
										<input type="text" class="form-control" pattern="[a-zA-Z\s]{0,30}" name="place"><br/>
									</div>
									Land
									<select name="land" class="form-control">
										<?php
										function getGba()
										{
											$dbh = getConnection();
											$sql = "SELECT GbaCode, LandNaam FROM Land";
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
									<input type="text" class="form-control" pattern="[0-9]{0,10}" name="telephone1"><br/>
									Geheime vraag
									<select name="question" class="form-control">
										<?php
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
									</select>
									Antwoord
									<input type="text" pattern="[a-zA-Z0-9\s]{0-20}" class="form-control" name="answer"><br/>
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
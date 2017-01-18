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
		header("Location: /www/login.php?registratie=1");
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

function returnNul(){
	return "0";
}


?>

<?php


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
									<input type="text" pattern="^[a-zA-Z0-9_]{5,25}$" required title="Er mogen alleen kleine letters en cijfers hier staan. er mogen 6 tot 25 tekens hier staan." class="form-control" name="username" value="<?php if (isset ($_GET['username'])) {echo $_GET['username'];}?>"><br/>
									Wachtwoord
									<input type="password" pattern="(?=^.{7,64}$)^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" required title="er moeten 6 tot 64 tekens hier staan." class="form-control" name="password"><br/>
									Wachtwoord herhalen
									<input type="password" pattern="(?=^.{7,64}$)^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" required title="er moeten 6 tot 64 tekens hier staan." class="form-control" name="password2"><br/>
									Voornaam
									<input type="text" pattern="[a-zA-Z\s]{0,20}" required title="Er mogen hier alleen kleine letters, hoofd letters en spatie's staan. er mogen 1 tot 20 tekens hier staan." class="form-control" name="fname" value="<?php if (isset ($_GET['fname'])) {echo $_GET['fname'];}?>"><br/>
									Achternaam
									<input type="text" pattern="[a-zA-Z\s]{0,25}" required title="Er mogen hier alleen kleine letters, hoofd letters en spatie's staan. er mogen 1 tot 25 tekens hier staan." class="form-control" name="lname" value="<?php if (isset ($_GET['lname'])) {echo $_GET['lname'];}?>"><br/>
									Geboortedatum
									<div class="form-inline">
										<input type="text" pattern="^[0-9]{1,2}$" title="Er mogen hier alleen cijfers staan. er mogen hier 1 tot 2 tekens staan." required placeholder="Dag"
										       class="form-control text-center" style="width: 72px;" name="day" value="<?php if (isset ($_GET['day'])) {echo $_GET['day'];}?>">
										<input type="text" pattern="^[0-9]{1,2}$" title="Er mogen hier alleen cijfers staan. er mogen hier 1 tot 2 tekens staan." required placeholder="Maand" class="form-control text-center"
										       style="width: 72px;" name="month" value="<?php if (isset ($_GET['month'])) {echo $_GET['month'];}?>">
										<input type="text" pattern="^[0-9]{4,4}$" title="Er mogen hier alleen cijfers staan. er mogen hier 4 tekens staan." required placeholder="Jaar" class="form-control text-center"
										       style="width: 72px;" name="year" value="<?php if (isset ($_GET['year'])) {echo $_GET['year'];}?>">
									</div>
									<br/>
									Straatnaam en huisnummer
									<input type="text" pattern="[a-zA-Z0-9\s]{0,50}" maxlength="50" title="Er mogen hier alleen kleine letters, hoofd letters, cijfers en spatie's staan. er mogen hier 1 tot 50 tekens staan." required class="form-control" name="street" value="<?php if (isset ($_GET['street'])) {echo $_GET['street'];}?>"><br/>
									Extra adresregel
									<input type="text" pattern="[a-zA-Z0-9\s]{0,50}" maxlength="50" title="Er mogen hier alleen kleine letters, hoofd letters, cijfers en spatie's staan. er mogen hier 1 tot 50 tekens staan." class="form-control" name="street2" value="<?php if (isset ($_GET['street2'])) {echo $_GET['street2'];}?>"><br/>
									<div class="col-sm-6" style="padding: 0px; padding-right: 3px;">
										Postcode
										<input type="text" maxlength="6" class="form-control" required pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" title="Zet hier een valide nederlandse postcode neer bestaande uit 4 cijfers en 2 letters" name="postcode" value="<?php if (isset ($_GET['postcode'])) {echo $_GET['postcode'];}?>"><br/>
									</div>
									<div class="col-sm-6" style="padding: 0px; padding-left: 3px;">
										Plaatsnaam
										<input type="text" class="form-control" maxlength="30" required pattern="[a-zA-Z\s]{1,30}" title="Er mogen hier alleen kleine letters, hoofd letters en spatie's staan. Er morgen hier 1 tot 30 tekens staan." name="place" value="<?php if (isset ($_GET['place'])) {echo $_GET['place'];}?>"><br/>
									</div>
									Land
									<select name="land" required class="form-control">
										<?php
										echo getGbaList("Nederland");
										?>
									</select><br/>
									Telefoonnummer
									<input type="text" class="form-control" required pattern="[0-9]{10,10}" title="er mogen hier alleen cijfers staan. Er mogen hier 10 tekens staan dus bijvoorbeeld 0612345678" name="telephone1" value="<?php if (isset ($_GET['telephone1'])) {echo $_GET['telephone1'];}?>"><br/>
									Geheime vraag
									<select name="question" required class="form-control">
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
									<input type="text" pattern="[a-zA-Z0-9\s]{0-20}" maxlength="20" required title="Er mogen hier alleen kleine letters, hoofd letters, cijfers en spatie's staan. Er mogen hier 1 tot 20 tekens staan." class="form-control" name="answer" value="<?php if (isset ($_GET['answer'])) {echo $_GET['answer'];}?>"><br/>
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
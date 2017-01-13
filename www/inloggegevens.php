<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 21-12-2016
 * Time: 11:42
 */
require ("scripts/header.php");

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

function passwordCheck($pw,$pw1){
	if($pw == $pw1 && $pw != ""){
		return true;
	} else {
		echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">Uw nieuw ingevoerde wachtwoorden komen niet overeen!</div></div></div>';
	}
}


if (isset($_SESSION["user"])) {
	$gebruiker = getLoginGegevens($_SESSION ['user']);
	$vragen = getQuestions();
	if (isset($_GET["oldpw"])){
		if (oldPasswordCheck($_SESSION["user"], $_GET["oldpw"])) {
			if (isset($_GET["oldpw"]) &&
				!empty($_GET["newpw"]) &&
				!empty($_GET["newpw2"])
			) {
				if (passwordCheck($_GET["newpw"], $_GET["newpw2"])) {
					changePassword($_GET["newpw"]);
					echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">Uw wachtwoord is succesvol veranderd!</div></div></div>';
				}
			}

			if (isset($_GET["oldpw"]) && isset($_GET["gv"]) && isset($_GET["antwoord"])) {
				veranderVraag($_GET["gv"], $_GET["antwoord"]);
			}
			header("Location: ../www/mijnaccount.php?success=1");
		}
	}
	?>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading text-center"><h4>Wijzig hier uw inloggegevens.</h4></div>
						<form class="form-group" style="margin: 0px;">
							<div class="panel-body">
								Gebruikersnaam<br>
								<input class="form-control" type="text" name="username"
								       value="<?= $gebruiker->getGebruikersnaam() ?>" disabled><br>
								Oud wachtwoord *<br>
								<input class="form-control" type="password" name="oldpw" placeholder="********"><br>
								Nieuw wachtwoord<br>
								<input class="form-control" type="password" name="newpw"
								       pattern="(?=^.{7,64}$)^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" placeholder="********"><br>
								Bevestiging wachtwoord<br>
								<input class="form-control" type="password" name="newpw2"
								       pattern="(?=^.{7,64}$)^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" placeholder="********"><br>
								Geheime vraag<br>
								<select class="selectpicker" name="gv" data-width="100%">
									<?php
									foreach ($vragen as $row) {
										if ($row->getTekstVraag() == $gebruiker->getGeheimeVraag()) {
											echo '<option selected value="' .$row->getVraagNummer() . '" >' . $row->getTekstVraag() . '</option>';
										} else {
											echo '<option value="' .$row->getVraagNummer() . '">' . $row->getTekstVraag() . '</option>';
										}
									}
									?>
								</select><br><br>
								Antwoord
								<input class="form-control" type="text" name="antwoord"
								       value="<?= $gebruiker->getAntwoordGV() ?>">
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-sm-6 text-center">
										<a href="mijnaccount.php" class="btn btn-default">Annuleer</a>
									</div>
									<div class="col-sm-6 text-center">
										<input class="btn btn-primary" type="submit" value="Verstuur">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

	<?php
}
require("scripts/footer.php");

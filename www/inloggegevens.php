<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 21-12-2016
 * Time: 11:42
 */
require ("scripts/header.php");

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
			header("Location: /www/mijnaccount.php?success=1");
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
								       value="<?= $gebruiker->getAntwoordGV() ?>" required>
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

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 21-12-2016
 * Time: 10:51
 */
require("scripts/DB.php");
require("scripts/header.php");

if (isset($_SESSION["user"])) {
	$user = getAccountgegevens($_SESSION["user"]);
	if (isset($_GET["success"])){
		echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-success text-center">Uw gegevens zijn succesvol gewijzigt</div></div></div>';
	} else if (isset($_GET["failure"])){
		echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Uw gegevens zijn niet gewijzigt</div></div></div>';
	}
	?>

	<div class="container">
		<div class="row">
			<div class="col-sm12">
				<div class="panel panel-info">

					<div class="panel-heading text-center"><h3>Mijn account</h3></div>

					<div class="row top-buffer">

						<div class="col-sm-4">
							<div class="panel panel-info panel-margin">
								<div class="panel-body panel-body-account">
									<h4 class="text-center">Inloggegevens</h4>
									<ul class="top-buffer no-bullet text-muted">
										<li><?php echo $user->getGebruikersnaam() ?></li>
										<li><?php echo "Wijzig wachtwoord" ?></li>
										<li><?php echo "Wijzig Geheime vraag" ?></li>
									</ul>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-12"><a class="btn btn-default" href="inloggegevens.php  ">Wijzigen</a></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="panel panel-info panel-margin">
								<div class="panel-body panel-body-account">
									<h4 class="text-center">Contactgegevens</h4>
									<ul class="top-buffer no-bullet text-muted">
										<li><?php echo $user->getVoornaam() ?>  <?php echo $user->getAchternaam() ?></li>
										<li><?php echo $user->getAdresregel1() ?>  <?php echo $user->getPostcode() ?></li>
										<li><?php echo $user->getPlaatsnaam() ?>  <?php echo $user->getLand() ?></li>
									</ul>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-12"><a class="btn btn-default" href="contactgegevens.php">Wijzigen</a></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="panel panel-info panel-margin">
								<div class="panel-body panel-body-account">
									<h4 class="text-center">Inschrijven en activeren verkoper</h4>
									<p class="top-buffer text-muted">Schrijf je hier in en activeer je code voor je
										verkoopaccount.</p>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-6"><a class="btn btn-default" href="">Inschrijven</a></div>
										<div class="col-sm-6"><a class="btn btn-default" href="">Activeren</a></div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="row top-buffer">

						<div class="col-sm-4">
							<div class="panel panel-info panel-margin">
								<div class="panel-body panel-body-account">
									<h4 class="text-center">Feedback</h4>
									<p class="top-buffer text-muted">Bekijk hier je ontvangen feedback.</p>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-12"><a class="btn btn-default" href="">Bekijk</a></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="panel panel-info panel-margin">
								<div class="panel-body panel-body-account">
									<h4 class="text-center">Biedingen</h4>
									<p class="top-buffer text-muted">Bekijk hier je lopende en aflopende biedingen.</p>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-12"><a class="btn btn-default" href="">Bekijk</a></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="panel panel-info panel-margin">
								<div class="panel-body panel-body-account">
									<h4 class="text-center">Verkoper</h4>
									<p class="top-buffer text-muted">Voorwerpen ter verkoop aanbieden</p>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-12"><a class="btn btn-default" href="">Verkopen</a></div>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>

	<?php
}
else {
	echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">U bent niet ingelogd. Log in om uw account te wijzigen!</div></div></div>';
}
require("scripts/footer.php");
?>

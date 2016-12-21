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
	$user = getAccountGegevens();
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
										<li>&lt;&lt;Gebruikersnaam&gt;&gt;</li>
										<li>Wachtwoord</li>
										<li>Geheime vraag</li>
									</ul>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-12"><a class="btn btn-default" href="">Wijzigen</a></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="panel panel-info panel-margin">
								<div class="panel-body panel-body-account">
									<h4 class="text-center">Contactgegevens</h4>
									<ul class="top-buffer no-bullet text-muted">
										<li>&lt;&lt;Voornaam &amp; Achternaam&gt;&gt;</li>
										<li>&lt;&lt;Adresregel 1 &amp; Postcode&gt;&gt;</li>
										<li>&lt;&lt;Plaats &amp; Land&gt;&gt;</li>
									</ul>
								</div>
								<div class="panel-footer text-center">
									<div class="row">
										<div class="col-sm-12"><a class="btn btn-default" href="">Wijzigen</a></div>
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

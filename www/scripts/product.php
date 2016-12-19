<?php
/**
 * Created by Tim Hendriksen.
 * Date: 28-11-2016
 * Time: 14:12
 */
require("DB.php");

function getProductPagina($voorwerpNummer)
{
	// Haalt het product op uit de database.
	$voorwerp = getProduct($voorwerpNummer);
	?>
	<div class="row">

		<!-- Categorie pager -->
		<div class="col-sm-12">
			<ul class="breadcrumb">
				<li><a href="#">Hoofdcategorie</a></li>
				<li><a href="#">Subcategorie</a></li>
				<li><a href="#">Subcategorie</a></li>
				<li class="active">Subcategorie</li>
			</ul>
		</div>

	</div>

	<div class="row">

		<!-- Foto's -->
		<div class="col-sm-6">

			<div class="panel panel-primary">
				<div class="panel-heading"><?= $voorwerp->getTitel(); ?></div>
				<div class="panel-body text-center">
					<img src="<?= $voorwerp->getAfbeeldingen()[0]; ?>" class="img-thumbnail img-responsive img-thumbnail-primary" alt="img"><br/>
				</div>

				<div class="panel-body text-center">
					<img src="<?= $voorwerp->getAfbeeldingen()[0]; ?>" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
					<img src="<?= $voorwerp->getAfbeeldingen()[1]; ?>" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
					<img src="<?= $voorwerp->getAfbeeldingen()[2]; ?>" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
					<img src="<?= $voorwerp->getAfbeeldingen()[3]; ?>" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
				</div>
			</div>

		</div>

		<div class="col-sm-6">
			<script src="../js/timer.js" data-id="countdown"></script>
			<!-- Product beschikbaarheid -->
			<div class="row">
				<div class="col-sm-12">
					<div class="panel-heading">
						<h4 class="text-center">Dit product is nog maar
							<span id="timer">
								<script type=\"text/javascript\">setTimer("timer",'"<?= $voorwerp->getLooptijdEindedag() ?> "');</script>
							</span> beschikbaar!
						</h4>
					</div>
				</div>
			</div>

			<!-- Verkoper/biedingen informatie -->
			<div class="row">

				<!-- Verkoper/verzend informatie -->
				<div class="col-sm-4">
					<h5><b>Aanbieder</b></h5>
					<ul class="list-group">
						<li class="list-group-item"><b><a href="#"><?= $voorwerp->getVerkoper(); ?></a></b></li>
						<li class="list-group-item"><?= $voorwerp->getPlaatsnaam(); ?></li>
						<li class="list-group-item"><?= $voorwerp->getLand(); ?><br></li>
					</ul>
					<button type="button" class="btn btn-primary btn-md">Geef Feedback</button>
					<br><br>
					<h5><b>Startprijs</b></h5>
					<p class="text-muted">&euro;<?= number_format($voorwerp->getStartprijs(), 2, ",", ".") ?></p>
					<h5><b>Ophalen of verzending</b></h5>
					<p class="text-muted"><?= $voorwerp->getVerzendInstructies(); ?><br/>
						<?php
						// Laat alleen verzendkosten zien als er een bedrag voor is ingesteld.
						if ($voorwerp->getVerzendkosten() != 0) {
							echo "&euro;" . number_format($voorwerp->getVerzendkosten(), 2, ",", ".");
						}
						?> </p>
				</div>

				<!-- Biedingen -->
				<div class="col-sm-8">
					<?php
					// Laat alleen biedingen zien als deze er zijn.
					if ($voorwerp->getBiedingen() != null) {
						?>
						<h5><b>Geboden</b></h5>
						<table class="table table-responsive">
							<tr>
								<th>Naam</th>
								<th>Geboden</th>
								<th>Datum</th>
							</tr>
							<?php
							$biedingen = $voorwerp->getBiedingen();
							$counter = 0;
							foreach ($biedingen as $bod) {
								// Laat maximaal 6 biedingen zien
								if ($counter == 6) {
									break;
								}

								// Parsed de datum en tijd op een leesbare manier.
								$datum =
									"<div class='col-md-4' style='padding: 0px;'>" .
									date_parse($bod->getBodDagTijdstip()) ['day'] . "-" .
									date_parse($bod->getBodDagTijdstip()) ['month'] . " " .
									"</div><div class='col-md-4' style='padding: 0px;'>" .
									date_parse($bod->getBodDagTijdstip()) ['hour'] . ":" .
									sprintf("%02d", date_parse($bod->getBodDagTijdstip()) ['minute']) . ":" .
									sprintf("%02d", date_parse($bod->getBodDagTijdstip()) ['second']) .
									"</div>";

								echo "<tr>
								<td>" . $bod->getGebruiker() . "</td>
								<td>&euro;" . number_format($bod->getBodBedrag(), 2, ",", ".") . "</td>
								<td>" . $datum . "</td>
								</tr>";
								$counter++;
							}
							echo "\n";
							?>
						</table>
						<?php
						// Laat een melding zien als er geen biedingen zijn.
					} else {
						?>
						<h5 class="text-muted">Er zijn nog geen biedingen.</h5>
						<?php
					}
					// Laat alleen het bieformulier zien als er is ingelogd.
					if (isset ($_SESSION ['user'])) {

						// Neemt de startprijs als laatst hoge bod om overheen te bieden
						if ($voorwerp->getBiedingen() == null) {
							$hoogsteBod = $voorwerp->getStartprijs();
						} else {
							$hoogsteBod = $voorwerp->getBiedingen()[0]->getBodbedrag();
						}

						// Dit stuk verwerkt de regels uit de casus voor de geaccepteerde verhogingen.
						if (
							$hoogsteBod >= 1 &&
							$hoogsteBod < 50
						) {
							$minimaalBod = $hoogsteBod + 0.5;
						} else if (
							$hoogsteBod >= 50 &&
							$hoogsteBod < 500
						) {
							$minimaalBod = $hoogsteBod + 1;
						} else if (
							$hoogsteBod >= 500 &&
							$hoogsteBod < 1000
						) {
							$minimaalBod = $hoogsteBod + 5;
						} else if (
							$hoogsteBod >= 1000 &&
							$hoogsteBod < 5000
						) {
							$minimaalBod = $hoogsteBod + 10;
						} else if (
							$hoogsteBod >= 5000
						) {
							$minimaalBod = $hoogsteBod + 50;
						}
						?>
						<div class="form-inline">
							<h5><b>Uw Bod:</b></h5>
							<form class="form-group-sm" action="productDetailPagina.php" method="get">
								<input name="voorwerpNummer" value="<?= $voorwerp->getVoorwerpnummer() ?>" hidden>
								<input name="hoogsteBod" value="<?= $hoogsteBod ?>" hidden>

								<input type="text" class="form-control" name="bedrag">
								<input type="submit" class="form-control btn btn-danger btn-sm" value="Plaats bod">
								<div class="text-muted">Minimaal bod: &euro;<?= number_format($minimaalBod, 2, ",", ".") ?></div>
							</form>
						</div>
					<?php } else { ?>
						<p class="text-muted text-center">Log in om te kunnen bieden</p>
						<div class="text-center"><a href="login.php" class="btn btn-danger btn-lg">Doe nu mee!</a></div>
					<?php } ?>
				</div>

			</div>

		</div>
	</div>

	<!-- Productinformatie -->
	<div class="row top-buffer">

		<div class="col-sm-12 mt-1">
			<div class="panel panel-default">
				<div class="panel-heading">Beschrijving</div>
				<div class="panel-body">
					<p><?= $voorwerp->getBeschrijving(); ?></p>
				</div>
			</div>
		</div>

	</div>

	<div class="row">

		<!-- Productnummer -->
		<div class="col-sm-6">
			<span class="text-left text-info">Productnummer: <?= $voorwerp->getVoorwerpnummer(); ?></span>
		</div>
		<div class="col-sm-6">
			<div class="text-danger text-right"><span class="glyphicon glyphicon-warning-sign"></span>
				<a href="#">Report veiling</a>
			</div>
		</div>

	</div>

<?php } ?>
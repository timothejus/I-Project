<?php
/**
 * Created by Tim Hendriksen.
 * Date: 28-11-2016
 * Time: 14:12
 */
require("DB.php");

function getProductPagina ($voorwerpNummer) {
	$voorwerp = getProduct($voorwerpNummer);
	echo $voorwerp->getResterendeSeconden();
	?>

	<script src="js/timer.js" data-count="<?php echo get_time ($voorwerp->getVoorwerpnummer()); ?>" data-id="timer"></script>
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

			<div class="panel panel-default">
				<div class="panel-heading"><a href="#" class="panelheader-link"><?=$voorwerp->getTitel();?></a></div>
				<div class="panel-body text-center">
					<img src="../www/images/box.png" class="img-thumbnail img-responsive img-thumbnail-primary" alt="img"><br/>
				</div>

				<div class="panel-body text-center">
					<img src="../www/images/box.png" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
					<img src="../www/images/box.png" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
					<img src="../www/images/box.png" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
					<img src="../www/images/box.png" class="img-thumbnail img-responsive img-thumbnail-secondary" alt="img">
				</div>
			</div>

		</div>

		<div class="col-sm-6">

			<!-- Product beschikbaarheid -->
			<div class="row">
				<div class="col-sm-12">
					<div class="panel-heading">
						<h4 class="text-center">Dit product is nog maar <span id="timer" class="text-danger"></span> beschikbaar!</h4>
					</div>
				</div>
			</div>

			<!-- Verkoper/biedingen informatie -->
			<div class="row">

				<!-- Verkoper informatie -->
				<div class="col-sm-4">
					<h5><b>Aanbieder</b></h5>
					<ul class="list-group">
						<li class="list-group-item"><b><a href="#"><?=$voorwerp->getVerkoper();?></a></b></li>
						<li class="list-group-item"><?=$voorwerp->getPlaatsnaam();?></li>
						<li class="list-group-item"><?=$voorwerp->getLand();?><br></li>
					</ul>
					<button type="button" class="btn btn-primary btn-md">Geef Feedback</button>
					<br>
				</div>

				<!-- Biedingen -->
				<div class="col-sm-8">
					<h5><b>Geboden</b></h5>
					<table class="table table-responsive">
						<tr>
							<th>Naam</th>
							<th>Geboden</th>
							<th>Datum</th>
						</tr>
							<?php
							$biedingen = $voorwerp->getBiedingen();
							foreach($biedingen as $bod) {
								$datum =
									date_parse ($bod->getBodDagTijdstip()) ['day'] . "-" .
									date_parse ($bod->getBodDagTijdstip()) ['month'] . " " .
									date_parse ($bod->getBodDagTijdstip()) ['hour'] . ":" .
									date_parse ($bod->getBodDagTijdstip()) ['minute'] . ":" .
									date_parse ($bod->getBodDagTijdstip()) ['second'];
								echo "<tr>
								<td>". $bod->getGebruiker()."</td>
								<td>&euro;" . number_format ($bod->getBodBedrag(), 2, ",", ".")."</td>
								<td>".$datum."</td>
							</tr>";
							}
							?>
					</table>
				</div>
			</div>

			<div class="row">

				<!-- Verzendinformatie -->
				<div class="col-sm-4">
					<h5><b><?=$voorwerp->getVerzendInstructies();?></b></h5>
					<p class="text-muted">Ophalen of verzending:<br/>
						<?=$voorwerp->getVerzendkosten();?> </p>
					<br>
				</div>

				<!-- Bod plaatsen -->
				<div class="col-sm-8">
					<div class="form-inline">
						<h5><b>Uw Bod:</b></h5>
						<div class="form-group-sm">
							<input type="text" class="form-control">
							<button type="button" class="form-control btn btn-danger btn-sm">Plaats bod</button>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>

	<!-- Productinformatie -->
	<div class="row top-buffer">

		<div class="col-sm-12 mt-1">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="#" class="panelheader-link">Beschrijving</a></div>
				<div class="panel-body">
					<p><?=$voorwerp->getBeschrijving();?></p>
				</div>
			</div>
		</div>

	</div>

	<div class="row">

		<!-- Productnummer -->
		<div class="col-sm-6">
			<span class="text-left text-info">Productnummer: <?=$voorwerp->getVoorwerpnummer();?></span>
		</div>
		<div class="col-sm-6">
			<div class="text-danger text-right"><span class="glyphicon glyphicon-warning-sign"></span>
				<a href="#">Report veiling</a>
			</div>
		</div>

	</div>
	</div>

<?php } ?>
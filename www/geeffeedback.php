<?php

// Includes
require ("scripts/DB.php");
require ("scripts/header.php");

// Variabelen
$product = getProductData (floatval ($_GET['voorwerpnummer']));
$verkoper = $product->getVerkoper();
$koper = $product->getKoper();
$voorwerp = $product->getVoorwerpnummer();
$opgestuurd = 0;
$ingevuld = '0';

// Checkt of het formulier ingevuld is.
if (isset ($_GET ['ingevuld'])) {
	if ($_GET ['ingevuld'] == '1') {
		$ingevuld = $_GET ['ingevuld'];
	}
}

// Checkt of de gebruiker ingelogd is en geeft een foutmelding als het niet zo is.
if (isset ($_SESSION ['user'])) {
	$user = $_SESSION ['user'];
} else {
	echo '<div class="container"><div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="alert alert-danger text-center">U moet ingelogd zijn om de feedback in te kunnen vullen.</div></div></div></div>';
	require ("scripts/footer.php");
	exit;
}

// Checkt of de gebruiker ook de koper van het product is en geeft een foutmelding als het niet zo is.
if ($user != $product->getKoper()) {
	echo '<div class="container"><div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="alert alert-danger text-center">U bent niet de koper van dit product.</div></div></div></div>';
	require ("scripts/footer.php");
	exit;
}

// Checkt of een veld leeg is.
function checkLeegte ($veld) {
	if ($veld == '') {
		return null;
	} else {
		return $veld;
	}
}

// Dit blok wordt uitgevoerd als er op "Verzend" is gedrukt.
if ($ingevuld == '1') {
	// Stelt de beoordelingen in om op te sturen.
	$communicatiebeoordeling = $_GET['communicatie'];
	$communicatieopmerking = checkLeegte ($_GET['communicatiecomments']);
	$leveringbeoordeling = $_GET['levering'];
	$leveringopmerking = checkLeegte ($_GET['leveringcomments']);
	$levertijdbeoordeling = $_GET['levertijd'];
	$levertijdopmerking = checkLeegte ($_GET['levertijdcomments']);
	$algemeneopmerking = checkLeegte ($_GET['overigecomments']);

	// Stuurt de feedback op.
	geefFeedback(
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
	);

	// Ingevuld en geplaatst
	echo '<div class="container"><div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="alert alert-success text-center">Bedankt voor het invullen van de feedback!<br>U wordt teruggestuurd naar de hoofdpagina.</div></div></div></div>';
	echo '<script type="text/javascript">setTimeout(function(){location.href="index.php"}, 5000);</script>';
	require ("scripts/footer.php");
	exit;
}
?>

		<div class="container">

			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading text-center"><h4>Geef feedback</h4></div>
						<form method="get" action="geeffeedback.php">
							<div class="panel-body">
								<table style="width: 100%; table-layout: fixed;">
									<tr>
										<td style="width: 40%"></td>
										<td>Slecht</td>
										<td class="text-center">Wel oké</td>
										<td class="text-right">Uitstekend</td>
									</tr>
									<tr>
										<td>Communicatie</td>
										<td colspan="3"><input name="communicatie" style="width: 100%" id="r1" type="text" data-slider-tooltip="hide" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="2"></td>
									</tr>
								</table>
								<textarea class="form-control" name="communicatiecomments" rows="3"></textarea><br>
								<table style="width: 100%; table-layout: fixed;">
									<tr>
										<td style="width: 40%"></td>
										<td>Slecht</td>
										<td class="text-center">Wel oké</td>
										<td class="text-right">Uitstekend</td>
									</tr>
									<tr>
										<td>Levering</td>
										<td colspan="3"><input name="levering" style="width: 100%" id="r2" type="text" data-slider-tooltip="hide" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="2"></td>
									</tr>
								</table>
								<textarea class="form-control" name="leveringcomments" rows="3"></textarea><br>
								<table style="width: 100%; table-layout: fixed;">
									<tr>
										<td style="width: 40%"></td>
										<td>Slecht</td>
										<td class="text-center">Wel oké</td>
										<td class="text-right">Uitstekend</td>
									</tr>
									<tr>
										<td>Levertijd</td>
										<td colspan="3"><input name="levertijd" style="width: 100%" id="r3" type="text" data-slider-tooltip="hide" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="2"></td>
									</tr>
								</table>
								<textarea class="form-control" name="levertijdcomments" rows="3"></textarea><br><br>
								Overige opmerkingen
								<textarea class="form-control" name="overigecomments" rows="3"></textarea>
							</div>
							<div class="panel-footer text-center">
								<table class="text-center" style="width: 100%">
									<tr>
										<td><a href="#" class="btn btn-default">Annuleer</a></td>
										<td><input type="submit" href="#" class="btn btn-primary" value="Verzend"></td>
									</tr>
								</table>
							</div>
							<input type="text" name="ingevuld" value="1" hidden>
							<input type="text" name="voorwerpnummer" value="<?=$voorwerp?>" hidden>
						</form>
					</div>
				</div>

			</div>

		</div>

		<script>
			$('#r1').slider ({
			});
			$('#r2').slider ({
			});
			$('#r3').slider ({
			});
		</script>

<?php require ("scripts/footer.php"); ?>


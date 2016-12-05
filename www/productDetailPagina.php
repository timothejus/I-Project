<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 29-11-2016
 * Time: 13:17
 */

// Haalt de benodigde functies op (product v/d dag, klein product en de time formatter)
require("scripts/product.php");
require("scripts/format_time.php");
require("scripts/get_time.php");

$voorwerpNummer = $_GET['voorwerpNummer'];
if (isset ($_GET ['bedrag'])) {
	$bodBedrag = str_replace(',', '.', $_GET['bedrag']);
}
if (isset ($_GET ['hoogsteBod'])) {
	$hoogsteBod = $_GET ['hoogsteBod'];
}

// Include de header
require("scripts/header.php");

// Parse het meegegeven bedrag
if (isset ($_GET ['bedrag']) && isset ($_GET ['hoogsteBod'])) {
	if ($_GET ['bedrag'] != "" && $_GET ['hoogsteBod'] != "") {
		if (
			(
				$hoogsteBod >= 1 &&
				$hoogsteBod < 50 &&
				$bodBedrag >= $hoogsteBod + 0.5
			) || (
				$hoogsteBod >= 50 &&
				$hoogsteBod < 500 &&
				$bodBedrag >= $hoogsteBod + 1
			) || (
				$hoogsteBod >= 500 &&
				$hoogsteBod < 1000 &&
				$bodBedrag >= $hoogsteBod + 5
			) || (
				$hoogsteBod >= 1000 &&
				$hoogsteBod < 5000 &&
				$bodBedrag >= $hoogsteBod + 10
			) || (
				$hoogsteBod >= 5000 &&
				$bodBedrag >= $hoogsteBod + 50
			)
		) {
			$nieuwbod = new Bod ($voorwerpNummer, $bodBedrag, $_SESSION['user'], "");
			$nieuwbod->plaatsBod();
		} else if (is_float ($bodBedrag) || is_numeric ($bodBedrag)) {
			echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Bod is te laag!</div></div></div>';
		} else {
			echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Bod is geen geldig getal!</div></div></div>';
		}
	} else {
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Bod is te laag!</div></div></div>';
	}
}

?>
	<!-- Hoofdpagina container -->
<div class="container">
	<?php getProductPagina($voorwerpNummer); ?>
</div>

<?php require ("scripts/footer.php"); ?>

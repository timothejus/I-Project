<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 29-11-2016
 * Time: 13:17
 */

// Haalt de benodigde functies op (product v/d dag, klein product en de time formatter)
require ("scripts/product.php");
//require ("Bod.php");
require ("scripts/format_time.php");
require ("scripts/get_time.php");

$voorwerpNummer = $_GET['voorwerpNummer'];
$bodBedrag = $_GET['bedrag'];
$Bod = $_GET['hoogsteBod'];
$hoogsteBod = $Bod->getBodbedrag();
echo $hoogsteBod;

// Include de header
require ("scripts/header.php");

// Parse het meegegeven bedrag
if (isset ($_GET ['bedrag'])) {
	// Bedrag is ingesteld
	echo "isset: ja<br/>";
	if ($_GET ['bedrag'] == "") {
		// Bedrag is ingesteld maar niet ingevuld
		echo "isleeg: ja";
	} else {
		// Bedrag is ingesteld en ingevuld
		echo "isleeg: nee";
		if($bodBedrag > $hoogsteBod + 1){
			$nieuwbod = new Bod ($voorwerpNummer, $bodBedrag, $_SESSION['user'], "");
			$nieuwbod -> plaatsBod ();
		}
		else{
			echo "bod te laag!";
		}


	}
} else {
	// Bedrag is niet ingesteld
	echo "isset: nee";
}

?>
<!-- Hoofdpagina container -->
<div class="container">
	<?php getProductPagina($voorwerpNummer);?>
</div>

<?php require("scripts/footer.php");?>

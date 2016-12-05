<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 29-11-2016
 * Time: 13:17
 */

// Haalt de benodigde functies op (product v/d dag, klein product en de time formatter)
require ("scripts/product_groot.php");
require ("scripts/product_klein.php");
require ("scripts/format_time.php");
require("scripts/DB.php");

// Include de header
require ("scripts/header.php");

?>
<!-- Hoofdpagina container -->
<div class="container">

	<!-- Product van de dag -->
	<div class="row">

		<?php
		//$ProductGroot = ProductGroot();
		geefProductGroot ("Titel", "images/box.png", "6,50", "00:39:20");
		?>

	</div>

	<!-- Overige producten -->
	<div class="row">
		<script src="js/timer.js" data-id="countdown"></script>
		<?php
		//Haal voorwerpen op voor homepagina
		$voorwerpen = getVoorwerpen();

		//loop door de array voorwerpen en laat de voorwerpen zien
		foreach ($voorwerpen as $voorwerp) {
			echo $voorwerp->geefProductKlein();
		}
		?>

	</div>

</div>

<?php
// Include de footer
require("scripts/footer.php");
?>

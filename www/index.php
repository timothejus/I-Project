<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 29-11-2016
 * Time: 13:17
 */

// Haalt de benodigde functies op (product v/d dag, klein product en de time formatter)
require("scripts/DB.php");

// Include de header
require ("scripts/header.php");

?>
<!-- Hoofdpagina container -->
<script src="js/timer.js" data-id="countdown"></script>
<div class="container">

	<!-- Product van de dag -->
	<div class="row">

		<?php
		$voorwerp = getProductGroot();
		//Als er geen voorwerp van de dag wordt opggehaald laat dan toch de website zien.
		if(isset($voorwerp)) {
			echo $voorwerp->geefProductGroot();
		}
		?>
	</div>

	<!-- Overige producten -->
	<div class="row">
		<?php
		//Haal voorwerpen op voor homepagina
		$voorwerpen = getVoorwerpen();

		//creeër een counter zodat de producten op de pagina maar vier breed zijn.
		$counter = 1;

		//loop door de array voorwerpen en laat de voorwerpen zien
		foreach ($voorwerpen as $voorwerp) {
			if ($counter%4 == 1) {
				echo "<div class='row'>\n";
			}
			echo $voorwerp->geefProductKlein();
			if ($counter%4 == 0) {
				echo "</div>\n";
			}
			$counter++;
		}
		?>

	</div>

</div>

<?php
// Include de footer
require("scripts/footer.php");
?>

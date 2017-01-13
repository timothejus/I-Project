<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 29-11-2016
 * Time: 13:17
 */

// Include de header
require ("scripts/header.php");
require ("rubriek.php");

if (isset($_GET["uitgelogd"])){
	echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-success text-center">U bent succesvol uitgelogd!</div></div></div>';
}
?>

<!-- Hoofdpagina container -->
<script src="js/timer.js" data-id="countdown"></script>
<div class="container">

	<!-- Product van de dag -->
	<div class="row">

		<?php
		$voorwerp = getProductGroot();
		//Als er geen voorwerp van de dag wordt opgehaald laat dan toch de website zien.
		if(isset($voorwerp)) {
			echo $voorwerp->geefProductGroot();
		}
		?>
	</div>

	<!-- Overige producten -->
	<div class="row">
		<div class="col-sm-3">
			<div class="panel panel-info">
				<div class="panel-heading">Rubrieken</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<?php
						$rubrieken = getHoofdrubrieken ();

						foreach ($rubrieken as $row) {
							echo '<li><a href="subrubriek.php?id=' . $row->getID () . '&top=0" class="catlink">' . $row->getNaam () . "</a></li>\n";
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="panel panel-default"><div class="panel-heading text-center"><h3 class="text-danger">Laatste kans!</h3></div><div class="panel-body">
			<?php
			//Haal voorwerpen op voor homepagina
			$voorwerpen = getVoorwerpen();

			//creeër een counter zodat de producten op de pagina maar vier breed zijn.
			$counter = 1;

			//loop door de array voorwerpen en laat de voorwerpen zien
			foreach ($voorwerpen as $voorwerp) {
				if ($counter%3 == 1) {
					echo "<div class='row'>\n";
				}
				echo $voorwerp->geefProductKlein();
				if ($counter%3 == 0) {
					echo "</div>\n";
				}
				$counter++;
			}
			?>
			</div>
		</div>

	</div>

</div>

<?php
// Include de footer
require("scripts/footer.php");
?>

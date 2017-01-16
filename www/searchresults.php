<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 4-1-2017
 * Time: 23:14
 */

require ("rubriek.php");
require ("scripts/header.php");


$zoektekst = $email = $_GET["zoektekst"];


?>

<script src="js/timer.js" data-id="countdown"></script>
<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<div class="panel panel-info">
				<div class="panel-heading">Rubrieken</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<?php
						$rubrieken = getHoofdrubrieken ();

						foreach ($rubrieken as $row) {
							echo '<li><a href="subrubriek.php?id=' . $row->getID () . '" class="catlink">' . $row->getNaam () . "</a></li>\n";
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="panel panel-default">

			<div class="panel-heading text-center"><h3>Zoekresultaten voor: " <?php echo $zoektekst ?> "</h3></div>
			<div class="panel-body">
				<?php
				$voorwerpen = getZoekresultaten($zoektekst);
				$counter = 1;

				if (isset ($voorwerpen)) {
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
				} else {
				?>
				<p class="text-muted">Er zijn geen producten binnen deze categorie</p>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</div>
<?php require ("scripts/footer.php"); ?>

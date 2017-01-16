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
							echo '<li><a href="subrubriek.php?id=' . $row->getID () . '&top=0" class="catlink">' . $row->getNaam () . "</a></li>\n";
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
				$voorwerpen = getZoekresultaten($zoektekst,$_GET["top"] * 18);
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
				}
				else {
				?>
				<p class="text-muted">Er zijn geen producten binnen deze categorie</p>
			</div>
		</div>
		<?php
		}?>
		<ul class="pagination">
					<?php
					$voorwerpenCount = getCountZoekresultaten($zoektekst);
					if ($voorwerpenCount <= $_GET["top"]*18 + 18){
						$top1 = $_GET["top"]-4;
						$top2 = $_GET["top"]-3;
						$top3 = $_GET["top"]-2;
						$top4 = $_GET["top"]-1;
						$top5 = $_GET["top"];
						$top6 = $_GET["top"]+1;
						if ($top1 <= 0){
							$top1 = 0;
						}
						if ($top2 <= 0){
							$top2 = 0;
						}
						if ($top3 <= 0){
							$top3 = 0;
						}
						if ($top4 <= 0){
							$top4 = 0;
						}
						if ($top5 <= 0){
							$top5 = 0;
						}

						echo "
				<li><a  href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top1 . "'>" . $top2 . "</a></li>
				<li ><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top2 . "'>" . $top3 . "</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li class='active'><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
					}
					else if ($voorwerpenCount <= $_GET["top"]*18 + 36){
						$top0 = $_GET["top"]-4;
						$top1 = $_GET["top"]-3;
						$top2 = $_GET["top"]-2;
						$top3 = $_GET["top"]-1;
						$top4 = $_GET["top"];
						$top5 = $_GET["top"]+1;
						$top6 = $_GET["top"]+2;
						if ($top0 <= 0){
							$top0 = 0;
						}
						if ($top1 <= 0){
							$top1 = 0;
						}
						if ($top2 <= 0){
							$top2 = 0;
						}
						if ($top3 <= 0){
							$top3 = 0;
						}
						if ($top4 <= 0){
							$top4 = 0;
						}
						echo "
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top1 . "'>" . $top2 . "</a></li>
				<li ><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top2 . "'>" . $top3 . "</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li class='active'><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
					}
					else if ($_GET["top"] == 0) {
						$top1 = $_GET["top"];
						$top2 = $_GET["top"]+1;
						$top3 = $_GET["top"]+2;
						$top4 = $_GET["top"]+3;
						$top5 = $_GET["top"]+4;
						echo "
				<li class='active'><a  href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top1 . "'>1</a></li>
				<li ><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top3 . "'>3</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top4 . "'>4</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top5 . "'>5</a></li>";
					}

					else if ($_GET["top"] == 1) {
						$top1 = $_GET["top"]-1;
						$top2 = $_GET["top"];
						$top3 = $_GET["top"]+1;
						$top4 = $_GET["top"]+2;
						$top5 = $_GET["top"]+3;
						echo "
				<li><a  href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top1 . "'>1</a></li>
				<li class='active'><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top3 . "'>3</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top4 . "'>4</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top5 . "'>5</a></li>";
					}
					else if ($_GET["top"] >= 2) {
						$top1 = $_GET["top"]-2;
						$top2 = $_GET["top"]-1;
						$top3 = $_GET["top"];
						$top4 = $_GET["top"]+1;
						$top5 = $_GET["top"]+2;
						$top6 = $_GET["top"]+3;
						echo "
				<li><a  href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top1 . "'>". $top2 ."</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top2 . "'>". $top3 . "</a></li>
				<li class='active'><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top3 . "'>". $top4 ."</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top4 . "'>". $top5 ."</a></li>
				<li><a href='searchresults.php?zoektekst=" . $_GET["zoektekst"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
					}
		?>

			</ul>
	</div>
</div>
<?php require ("scripts/footer.php"); ?>

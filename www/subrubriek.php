<?php
/**
 * Created by IntelliJ IDEA.
 * User: DevServer
 * Date: 19-12-2016
 * Time: 14:22
 */
require ("scripts/DB.php");
require ("rubriek.php");
require ("scripts/header.php");
?>

<script src="../js/timer.js" data-id="countdown"></script>
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
				<?php
				if (isset ($_GET ['id'])) {
					if (!empty ($_GET ['id'])) {
						$rubrieken = getSubrubrieken ($_GET ['id']);
						if ($rubrieken != null) {
				?>
				<div class="panel-heading text-center"><h3>Subrubrieken binnen "<?=getRubriek ($_GET ['id'])[0]->getNaam(); ?>"</h3></div>
				<div class="panel-body">
					<div class="col-sm-6">
						<ul class="nav nav-pills nav-stacked">
							<?php
							if (count ($rubrieken)%2 != 0) {
								$arrfirsthalf = array_slice ($rubrieken, 0, count($rubrieken)/2+1);
								$arrsecondhalf = array_slice ($rubrieken, count($rubrieken)/2+1, count ($rubrieken));
							} else {
								$arrfirsthalf = array_slice ($rubrieken, 0, count($rubrieken)/2);
								$arrsecondhalf = array_slice ($rubrieken, count($rubrieken)/2, count ($rubrieken));
							}

							foreach ($arrfirsthalf as $row) {
								if (getVoorwerpenVanRubriek ($row->getID ()) != null) {
									echo '<li><a href="subrubriek.php?id=' . $row->getID () . '">' . $row->getNaam () . " <span class='text-muted'>(" . count (getVoorwerpenVanRubriek ($row->getID ())) . ")</span></a></li>\n";
								} else {
									echo '<li><a href="subrubriek.php?id=' . $row->getID () . '">' . $row->getNaam () . "</a></li>\n";
								}
							}
							?>
						</ul>
					</div>
					<div class="col-sm-6">
						<ul class="nav nav-pills nav-stacked">
							<?php
							foreach ($arrsecondhalf as $row) {
								echo '<li><a href="subrubriek.php?id=' . $row->getID () . '">' . $row->getNaam () . "</a></li>\n";
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php
			} else {
			?>
			<div class="panel-heading text-center"><h3>Producten binnen "<?=getRubriek ($_GET ['id'])[0]->getNaam(); ?>"</h3></div>
			<div class="panel-body">
				<?php
				$voorwerpen = getVoorwerpenVanRubriek($_GET['id']);
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
			}
			}
			}
			?>
		</div>
	</div>
	<?php require ("scripts/footer.php"); ?>


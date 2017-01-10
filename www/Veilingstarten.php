<?php
/**
 * Created by IntelliJ IDEA.
 * User: DevServer
 * Date: 19-12-2016
 * Time: 14:22
 */
require("scripts/DB.php");
require("rubriek.php");
require("scripts/header.php");

$rubrieken = getSubrubrieken($_GET ['id']);
if ($rubrieken == null){
	header("Location: /I-Project/www/verkopen.php?rubriek=" . $_GET["id"]);
}
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
						$rubrieken = getHoofdrubrieken();

						foreach ($rubrieken as $row) {
							echo '<li><a href="Veilingstarten.php?id=' . $row->getID() . '" class="catlink">' . $row->getNaam() . "</a></li>\n";
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<nav class="breadcrumb">
				<?php
				$rubriek = $_GET ['id'];
				$rubrieken = array();

				while (getRubriekParent($rubriek) != 0) {
					$rubrieken [] = $rubriek;
					$rubriek = getRubriekParent($rubriek);
				}

				$rubrieken = array_reverse($rubrieken);
				$counter = 1;

				foreach ($rubrieken as $row) {
					if ($counter != count($rubrieken)) {
						echo '<li class="breadcrumb-item"><a href="Veilingstarten.php?id=' . $row . '">' . getRubriek($row)[0]->getNaam() . '</a></li>' . "\n";
					} else {
						echo '<li class="breadcrumb-item active">' . getRubriek($row)[0]->getNaam() . '</li>' . "\n";
					}
					$counter++;
				}
				?>
			</nav>
			<div class="panel panel-default">
				<?php
				if (isset ($_GET ['id'])) {
				if (!empty ($_GET ['id'])) {
				$rubrieken = getSubrubrieken($_GET ['id']);
				if ($rubrieken != null) {
				?>
				<div class="panel-heading text-center">
					<h3>Subrubrieken binnen "<?php
						if ($_GET["id"] == -1){
							echo "hoofdrubriek";
						} else {
							echo getRubriek($_GET ['id'])[0]->getNaam();
						}?>"</h3></div>
				<div class="panel-body">
					<div class="col-sm-6">
						<ul class="nav nav-pills nav-stacked">
							<?php
							if (count($rubrieken) % 2 != 0) {
								$arrfirsthalf = array_slice($rubrieken, 0, count($rubrieken) / 2 + 1);
								$arrsecondhalf = array_slice($rubrieken, count($rubrieken) / 2 + 1, count($rubrieken));
							} else {
								$arrfirsthalf = array_slice($rubrieken, 0, count($rubrieken) / 2);
								$arrsecondhalf = array_slice($rubrieken, count($rubrieken) / 2, count($rubrieken));
							}

							foreach ($arrfirsthalf as $row) {
								if (getVoorwerpenVanRubriek($row->getID()) != null) {
									echo '<li><a href="veilingstarten.php?id=' . $row->getID() . '">' . $row->getNaam() . " <span class='text-muted'>(" . count(getVoorwerpenVanRubriek($row->getID())) . ")</span></a></li>\n";
								} else {
									echo '<li><a href="veilingstarten.php?id=' . $row->getID() . '">' . $row->getNaam() . "</a></li>\n";
								}
							}
							?>
						</ul>
					</div>
					<div class="col-sm-6">
						<ul class="nav nav-pills nav-stacked">
							<?php
							foreach ($arrsecondhalf as $row) {
								if (getVoorwerpenVanRubriek($row->getID()) != null) {
									echo '<li><a href="veilingstarten.php?id=' . $row->getID() . '">' . $row->getNaam() . " <span class='text-muted'>(" . count(getVoorwerpenVanRubriek($row->getID())) . ")</span></a></li>\n";
								} else {
									echo '<li><a href="veilingstarten.php?id=' . $row->getID() . '">' . $row->getNaam() . "</a></li>\n";
								}
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php

			}
			}
			}
			?>
		</div>
	</div>
	<?php require("scripts/footer.php"); ?>


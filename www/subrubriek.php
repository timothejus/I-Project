<?php
/**
 * Created by IntelliJ IDEA.
 * User: DevServer
 * Date: 19-12-2016
 * Time: 14:22
 */
require("scripts/header.php");
require("rubriek.php");
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
							echo '<li><a href="subrubriek.php?id=' . $row->getID() . "&top=0" . '" class="catlink">' . $row->getNaam() . "</a></li>\n";
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
						echo '<li class="breadcrumb-item"><a href="subrubriek.php?id=' . $row . "&top=0" . '">' . getRubriek($row)[0]->getNaam() . '</a></li>' . "\n";
					} else {
						echo '<li class="breadcrumb-item active">' . getRubriek($row)[0]->getNaam() . '</li>' . "\n";
					}
					$counter++;
				}
				?>
			</nav>
				<?php
				if (isset ($_GET ['id'])) {
				if (!empty ($_GET ['id'])) {
				$rubrieken = getSubrubrieken($_GET ['id']);
				if ($rubrieken != null) {
				?>
				<div class="panel panel-default">
				<div class="panel-heading text-center">
					<h3>Subrubrieken binnen "<?= getRubriek($_GET ['id'])[0]->getNaam(); ?>"</h3></div>
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
								echo '<li><a href="subrubriek.php?id=' . $row->getID() . "&top=0" . '">' . $row->getNaam() . " </a></li>\n";
							}
							//<span class='text-muted'>(" . getVoorwerpenVanRubriekCount($row->getID()) . ")</span>
							?>
						</ul>
					</div>
					<div class="col-sm-6">
						<ul class="nav nav-pills nav-stacked">
							<?php
							foreach ($arrsecondhalf as $row) {
								echo '<li><a href="subrubriek.php?id=' . $row->getID() . "&top=0" . '">' . $row->getNaam() . " </a></li>\n";
							}
							//<span class='text-muted'>(" . getVoorwerpenVanRubriekCount($row->getID()) . ")</span>
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					<h3>Producten binnen "<?= getRubriek($_GET ['id'])[0]->getNaam(); ?>"</h3></div>
				<div class="panel-body">
					<?php
					$voorwerpen = getVoorwerpenVanRubriek($_GET['id'], $_GET["top"] * 18);
					$counter = 1;
					if (isset ($voorwerpen)) {
						foreach ($voorwerpen as $voorwerp) {
							if ($counter % 3 == 1) {
								echo "<div class='row'>\n";
							}
							echo $voorwerp->geefProductKlein();
							if ($counter % 3 == 0) {
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
					<div class="text-center">
			<ul class="pagination">
				<?php
				$voorwerpenVanRubriek = getVoorwerpenVanRubriekCount($_GET["id"]);

				if ($voorwerpenVanRubriek <= $_GET["top"]*18 + 18) {
					$top1 = $_GET["top"] - 4;
					$top2 = $_GET["top"] - 3;
					$top3 = $_GET["top"] - 2;
					$top4 = $_GET["top"] - 1;
					$top5 = $_GET["top"];
					$top6 = $_GET["top"] + 1;
					if ($top1 <= 0) {
						$top1 = 0;
					}
					if ($top2 <= 0) {
						$top2 = 0;
					}
					if ($top3 <= 0) {
						$top3 = 0;
					}
					if ($top4 <= 0) {
						$top4 = 0;
					}
					if ($top5 <= 0) {
						$top5 = 0;
					}

					If ($top5 == 0) {
						echo "
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";

					} else If ($top4 == 0) {
						echo "
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
					} else If ($top3 == 0) {
						echo "
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";

					} else If ($top2 == 0) {
						echo "
				<li ><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>" . $top3 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";

					} else {
						echo "
				<li><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>" . $top2 . "</a></li>
				<li ><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>" . $top3 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
					}
				}
				else if ($voorwerpenVanRubriek <= $_GET["top"]*18 + 36){
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

					If ($top4 == 0) {
						echo "
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";

					} else If ($top3 == 0) {
						echo "
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
					} else If ($top2 == 0) {
						echo "
				<li ><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>" . $top3 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";

					} else {
						echo "
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>" . $top2 . "</a></li>
				<li ><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>" . $top3 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>" . $top4 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>" . $top5 . "</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
					}

				}
				else if ($_GET["top"] == 0) {
					$top1 = $_GET["top"];
					$top2 = $_GET["top"] + 1;
					$top3 = $_GET["top"] + 2;
					$top4 = $_GET["top"] + 3;
					$top5 = $_GET["top"] + 4;
					if ($voorwerpenVanRubriek <= $_GET["top"] * 18 + 54) {
						echo "
				<li class='active'><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>1</a></li>
				<li ><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>3</a></li>";
					}
					else if ($voorwerpenVanRubriek <= $_GET["top"] * 18 + 72) {
						echo "
				<li class='active'><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>1</a></li>
				<li ><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>3</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>4</a></li>";
					}
					else {
						echo "
				<li class='active'><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>1</a></li>
				<li ><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>3</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>4</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>5</a></li>";
					}
				}

				else if ($_GET["top"] == 1) {
					$top1 = $_GET["top"]-1;
					$top2 = $_GET["top"];
					$top3 = $_GET["top"]+1;
					$top4 = $_GET["top"]+2;
					$top5 = $_GET["top"]+3;
					if ($voorwerpenVanRubriek <= $_GET["top"] * 18 + 36) {
						echo "
				<li><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>1</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>3</a></li>";
					} else if ($voorwerpenVanRubriek <= $_GET["top"] * 18 + 54) {
						echo "
				<li><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>1</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>3</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>4</a></li>";
					} else {
						echo "
				<li><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>1</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>2</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>3</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>4</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>5</a></li>";

					}
				}
				else if ($_GET["top"] >= 2) {
					$top1 = $_GET["top"]-2;
					$top2 = $_GET["top"]-1;
					$top3 = $_GET["top"];
					$top4 = $_GET["top"]+1;
					$top5 = $_GET["top"]+2;
					$top6 = $_GET["top"]+3;
					echo "
				<li><a  href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top1 . "'>". $top2 ."</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top2 . "'>". $top3 . "</a></li>
				<li class='active'><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top3 . "'>". $top4 ."</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top4 . "'>". $top5 ."</a></li>
				<li><a href='subrubriek.php?id=" . $_GET["id"] . "&top=" . $top5 . "'>" . $top6 . "</a></li>";
				}
				?>
			</ul>
			<?php
			//}
			}
			}
			?>
		</div>
	</div>
</div>
	<?php require("scripts/footer.php"); ?>


<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 10-1-2017
 * Time: 14:38
 */

session_start();

// Includes
require("rubriek.php");
require("scripts/DB.php");

// Functie voor het kruimelpad.
function getBreadcrumb ($rubriek) {
	$rubrieken = array();

	// Maakt een array van de parent nummers aan.
	while (getRubriekParent($rubriek) != 0) {
		$rubrieken [] = $rubriek;
		$rubriek = getRubriekParent($rubriek);
	}

	// Draait de array om.
	$rubrieken = array_reverse($rubrieken);

	// Terug naar de hoofdcategorieën.
	$output = '<li class="breadcrumb-item"><a href="#" onClick="javascript:loadRubriek (' . "'-1', " . "'" . $_GET['kolom'] . "'" . ');">Hoofd</a></li>' . "\n";

	// Maakt de dyamische html code aan.
	$counter = 1;
	foreach ($rubrieken as $row) {
		if ($counter != count($rubrieken)) {
			$output .= '<li class="breadcrumb-item"><a href="#" onClick="loadRubriek(' . "'" . $row . "'" . ', ' . "'" . $_GET['kolom'] . "'" . ')">' . getRubriek($row)[0]->getNaam() . '</a></li>' . "\n";
		} else {
			$output .= '<li class="breadcrumb-item active">' . getRubriek($row)[0]->getNaam() . '</li>' . "\n";
		}
		$counter++;
	}

	// Stuur de output terug.
	return $output;
}

// Initialiseer een lijst met categorieën.
$rubrieken = getSubrubrieken($_GET['rubriek']);

?>

<div class="panel panel-default">
	<div class="panel-heading">Kies een rubriek</div>
	<div class="panel-body">
		<ul class="breadcrumb">
			<?php
			// Zet de breadcrumb neer.
			echo getBreadcrumb($_GET['rubriek']);
			?>
		</ul>
		<ul class="list-group">
			<?php
			if (is_array ($rubrieken)) {
				// Zet de categorieën neer.
				foreach ($rubrieken as $row) {
				?>
					<li class="list-group-item">
						<a href="#" onClick="javascript:loadRubriek('<?= $row->getId() ?>','<?=$_GET['kolom']?>');"><?= $row->getNaam()?></a>
					</li>
				<?php
				}
			} else {
				if ($_GET ['kolom'] == 1) {
					$_SESSION ['rubriek1'] = $_GET ['rubriek']; ?>
					<h4 class="text-center text-success">Rubriek "<?=getRubriek ($_SESSION['rubriek1'])[0]->getNaam()?>" geselecteerd!</h4>
				<?php
				} else if ($_GET ['kolom'] == 2) {
					$_SESSION ['rubriek2'] = $_GET ['rubriek']; ?>
					<h4 class="text-center text-success">Rubriek "<?=getRubriek ($_SESSION['rubriek2'])[0]->getNaam()?>" geselecteerd!</h4>
				<?php
				}
				?>
			<?php } ?>
		</ul>
	</div>
</div>

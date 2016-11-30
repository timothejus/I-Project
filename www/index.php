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

// Maak een connectie met de database.
$dsn = "sqlsrv:Server=192.168.0.20;Database=EenmaalAndermaal";
$user = "sa";
$pass = "iproject4";
$conn = new PDO ($dsn, $user, $pass);

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

		<?php

		/*
		// SQL query voor alle info behalve de aflooptijd. Alle producten waar op geboden is worden weergegeven.
		$sql = "SELECT * FROM Voorwerp INNER JOIN Bod ON Voorwerp.Voorwerpnummer=Bod.Voorwerp WHERE Bod.Bodbedrag = (SELECT MAX (Bodbedrag) FROM Bod WHERE Bod.Voorwerp=Voorwerp.Voorwerpnummer)";

		$tijd = "";

		// Loop voor alle producten
		foreach ($conn -> query ($sql) as $row) {

			// Query en loop voor de aflooptijd per product in seconden
			$sql2 = "SELECT DATEDIFF (second, getDate (), LooptijdEindeDagTijdstip) FROM Voorwerp WHERE Voorwerpnummer = " . $row ['Voorwerpnummer'] . ";";
			foreach ($conn -> query ($sql2) as $row2) {
				$tijd = $row2 [0];
			}

			// Tijd wordt geparsed door format_time
			$tijd = format_time ($tijd);
		}
		*/
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

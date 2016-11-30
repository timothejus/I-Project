<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 29-11-2016
 * Time: 13:17
 */

// Haalt de benodigde functies op (product v/d dag, klein product en de time formatter)
require ("scripts/product.php");
require ("scripts/format_time.php");

$voorwerpNummer = $_GET['voorwerpNummer'];

// Include de header
require ("scripts/header.php");

?>
<!-- Hoofdpagina container -->
<div class="container">
	<?php getProductPagina($voorwerpNummer);?>
</div>

<?php require("scripts/footer.php");?>

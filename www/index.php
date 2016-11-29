<?php
require("scripts/product_groot.php");
require("scripts/product_klein.php");
require("scripts/header.php");
require("mssql.inc.php");

$db = new DB();
$db->getVoorwerpen();

?>
<!-- Hoofdpagina container -->
<div class="container">

	<!-- Product van de dag -->
	<div class="row">

		<?php geefProductGroot(); ?>

	</div>

	<!-- Overige producten -->
	<div class="row">

		<!-- Product 1 -->
		<?php geefProductKlein(); ?>

	</div>
</div>
<?php require ("scripts/footer.php"); ?>

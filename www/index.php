<?php
require("scripts/product_groot.php");
require("scripts/product_klein.php");
require("scripts/header.php");
require("mssql.inc.php");
require ("DB.php");
require("scripts/login.php")

?>
<!-- Hoofdpagina container -->
<div class="container">

	<!-- Product van de dag -->
	<div class="row">

		<?php geefProductGroot ("Titel", "images/box.png", "6,50", "00:39:20"); ?>

	</div>

	<!-- Overige producten -->
	<div class="row">

		<!-- Product 1 -->
		<?php geefProductKlein ("Titel", "images/box.png", "6,50", "00:39:20"); ?>

	</div>
</div>
<?php require ("scripts/footer.php"); ?>

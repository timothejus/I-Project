<?php
require ("scripts/header.php");

function minimaleBedrag($hoogsteBod){
$bodBedrag = $hoogsteBod;
	if (
		$hoogsteBod >= 1 &&
		$hoogsteBod < 50 )
		$bodBedrag = $hoogsteBod + 0.5;
	else if (
		$hoogsteBod >= 50 &&
		$hoogsteBod < 500 )
		$bodBedrag = $hoogsteBod + 1;
	else if (
		$hoogsteBod >= 500 &&
		$hoogsteBod < 1000 )
		$bodBedrag = $hoogsteBod + 5;
	else if (
		$hoogsteBod >= 1000 &&
		$hoogsteBod < 5000 )
		$bodBedrag = $hoogsteBod + 10;
	else if (
		$hoogsteBod >= 5000 )
		$bodBedrag = $hoogsteBod + 50;
	return $bodBedrag;
}
if (isset($_GET["voorwerp"]) && isset($_GET["bod"])){
	plaatsBod($_GET["voorwerp"], $_GET["bod"], $_SESSION["user"]);
}

?>

<?php if (isset($_SESSION["user"])) { ?>
	<div class="container">

		<!--inloggen-->
		<div class="row">

			<div class="col-sm-10 col-sm-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading text-center"><h4>Biedingen</h4></div>
					<div class="panel-body">
						<table class="table mijnbiedingen">
							<tr>
								<th>Productnaam</th>
								<th>Eigen bod</th>
								<th>Hoogste bod</th>
								<th>Veiling gesloten/open</th>
							</tr>
							<?php echo toonBiedingen() ?>
						</table>
					</div>
					<div class="panel-footer text-center">
						<a href="mijnaccount.php" class="btn btn-default">Terug</a>
					</div>
				</div>
			</div>

		</div>

	</div>

	<?php

}
else {
	echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">U bent niet ingelogd. Log in om uw biedingen te zien!</div></div></div>';
}require ("scripts/footer.php"); ?>


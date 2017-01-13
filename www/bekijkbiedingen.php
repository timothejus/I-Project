<?php
require ("scripts/header.php");
require ("scripts/DB.php");

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
//TODO: place in DB.php
function toonBiedingen(){

	try {

		$db = getConnection();
		$sql = "EXEC spGetGebruikerBiedingen :Gebruikersnaam";
		$stmt = $db->prepare ($sql);
		$stmt->bindParam(':Gebruikersnaam', $_SESSION["user"], PDO::PARAM_STR);
		$stmt->execute ();
		$user = null;
		$ret = "";

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			 $ret .= 	'							<tr>
									<td style="overflow: hidden"><a href="productDetailPagina.php?voorwerpNummer='. $row["Voorwerpnummer"] .'">'. $row["Titel"] .'</a></td>
									<td>&euro;'. number_format ($row["GebodenBedrag"],2,',','.') .'</td>
									<td>&euro;'. number_format ($row["HoogsteBod"],2,',','.') .'</td>';
			if ($row["Status"] == 0){
				$ret .= '<td>Open</td>';
			} else {
			$ret .= '<td>Gesloten</td>';
			}
								if ($row["HoogsteBod"] != $row["GebodenBedrag"]) {
									$ret .= '
									<td><a href="?voorwerp=' . $row["Voorwerpnummer"] . '&bod=' . minimaleBedrag($row["HoogsteBod"]) . '" class="btn btn-danger btn-xs">Bied &euro;' . minimaleBedrag($row["HoogsteBod"]) . ',-</a></td>
								</tr>';
								} else {
									$ret .= '<td><a class="btn btn-danger btn-xs" disabled>Bied &euro;' . minimaleBedrag($row["HoogsteBod"]) . ',-</a></td>
								</tr>';
								}
			}

	}
	catch (PDOException $e) {
		echo $e->getMessage ();
		echo $e->errorInfo;
	}
	return $ret;
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
								<th>Bied minimaal bod</th>
							</tr>
							<?php echo toonBiedingen() ?>
						</table>
						<div class="text-center">
							<ul class="pagination">
								<li class="active"><a>1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
								<li><a href="#">6</a></li>
								<li><a href="#">7</a></li>
								<li><a href="#">8</a></li>
							</ul>
						</div>
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


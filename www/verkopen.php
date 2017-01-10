<?php
require ("scripts/header.php");
require ("scripts/DB.php");

function getRubriekNaam($id){
	$dbh = getConnection();
	$sql = "SELECT RubriekNaam FROM Rubriek WHERE ID=:rubriek";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':rubriek', $id, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$ret = $row["RubriekNaam"];
	}
	return $ret;
}

function getPlaats($user){
	$dbh = getConnection();
	$sql = "SELECT Plaatsnaam FROM Gebruiker WHERE Gebruikersnaam=:gebruiker";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return $row["Plaatsnaam"];
	}
	return $ret;
}

function getGba($user){
	$dbh = getConnection();
	$sql = "SELECT GbaCode FROM Gebruiker WHERE Gebruikersnaam=:gebruiker";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return $row["GbaCode"];
	}
	return $ret;
}

function veilingPlaatsen(
	$titel,
	$beschrijving,
	$startprijs,
	$betaalwijze,
	$plaatsnaam,
	$GbaCode,
	$Looptijd,
	$verzendkosten,
	$verzendinstructies,
	$verkoper,
	$rubriek
){
	if ($verzendkosten == ""){
		$verzendkosten = NULL;
	}
	if ($verzendinstructies == ""){
		$verzendinstructies = NULL;
	}

	$dbh = getConnection();
	$sql = "INSERT INTO Voorwerp(Titel,
 								Beschrijving, 
 								Startprijs, 
 								Betaalwijze, 
 								Plaatsnaam, 
 								GbaCode, 
 								Looptijd,
 								VerzendKosten, 
 								VerzendInstructies, 
 								Verkoper, 
 								Rubriek) VALUES (:titel,
 													:beschrijving,
 													:startprijs,
 													:betaalwijze,
 													:plaatsnaam,
 													:gbacode,
 													:looptijd,
 													:verzendkosten,
 													:verzendinstructies,
 													:verkoper,
 													:rubriek)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':titel', $titel);
	$stmt->bindParam(':beschrijving', $beschrijving);
	$stmt->bindParam(':startprijs', $startprijs);
	$stmt->bindParam(':betaalwijze', $betaalwijze);
	$stmt->bindParam(':plaatsnaam', $plaatsnaam);
	$stmt->bindParam(':gbacode', $GbaCode);
	$stmt->bindParam(':looptijd', $Looptijd);
	$stmt->bindParam(':verzendkosten', $verzendkosten);
	$stmt->bindParam(':verzendinstructies', $verzendinstructies);
	$stmt->bindParam(':verkoper', $verkoper);
	$stmt->bindParam(':rubriek', $rubriek);
	$stmt->execute();
}

if (isset($_GET["gebruikersnaam"]) &&
	isset($_GET["titel"]) &&
	isset($_GET["beschrijving"]) &&
	isset($_GET["rubriek"]) &&
	isset($_GET["afbeelding1"]) &&
	isset($_GET["startprijs"]) &&
	isset($_GET["betalingswijze"]) &&
	isset($_GET["looptijd"]) &&
	isset($_GET["verzendkosten"]) &&
	isset($_GET["verzendinstructies"])){
		veilingPlaatsen($_GET["titel"],
						$_GET["beschrijving"],
						$_GET["startprijs"],
						$_GET["betalingswijze"],
						getPlaats($_GET["gebruikersnaam"]),
						getGba($_GET["gebruikersnaam"]),
						$_GET["looptijd"],
						$_GET["verzendkosten"],
						$_GET["verzendinstructies"],
						$_GET["gebruikersnaam"],
						$_GET["rubriek"]);
		//AfbeeldingPlaatsen();
} else {

}
?>

		<div class="container">

			<!--inloggen-->
			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-info">
						<div class="panel-heading text-center"><h4>Verkopen</h4></div>
						<form method="get">
							<div class="panel-body">
								Gebruikersnaam
								<input name="gebruikersnaam" type="text" class="form-control" value="<?= $_SESSION["user"] ?>" disabled><br>
								<input name="gebruikersnaam" type="hidden" class="form-control" value="<?= $_SESSION["user"] ?>">
								Titel
								<input name="titel" type="text" class="form-control"><br>
								Beschrijving
								<textarea name="beschrijving" class="form-control" rows="4"></textarea><br>
								Rubriek
								<input name="rubriek" type="text" value="<?= getRubriekNaam($_GET["rubriek"]); ?>" class="form-control" disabled=""><br>
								<input name="rubriek" type="hidden" value="<?= $_GET["rubriek"]; ?>" class="form-control">
								Afbeelding1
								<input name="afbeelding1" type="file" class="form-control-file"><br>
								Afbeelding2
								<input name="afbeelding2" type="file" class="form-control-file"><br>
								Afbeelding3
								<input name="afbeelding3" type="file" class="form-control-file"><br>
								Afbeelding4
								<input name="afbeelding4" type="file" class="form-control-file"><br>
								Startprijs
								<input name="startprijs" type="text" class="form-control"><br>
								Betalingswijze
								<table style="width: 100%; margin-top: 5px;" class="text-center">
									<tr>
										<td><label><input name="betalingswijze" type="radio" value="bank" checked="checked">Bank</input></label></td>
										<td> - of - </td>
										<td><label><input name="betalingswijze" type="radio" value="giro">Giro</input></label></td>
									</tr>
								</table><br>
								Looptijd in dagen<br>
								<select name="looptijd">
									<?php
									$dbh = getConnection();
									$sql = "SELECT Dagen FROM VoorwerpLooptijd";
									$stmt = $dbh->prepare($sql);
									$stmt->execute();
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value=".$row["Dagen"].">".$row["Dagen"]."</option>";
									}
									?>
								</select><br>
								Verzendkosten
								<input name="verzendkosten" type="text" class="form-control"><br>
								Verzendinstructies
								<input name="verzendinstructies" type="text" class="form-control"><br>
							</div>
							<div class="panel-footer text-center">
								<a href="#" class="btn btn-default">Terug</a>
								<div class="col-sm-6 text-center">
									<input class="btn btn-primary" type="submit" value="Verstuur">
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>

		</div>

<?php require ("scripts/footer.php"); ?>


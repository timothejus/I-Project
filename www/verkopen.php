<?php
require ("scripts/header.php");

// Bepalen van de geselecteerde rubrieken
if (!isset ($_SESSION ['rubriek1']) && !isset ($_SESSION ['rubriek2'])) {
	echo '<div class="container"><div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="alert alert-danger text-center">Geen rubriek opgegeven</div></div></div></div>';
	require ("scripts/footer.php");
	exit;
}

// Geef fout als er geen rubrieken opgegeven zijn
if ($_SESSION ['rubriek1'] == "" && $_SESSION ['rubriek2'] == "") {
	echo '<div class="container"><div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="alert alert-danger text-center">Geen rubriek opgegeven</div></div></div></div>';
	require ("scripts/footer.php");
	exit;

// Zet de tweede rubriek terug naar de eerste als alleen de tweede is ingevuld
} else if ($_SESSION ['rubriek1'] == "" && $_SESSION ['rubriek2'] != "") {
	$_SESSION ['rubriek1'] = $_SESSION ['rubriek2'];
	$_SESSION ['rubriek2'] = "";
}

// Stelt de eerste rubriek in, en de tweede alleen als die is ingevuld
$rubrieknaam1 = $_SESSION['rubriek1'];
$rubrieknaam2 = "";

if ($_SESSION ['rubriek2'] != "") {
	$rubrieknaam2 = $_SESSION['rubriek2'];
}

if (isset($_GET["rubriek"])) {
	if (!empty($_GET["rubriek"])) {
		$rubrieknaam1 = $_GET["rubriek"];
	}
}

if (isset($_GET["rubriek2"])) {
	if (!empty($_GET["rubriek2"])) {
		$rubrieknaam2 = $_GET["rubriek2"];
	}
}

function numberFormat($pizza)
{
	if (substr_count($pizza, ".") && substr_count($pizza, ",")) {
		$bodBedrag = str_replace(',', '.', str_replace('.', '', $pizza));
	} else {
		$bodBedrag = str_replace(',', '.', $pizza);
	}
	return $bodBedrag;
}

//TODO: Change to Stored Procedure AND place in DB.php
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

//TODO: Change to Stored Procedure AND place in DB.php
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

//TODO: Change to Stored Procedure AND place in DB.php
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

//TODO: Change to Stored Procedure AND place in DB.php
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
	if ($_GET["rubriek2"] == ""){
		$rubriek2 = NULL;
	} else {
		$rubriek2 = $_GET["rubriek2"];
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
 								Rubriek,
 								Rubriek2) VALUES (:titel,
 													:beschrijving,
 													:startprijs,
 													:betaalwijze,
 													:plaatsnaam,
 													:gbacode,
 													:looptijd,
 													:verzendkosten,
 													:verzendinstructies,
 													:verkoper,
 													:rubriek,
 													:rubriek2)";
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
	$stmt->bindParam(':rubriek2', $rubriek2);
	$stmt->execute();
}

//TODO: Change to Stored Procedure AND place in DB.php
function getVoorwerpNummer($user)
{
	$dbh = getConnection();
	$sql = "select Voorwerpnummer from Voorwerp where Verkoper=:gebruiker order by Voorwerpnummer DESC;";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->execute();
	$ret = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return $row["Voorwerpnummer"];
	}
	return $ret;
}
if (isset($_SESSION["user"])) {
	if (isVerkoper($_SESSION["user"])) {

		if (!empty($_GET["gebruikersnaam"]) &&
			!empty($_GET["titel"]) &&
			!empty($_GET["beschrijving"]) &&
			!empty($_GET["rubriek"]) &&
			!empty($_GET["startprijs"]) &&
			!empty($_GET["betalingswijze"]) &&
			!empty($_GET["looptijd"]) &&
			isset($_GET["verzendkosten"]) &&
			isset($_GET["verzendinstructies"])
		) {
			veilingPlaatsen($_GET["titel"],
				$_GET["beschrijving"],
				numberFormat($_GET["startprijs"]),
				$_GET["betalingswijze"],
				getPlaats($_GET["gebruikersnaam"]),
				getGba($_GET["gebruikersnaam"]),
				$_GET["looptijd"],
				numberFormat($_GET["verzendkosten"]),
				$_GET["verzendinstructies"],
				$_GET["gebruikersnaam"],
				$_GET["rubriek"]);
			//AfbeeldingPlaatsen();
			header("Location: /I-Project/www/fileupload.php?voorwerpNummer=" . getVoorwerpNummer($_SESSION["user"]));
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
								Invoervelden met een * zijn verplicht!<br><br>
								<!--
								<table style="width: 100%; table-layout: fixed;">
									<tr>

										<td>Rubriek kiezen</td>
										<td class="text-center">Product informatie invullen</td>
										<td class="text-right">Afbeeldingen uploaden</td>
									</tr>
									<tr>
										<td colspan="3"><input name="levering" style="width: 100%" id="r2" type="text" data-slider-tooltip="hide" data-slider-enabled="false" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="2" ></td>
									</tr>
								</table>
								<BR>
								-->

								Gebruikersnaam
								<input name="gebruikersnaam" type="text" class="form-control"
								       value="<?= $_SESSION["user"] ?>" disabled><br>
								<input name="gebruikersnaam" type="hidden" class="form-control"
								       value="<?= $_SESSION["user"] ?>">
								Titel*
								<input name="titel" type="text" pattern="[a-zA-Z0-9_\s]{4,100}" class="form-control"
								       required><br>
								Beschrijving*
								<textarea name="beschrijving" pattern="^[a-zA-Z0-9_\s]$" class="form-control" rows="4"
								          required></textarea><br>
								Rubriek
								<input name="rubriek" type="text" value="<?= getRubriekNaam($rubrieknaam1); ?>"
								       class="form-control" disabled=""><br>
								<input name="rubriek" type="hidden" value="<?= $rubrieknaam1; ?>"
								       class="form-control">
								2de Rubriek
								<input name="rubriek2" type="text" value="<?= getRubriekNaam($rubrieknaam2); ?>"
								       class="form-control" disabled=""><br>
								<input name="rubriek2" type="hidden" value="<?= $rubrieknaam2; ?>"
								       class="form-control">
								<!--
								Afbeelding1*
								<input name="afbeelding1" type="file" accept="image/x-png,image/gif,image/jpeg"
								       class="form-control-file" required><br>
								Afbeelding2
								<input name="afbeelding2" type="file" accept="image/x-png,image/gif,image/jpeg"
								       class="form-control-file"><br>
								Afbeelding3
								<input name="afbeelding3" type="file" accept="image/x-png,image/gif,image/jpeg"
								       class="form-control-file"><br>
								Afbeelding4
								<input name="afbeelding4" type="file" accept="image/x-png,image/gif,image/jpeg"
								       class="form-control-file"><br>
						       -->
								Startprijs* (bijv. 50.00)
								<input name="startprijs" pattern="[-+]?[0-9]*[.,]?[0-9]+" type="text" class="form-control" required><br>
								Betalingswijze*
								<table style="width: 100%; margin-top: 5px;" class="text-center" required>
									<tr>
										<td><label><input name="betalingswijze" type="radio" value="bank"
										                  checked="checked">Bank</input></label></td>
										<td> - of -</td>
										<td><label><input name="betalingswijze" type="radio" value="giro">Giro</input>
											</label></td>
									</tr>
								</table>
								<br>
								Looptijd in dagen*<br>
								<select name="looptijd" required>
									<?php
									$dbh = getConnection();
									$sql = "SELECT Dagen FROM VoorwerpLooptijd";
									$stmt = $dbh->prepare($sql);
									$stmt->execute();
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value=" . $row["Dagen"] . ">" . $row["Dagen"] . "</option>";
									}
									?>
								</select><br><br>
								Verzendkosten (niet meer dan &euro;99.99!)
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
		<script>

			$('#r1').slider ({
			});
			$('#r2').slider ({
			});
			$('#r3').slider ({
			});
		</script>


	<?php } else {
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">U bent geen verkoper!</div></div></div>';
	}
} else {
	echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">U bent niet ingelogd!</div></div></div>';
}
require ("scripts/footer.php"); ?>


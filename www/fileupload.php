<?php
require ("scripts/header.php");
require ("scripts/DB.php");

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

function isVerkoperVanVoorwerp($user,$voorwerp){
	$dbh = getConnection();
	$sql = "SELECT * FROM Voorwerp WHERE Verkoper=:gebruiker AND Voorwerpnummer=:voorwerp";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':gebruiker', $user, PDO::PARAM_INT);
	$stmt->bindParam(':voorwerp', $voorwerp, PDO::PARAM_INT);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return true;
	}
	return false;
}

function setFileSQL($path,$vn){
	$dbh = getConnection();
	$sql = "INSERT INTO Bestand(FileNaam,Voorwerp) 
						VALUES (:path,
 								:vn)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':path', $path);
	$stmt->bindParam(':vn', $vn);
	$stmt->execute();
}

function uploadImage($img_ff, $dst_path, $dst_img, $naam){
	$dst_ext = strtolower(end(explode(".", $dst_img)));
	$dst_img = $naam . '.' . $dst_ext;
	$dst_cpl = $dst_path . $dst_img;
	echo $dst_cpl;
	move_uploaded_file($_FILES[$img_ff]['tmp_name'], $dst_cpl);
	$dst_type = exif_imagetype($dst_cpl);
	if(( (($dst_ext =="jpg") && ($dst_type =="2")) || (($dst_ext =="jpeg") && ($dst_type =="2")) || (($dst_ext =="gif") && ($dst_type =="1")) || (($dst_ext =="png") && ($dst_type =="3") )) == false){
		unlink($dst_cpl);
		die('<p>The file "'. $dst_img . '" with the extension "' . $dst_ext . '" and the imagetype "' . $dst_type . '" is not a valid image. Please upload an image with the extension JPG, JPEG, PNG or GIF and has a valid image filetype.</p>');
		header("Location: /I-Project/www/fileupload.php?voorwerpNummer=" . getVoorwerpNummer($_SESSION["user"]));
	}
	setFileSQL($dst_cpl, $_GET["voorwerpNummer"]);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if ($_FILES["afbeelding1"]["error"] != 4) {
		$img_ff = 'afbeelding1'; // Form name of the image
		$dst_img = strtolower($_FILES[$img_ff]['name']); // This name will be given to the image. (in this case: lowercased original image name uploaded by user).
		$dst_path = '../www/afbeeldingen/'; // The path where the image will be moved to.
		uploadImage($img_ff, $dst_path, $dst_img, getVoorwerpNummer($_session["user"]) . "_1");
	}
	if ($_FILES["afbeelding2"]["error"] != 4) {
		$img_ff = 'afbeelding2';
		$dst_img = strtolower($_FILES[$img_ff]['name']); // This name will be given to the image. (in this case: lowercased original image name uploaded by user).
		$dst_path = '../www/afbeeldingen/'; // The path where the image will be moved to.
		uploadImage($img_ff, $dst_path, $dst_img, getVoorwerpNummer($_session["user"]) . "_2");
	}
	if ($_FILES["afbeelding3"]["error"] != 4) {
		$img_ff = 'afbeelding3';
		$dst_img = strtolower($_FILES[$img_ff]['name']); // This name will be given to the image. (in this case: lowercased original image name uploaded by user).
		$dst_path = '../www/afbeeldingen/'; // The path where the image will be moved to.
		uploadImage($img_ff, $dst_path, $dst_img, getVoorwerpNummer($_session["user"]) . "_3");
	}
	if ($_FILES["afbeelding4"]["error"] != 4) {
		$img_ff = 'afbeelding4';
		$dst_img = strtolower($_FILES[$img_ff]['name']); // This name will be given to the image. (in this case: lowercased original image name uploaded by user).
		$dst_path = '../www/afbeeldingen/'; // The path where the image will be moved to.
		uploadImage($img_ff, $dst_path, $dst_img, getVoorwerpNummer($_session["user"]) . "_4");
	}
	header("Location: /I-Project/www/productDetailPagina.php?voorwerpNummer=" . getVoorwerpNummer($_SESSION["user"]));
}

if (isset($_SESSION["user"])) {
	if (isVerkoper($_SESSION["user"]) && isVerkoperVanVoorwerp($_SESSION["user"], $_GET["voorwerpNummer"])) {

		?>

		<div class="container">

			<!--inloggen-->
			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-info">
						<div class="panel-heading text-center"><h4>Bestand uploaden voor </h4></div>
						<form method="post" enctype="multipart/form-data" name="afbeelding">
							<div class="panel-body">
								<table style="width: 100%; table-layout: fixed;">
									<tr>

										<td>Rubriek kiezen</td>
										<td class="text-center">Product informatie invullen</td>
										<td class="text-right">Afbeeldingen uploaden</td>
									</tr>
									<tr>
										<td colspan="3"><input name="levering" style="width: 100%" id="r2" type="text" data-slider-tooltip="hide" data-slider-enabled="false" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="3" ></td>
									</tr>
								</table>
								<BR>
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

		<?php
	}
}
require ("scripts/footer.php"); ?>


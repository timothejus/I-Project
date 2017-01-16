<?php
require ("scripts/header.php");

$_SESSION["rubriek1"] = "";
$_SESSION["rubriek2"] = "";

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


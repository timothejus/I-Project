<?php require ("scripts/header.php"); ?>

		<div class="container">

			<!--inloggen-->
			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-info">
						<div class="panel-heading text-center"><h4>Geef feedback</h4></div>
						<form>
							<div class="panel-body">
								<table style="width: 100%; table-layout: fixed;">
									<tr>
										<td style="width: 40%"></td>
										<td>Slecht</td>
										<td class="text-center">Wel oké</td>
										<td class="text-right">Uitstekend</td>
									</tr>
									<tr>
										<td>Communicatie</td>
										<td colspan="3"><input name="communicatie" style="width: 100%" id="r1" type="text" data-slider-tooltip="hide" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="2"></td>
									</tr>
								</table>
								<textarea class="form-control" name="communicatiecomments" rows="3"></textarea><br>
								<table style="width: 100%; table-layout: fixed;">
									<tr>
										<td style="width: 40%"></td>
										<td>Slecht</td>
										<td class="text-center">Wel oké</td>
										<td class="text-right">Uitstekend</td>
									</tr>
									<tr>
										<td>Levering</td>
										<td colspan="3"><input name="levering" style="width: 100%" id="r2" type="text" data-slider-tooltip="hide" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="2"></td>
									</tr>
								</table>
								<textarea class="form-control" name="leveringcomments" rows="3"></textarea><br>
								<table style="width: 100%; table-layout: fixed;">
									<tr>
										<td style="width: 40%"></td>
										<td>Slecht</td>
										<td class="text-center">Wel oké</td>
										<td class="text-right">Uitstekend</td>
									</tr>
									<tr>
										<td>Levertijd</td>
										<td colspan="3"><input name="levertijd" style="width: 100%" id="r3" type="text" data-slider-tooltip="hide" data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="2"></td>
									</tr>
								</table>
								<textarea class="form-control" name="levertijdcomments" rows="3"></textarea><br><br>
								Overige opmerkingen
								<textarea class="form-control" name="overigecomments" rows="3"></textarea>
							</div>
							<div class="panel-footer text-center">
								<table class="text-center" style="width: 100%">
									<tr>
										<td><a href="#" class="btn btn-default">Annuleer</a></td>
										<td><input type="submit" href="#" class="btn btn-primary" value="Verzend"></td>
									</tr>
								</table>
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

<?php require ("scripts/footer.php"); ?>


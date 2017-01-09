<?php require ("scripts/header.php"); ?>

		<div class="container">

			<!--inloggen-->
			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-info">
						<div class="panel-heading text-center"><h4>Verkopen</h4></div>
						<form>
							<div class="panel-body">
								Gebruikersnaam
								<input name="gebruikersnaam" type="text" class="form-control" value="&lt;&lt;gebruikersnaam&gt;&gt;" disabled><br>
								Titel
								<input name="titel" type="text" class="form-control"><br>
								Beschrijving
								<textarea name="beschrijving" class="form-control" rows="4"></textarea><br>
								Rubriek
								<input name="rubriek" type="text" class="form-control"><br>
								Afbeelding
								<input name="afbeelding" type="file" class="form-control-file"><br>
								Startprijs
								<input name="startprijs" type="text" class="form-control"><br>
								Betalingswijze
								<table style="width: 100%; margin-top: 5px;" class="text-center">
									<tr>
										<td><label><input name="betalingswijze" type="radio">Bank</input></label></td>
										<td> - of - </td>
										<td><label><input name="betalingswijze" type="radio">Giro</input></label></td>
									</tr>
								</table>
							</div>
							<div class="panel-footer text-center">
								<a href="#" class="btn btn-default">Terug</a>
							</div>
						</form>
					</div>
				</div>

			</div>

		</div>

<?php require ("scripts/footer.php"); ?>


<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 21-12-2016
 * Time: 11:42
 */
require("../scripts/header.php");
?>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading text-center"><h4>Wijzig hier uw inloggegevens.</h4></div>
						<form class="form-group" style="margin: 0px;">
							<div class="panel-body">
								Gebruikersnaam<br>
								<input class="form-control" type="text" disabled><br>
								Oud wachtwoord *<br>
								<input class="form-control" type="text"><br>
								Nieuw wachtwoord<br>
								<input class="form-control" type="text"><br>
								Bevestiging wachtwoord<br>
								<input class="form-control" type="text"><br>
								Geheime vraag<br>
								<select class="selectpicker" data-width="100%">
									<option selected>Optie 1</option>
									<option>Optie 2</option>
									<option>Optie 3</option>
									<option>Optie 4</option>
									<option>Optie 5</option>
								</select><br><br>
								Antwoord
								<input class="form-control" type="text">
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-sm-6 text-center">
										<a href="index.php" class="btn btn-default">Annuleer</a>
									</div>
									<div class="col-sm-6 text-center">
										<input class="btn btn-primary" type="submit" value="Verstuur">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

<?php
require("../scripts/footer.php");

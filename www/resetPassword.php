<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 6-1-2017
 * Time: 00:59
 */

require("scripts/header.php");
require ("scripts/DB.php");

$vragen = getQuestions();

?>

<!--inloggen-->
<div class="row">

	<div class="col-sm-6 col-sm-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading"><a href="#" class="panelheader-link">Reset wachtwoord</a></div>
			<form action="procesResetPassword.php">
				<div class="panel-body">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								Gebruikersnaam
								<input class="form-control" name="gebruikersnaam" required="required" type="text" value="">
								<br>
								Geheime vraag
								<select name="question" required="required" class="form-control">
									<?php
									function getQuestion()
									{
										$dbh = getConnection();
										$sql = "SELECT Vraagnummer, Tekstvraag FROM GeheimeVraag";
										$stmt = $dbh->prepare($sql);
										$stmt->execute();
										$ret = "";
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											$ret .= '<option value="' . $row['Vraagnummer'] . '">' . $row['Tekstvraag'] . '</option>';
										}
										return $ret;
									}
									echo getQuestion();


									?>
								</select>
								<br>
								Antwoord
								<input class="form-control" type="text" name="antwoord" value=""></div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-6">
							<button type="submit" class="btn btn-default">Controleer</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>





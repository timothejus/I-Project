<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 21-12-2016
 * Time: 11:42
 */
require("scripts/DB.php");
require("scripts/header.php");
if (isset($_SESSION["user"])) {

	if (isset($_GET["fname"])
	&& isset($_GET["lname"])
	&& isset($_GET["day"])
	&& isset($_GET["month"])
	&& isset($_GET["year"])
	&& isset($_GET["adres"])
	&& isset($_GET["postcode"])
	&& isset($_GET["plaatsnaam"])
	&& isset($_GET["land"])
	&& isset($_GET["telefoon"])){
		if (checkDatum($_get["day"],$_GET["month"],$_GET["year"])){

		}
	}
	function checkDatum($day,$month,$year){
		if (checkdate($month,$day,$year) && hogerDan18($year,$month,$day)){
			return true;
		} else {
			echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">De geboortedatum klopt niet!</div></div></div>';
			return false;
		}
	}


	function hogerDan18($year,$month,$day){
		$d1 = new DateTime($year.'-'.$month.'-'.$day);
		$dd = getdate();
		$d2 = new DateTime($dd["year"].'-'.$dd["mon"].'-'.$dd["mday"]);
		$diff = $d1->diff($d2);

		if ($diff->y-18 < 0) {
			echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Uw geboortedatum is lager dan 18. Onze site mag alleen bezocht worden door mensen die 18+ zijn.</div></div></div>';
			return false;
		} else {
			return true;
		}

	}

	$user = getAccountgegevens($_SESSION["user"]);
	$geboortedatum = explode("-",$user->getGeboortenaam());
	$geboortedatum2 = explode(" ",$geboortedatum["2"]);
	?>


	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading text-center"><h4>Wijzig hier uw contactgegevens.</h4></div>
						<form class="form-group" method="get" style="margin: 0px;">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										Voornaam<br>
										<input class="form-control" pattern="[a-zA-Z\s]{0,20}" maxlength="20" required="required" type="text" name="fname" value="<?php echo $user->getVoornaam() ?>" >
									</div>
									<div class="col-sm-6">
										Achternaam<br>
										<input class="form-control" pattern="[a-zA-Z\s]{0,25}" maxlength="25" required="required" type="text" name="lname" value="<?php echo $user->getAchternaam()?>">
									</div>
								</div><br>
								Geboortedatum<br>
								<div class="row">
									<div class="col-sm-3">
										<input class="form-control text-center" pattern="^[0-9]{1,2}$" type="text" name="day" maxlength="2" value="<?php echo $geboortedatum2["0"]?>" placeholder="dag">
									</div>
									<div class="col-sm-3">
										<input class="form-control text-center" pattern="^[0-9]{1,2}$" type="text" name="month" maxlength="2" value="<?php echo $geboortedatum["1"]?>" placeholder="maand">
									</div>
									<div class="col-sm-3">
										<input class="form-control text-center" pattern="^[0-9]{4,4}$" maxlength="4" name="year" type="text" value="<?php echo $geboortedatum["0"]?>" placeholder="jaar">
									</div>
								</div><br>
								Adres<br>
								<input class="form-control" name="adres" pattern="[a-zA-Z0-9\s]{0,50}" maxlength="50" required="required" value="<?php echo $user->getAdresregel1()?>" type="text"><br>
								Extra adresregel<br>
								<input class="form-control" name="extraadres" pattern="[a-zA-Z0-9\s]{0,50}" value="<?php echo $user->getAdresregel2()?>" type="text"><br>
								<div class="row">
									<div class="col-sm-5">
										Postcode<br>
										<input maxlength="6" class="form-control" name="postcode" value="<?php echo $user->getPostcode()?>" type="text">
									</div>
									<div class="col-sm-7">
										<br>
										Plaatsnaam<br>
										<input class="form-control" maxlength="30" required="required" pattern="[a-zA-Z\s]{1,30}" name="plaatsnaam" value="<?php echo $user->getPlaatsnaam()?>" type="text">
									</div>
								</div><br>
								Land<br>
								<select name="land" class="form-control" >
									<?php
									function getGba($land)
									{
										$dbh = getConnection();
										$sql = "SELECT GbaCode, LandNaam FROM Land";
										$stmt = $dbh->prepare($sql);
										$stmt->execute();
										$ret = "";
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											if ($row["LandNaam"] == $land){
												$ret .= '<option value="' . $row['GbaCode'] . '" Selected="selected">' . $row['LandNaam'] . '</option>';
											} else {
												$ret .= '<option value="' . $row['GbaCode'] . '">' . $row['LandNaam'] . '</option>';
											}
										}
										return $ret;
									}
									echo getGba($user->getLand());



									?>
								</select><br>
								Telefoonnummer
								<input class="form-control" maxlength="10" name="telefoon" pattern="[0-9]{10,10}" value="<?php echo $user->getPostcode()?>" type="text">
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-sm-6 text-center">
										<a href="mijnaccount.php?fail=1" class="btn btn-default">Annuleer</a>
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
}
else {
	echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">U bent niet ingelogd. Log in om uw account te wijzigen!</div></div></div>';
}
require("scripts/footer.php");

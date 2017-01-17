<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 9-1-2017
 * Time: 00:33
 */

require("scripts/header.php");
if (isset($_SESSION["user"])){
$gebruiker = getAccountgegevens($_SESSION["user"]);

$wachtwoord = hash('sha256', 'Brouwer' . 'admin');

function elfProef($input) {
	$return = '';
	if ((!preg_match("!^[0-9]{9}$!ie", $input)) || (strlen($input) <> 9)) { return false; }
	else {
		for ($i=1;$i<=10;$i++) {
			$nrParts = (substr((int)$input, ($i -1), 1) * (10 - $i));
			$return = ($return + ($nrParts));
		}

		return (($return % 11) == 0) ? true : false ;
	}
}

function passes_luhn_check($cc_number) {
	$checksum  = 0;
	$j = 1;
	for ($i = strlen($cc_number) - 1; $i >= 0; $i--) {
		$calc = substr($cc_number, $i, 1) * $j;
		if ($calc > 9) {
			$checksum = $checksum + 1;
			$calc = $calc - 10;
		}
		$checksum += $calc;
		$j = ($j == 1) ? 2 : 1;
	}
	if ($checksum % 10 != 0) {
		return false;
	}
	return true;
}

?>

<script type="text/javascript">
    function hide() {
        document.getElementById('test3').style.display = "none";
    }
    function show() {
        document.getElementById('test3').style.display = "block";
    }
</script>

<?php

$errRekeningnummer = '';
$errCreditcard = '';

$checkRekeningnummer = false;
$checkCreditcard = false;

if(isset($_GET['bank'])){
	$bank = $_GET['bank'];
}

if(isset($_GET['rekeningnummer'])){
	$rekeningnummer = $_GET['rekeningnummer'];
	if(elfProef($rekeningnummer)){
		$checkRekeningnummer = true;
	}
	else{

		$errRekeningnummer = "geen geldig rekeningnummer!";
	}
}

if(isset($_GET['radio'])){
	$radio = $_GET['radio'];
	if($radio == 'creditcard'){
		if(isset($_GET['credit'])&&!empty($_GET['credit'])){
			$creditcard = $_GET['credit'];
			if(passes_luhn_check($creditcard)){
				$checkCreditcard = true;

			}
			else{
				$errCreditcard = "Geen geldig nummer!";
				$checkCreditcard = false;
			}
		}
		else{
			$checkCreditcard = false;
			echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">U heeft geen creditcardgegevens ingevoerd!</div></div></div>';
		}

		if($checkRekeningnummer&&$checkCreditcard){
			registreerVerkoperViaCreditcard($gebruiker->getGebruikersnaam(),$bank,$rekeningnummer,$creditcard);
			updateVerkoper($gebruikersnaam);
			//locate to new page
			header('Location: /www/mijnaccount.php');
		}
	}
	else if($radio == 'post')
	{

			if($checkRekeningnummer){
				//sendmail
				insertBankRekeningNummer($rekeningnummer,$_SESSION['user'],$bank);

				$code = hash('sha256', $gebruiker->getAchternaam() . $gebruiker->getGebruikersnaam());

				$to=$gebruiker->getMailadres();
				$subject="Verify as verkoper for EenmaalAndermaal";
				$from = 'noreacteenmaalandermaal@gmail.com';
				$body=' Please Click On This link to verify as verkoper http://iproject4.icasites.nl/www/procesRegistreerVerkoper.php?g='.$gebruiker->getGebruikersnaam().'&h='.$code;
				$headers = "From:".$from;

				mail($to,$subject,$body,$headers);

				echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-success text-center">Er is een mail naar u gestuurd met verificatielink</div></div></div>';

			}else{
				echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">Rekeningnummer klopt niet</div></div></div>';
			}



	}
}
	?>

	<!--inloggen-->
	<div class="row">

		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="#" class="panelheader-link">Registreer als verkoper</a></div>
				<form action="registreerVerkoper.php">
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									Bank
									<select class="form-control" name="bank" required="required">
										<option value="ABN AMRO">ABN AMRO</option>
										<option value="ING">ING</option>
										<option value="RABOBANK">RABOBANK</option>
										<option value="SNS">SNS</option>
									</select>
									<br>
									Rekeningnummer
									<input class="form-control" name="rekeningnummer" required="required" type="text"
									       value="<?php if (isset($_GET['rekeningnummer'])) {
										       echo $_GET['rekeningnummer'];
									       } ?>"> <?php echo $errRekeningnummer ?>
									<br>
									Manier van controle<br>
									<label class="radio-inline"><input type="radio" onclick="show()" checked
									                                   name="radio"
									                                   value="creditcard">Creditcard</label>
									<label class="radio-inline"><input type="radio" onclick="hide()" name="radio"
									                                   value="post">Post</label>

									<div id="test3">
										<br>
										Creditcardnummer
										<input class="form-control" name="credit" type="text"
										       value=""> <?php echo $errCreditcard ?>
									</div>
									<br>

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


	<?php
} else {
	echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-warning text-center">U bent niet ingelogd. Log in om uw account als verkoper te registreren!</div></div></div>';
}

require "scripts/footer.php";
	?>
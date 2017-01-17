<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 6-1-2017
 * Time: 01:10
 */

require("scripts/header.php");

$gebruikersnaam = $_GET["gebruikersnaam"];
$geheimeVraag = $_GET["question"];
$antwoord = $_GET["antwoord"];

if(checkResetpassword($gebruikersnaam,$geheimeVraag,$antwoord) == 1){

	$gebruiker = getAccountgegevens($gebruikersnaam);

	sendNewPassword($gebruiker->getMailadres(),$gebruikersnaam,$gebruiker->getAchternaam());

	echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-success text-center">Er is een email naar u verstuurd met het nieuwe wachtwoord</div></div></div>';

}
else{
	echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">De ingevoerde gegevens zijn onjuist!</div></div></div>';
}

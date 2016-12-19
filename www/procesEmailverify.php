<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 16-12-2016
 * Time: 10:52
 */

require("scripts/header.php");
require ("scripts/DB.php");

$email = "";

if (isset($_GET["email"])){
	$email = $_GET["email"];
	$code=substr(md5(mt_rand()),0,15);

	//Check if mailadres already exists

	if(verify($email)&& verifyUser($email)){

		$to=$email;
		$subject="Activation Code For EenmaalAndermaal";
		$from = 'noreacteenmaalandermaal@gmail.com';
		$body='Your Activation Code is '.$code.' Please Click On This link https://www.iproject4.icasites.nl/test/www/registratie.php?code='.$code.' to activate your account.';
		$headers = "From:".$from;

		insertCode($code,$email);

		mail($to,$subject,$body,$headers);


		echo"Er is een email met verificatiecode gestuurd naar uw emailadres.";
	}
	else if(verify($email)&& !verifyUser($email)){
		echo"Er is al een gebruiker geregistreerd met dit mailadres";
	}
	else if(!verify($email)&& verifyUser($email)){
		echo "U heeft al een code aangevraagd";
	}

}
else{
	echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Gewoon niet!</div></div></div>';
}


?>



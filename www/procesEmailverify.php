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


		$to=$email;
		$subject="Activation Code For EenmaalAndermaal";
		$from = 'jip_brouwer@hotmail.com';
		$body='Your Activation Code is '.$code.' Please Click On This link <a href="register.php">?code='.$code.'</a>to activate your account.';
		$headers = "From:".$from;



		insertCode($code,$email);




		mail($to,$subject,$body,$headers);


		//verify();

		echo"Er is een email met verificatiecode gestuurd naar uw emailadres.";

}
else{
	echo "Er is een fout opgetreden!!";
}


?>



<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 10-1-2017
 * Time: 15:14
 */

require("scripts/header.php");
require ("scripts/DB.php");

if(isset($_GET["g"])&&isset($_GET["h"])&&!empty($_GET["g"])&&!empty($_GET["h"])){
	$gebruiker = getAccountgegevens($_GET['g']);

	$hash = $_GET['h'];
	$code = hash('sha256', $gebruiker->getAchternaam() . $gebruiker->getGebruikersnaam());

	if($code == $hash){
		updateVerkoper($gebruiker);
		echo'<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-success text-center">U bent nu een verkoper!</div></div></div>';
	}
	else{
		echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Geen toegang!</div></div></div>';
	}

}else{
	echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-danger text-center">Geen toegang!</div></div></div>';
}

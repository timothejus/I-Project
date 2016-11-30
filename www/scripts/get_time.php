<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 30-11-2016
 * Time: 12:09
 */

function get_time ($voorwerpNummer) {
	$dsn = "sqlsrv:Server=192.168.0.20;Database=EenmaalAndermaal";
	$user = "sa";
	$pass = "iproject4";
	$conn = new PDO ($dsn, $user, $pass);
	$sql = "SELECT DATEDIFF (second, getDate (), LooptijdEindeDagTijdstip) FROM Voorwerp WHERE Voorwerpnummer = " . $voorwerpNummer;
	$result = $conn -> query ($sql);
	foreach ($result as $row) {
		foreach ($row as $row2) {
			$tijd = $row2 [0];
		}
	}
	return $row2;
}

?>

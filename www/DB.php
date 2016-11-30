<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 29-11-2016
 * Time: 10:49
 */
require ("voorwerp.php");


	function getVoorwerpen()
	{
		$voorwerpen = array();

		try {
			$dbh = getConnection();
			$sql = "SELECT * FROM Voorwerp";

			$stmt = $dbh->prepare($sql);
			$stmt->execute();

			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$voorwerp = new Voorwerp($row["Voorwerpnummer"],$row["Titel"],$row["Beschrijving"],$row["Startprijs"],$row["Betalingswijze"],$row["Plaatsnaam"],$row["Land"],$row["Looptijd"],$row["LooptijdBeginDagTijdstip"],$row["VerzendKosten"],$row["VerzendInstructies"],$row["LooptijdEindeDagTijdstip"],$row["VeilingGesloten"],$row["VerkoopPrijs"]);
				$voorwerpen[] = $voorwerp;


			}
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
		return $voorwerpen;

	}

function ProductGroot(){
	$dsn = 'sqlsrv:server=192.168.0.20;Database=EenmaalAndermaal';
	$user = 'sa';
	$password = 'iproject4';
	$dbh = new PDO($dsn, $user, $password);

	$sql = "SELECT Voorwerp FROM ProductVanDeDag WHERE ProductVanDag=(:datum)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':datum', date("Y-m-d"), PDO::PARAM_INT);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$ProductVanDag = $row["Voorwerp"];
	}
}

	?>

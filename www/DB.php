<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 29-11-2016
 * Time: 10:49
 */
require ("voorwerp.php");
require ("mssql.inc.php");


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

	function getProduct($voorwerpNummer)
	{
		$voorwerp = "";
		try {
			$dbh = getConnection();

			$sql = " 
SELECT 
V.Voorwerpnummer,
V.Titel,
V.Startprijs,
V.Beschrijving,
BTW.Betalingswijze,
BTW.Betalingsinstructie,
V.Plaatsnaam,
V.Koper,
V.Looptijd,
V.LooptijdBeginDagTijdstip,
V.VerzendKosten,
V.VerzendInstructies,
V.Verkoper,
V.LooptijdEindeDagTijdstip,
V.VeilingGesloten,
V.VerkoopPrijs,
LDN.Land

FROM Voorwerp V

INNER JOIN Landen LDN ON V.Land = LDN.ISO
INNER JOIN Betalingswijzen BTW ON V.Betalingswijze = BTW.Betalingswijze

WHERE V.Voorwerpnummer =" . $voorwerpNummer . ";";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();


			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$voorwerp = new Voorwerp(
					$row["Voorwerpnummer"],
					$row["Titel"],
					$row["Beschrijving"],
					$row["Startprijs"],
					$row["Betalingswijze"],
					$row["Betalingsinstructie"],
					$row["Plaatsnaam"],
					$row["Land"],
					$row["Looptijd"],
					$row["LooptijdBeginDagTijdstip"],
					$row["VerzendKosten"],
					$row["VerzendInstructies"],
					$row["Verkoper"],
					$row["Koper"],
					$row["LooptijdEindeDagTijdstip"],
					$row["VeilingGesloten"],
					$row["VerkoopPrijs"]
				);
			}
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
		return $voorwerp;
	}

	?>

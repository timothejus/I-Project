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

	?>

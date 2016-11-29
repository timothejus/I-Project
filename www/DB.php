<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 29-11-2016
 * Time: 10:49
 */



	function getVoorwerpen()
	{
		$voorwerpen = array();

		//Controleer of er conversaties bestaat in DB
		$query = query("SELECT * FROM Voorwerp ");

		/*
		//Controleer of er conversaties bestaat in DB
		$query = query("SELECT * FROM Voorwerp WHERE eplanningID=:eplanningID", array(
			"eplanningID" => $eplanningID
		));*/


		if ($query->rowCount() > 0)
		{
			foreach ($query as $row)
			{
				$voorwerp = new Voorwerp($row["voorwerpnummer"],$row["titel"],$row["beschrijving"],$row["startprijs"],$row["betalingswijze"],$row["betalingsinstructie"],$row["plaatsnaam"],$row["land"],$row["looptijd"],$row["looptijdBegindagTijdstip"],$row["verzendkosten"],$row["verzendInstructies"],$row["verkoper"],$row["koper"],$row["looptijdEindeDag"],$row["veilingGesloten"],$row["verkoopPrijs"],$row["rubriek"]);
				$voorwerpen[] = $voorwerp;
			}
		}
		print_r($voorwerpen);
		return $voorwerpen;

	}

	?>

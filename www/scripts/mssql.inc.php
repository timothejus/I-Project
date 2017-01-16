<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 29-11-2016
 * Time: 09:04
 */

function getConnection()
{
	try {
		//LOKAAL

				$db_username = "sa";
				$db_password = "iproject4";
				$db_host = '(local)\sqlexpress';
				$db_name = "EenmaalAndermaal";

		/*
		//SERVER VAN SCHOOL
		$db_username = "iproject4";
		$db_password = "uK8VGTza";
		$db_host = "mssql.iproject.icasites.nl";
		$db_name = "iproject4";
		*/
		$conn = new PDO("sqlsrv:Server=$db_host;Database=$db_name;ConnectionPooling=0",$db_username,$db_password);
		//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException  $e) {
		echo "Error: " . $e;
	} catch (PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}

	return $conn;

}


function query($query, $parameters = null)
{
	$db = getConnection();
	$statement = $db->prepare($query);

	$i = 0;
	if ($parameters != null) {
		$i = 0;
		foreach ($parameters as $key => $value) {
			${"name" . $i} = $key;
			${"value" . $i} = $value;
			$statement->bindParam(":" . ${"name" . $i}, ${"value" . $i});
			$i++;
		}
	}
	$statement->execute();
	if (substr($query, 0, 6) == "INSERT") {
		return $db->lastInsertId();
	} else {
		return $statement;
	}

}

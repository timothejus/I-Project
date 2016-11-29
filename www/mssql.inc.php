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
		$db_username = "sa";
		$db_password = "iproject4";
		$db_host = "192.168.0.20";
		$db_name = "EenmaalAndermaal";

		$conn = new PDO("sqlsrv:Server=$db_host;Database=$db_name",$db_username,$db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "test";
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

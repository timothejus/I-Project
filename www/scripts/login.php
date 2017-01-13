<?php
/**
 * @param $login
 * @param $wachtwoord
 * @return bool
 */

//require ("mssql.inc.php");

function login($login, $wachtwoord){
	$login = strtolower($login);
	$dbh = getConnection();

	$sql = "SELECT Achternaam FROM Gebruiker WHERE Gebruikersnaam=(:login)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':login', $login, PDO::PARAM_INT);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
			$achternaam = $row['Achternaam'];
	}
	if (isset($achternaam)) {
		$sql = "SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam=(:login) AND Wachtwoord=(:wachtwoord)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':login', $login, PDO::PARAM_INT);
		$wachtwoord = hash('sha256', $achternaam . $wachtwoord);
		$stmt->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_INT);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			if (isset($row)) {
				$_SESSION["user"] = $row['Gebruikersnaam'];
				return true;
			} else {
				return false;
			}
		}
	}
}

?>
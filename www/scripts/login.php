<?php
function login($login, $wachtwoord){
	$dsn = 'sqlsrv:server=192.168.0.20;Database=EenmaalAndermaal';
	$user = 'sa';
	$password = 'iproject4';
	$dbh = new PDO($dsn, $user, $password);

	$sql = "SELECT Achternaam FROM Gebruiker WHERE Gebruikersnaam=(:login)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':login', $login, PDO::PARAM_INT);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
			$achternaam = $row['Achternaam'];
	}
	if (!isset($achternaam)){
		return false;
	}
	$sql = "SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam=(:login) AND Wachtwoord=(:wachtwoord)";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':login', $login, PDO::PARAM_INT);
	$wachtwoord = hash('sha256',$achternaam.$wachtwoord);
	$stmt->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_INT);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		if(isset($row)){
			return true;
		} else {
			return false;
		}
	}
}

?>
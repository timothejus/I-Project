<?php
$dsn = 'sqlsrv:server=192.168.0.20;Database=EenmaalAndermaal';
//$dsn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$user = 'sa';
$password = 'iproject4';

$dbh = new PDO($dsn, $user, $password);

$sql = "SELECT * FROM Voorwerp";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo $row["VerzendKosten"];
}



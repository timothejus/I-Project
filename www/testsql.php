<?php
$dsn = 'sqlsrv:server=192.168.0.20;Database=EenmaalAndermaal';
//$dsn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$user = 'sa';
$password = 'iproject4';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

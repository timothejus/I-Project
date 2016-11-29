<?php
require ("scripts/login.php");
if (isset($_GET["login"]) && isset($_GET["password"]) && $_GET["login"] != "" && $_GET["password"] != ""){
	if (login($_GET["login"],$_GET["password"]) == true) {
		header("refresh:0;url=index.php");

	} elseif (login($_GET["login"],$_GET["password"]) == true) {

	}
	else {
		echo "Uw gebruikersnaam of wachtwoord is verkeerd";
	}
}

?>

<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="../www/css/bootstrap.min.css" rel="stylesheet">
		<link href="../www/css/bootstrap-select.min.css" rel="stylesheet">

		<!-- Kleine CSS fixes -->
		<link href="../www/css/fixes.css" rel="stylesheet">

		<title>Inloggen</title>
	</head>
	<body>

		<!-- Scripts voor extra functionaliteit van Bootstrap -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="../www/js/bootstrap.min.js"></script>
		<script src="../www/js/bootstrap-select.min.js"></script>

		<!-- Navbar containers -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">

				<!-- Navbar logo -->
				<div class="navbar-header">
					<img class="navbar-brand" src="../www/images/logo.jpg" alt="EenmaalAndermaal">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#loginNav">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<!-- Inklappend menu voor kleine schermen -->
				<div class="collapse navbar-collapse" id="loginNav">

					<!-- Zoekbalk/filters -->
					<div class="navbar-left">
						<form class="navbar-form">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Zoek">
								<div class="selectmenu">
									<select class="form-control selectpicker">
										<option class="hide" value="" disabled selected>Categorieen</option>
										<option value="cat1">Categorie 1</option>
										<option value="cat2">Categorie 2</option>
										<option value="cat3">Categorie 3</option>
										<option value="cat4">Categorie 4</option>
										<option value="cat5">Categorie 5</option>
										<option value="cat6">Categorie 6</option>
										<option value="cat7">Categorie 7</option>
										<option value="cat8">Categorie 8</option>
									</select>
								</div>
								<button type="submit" class="btn btn-default">
									<span class="glyphicon glyphicon-search"></span></button>
							</div>
						</form>
					</div>

					<!-- Login/registreer/help knoppen -->
					<div class="navbar-right">
						<ul class="nav navbar-nav">
							<li><a href="#">Log in</a></li>
							<li><a href="#">Registreer</a></li>
							<li><a href="#">Help</a></li>
						</ul>
					</div>

				</div>

			</div>
		</nav>

		<div class="container">

			<!--inloggen-->
			<div class="row">

				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading"><a href="#" class="panelheader-link">Inloggen</a></div>
						<form action='login.php' method='get'>
							<div class='panel-body'>
								Gebruikersnaam
								<input type='text' class='form-control' name='login' value='<?php if(isset($_GET['login'])) {
									echo $_GET['login'];
								}?>'><br/>
								Wachtwoord
								<input type='password' class='form-control' name='password'>
							</div>
							<div class='panel-footer'>
								<div class='row'>
									<div class='col-sm-6'>
										<button type='submit' class='btn btn-default'>Login</button>
									</div>
									<div class='col-sm-6 text-right'>
										<a href='#'>Wachtwoord vergeten?</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading"><a href="#" class="panelheader-link">Registreer</a></div>
						<div class="panel-body">
							<h4>Met een account kun je:</h4>
							<ul>
								<li>Biedingen plaatsen.</li>
								<li>Biedingen beheren.</li>
								<li>Aanvragen verkoop account.</li>
							</ul>
						</div>
						<div class="panel-footer">
							<button type="button" class="btn btn-default">Registreren</button>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="container">
			<footer class="footer text-right">
				<span class="text-muted">&copy; 2016 Ubera</span>
			</footer>
		</div>

	</body>
</html>
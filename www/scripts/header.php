<?php
session_start();

if (isset($_GET["uitloggen"])){
	session_destroy();
	header("Location: /I-Project/www/index.php?uitgelogd");
}

?>

<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="css/theme.min.css" rel="stylesheet">
		<link href="css/bootstrap-select.min.css" rel="stylesheet">
		<link href="css/bootstrap-slider.min.css" rel="stylesheet">

		<!-- Kleine CSS fixes -->
		<link href="css/fixes.css" rel="stylesheet">

		<title>Home</title>

	</head>
	<body>

		<!-- Scripts voor extra functionaliteit van Bootstrap -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap-slider.min.js"></script>

		<!-- Navbar containers -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">

				<!-- Navbar logo -->
				<div class="navbar-header">
					<a href="index.php">
					<img class="navbar-left" style="height: 80px" src="images/logo.png" alt="EenmaalAndermaal">
					</a>
						<button type="button" class="navbar-toggle"  data-toggle="collapse" data-target="#loginNav">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<!-- Inklappend menu voor kleine schermen -->
				<div class="collapse navbar-collapse" id="loginNav">

					<!-- Zoekbalk/filters -->
					<div class="navbar-left">
						<form action="searchresults.php" method="get" class="navbar-form">
							<div class="form-group">
								<input type="text" name="zoektekst" class="form-control" placeholder="Zoek">
								<!--
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
								-->
								<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
							</div>
						</form>
					</div>

					<?php if(!isset($_SESSION["user"])){ ?>
					<!-- Login/registreer/help knoppen -->
					<div class="navbar-right">
						<ul class="nav navbar-nav">
							<li><a href="login.php">Log in</a></li>
							<li><a href="verifierRegistratie.php">Registreer</a></li>
							<li><a href="#">Help</a></li>
						</ul>
					</div>
				<?php }
					else {?>
					<div class="navbar-right">
						<ul class="nav navbar-nav">
							<li><a>Welkom, <?php echo $_SESSION["user"]; ?></a></li>
							<li><a href="mijnAccount.php">Mijn account</a></li>
							<li><a href="?uitloggen">Uitloggen</a></li>
							<li><a href="#">Help</a></li>
						</ul>
					</div>
					<?php }?>
				</div>

			</div>
		</nav>


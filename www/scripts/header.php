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

		<title>Home</title>
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
								<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
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


<?php
require ("scripts/header.php");
require ("scripts/login.php");
if (isset($_GET["login"]) && isset($_GET["password"]) && $_GET["login"] != "" && $_GET["password"] != ""){
	if (login($_GET["login"],$_GET["password"]) == true) {
		header("Location: index.php");
		$_SESSION["user"] = $_GET["login"];
	}
	else {
		echo "Uw gebruikersnaam of wachtwoord is verkeerd";
	}
}
?>

		<?php if (!isset($_SESSION["user"])) { ?>
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
		<?php }
		else { echo "u bent al ingelogd"; } ?>

		<div class="container">
			<footer class="footer text-right">
				<span class="text-muted">&copy; 2016 Ubera</span>
			</footer>
		</div>

	</body>
</html>
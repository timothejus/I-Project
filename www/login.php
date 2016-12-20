<?php
require("scripts/header.php");
?>
<div class="container">
	<?php
	require("scripts/login.php");
	if (isset($_GET["login"]) && isset($_GET["password"]) && $_GET["login"] != "" && $_GET["password"] != "") {
		if (login($_GET["login"], $_GET["password"]) == true) {
			header("Location: index.php");
			$_SESSION["user"] = $_GET["login"];
		} else {
			?>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="alert alert-danger text-center">
						Gebruikersnaam/wachtwoord verkeerd
					</div>
				</div>
			</div>
			<?php
		}
	}
	?>

	<?php if (!isset($_SESSION["user"])) {
		if (isset($_GET["geregistreerd"])) {
			echo '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1 alert alert-success text-center">U bent geregistreerd. Log hier onder in!</div></div></div>';
		}
?>

	<!--inloggen-->
	<div class="row">

		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="#" class="panelheader-link">Inloggen</a></div>
				<form action='login.php' method='get' class="form-group" style="margin-bottom: 0px;">
					<div class='panel-body'>
						Gebruikersnaam
						<input type='text' class='form-control' name='login' value='<?php if (isset($_GET['login'])) {
							echo $_GET['login'];
						} ?>'><br/>
						Wachtwoord
						<input type='password' class='form-control' name='password'>
					</div>
					<div class='panel-footer'>
						<div class='row'>
							<div class='col-sm-6'>
								<button type='submit' class='btn btn-primary'>Login</button>
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
				<form action="verifierRegistratie.php" >
					<input type="submit" class="btn btn-primary" value="Registreren">
				</form>
				</div>
			</div>
		</div>
	</div>

</div>
<?php
} else {
?>

<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-default text-center">
				<div class="panel-body">
					<h4>U bent al ingelogd!</h4>
				</div>
				<div class="panel-footer"><a href="index.php">Terug naar de homepagina</a>
				</div>
			</div>
		</div>
	</div>
</div>

	<?php } ?>

	<div class="container">
		<footer class="footer text-right">
			<span class="text-muted">&copy; 2016 Ubera</span>
		</footer>
	</div>

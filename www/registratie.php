<?php
require "scripts/mssql.inc.php";
if (!empty($_GET["username"]) &&
	!empty($_GET["password"]) &&
	!empty($_GET["password2"]) &&
	!empty($_GET["fname"]) &&
	!empty($_GET["lname"]) &&
	!empty($_GET["day"]) &&
	!empty($_GET["month"]) &&
	!empty($_GET["year"]) &&
	!empty($_GET["street"]) &&
	!empty($_GET["street2"]) &&
	!empty($_GET["postcode"]) &&
	!empty($_GET["place"]) &&
	!empty($_GET["land"]) &&
	!empty($_GET["telephone"]) &&
	!empty($_GET["question"]) &&
	!empty($_GET["answer"])
	&& $_GET["password"] === $_GET["password2"]){
	registreren(
		$_GET["username"],
		$_GET["password"],
		$_GET["fname"],
		$_GET["lname"],
		$_GET["day"],
		$_GET["month"],
		$_GET["year"],
		$_GET["street"],
		$_GET["street2"],
		$_GET["postcode"],
		$_GET["place"],
		$_GET["land"],
		$_GET["telephone"],
		$_GET["question"],
		$_GET["answer"]
		);
} else if (!empty($_GET["username"]) &&
	!empty($_GET["password"]) &&
	!empty($_GET["password2"]) &&
	!empty($_GET["fname"]) &&
	!empty($_GET["lname"]) &&
	!empty($_GET["day"]) &&
	!empty($_GET["month"]) &&
	!empty($_GET["year"]) &&
	!empty($_GET["street"]) &&
	!empty($_GET["postcode"]) &&
	!empty($_GET["place"]) &&
	!empty($_GET["telephone"]) &&
	!empty($_GET["question"]) &&
	!empty($_GET["answer"])){

} else if (!empty($_GET["username"])){

	require "scripts/PHPMailAutoload.php";
	require "scripts/phpmailer.php";
	require "scripts/smtp.php";

	$mail = new PHPMailer(); // create a new object
	$mail->isSMTP(); // enable SMTP
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; // or 587
	$mail->isHTML(true);
	$mail->Username = "noreacteenmaalandermaal@gmail.com";
	$mail->Password = "iproject4!";
	$mail->setFrom("noreacteenmaalandermaal@gmail.com");
	$mail->Subject = "Test";
	$mail->Body = "hello";
	$mail->addAddress("gigceez@gmail.com");

	if(!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message has been sent";
	}
// You may delete or alter these last lines reporting error messages, but beware, that if you delete the $mail->Send() part, the e-mail will not be sent, because that is the part of this code, that actually sends the e-mail.
}

function registreren(
	$username,
	$password,
	$fname,
	$lname,
	$day,
	$month,
	$year,
	$street,
	$street2,
	$postcode,
	$place,
	$land,
	$telephone,
	$question,
	$answer
){
	try
	{
		$db = getConnection();
		$date = $day."-".$month."-".$year;
		$hashedpassword = hash('sha256', $lname . $password);
		echo "fresh";
		$stmt = $db->prepare("INSERT INTO Gebruiker(Gebruikersnaam, 
											Voornaam, 
											Achternaam, 
											Adresregel1, 
											Adresregel2, 
											Postcode, 
											Plaatsnaam, 
											Land, 
											Geboortedag, 
											Mailadres, 
											Wachtwoord, 
											Vraag, 
											Antwoordtekst, 
											Verkoper)
											VALUES (:Gebruikersnaam,
													:Voornaam,
													:Achternaam,
													:Adresregel1,
													:Adresregel2,
													:Postcode,
													:Plaatsnaam,
													:Land,
													:Geboortedag,
													:Mailadres,
													:Wachtwoord,
													:Vraag,
													:Antwoordtekst,
													:Verkoper
													)
													
												  )");
		$stmt->bindParam("Gebruikersnaam", $username);
		$stmt->bindParam("Voornaam", $fname);
		$stmt->bindParam("Achternaam", $lname);
		$stmt->bindParam("Adresregel1", $street);
		$stmt->bindParam("Adresregel2", $street2);
		$stmt->bindParam("Postcode", $postcode);
		$stmt->bindParam("Plaatsnaam", $place);
		$stmt->bindParam("Land", $land);
		$stmt->bindParam("Geboortedag", $date);
		$stmt->bindParam("Mailadres", $mail);
		$stmt->bindParam("Wachtwoord", $hashedpassword);
		$stmt->bindParam("Vraag", $question);
		$stmt->bindParam("Andwoordtekst", $answer);
		$stmt->bindParam("Verkoper", intval(0));
		$stmt->execute();
		$db = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
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

				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">Registratieformulier</div>
						<form action="registratie.php" method="get">
							<div class="panel-body">
								<div class="col-sm-6">
										Gebruikersnaam
										<input type="text" class="form-control" name="username"><br/>
										Wachtwoord
										<input type="password" class="form-control" name="password"><br/>
										Wachtwoord herhalen
										<input type="password" class="form-control" name="password2"><br/>
										Emailadres
										<input type="text" class="form-control" name="emailadres" disabled><br/>
										Voornaam
										<input type="text" class="form-control" name="fname"><br/>
										Achternaam
										<input type="text" class="form-control" name="lname"><br/>
										Geboortedatum
										<div class="form-inline">
											<input type="text" pattern="^[0-9]{1,45}$" placeholder="Dag" class="form-control text-center" style="width: 72px;" name="day">
											<input type="text" placeholder="Maand" class="form-control text-center" style="width: 72px;" name="month">
											<input type="text" placeholder="Jaar" class="form-control text-center" style="width: 72px;" name="year">
										</div>
										<br/>
										Straatnaam en huisnummer *
										<input type="text" class="form-control" name="street"><br/>
										Extra adresregel
										<input type="text" class="form-control" name="street2"><br/>
										<div class="col-sm-6" style="padding: 0px; padding-right: 3px;">
											Postcode *
											<input type="text" class="form-control" name="postcode"><br/>
										</div>
										<div class="col-sm-6" style="padding: 0px; padding-left: 3px;">
											Plaatsnaam *
											<input type="text" class="form-control" name="place"><br/>
										</div>
										Land *
										<input type="text" class="form-control" name="land"><br/>
										Telefoonnummer *
										<input type="text" class="form-control" name="telephone"><br/>
										Geheime vraag
										<select name="question" class="form-control">
											<?php
											echo getQuestion();

											function getQuestion(){
												$dbh = getConnection();
												$sql = "SELECT Vraagnummer, TekstVraag FROM Vraag";
												$stmt = $dbh->prepare($sql);
												$stmt->execute();
												$ret = "";
												while($row = $stmt->fetch(PDO::FETCH_ASSOC))
												{
													$ret .=  '<option value="'.$row['Vraagnummer'].'">'.$row['TekstVraag'].'</option>';

												}
												return $ret;
											}
											?>
										</select>
										Antwoord *
										<input type="text" class="form-control" name="answer"><br/>
										Captcha *
								</div>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-sm-6">
										<input type="submit" class="btn btn-default" value="Registreer">
									</div>
									<div class="col-sm-6 text-right">
										<a href="#">Wachtwoord vergeten?</a>
									</div>
								</div>
							</div>
						</form>
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
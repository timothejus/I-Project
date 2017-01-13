<?php

// Includes
require ("rubriek.php");
require ("scripts/header.php");

// Checkt of de gebruiker is ingelogd.
if (!isset ($_SESSION ['user'])) {
	echo '<div class="container"><div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="alert alert-danger text-center">U bent niet ingelogd.</div></div></div></div>';
	require ("scripts/footer.php");
	exit;
}

// Checkt of de gebruiker een advertentie mag plaatsen.
if (!isVerkoper ($_SESSION ['user'])) {
	echo '<div class="container"><div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="alert alert-danger text-center">U bent niet ingeschreven als verkoper.</div></div></div></div>';
	require ("scripts/footer.php");
	exit;
}

// Session variabelen worden eerst leeggemaakt.
if (!isset ($_SESSION ['rubriek1'])) { $_SESSION ['rubriek1'] = ""; }
if (!isset ($_SESSION ['rubriek2'])) { $_SESSION ['rubriek2'] = ""; }

// Initialiseer de keuzes.
$_SESSION ['rubriek1'] = "";
$_SESSION ['rubriek2'] = "";

// Haal de hoofdrubrieken op.
$rubrieken = getHoofdrubrieken();

?>

<script type="text/javascript">
	function loadRubriek (nummer, kolom) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById (kolom).innerHTML = this.responseText;
			};
		};
		xhttp.open ("GET", "kiesrubriek.inc.php?rubriek="+nummer+"&kolom="+kolom, true);
		xhttp.send ();
	};
	function loadKnop () {
		$("knop").css ("display", "block");
	}
</script>

<div class="container">

	<div class="row">

		<div class="col-sm-6">

			<div id="1">
				<div class="panel panel-default">
					<div class="panel-heading">Kies een rubriek</div>
					<div class="panel-body">
						<ul class="breadcrumb">
							<li class="breadcrumb-item active">Hoofd</li>
						</ul>
						<ul class="list-group">
							<?php foreach ($rubrieken as $row) { ?>
								<li class="list-group-item"><a href="#" onClick="javascript:loadRubriek('<?=$row->getId()?>','1');"><?=$row->getNaam()?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>

		</div>

		<div class="col-sm-6">
			<div id="2">
				<div class="text-center">
					<a href="#" class="btn btn-primary btn-lg" onclick="javascript:loadRubriek('-1', '2');">Kies nog een rubriek</a>
				</div>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-12 text-center">
			<a id="knop" href="verkopen.php" class="btn btn-primary">Ga door</a>
		</div>
	</div>

</div>

<?php require ("scripts/footer.php"); ?>

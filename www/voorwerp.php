<?php

class Voorwerp {

	private $voorwerpnummer;
	private $titel;
	private $beschrijving;
	private $startprijs;
	private $betalingswijze;
	private $betalingsinstructie;
	private $plaatsnaam;
	private $land;
	private $looptijd;
	private $looptijdBegindagTijdstip;
	private $verzendkosten;
	private $verzendInstructies;
	private $verkoper;  // user class
	private $koper;    //user class
	private $looptijdEindeDag;
	private $veilingGesloten;
	private $verkoopPrijs;
	private $biedingen;
	private $afbeeldingen;
	private $hoogsteBod;


	//construcor
	function __construct(
		$voorwerpnummer,
		$titel,
		$beschrijving,
		$startprijs,
		$betalingswijze,
		$betalingsinstructie,
		$plaatsnaam,
		$land,
		$looptijd,
		$looptijdBegindagTijdstip,
		$verzendkosten,
		$verzendInstructies,
		$verkoper,
		$koper,
		$looptijdEindeDag,
		$veilingGesloten,
		$verkoopPrijs
	)
	{
		$this->voorwerpnummer = $voorwerpnummer;
		$this->titel = $titel;
		$this->beschrijving = $beschrijving;
		$this->startprijs = $startprijs;
		$this->betalingswijze = $betalingswijze;
		$this->betalingsinstructie = $betalingsinstructie;
		$this->plaatsnaam = $plaatsnaam;
		$this->land = $land;
		$this->looptijd = $looptijd;
		$this->looptijdBegindagTijdstip = $looptijdBegindagTijdstip;
		$this->verzendkosten = $verzendkosten;
		$this->verzendInstructies = $verzendInstructies;
		$this->verkoper = $verkoper;
		$this->koper = $koper;
		$this->looptijdEindeDag = $looptijdEindeDag;
		$this->veilingGesloten = $veilingGesloten;
		$this->verkoopPrijs = $verkoopPrijs;

		//$this->verkoper = $this->fillVerkoper($verkopernummer);
	}

	//Getters & Setters
	public function getVoorwerpnummer()
	{
		return $this->voorwerpnummer;
	}

	public function getTitel()
	{
		return $this->titel;
	}

	public function getBeschrijving()
	{
		return $this->beschrijving;
	}

	public function getStartprijs()
	{
		return $this->startprijs;
	}

	public function getBetalingswijze()
	{
		return $this->betalingswijze;
	}

	public function getBetalingsInstructie()
	{
		return $this->betalingsinstructie;
	}

	public function getPlaatsnaam()
	{
		return $this->plaatsnaam;
	}

	public function getLand()
	{
		return $this->land;
	}

	public function getLooptijd()
	{
		return $this->looptijd;
	}

	public function getLooptijdBegindagTijdstip()
	{
		return $this->looptijdBegindagTijdstip;
	}

	public function getVerzendkosten()
	{
		return $this->verzendkosten;
	}

	public function getVerzendInstructies()
	{
		return $this->verzendInstructies;
	}

	public function getVerkoper()
	{
		return $this->verkoper;
	}

	public function getKoper()
	{
		return $this->koper;
	}

	public function getLooptijdEindedag()
	{
		return $this->looptijdEindeDag;
	}

	public function getVeilingGesloten()
	{
		return $this->looptijdEindeDag;
	}

	public function getVerkoopprijs()
	{
		return $this->verkoopPrijs;
	}

	public function setKoper($kopernummer)
	{
		$this->koper = $this->fillKoper($kopernummer);
	}

	public function setBiedingen(array $biedingen)
	{
		$this->biedingen = $biedingen;
	}

	public function getBiedingen()
	{
		return $this->biedingen;
	}

	public function setAfbeeldingen($afbeeldingen)
	{
		$this->afbeeldingen = $afbeeldingen;
	}

	public function getAfbeeldingen()
	{
		return $this->afbeeldingen;
	}

	public function setHoogsteBod($hoogsteBod)
	{
		$this->hoogsteBod = $hoogsteBod;
	}

	public function getHoogsteBod()
	{
		return $this->hoogsteBod;
	}

	//Functions
	public function geefProductKlein()
	{
		if ($this->hoogsteBod == null) {
			$bedrag = $this->startprijs;
		} else {
			$bedrag = $this->hoogsteBod;
		}
		$ret = "
				<div class='col-sm-4'>
					<div class='panel panel-primary'>
						<div class='panel-heading'><a href='productDetailPagina.php?voorwerpNummer=" . $this->voorwerpnummer . "' class='panelheader-link'>" . $this->titel . "</a></div>
							<div class='panel-body text-center'>
								<img src='/pics/" . $this->afbeeldingen . "' class='img-thumbnail img-responsive img-thumbnail-overview' alt='img'><br/>
							</div>
						<div class='panel-footer'>
							<table class='table table-responsive'>
								<tr>
									<th class='text-center'>&euro;" . number_format($bedrag, 2, ",", ".") . "</th>
									<th class='text-danger text-center'><i id='" . $this->voorwerpnummer . "'></i><script type=\"text/javascript\">setTimer(" . $this->voorwerpnummer . ",'" . $this->looptijdEindeDag . "');</script></th>
									<th class='text-center'><a href='productDetailPagina.php?voorwerpNummer=" . $this->voorwerpnummer . "' class='btn btn-xs btn-danger'>Bied</a></th>
								</tr>
							</table>
						</div>
					</div>
				</div>
      ";
		return $ret;
	}

	public function geefProductgroot()
	{
		if ($this->hoogsteBod == null) {
			$bedrag = $this->startprijs;
		} else {
			$bedrag = $this->hoogsteBod;
		}
		$ret = '
		<div class="panel panel-default">
			<div class="panel-body" style="background: linear-gradient(to left, rgb(243,134,48), rgb(255,255,255));">
				<div class="col-sm-5">
					<h2>Product van de dag</h2><br/>
					<h4><a href="productDetailPagina.php?voorwerpNummer=' . $this->voorwerpnummer . '">' . $this->titel . '</a></h4>
					<p class="lead"><b>&euro;' . number_format($bedrag, 2, ",", ".") . '</b><br/>
					<span id="' . $this->voorwerpnummer . '" class="text-danger"></span><script type="text/javascript">setTimer("' . $this->voorwerpnummer . '", "' . $this->looptijdEindeDag . '");</script></p><br/><br/>
					<a class="btn btn-primary btn-lg" href="productDetailPagina.php?voorwerpNummer=' . $this->voorwerpnummer . '">Bied nu!</a>
				</div>
				<div class="col-sm-7 text-right">
					<img class="img-thumbnail" src="/pics/' . $this->afbeeldingen . '">
				</div>
			</div>
		</div>
		';
		return $ret;
	}

	public function __toString()
	{
		$returnValue = '
		<div>
			<table class="table table-responsive">
				<tr>
					<th>Veld</th>
					<th>Waarde</th>
				</tr>
				<tr>
					<td>Voorwerp Nummer</td>
					<td>' . $this->voorwerpnummer.'</td>
				</tr>
				<tr>
					<td>Titel</td>
					<td>'.$this->titel.'</td>
				</tr>
				<tr>
					<td>Beschrijving</td>
					<td>'. $this->beschrijving .'</td>
				</tr>
				<tr>
					<td>Startprijs</td>
					<td>'.$this->startprijs.'</td>
				</tr>
				<tr>
					<td>Betaalwijze</td>
					<td>'.$this->betalingswijze.'</td>
				</tr>
				<tr>
					<td>Betaalinstructie</td>
					<td>'.$this->betalingsinstructie.'</td>
				</tr>
				<tr>
					<td>Plaatsnaam</td>
					<td>'.$this->plaatsnaam.'</td>
				</tr>
				<tr>
					<td>Land</td>
					<td>'.$this->land.'</td>
				</tr>
				<tr>
					<td>Looptijd</td>
					<td>'.$this->looptijd.'</td>
				</tr>
				<tr>
					<td>Starttijd</td>
					<td>'.$this->looptijdBegindagTijdstip.'</td>
				</tr>
				<tr>
					<td>Verzendkosten</td>
					<td>'.$this->verzendkosten.'</td>
				</tr>
				<tr>
					<td>Verzendinstructie</td>
					<td>'.$this->verzendInstructies.'</td>
				</tr>
				<tr>
					<td>Verkoper</td>
					<td>'.$this->verkoper.'</td>
				</tr>
				<tr>
					<td>Koper</td>
					<td>'.$this->koper.'</td>
				</tr><tr>
					<td>Eindtijd</td>
					<td>'.$this->looptijdEindeDag.'</td>
				</tr>
				<tr>
					<td>Veiling Gesloten</td>
					<td>'.$this->veilingGesloten.'</td>
				</tr>
				<tr>
					<td>Verkoopprijs</td>
					<td>'.$this->verkoopPrijs.'</td>
				</tr>				
			</table>
		</div>
		';
		return $returnValue;
	}
}

<?php

/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 21-12-2016
 * Time: 15:05
 */
class vraag
{
	private $vraagNummer;
	private $tekstVraag;

	function __construct($vraagNummer,$tekstVraag){
		$this->vraagNummer = $vraagNummer;
		$this->tekstVraag = $tekstVraag;
	}

	/**
	 * @return mixed
	 */
	public function getVraagNummer()
	{
		return $this->vraagNummer;
	}

	/**
	 * @param mixed $vraagNummer
	 */
	public function setVraagNummer($vraagNummer)
	{
		$this->vraagNummer = $vraagNummer;
	}

	/**
	 * @return mixed
	 */
	public function getTekstVraag()
	{
		return $this->tekstVraag;
	}

	/**
	 * @param mixed $tekstVraag
	 */
	public function setTekstVraag($tekstVraag)
	{
		$this->tekstVraag = $tekstVraag;
	}




}
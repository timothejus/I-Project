<?php
/**
 * Created by IntelliJ IDEA.
 * User: DevServer
 * Date: 19-12-2016
 * Time: 10:48
 */

class Rubriek
{
	private $id;
	private $naam;
	private $volgnummer;
	private $parent;

	//constructor
	function __construct($id, $naam, $volgnummer, $parent)
	{
		$this->id = $id;
		$this->naam = $naam;
		$this->volgnummer = $volgnummer;
		$this->parent = $parent;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getNaam()
	{
		return $this->naam;
	}

	/**
	 * @param mixed $naam
	 */
	public function setNaam($naam)
	{
		$this->naam = $naam;
	}

	/**
	 * @return mixed
	 */
	public function getVolgnummer()
	{
		return $this->volgnummer;
	}

	/**
	 * @param mixed $volgnummer
	 */
	public function setVolgnummer($volgnummer)
	{
		$this->volgnummer = $volgnummer;
	}

	/**
	 * @return mixed
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @param mixed $parent
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;
	}



}

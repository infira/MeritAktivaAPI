<?php

namespace Infira\MeritAktiva;
/**
 * Class Article
 *
 * @see     https://api.merit.ee/reference-manual/sales-invoices/create-sales-invoice/#ItemObject
 * @package Infira\MeritAktiva
 */
class Article extends \Infira\MeritAktiva\General
{
	public function __construct($array = [])
	{
		$this->setMandatoryField('Code');
		$this->setMandatoryField('Description');
		$this->setMandatoryField('Type');
	}
	
	public function setCode(string $code)
	{
		$this->set("Code", $code);
	}
	
	/**
	 * @param string $descriptin
	 * @return void
	 */
	public function setDescription(string $descriptin)
	{
		$this->set("Description", $descriptin);
	}
	
	/**
	 * 1 = stock item, 2 = service, 3 = item. Required.
	 *
	 * @param int $int
	 */
	public function setType(int $int)
	{
		if ($int !== 1 AND $int !== 2 AND $int !== 3)
		{
			$this->intError("Unknown Item type");
		}
		$this->set("Type", $int);
	}
	
	/**
	 * Name for the unit
	 *
	 * @param $name
	 */
	public function setUOMName($name)
	{
		$this->set("UOMName", $name);
	}
	
	/**
	 * If company has more than one (default) stock, stock code in this field is required for all stock items.
	 *
	 * @param string $code
	 * @return void
	 */
	public function setDefLocationCode(string $code)
	{
		$this->set("DefLocationCode", $code);
	}
}

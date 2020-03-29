<?php

namespace Infira\MeritAktiva;
class VATObject extends \Infira\MeritAktiva\General
{
	/**
	 * @param string $GUID
	 */
	public function setTaxID(string $GUID)
	{
		$this->set("TaxId", $this->validateGUID($GUID));
	}
	
	public function getTaxID(): string
	{
		return $this->get("TaxId");
	}
	
	public function setAmount($amount)
	{
		$this->set("Amount", round($this->toFloat($amount), 2));
	}
	
}

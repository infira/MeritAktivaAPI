<?php

namespace Infira\MeritAktiva;
class Payment extends \Infira\MeritAktiva\InvoiceGeneral
{
	public function __construct()
	{
		$this->setMandatoryField('IBAN');
		$this->setMandatoryField('CustomerName');
		$this->setMandatoryField('InvoiceNo');
		$this->setMandatoryField('Amount');
	}
	
	public function setIBAN(string $IBAN)
	{
		$this->set('IBAN', $IBAN);
	}
	
	public function setCustomerName(string $CustomerName)
	{
		$this->set('CustomerName', $CustomerName);
	}
	
	public function setInvoiceNo(string $InvoiceNo)
	{
		$this->set('InvoiceNo', $InvoiceNo);
	}
	
	public function setRegNo(string $RegNo)
	{
		$this->set('RegNo', $RegNo);
	}
	
	public function setAmount(float $Amount)
	{
		$this->set('Amount', $this->toFloat());
	}
	
}

?>
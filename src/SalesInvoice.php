<?php

namespace Infira\MeritAktiva;

class SalesInvoice extends \Infira\MeritAktiva\InvoiceGeneral
{
	public function __construct()
	{
		$this->setMandatoryField('Customer');
		$this->setMandatoryField('InvoiceNo');
		$this->setMandatoryField('TaxAmount');
		$this->setMandatoryField('TotalAmount');
	}
	
	public function setCustomer(\Infira\MeritAktiva\Customer $Customer)
	{
		$this->set('Customer', $Customer->getData());
	}
	
	public function setInvoiceNo($no)
	{
		$this->set('InvoiceNo', $no);
	}
	
	protected function beforeGetData()
	{
		foreach ($this->taxAmounts as $taxID => $amount)
		{
			$Tax = new \Infira\MeritAktiva\VATObject();
			$Tax->setTaxID($taxID);
			$Tax->setAmount($amount);
			$this->setTaxAmount($Tax);
		}
	}
}

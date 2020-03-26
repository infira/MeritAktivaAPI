<?php

namespace Infira\MeritAktiva;
class PurchaseInvoice extends \Infira\MeritAktiva\InvoiceGeneral
{
	public function __construct()
	{
		$this->setMandatoryField('Vendor');
		$this->setMandatoryField('InvoiceNo');
		$this->setMandatoryField('TaxAmount');
		$this->setMandatoryField('TotalAmount');
	}
	
	public function setVeondor(\Infira\MeritAktiva\Vendor $Vendor)
	{
		$this->set('Vendor', $Vendor);
	}
	
	/**
	 * If false, it indicates a normal purchase invoice. If true, the purchase invoice is handled as presented by responsible employee for expense claim.
	 *
	 * @param bool $bool
	 */
	public function setExpenseClaim(bool $bool)
	{
		$this->set('ExpenseClaim', $bool);
	}
	
	public function setBillNo(string $no)
	{
		$this->set('BillNo', $no);
	}
	
	public function setBankAccount(string $no)
	{
		$this->set('BankAccount', $no);
	}
	
	public function setAttachment(\Infira\MeritAktiva\Attachment $Attachment)
	{
		$this->set('Attachment', $Attachment);
	}
}

?>
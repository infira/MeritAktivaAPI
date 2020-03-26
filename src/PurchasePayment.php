<?php

namespace Infira\MeritAktiva;
class PurchasePayment extends \Infira\MeritAktiva\General
{
	public function __construct()
	{
		$this->setMandatoryField('PaymentMethod');
		$this->setMandatoryField('PaidAmount');
		$this->setMandatoryField('PaymDate');
	}
	
	public function setPaymentMethod(string $method)
	{
		$this->set("PaymentMethod", $method);
	}
	
	public function setPaidAmount($amount)
	{
		$this->set("PaidAmount", $this->toFloat($amount));
	}
	
	/**
	 * @param string $date - string to use in strtotime
	 */
	public function setPaymDate(string $date)
	{
		$this->set("PaymDate", $this->convertDate($date));
	}
	
}

?>
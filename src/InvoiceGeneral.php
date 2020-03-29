<?php

namespace Infira\MeritAktiva;
abstract class InvoiceGeneral extends \Infira\MeritAktiva\General
{
	protected $taxRows    = [];
	protected $taxAmounts = [];
	
	/**
	 * @param string $date - string to use in strtotime
	 */
	public function setDocDate(string $date)
	{
		$this->set("DocDate", $this->convertDate($date));
	}
	
	/**
	 * @param string $date - string to use in strtotime
	 */
	public function setDueDate($date)
	{
		$this->set("DueDate", $this->convertDate($date));
	}
	
	/**
	 * @param string $date - string to use in strtotime
	 */
	public function setTransactionDate($date)
	{
		$this->set("TransactionDate", $this->convertDate($date));
	}
	
	/**
	 * @see https://www.pangaliit.ee/settlements-and-standards/reference-number-of-the-invoice/check-digit-calculator-of-domestic-account-number
	 * @param integer $regNO
	 */
	public function setRefNo(int $regNO)
	{
		$this->set("RefNo", $regNO);
	}
	
	public function setCurrencyCode($code)
	{
		$this->set("CurrencyCode", $code);
	}
	
	public function setDepartmentCode($code)
	{
		$this->set("DepartmentCode", $code);
	}
	
	public function setProjectCode($code)
	{
		$this->set("ProjectCode", $code);
	}
	
	public function addRow(\Infira\MeritAktiva\InvoiceRow $Row)
	{
		$rows   = $this->getRows();
		$rows[] = $Row;
		$this->setRows($rows);
		$taxID = $Row->getTaxID();
		if (!array_key_exists($taxID, $this->taxAmounts))
		{
			$this->taxAmounts[$taxID] = 0;
		}
		$this->taxAmounts[$taxID] += $Row->getPriceTaxAmount();
		
		$totalSum = $this->get("TotalAmount", 0) + $Row->getPriceNET();
		$this->setTotalAmount($totalSum);
	}
	
	private function setRows(array $Rows)
	{
		$this->set("InvoiceRow", $Rows);
	}
	
	public function getRows()
	{
		return $this->get("InvoiceRow", []);
	}
	
	public function getTaxAmounts(): array
	{
		return $this->get("TaxAmount", []);
	}
	
	public function setTaxAmount(\Infira\MeritAktiva\VATObject $VATObject)
	{
		$this->taxRows[$VATObject->getTaxID()] = $VATObject;
		$this->set("TaxAmount", array_values($this->taxRows));
	}
	
	/**
	 * Use it for getting PDF invoice to round number. Does not affect TotalAmount.
	 *
	 * @param float $amount
	 */
	public function setRoundingAmount($amount)
	{
		$this->set("RoundingAmount", $this->toFloat($amount));
	}
	
	public function setTotalAmount($amount)
	{
		$this->set("TotalAmount", $this->toFloat($amount));
	}
	
	/**
	 * Get total amount
	 *
	 * @param $amount
	 * @return mixed
	 */
	public function getTotalAmount()
	{
		return $this->get("TotalAmount", 0);
	}
	
	/**
	 * Get total amount
	 *
	 * @param $amount
	 * @return mixed
	 */
	public function getTotalAmountGross()
	{
		return round($this->addTAX($this->getTotalAmount()), 2);
	}
	
	public function setPayment(\Infira\MeritAktiva\PurchasePayment $Payment)
	{
		$this->set("Payment", $Payment);
	}
	
	/**
	 * If not specified, API will get it from client record, if it is written there.
	 * Comment after invoice rows
	 *
	 * @param string $comment
	 */
	public function setFcomment(string $comment)
	{
		$this->set("Fcomment", $comment);
	}
	
	/**
	 * If not specified, API will get it from client record, if it is written there.
	 * Comment before invoice rows
	 *
	 * @param string $comment
	 */
	public function setHcomment(string $comment)
	{
		$this->set("Hcomment", $comment);
	}
}

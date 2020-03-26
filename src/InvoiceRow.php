<?php

namespace Infira\MeritAktiva;
/**
 * Class InvoiceRow
 *
 * @see     https://api.merit.ee/reference-manual/sales-invoices/create-sales-invoice/#InvoiceRowObject
 * @package Infira\MeritAktiva
 */
class InvoiceRow extends \Infira\MeritAktiva\General
{
	/**
	 * InvoiceRow constructor.
	 *
	 * @param float $taxPercent - tax percent
	 */
	public function __construct(float $taxPercent = MERIT_VAT_PERCENT)
	{
		$this->taxPercent = $taxPercent;
		$this->setMandatoryField('Item');
	}
	
	public function setItem(\Infira\MeritAktiva\Article $Item)
	{
		$this->set("Item", $Item);
	}
	
	public function setQuantity($quantity)
	{
		$this->set("Quantity", $quantity);
	}
	
	/**
	 * Get current row price without vat
	 *
	 * @return float
	 */
	public function getPriceNET()
	{
		return $this->get("Price", 0);
	}
	
	/**
	 * Get current row price without vat
	 *
	 * @return float
	 */
	public function getPriceGross()
	{
		return round($this->addTAX($this->getPriceNET()), 2);
	}
	
	/**
	 * Get current row price without vat
	 *
	 * @return float
	 */
	public function getPriceTaxAmount()
	{
		return round($this->getTAX($this->getPriceNET(), FALSE), 2);
	}
	
	/**
	 * Set price for invoice row object, prices must NOT INCLUDE VAT or use the $includesVat = true to calculate correct price
	 *
	 * @param      $price
	 * @return void
	 */
	public function setPriceNet($price)
	{
		$this->set("Price", $this->toFloat($price));
	}
	
	
	/**
	 * Set price for invoice row object, prices must NOT INCLUDE VAT or use the $includesVat = true to calculate correct price
	 *
	 * @param      $priceGross
	 * @return void
	 */
	public function setPriceGross($priceGross)
	{
		$this->setPriceNet(round($this->removeTAX($this->toFloat($priceGross)), 2));
	}
	
	public function setDiscountPct($percent)
	{
		$this->set("DiscountPct", $percent);
	}
	
	/**
	 * Amount * Price * (DiscountPCt / 100). This is not rounded. Will be substracted from row amount before row roundings.
	 *
	 * @param $amount
	 */
	public function setDiscountAmount($amount)
	{
		$this->set("DiscountAmount", $this->toFloat($amount));
	}
	
	/**
	 * Required. Use gettaxes endpoint to detect the guid needed
	 *
	 * @param $GUID
	 * @return void
	 */
	public function setTaxID($GUID)
	{
		$this->set("TaxId", $this->validateGUID($GUID));
	}
	
	/**
	 * Get current row tax GUID
	 *
	 * @return string
	 */
	public function getTaxID(): string
	{
		return $this->get("TaxId");
	}
	
	
	/**
	 * Used for stock items and multiple stocks. If used then must be found in the company database.
	 *
	 * @param string $code
	 * @return void
	 */
	public function setLocationCode(string $code)
	{
		$this->set("LocationCode", $code);
	}
	
	/**
	 * If used then must be found in the company database.
	 *
	 * @param string $code
	 * @return void
	 */
	public function setDepartmentCode(string $code)
	{
		$this->set("DepartmentCode", $code);
	}
	
	/**
	 * Required for credit invoices when crediting stock items.
	 *
	 * @param string $code
	 * @return void
	 */
	public function setItemCostAmount(string $code)
	{
		$this->set("ItemCostAmount", $code);
	}
	
	/**
	 * If used, must be found in the company database.
	 *
	 * @param string $code
	 * @return void
	 */
	public function setGLAccountCode(string $code)
	{
		$this->set("GLAccountCode", $code);
	}
	
	/**
	 * If used, must be found in the company database.
	 *
	 * @param string $code
	 * @return void
	 */
	public function setProjectCode(string $code)
	{
		$this->set("ProjectCode", $code);
	}
	
	/**
	 * If used, must be found in the company database.
	 *
	 * @param string $code
	 * @return void
	 */
	public function setCostCenterCode(string $code)
	{
		$this->set("CostCenterCode", $code);
	}
}

?>
<?php
require_once 'inc.php';
$Api = new Infira\MeritAktiva\API($apiID, $apiKey, 'ee', 20, TRUE);
$Api->setDebug(TRUE);
$Customer = new \Infira\MeritAktiva\Customer();
/**
 * If you know customer GUID use code bel
 */
if (isset($ifYouHaveCustomerID))
{
	$Customer->setID($ifYouHaveCustomerID);
}
else //Then  new customer will be added
{
	$Customer->setName("Nälg ja võlg OÜ");
	$Customer->setISCompany(TRUE);
	$Customer->setVatRegNo('EE1234568');
	$Customer->setRegNo(1234568);
	$Customer->setCurrencyCode("EUR");
	$Customer->setAddress('Pappkasti 3');
	$Customer->setCountryCode("EE");
	$Customer->setPhoneNo('56123345');
	$Customer->setEmail('dont@tell.com');
	$Customer->setHomePage('www.donthave.com');
}

$Invoice = new \Infira\MeritAktiva\SalesInvoice();
$Invoice->setCustomer($Customer);
$Invoice->setDocDate('now');
$Invoice->setDueDate('now');
$Invoice->setTransactionDate('now');
$Invoice->setInvoiceNo('NO13');
//$Invoice->setRefNo('NO13');
$Invoice->setCurrencyCode("EUR");
//$Invoice->setDepartmentCode($departmentCode);
//$Invoice->setProjectCode('ProjectCode');

$Article = new \Infira\MeritAktiva\Article();
$Article->setCode("kaup");
$Article->setDescription("Yeii, new invoice");
$Article->setType(3);
$Article->setUOMName("tk");

$taxID      = $Api->getTaxDetails("20%")->Id;
$priceNet   = 80.33;
$priceGross = 58.89;


$InvoiceRow = new \Infira\MeritAktiva\InvoiceRow(MERIT_VAT_PERCENT);
$InvoiceRow->setItem($Article);
$InvoiceRow->setQuantity(1);
if (isset($_GET["testGross"]))
{
	$InvoiceRow->setPriceGross($priceGross);
}
else
{
	$InvoiceRow->setPriceNet($priceNet);
}
$InvoiceRow->setTaxID($taxID);
//$InvoiceRow->setDepartmentCode('$departmentCode');

$Invoice->addRow($InvoiceRow);
$Create = $Api->createSalesInvoice($Invoice);
if ($Create->isError())
{
	exit($Create->getError());
}
debug($Create->getRaw());
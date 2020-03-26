<?php
require_once 'inc.php';
$Api = new Infira\MeritAktiva\API($apiID, $apiKey, 'ee', 20);

debug("************TAXES************");
$List = $Api->getTaxes();
if ($List->isError())
{
	debug($List->getError());
}
debug($List->getRaw());
debug("************TAXES************");


debug("************CUSTOMERS************");
$List = $Api->getCustomers();
if ($List->isError())
{
	debug($List->getError());
}
debug($List->getRaw());
debug("************CUSTOMERS************");


debug("************VENDORS************");
$List = $Api->getVendors();
if ($List->isError())
{
	debug($List->getError());
}
debug($List->getRaw());
debug("************VENDORS************");
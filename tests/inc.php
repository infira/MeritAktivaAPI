<?php
require_once 'function.php';
spl_autoload_register(function ($className)
{
	$className = str_replace('Infira\MeritAktiva\\', '', $className);
	include_once "../src/" . $className . '.php';
});
$apiID  = 'place your api ID here';
$apiKey = 'place your apy key here';


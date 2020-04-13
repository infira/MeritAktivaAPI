<?php
function dump($variable)
{
	
	if (is_array($variable) or is_object($variable))
	{
		$html = print_r($variable, TRUE);
	}
	else
	{
		ob_start();
		var_dump($variable);
		$html = ob_get_clean();
	}
	
	return $html;
}

function debug()
{
	$html = '';
	$args = func_get_args();
	if (count($args) == 1)
	{
		$html .= dump($args[0]);
	}
	else
	{
		$html .= dump($args);
	}
	$html = '<pre>' . $html . '</pre>';
	echo($html);
}

spl_autoload_register(function ($className)
{
	$className = str_replace('Infira\MeritAktiva\\', '', $className);
	include_once "../src/" . $className . '.php';
});
$apiID  = 'place your api ID here';
$apiKey = 'place your apy key here';


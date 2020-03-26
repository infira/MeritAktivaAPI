<?php
function pre($var)
{
	return "<pre>$var</pre>";
}

/**
 * Debug function is to debug
 *
 * @param              $variable can
 *                               be all kind of type
 * @param unknown_type $trace
 */
$GLOBALS["debugIsActive"] = FALSE;
function debug()
{
	$GLOBALS["debugIsActive"] = TRUE;
	$args                     = func_get_args();
	$html                     = "";
	
	if (count($args) == 1)
	{
		$html .= dump($args[0]);
	}
	else
	{
		$html .= dump($args);
	}
	$html = pre($html);
	
	if (isset($_GET["isViewSource"]))
	{
		$html = str_replace(["<br />", "<br>"], "\n", $html);
	}
	if (isset($_GET["traceDebug"]))
	{
		cleanOutput();
		echo($html);
		echo getTrace();
		exit;
	}
	echo($html);
}


function cleanOutput($isRecursive = FALSE)
{
	if (ob_get_contents())
	{
		ob_clean();
		ob_end_clean();
		if ($isRecursive)
		{
			cleanOutput(TRUE);
		}
	}
}


function debugClean($v1, $v2 = UNDEFINDED)
{
	cleanOutput();
	debug(($v2 === UNDEFINDED) ? $v1 : func_get_args());
}


function dump($variable, $echo = FALSE)
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
	if ($echo == TRUE)
	{
		exit($html);
	}
	
	return $html;
}

?>
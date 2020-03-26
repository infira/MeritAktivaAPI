<?php

namespace Infira\MeritAktiva;
abstract class General
{
	protected $vars            = [];
	private   $mandatoryFields = [];
	protected $taxPercent      = 20;
	
	public function __get($name)
	{
		return $this->get($name);
	}
	
	protected function toFloat(string $nr): float
	{
		return floatval(self::toNumber("$nr"));
	}
	
	private static function toNumber($val)
	{
		$val = trim($val);
		if (strpos($val, ",") > 0 or strpos($val, ".") > 0)
		{
			return str_replace(",", ".", floatval(str_replace(",", ".", $val)));
		}
		else
		{
			return intval($val);
		}
	}
	
	protected function validateGUID($GUID)
	{
		if (preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $GUID))
		{
			return $GUID;
		}
		$this->intError("Unvalid GUID");
	}
	
	protected function convertDate($date)
	{
		return date("YmdHis", strtotime($date));
	}
	
	
	/**
	 * Get variable
	 *
	 * @param string $name
	 * @param mixed  $onNotFoundReurn - return this value on not found, defaults to false
	 * @return mixed
	 */
	public function get($name, $onNotFoundReurn = NULL)
	{
		$name = trim($name);
		if (!$name)
		{
			return $onNotFoundReurn;
		}
		if ($this->exists($name))
		{
			$r = $this->vars[$name];
			
			return $r;
		}
		
		return $onNotFoundReurn;
	}
	
	protected function setMandatoryField($name)
	{
		$this->mandatoryFields[$name] = TRUE;
	}
	
	
	/**
	 * Alias to offsetSet
	 *
	 * @param string $name
	 * @param mixed  $newVal
	 * @return void
	 */
	public function set(string $name, $newVal)
	{
		$this->vars[$name] = $newVal;
	}
	
	
	/**
	 * Does item exist
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function exists($name)
	{
		return array_key_exists($name, $this->vars);
	}
	
	/**
	 * Get all vars
	 *
	 * @return array
	 */
	public function getData(): array
	{
		if (method_exists($this, 'beforeGetData'))
		{
			$this->beforeGetData();
		}
		if (count($this->mandatoryFields))
		{
			foreach ($this->mandatoryFields as $f => $v)
			{
				if (array_key_exists($f, $this->mandatoryFields) AND !array_key_exists($f, $this->vars))
				{
					$this->intError("Mandatory field($f) is missing");
				}
			}
		}
		$parserVars = function ($vars) use (&$parserVars)
		{
			foreach ($vars as $f => $v)
			{
				if (is_array($v))
				{
					$vars[$f] = $parserVars($v);
				}
				elseif (is_object($v) AND method_exists($v, "getData"))
				{
					$vars[$f] = $v->getData();
				}
			}
			
			return $vars;
		};
		
		return $parserVars($this->vars);
	}
	
	/**
	 * Send internal errors
	 *
	 * @return object
	 */
	public function intError($errorMessage)
	{
		throw new \Error($errorMessage);
	}
	
	private function getVatNr()
	{
		return ($this->taxPercent / 100) + 1;
	}
	
	
	/*
	 * Calc price VAT ammount @param float $price @param bool $priceContainsVat - is the price contains already vat
	 */
	public function getTAX($price, $priceContainsVat)
	{
		$price = floatval($price);
		if ($priceContainsVat == TRUE)
		{
			$output = $price - ($price / $this->getVatNr());
		}
		else
		{
			$output = ($price * $this->getVatNr()) - $price;
		}
		
		return $output;
	}
	
	
	/**
	 * @param $priceNet
	 * @return float|int
	 */
	public function addTAX($priceNet)
	{
		return $priceNet + $this->getTAX($priceNet, FALSE);
	}
	
	/**
	 * Remove vat from price
	 */
	public function removeTAX($priceGross)
	{
		return $priceGross - $this->getTAX($priceGross, TRUE);
	}
}

?>
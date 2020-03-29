<?php

namespace Infira\MeritAktiva;
class APIResult
{
	private $res = "";
	
	public function __construct($res)
	{
		$this->res = $res;
	}
	
	public function isError()
	{
		return (is_object($this->res) || is_array($this->res)) ? FALSE : TRUE;
	}
	
	public function getRaw()
	{
		return $this->res;
	}
	
	public function getError()
	{
		return $this->res;
	}
}

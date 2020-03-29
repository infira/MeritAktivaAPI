<?php

namespace Infira\MeritAktiva;
class Attachment extends \Infira\MeritAktiva\General
{
	public function setFleName(string $name)
	{
		$this->set("FileName", $name);
	}
	
	public function setFile(string $filePath)
	{
		if (!file_exists($filePath))
		{
			$this->intError("File does not exist");
		}
		$this->set("FileContent", base64_encode(file_get_contents($filePath)));
	}
}

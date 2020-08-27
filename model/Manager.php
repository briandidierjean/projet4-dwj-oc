<?php

namespace Model;

class Manager
{
	protected function dbConnect()
	{
		$db = new \PDO('');
		return $db;
	}
}
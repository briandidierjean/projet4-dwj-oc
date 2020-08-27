<?php

namespace Model;

require_once('model/Manager.php');

class UserManager extends Manager
{
	public function logIn($pseudo)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, password, root FROM users WHERE pseudo = :pseudo');
		$req->execute(array('pseudo' => $pseudo));

		return $req;
	}

	public function getPseudo($pseudo)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id from users WHERE pseudo = :pseudo');
		$req->execute(array('pseudo' => $pseudo));

		return $req;
	}

	public function signUp($pseudo, $hashedPassword)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO users(pseudo, password) VALUES(:pseudo, :hashedPassword)');
		$req->execute(array(
			'pseudo' => $pseudo,
			'hashedPassword' => $hashedPassword));

		return $req;
	}
}
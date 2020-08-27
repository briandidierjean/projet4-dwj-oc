<?php

namespace Model;

require_once('model/Manager.php');

class PostManager extends Manager
{
	public function getPostNumber()
	{
		$db = $this->dbConnect();
		$req = $db->query('SELECT COUNT(*) AS postNumber FROM posts');

		return $req;
	}

	public function getPosts($start)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %H:%i:%s\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT :start,5');
		$req->bindValue('start', $start, \PDO::PARAM_INT);
		$req->execute();

		return $req;
	}

	public function getPost($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %H:%i:%s\') AS creation_date_fr FROM posts WHERE id = :id');
		$req->execute(array('id' => $id));
		$post = $req->fetch();

	return $post;
	}

	public function postPost($title, $content)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO posts(title, content, creation_date) VALUES(:title, :content, NOW())');
		$affectedLines = $req->execute(array(
			'title' => $title,
			'content' => $content));

		return $affectedLines;
	}

	public function updatePost($title, $content, $id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('UPDATE posts SET content = :content, title = :title WHERE id = :id');
		$affectedLines = $req->execute(array(
			'content' => $content,
			'title' => $title,
			'id' => $id));

		return $affectedLines;
	}

	public function deletePost($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM posts WHERE id = :id');
		$affectedLines = $req->execute(array('id' => $id));

		return $affectedLines;
	}
}
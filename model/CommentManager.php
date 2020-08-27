<?php

namespace Model;

require_once('model/Manager.php');

class CommentManager extends Manager
{
	public function getComments($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT reported, c.id, pseudo, c.user_id AS user_id, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr
			FROM comments AS c
			INNER JOIN users AS u
			ON u.id = c.user_id
			WHERE c.post_id = :id
			ORDER BY comment_date DESC');
		$req->execute(array('id' => $id));

		return $req;
	}

	public function postComment($comment, $userId, $postId)
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('INSERT INTO comments(post_id, comment, user_id, comment_date) VALUES(:postId, :comment, :userId, NOW())');
		$affectedLines = $comments->execute(array(
			'postId' => $postId,
			'comment' => $comment,
			'userId' => $userId));

		return $affectedLines;
	}

	public function deleteComments($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM comments where post_id = :id');
		$affectedLines = $req->execute(array('id' => $id));

		return $affectedLines;
	}

	public function deleteComment($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM comments where id = :id');
		$affectedLines = $req->execute(array('id' => $id));

		return $affectedLines;
	}

	public function reportComment($id)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('UPDATE comments SET reported = 1 WHERE id = :id');
		$affectedLines = $req->execute(array('id' => $id));

		return $affectedLines;
	}

	public function getReportedComments()
	{
		$db = $this->dbConnect();
		$req = $db->query('SELECT c.id as commentId, pseudo, c.user_id AS user_id, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr
			FROM comments AS c
			INNER JOIN users AS u
			ON u.id = c.user_id
			WHERE c.reported = 1
			ORDER BY comment_date DESC');

		return $req;
	}
}
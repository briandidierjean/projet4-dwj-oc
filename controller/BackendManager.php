<?php

namespace Controller;

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

use \Model\PostManager;
use \Model\CommentManager;
use \Model\UserManager;

class BackendManager
{
	public function displayPostPostView()
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			require('view/backend/postPostView.php');
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}

	public function postPost($title, $content)
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			$postManager = new PostManager();

			$affectedLines = $postManager->postPost($title, $content);

			if ($affectedLines == false)
			{
				throw new \Exception('Impossible d\'ajouter le billet !');	
			}
			else
			{
				header('Location: index.php?action=listPosts');
			}
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}

	public function displayUpdatePostView()
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			require('view/backend/updatePostView.php');
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}

	public function updatePost($title, $content, $id)
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			$postManager = new PostManager();

			$affectedLines = $postManager->updatePost($title, $content, $id);

			if ($affectedLines == false)
			{
				throw new \Exception('Impossible de modifier le billet !');
			}
			else
			{
				header('Location: index.php?action=post&id=' . $id);
			}
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}

	public function deletePost($id)
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			$postManager = new PostManager();
			$commentManager = new CommentManager();

			$affectedLinesComment = $commentManager->deleteComments($id);
			$affectedLinesPost = $postManager->deletePost($id);

			if ($affectedLinesPost == false || $affectedLinesComment == false)
			{
				throw new \Exception('Impossible de supprimer le billet !');	
			}
			else
			{
				header('Location: index.php?action=listPosts');
			}
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}

	public function deleteComment($commentId, $postId)
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			$commentManager = new CommentManager();

			$affectedLines = $commentManager->deleteComment($commentId);

			if ($affectedLines == false)
			{
				throw new \Exception('Impossible de supprimer le commentaire !');
			}
			else
			{
				header('Location: index.php?action=post&id=' . $postId);
			}
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}

	public function displayReportedCommentsView()
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			$commentManager = new CommentManager();

			$commentsReported = $commentManager->getReportedComments();

			require('view/backend/reportedCommentsView.php');
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}

	public function deleteReportedComment($id)
	{
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			$commentManager = new CommentManager();

			$affectedLines = $commentManager->deleteComment($id);

			if ($affectedLines == false)
			{
				throw new \Exception('Impossible de supprimer le commentaire !');
			}
			else
			{
				header('Location: index.php?action=displayReportedCommentsView');
			}
		}
		else
		{
			throw new \Exception('Action non autorisée');
		}
	}
}
<?php

namespace Controller;

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

use \Model\PostManager;
use \Model\CommentManager;
use \Model\UserManager;

class FrontendManager
{
	protected function getPostNumber()
	{
		$postManager = new PostManager();
		$req = $postManager->getPostNumber();
		$answer = $req->fetch();
		$postNumber = $answer['postNumber'];
		$req->closeCursor();

		return $postNumber;
	}

	public function getPageNumber()
	{
		$postNumber = $this->getPostNumber();

		$pageNumber = ceil($postNumber / 5);

		return $pageNumber;
	}
	public function listPosts($page, $pageNumber)
	{
		$page = (int) $page;

		$start = (int) ($page - 1) * 5;

		$postManager = new PostManager();
		$posts = $postManager->getPosts($start);

		require('view/frontend/listPostsView.php');
	}

	public function post()
	{
		$postManager = new PostManager();
		$commentManager = new CommentManager();

		$post = $postManager->getPost($_GET['id']);
		$comments = $commentManager->getComments($_GET['id']);

		if (!$post)
		{
			throw new \Exception('Billet non trouvé');
			
		}
	
		require('view/frontend/postView.php');
	}

	public function postComment($comment, $userId, $postId)
	{
		if (isset($_SESSION['id']))
		{
			$commentManager = new CommentManager();

			$affectedLines = $commentManager->postComment($comment, $userId, $postId);

			if ($affectedLines == false)
			{
				throw new \Exception('Impossible d\'ajouter le commentaire !');
			}
			else
			{
				header('Location: index.php?action=post&id=' . $postId);
			}
		}
	}

	public function displayLogInView()
	{
		if (isset($_COOKIE['pseudo']) && isset($_COOKIE['password']))
		{
			$this->logIn($_COOKIE['pseudo'], $_COOKIE['password']);
		}
		else
		{
			require('view/frontend/logInView.php');
		}
	}

	public function logIn($pseudo, $password)
	{
		$userManager = new UserManager();
		$req = $userManager->logIn($pseudo);
		$answer = $req->fetch();

		$isPasswordCorrect = password_verify($password, $answer['password']);

		if (!$answer || !$isPasswordCorrect)
		{
			throw new \Exception('Mauvais identifiant ou mot de passe');
		}
		else
		{
			$_SESSION['id'] = $answer['id'];
			$_SESSION['pseudo'] = $pseudo;
			$_SESSION['root'] = $answer['root'];
			header('Location: index.php');
		}
	}

	public function autoLogIn($pseudo, $password)
	{
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		setcookie('pseudo', $pseudo, time() + 365*24*3600, null, null, false, true);
		setcookie('password', $hashedPassword, time() + 365*24*3600, null, null, false, true);
	}

	public function displaySignUpView()
	{
		require('view/frontend/signUpView.php');
	}

	public function signUp($pseudo, $password, $password2)
	{
		$userManager = new UserManager();
		$answer = $userManager->getPseudo($pseudo);
		if ($answer->fetch())
		{
			throw new \Exception('Le pseudo est déjà pris');
		}
		else
		{
			if (preg_match("#[A-Za-z0-9]{1,30}#", $_POST['pseudo']))
			{
				if ($_POST['password'] == $_POST['password2'])
				{
					if (preg_match("#[a-z0-9]{8,}#i", $_POST['password']))
					{
						$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
						$userManager = new UserManager();
						$affectedLines = $userManager->signUp($_POST['pseudo'], $hashedPassword);

						if ($affectedLines == false)
						{
							throw new \Exception('Impossible de s\'inscrire !');
						}
						else
						{
							header('Location: index.php');
						}
					}
					else
					{
						throw new \Exception('Le mot de passe doit faire au moins 8 caractères.');
					}
				}
				else
				{
					throw new \Exception('Les mots de passe ne correspondent pas');
				}
			}
			else
			{
				throw new \Exception('Le pseudo ne doit pas dépasser 30 caractères.');
				
			}
		}
	}

	public function logOff()
	{
		$_SESSION = array();
		session_destroy();
		setcookie('pseudo', '');
		setcookie('password', '');
		header('Location: index.php');
	}

	public function reportComment($commentId, $postId)
	{
		if (isset($_SESSION['id']))
		{
			$commentManager = new CommentManager();

			$affectedLines = $commentManager->reportComment($commentId);

			if ($affectedLines === false)
			{
				throw new \Exception('Impossible de signaler le commentaire !');
			}
			else
			{	
				header('Location: index.php?action=post&id=' . $postId);
			}
		}
	}
}
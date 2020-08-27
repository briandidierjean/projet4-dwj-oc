<?php

require('controller/BackendManager.php');
require('controller/FrontendManager.php');

session_start();

use \Controller\BackendManager;
use \Controller\FrontendManager;

try
{
	if (isset($_GET['action']))
	{
		if ($_GET['action'] == 'listPosts')
		{
			$frontendManager = new FrontendManager();
			$pageNumber = $frontendManager->getPageNumber();

			if (!isset($_GET['page']) || $_GET['page'] < 0 || $_GET['page'] > $pageNumber)
			{
				$_GET['page'] = 1;
			}

			$frontendManager->listPosts($_GET['page'], $pageNumber);
		}
		elseif ($_GET['action'] == 'post')
		{
			if (isset($_GET['id']) && $_GET['id'] > 0)
			{
				$frontendManager = new FrontendManager();
				$frontendManager->post();
			}
			else
			{
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'postComment')
		{
			if (isset($_GET['id']) && $_GET['id'] > 0)
			{
				if (!empty($_POST['comment']))
				{
					$frontendManager = new FrontendManager();
					$frontendManager->postComment($_POST['comment'], $_SESSION['id'], $_GET['id']);
				}
				else
				{
					throw new Exception('Le champ n\'est pas rempli');
				}
			}
			else
			{
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'displayLogInView')
		{
			$frontendManager = new FrontendManager();
			$frontendManager->displayLogInView();
		}
		elseif ($_GET['action'] == 'logIn')
		{
			if (!empty($_POST['pseudo']) && !empty($_POST['password']))
			{
				if (isset($_POST['autologging']))
				{
					$frontendManager = new FrontendManager();
					$frontendManager->autoLogIn($_POST['pseudo'], $_POST['password']);
				}
				$frontendManager = new FrontendManager();
				$frontendManager->logIn($_POST['pseudo'], $_POST['password']);
			}
			else
			{
				throw new Exception('Tous les champs ne sont pas remplis');
			}
		}
		elseif ($_GET['action'] == 'displaySignUpView')
		{
			$frontendManager = new FrontendManager();
			$frontendManager->displaySignUpView();
		}
		elseif ($_GET['action'] == 'signUp')
		{
			if (!empty($_POST['pseudo']) && !empty($_POST['password']) && !empty($_POST['password2']))
			{
				$frontendManager = new FrontendManager();
				$frontendManager->signUp($_POST['pseudo'], $_POST['password'], $_POST['password2']);
			}
			else
			{
				throw new Exception('Tous les champs ne sont pas remplis');
			}
		}
		elseif ($_GET['action'] == 'logOff')
		{
			$frontendManager = new FrontendManager();
			$frontendManager->logOff();
		}
		elseif ($_GET['action'] == 'reportComment')
		{
			if (isset($_GET['commentId']) && $_GET['commentId'] > 0 && isset($_GET['postId']) && $_GET['postId'] > 0)
			{
				$frontendManager = new FrontendManager();
				$frontendManager->reportComment($_GET['commentId'], $_GET['postId']);
			}
			else
			{
				throw new Exception('Aucun identifiant de commentaire envoyé');
			}
		}
		elseif ($_GET['action'] == 'displayPostPostView')
		{
			$backendManager = new BackendManager();
			$backendManager->displayPostPostView();
		}
		elseif ($_GET['action'] == 'postPost')
		{
			if (!empty($_POST['title']) && !empty($_POST['content']))
			{
				$backendManager = new BackendManager();
				$backendManager->postPost($_POST['title'], $_POST['content']);
			}
		}
		elseif ($_GET['action'] == 'displayUpdatePostView')
		{
			$backendManager = new BackendManager();
			$backendManager->displayUpdatePostView();
		}
		elseif ($_GET['action'] == 'updatePost')
		{
			if (isset($_GET['id']) && $_GET['id'] > 0)
			{
				if (!empty($_POST['title']) && !empty($_POST['content']))
				{
					$backendManager = new BackendManager();
					$backendManager->updatePost($_POST['title'], $_POST['content'], $_GET['id']);
				}
				else
				{
					throw new Exception('Tous les champs ne sont pas remplis');
				}
			}
			else
			{
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'deletePost')
		{
			if (isset($_GET['id']) && $_GET['id'] > 0)
			{
				$backendManager = new BackendManager();
				$backendManager->deletePost($_GET['id']);
			}
			else
			{
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'deleteComment')
		{
			if (isset($_GET['commentId']) && $_GET['commentId'] > 0 && isset($_GET['postId']) && $_GET['postId'] > 0)
			{
				$backendManager = new BackendManager();
				$backendManager->deleteComment($_GET['commentId'], $_GET['postId']);
			}
			else
			{
				throw new Exception('Aucun identifiant de commentaire envoyé');
			}
		}
		elseif ($_GET['action'] == 'displayReportedCommentsView')
		{
			$backendManager = new BackendManager();
			$backendManager->displayReportedCommentsView();
		}
		elseif ($_GET['action'] ==  'deleteReportedComment')
		{
			if (isset($_GET['commentId']) && $_GET['commentId'] > 0)
			{
				$backendManager = new BackendManager();
				$backendManager->deleteReportedComment($_GET['commentId']);
			}
			else
			{
				throw new Exception('Aucun identifiant de commentaire envoyé');
			}
		}
		elseif ($_GET['action'] == 'reportComment')
		{
			if (isset($_GET['commentId']) && $_GET['commentId'] > 0)
			{
				$frontendManager = new FrontendManager();
				$frontendManager->reportComment($_GET['commentId']);
			}
			else
			{
				throw new Exception('Aucun identifiant de commentaire envoyé');
			}
		}
		elseif (empty($_GET['action']))
		{
			$frontendManager = new FrontendManager();
			$pageNumber = $frontendManager->getPageNumber();
			$frontendManager->listPosts(1, $pageNumber);
		}
	}
	else
	{
		$frontendManager = new FrontendManager();
		$pageNumber = $frontendManager->getPageNumber();
		$frontendManager->listPosts(1, $pageNumber);
	}
}
catch(Exception $e)
{
	$errorMessage = $e->getMessage();
	require('view/frontend/errorView.php');
}

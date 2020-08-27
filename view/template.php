<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<title><?= $title ?></title>
	<link rel="stylesheet" href="public/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="public/bootstrap/css/bootstrap-theme.min.css" />
	<link rel="stylesheet" type="text/css" href="public/css/styles.css" />
	<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
  	<script>tinymce.init({selector:'.tinymce'});</script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        		<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span> 
      		</button>

		<?php
		if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
		{
		?>
				<span class="navbar-brand">Bonjour <?= $_SESSION['pseudo']	?></span>
		<?php
		}
		else
		{
		?>
				<span class="navbar-brand">Bonjour</span>
		<?php
		}
		?>
	</div>
	<div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav">
			<li><a href="index.php">Accueil</a></li>
			<?php
			if (isset($_SESSION['id']))
			{
				if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
				{
				?>
					<li><a href="index.php?action=displayReportedCommentsView">Modération des commentaires</a></li>
					<?php
					}
					?>
					<li><a href="index.php?action=logOff">Déconnexion</a></li>
			<?php
			}
			else
			{
			?>
				<li><a href="index.php?action=displayLogInView">Connexion</a></li>
				<li><a href="index.php?action=displaySignUpView">Inscription</a></li>
			<?php
			}
			?>
		</ul>
	</div> 
	</nav>
	<div class="container">
		<?= $content ?>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script src="public/bootstrap/js/bootstrap.js"></script>
</body>
</html>
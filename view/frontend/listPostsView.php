<?php $title = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>
<div class="row">
	<div class="col-sm-12">
		<h1>Billet simple pour l'Alaska</h1>
		<h2>de Jean Forteroche</h2>

		<?php
		if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
		{
			echo '<p><a href="index.php?action=displayPostPostView">Ajouter un billet</a></p>';
		}
		?>

		<div class="pageLinks">
			<?php
			for ($i = 1; $i < $pageNumber; $i++)
			{
			?>
				<a href="index.php?action=listPosts&amp;page=<?= $i ?>">Page <?= $i ?> </a> -
			<?php
			}
			?>
			<a href="index.php?action=listPosts&amp;page=<?= $i ?>">Page <?= $i ?></a>
		</div>

		<?php
		while ($post = $posts->fetch())
		{
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<?= $post['title']; ?>
						le <?= $post['creation_date_fr']; ?>
					</h3>
				</div>
				<div class="panel-body">
					<?php
					$content = substr($post['content'], 0, 200);
					echo'<p>' . nl2br(strip_tags($content)) . '...</p>';
					?>
				</div>
				<div class="panel-footer">
					<em><a href="index.php?action=post&amp;id=<?= $post['id'] ?>">Voir le chapitre</a></em>
				</div>
			</div>
		<?php
		}
		$posts->closeCursor();
		?>

		<div class="pageLinks">
			<?php
			for ($i = 1; $i < $pageNumber; $i++)
			{
			?>
				<a href="index.php?action=listPosts&amp;page=<?= $i ?>">Page <?= $i ?> </a> -
			<?php
			}
			?>
			<a href="index.php?action=listPosts&amp;page=<?= $i ?>">Page <?= $i ?></a>
		</div>
	</div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>
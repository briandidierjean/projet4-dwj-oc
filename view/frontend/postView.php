<?php $title = htmlspecialchars($post['title']); ?>

<?php ob_start(); ?>
<div class="row">
	<div class="col-sm-12">
		<p><a href="index.php">Retour à la liste des billets</a></p>

		<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title">
						<?= $post['title']; ?>
						<em>le <?= $post['creation_date_fr']; ?></em>
					</h1>
				</div>

				<div class="panel-body">
					<?= nl2br($post['content']); ?>
				</div>
			
			<?php
			if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
			{
			?>
				<div class="panel-footer">
					<a href="index.php?action=deletePost&amp;id=<?= $_GET['id'] ?>">Supprimer</a> - <a href="index.php?action=displayUpdatePostView&amp;id=<?= $_GET['id'] ?>">Modifier</a>
				</div>
			<?php
			}
			?>	
		</div>

		<h3>Commentaires</h3>

		<?php
		if (isset($_SESSION['id']))
		{
		?>
		<form id="postCommentForm" action="index.php?action=postComment&amp;id=<?= $post['id'] ?>" method="post">
			<div>
				<label for="comment">Laisser un commentaire :</label><br />
				<textarea id="comment" name="comment"></textarea>
			</div>
			<div>
				<input type="submit" />
			</div>
		</form>
		<?php
		}

		while ($comment = $comments->fetch())
		{
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<em class="panel-title"><?= $comment['pseudo'] ?></em> le <?= $comment['comment_date_fr'] ?>
				</div>
				<div class="panel-body">
					<?= nl2br(htmlspecialchars($comment['comment'])) ?>
				</div>
				<?php
				if (isset($_SESSION['id']) && $_SESSION['root'] == 1)
				{
				?>
					<div class="panel-footer">
						<a href="index.php?action=deleteComment&amp;commentId=<?= $comment['id'] ?>&amp;postId=<?= $_GET['id'] ?>">Supprimer</a>
					</div>
				<?php
				}
				elseif (isset($_SESSION['id']))
				{
					if ($comment['reported'] == 1)
					{
					?>
						<div class="panel-footer">
							<span>Ce commentaire à déjà été signalé</span>
						</div>
					<?php
					}
					else
					{
					?>
					<div class="panel-footer">
						<button><a href="index.php?action=reportComment&amp;commentId=<?= $comment['id'] ?>&amp;postId=<?= $_GET['id'] ?>">Signaler</a></button>
					</div>
					<?php
					}
				}
				?>
			 </div>
		<?php
  		}
  		?>
		</div>
	 </div>
  <?php
  
  $comments->closeCursor();

  $content = ob_get_clean();

  require('view/template.php'); ?>
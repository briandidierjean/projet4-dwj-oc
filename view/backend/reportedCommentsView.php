<?php $title = 'Billet simple pour l\'Alaska'; ?>

<?php ob_start(); ?>
<h1>Billet simple pour l'Alaska</h1>

<?php
while ($comment = $commentsReported->fetch())
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
				<a href="index.php?action=deleteReportedComment&amp;commentId=<?= $comment['commentId'] ?>">Supprimer</a></p>
			</div>
		<?php
		}
		?>
	</div>
<?php
}
$commentsReported->closeCursor();
?>
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>
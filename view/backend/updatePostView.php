<?php $title = 'Modifier le billet'; ?>

<?php ob_start(); ?>
<h1>Modifier le billet</h1>

<form method="post" action="index.php?action=updatePost&amp;id=<?= $_GET['id'] ?>">
	<label>Titre : </label><input type="text" name="title" /><br />
	<label>Contenu : </label><br /><textarea class="tinymce" name="content"></textarea><br />
	<input type="submit" />
</form>
<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>
<?php $title = 'Erreur'; ?>

<?php ob_start(); ?>
<div class="row">
	<div class="col-sm-12">
		<h1>Erreur</h1>
		<p><?= $errorMessage ?></p>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>
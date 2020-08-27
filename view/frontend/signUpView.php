<?php $title = 'Inscription'; ?>

<?php ob_start(); ?>
<div class="row">
	<div class="col-sm-12">
		<h1>Inscription</h1>
		<form method="post" action="index.php?action=signUp">
			<label for="pseudo">Pseudo : </label>
			<input id="pseudo" type="text" name="pseudo" required /><br /><br />
			<label for="password">Mot de passe  : </label>
			<input id="password" type="password" name="password" required /><br /><br />
			<label for="password2">Mot de passe (confirmation) : </label>
			<input id="password2" type="password" name="password2" required /><br /><br />
			<input type="submit" value="S'inscrire" />
		</form>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>
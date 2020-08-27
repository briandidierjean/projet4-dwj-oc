<?php $title = 'Connexion'; ?>

<?php ob_start(); ?>
<div class="row">
	<div class="col-sm-12">
		<h1>Connexion</h1>
		<form method="post" action="index.php?action=logIn">
			<label for="pseudo">Pseudo : </label>
			<input id="pseudo" type="text" name="pseudo" required /><br /><br />
			<label for="password">Mot de passe  : </label>
			<input id="password" type="password" name="password" required /><br /><br />
			<label for="autologging">Rester connecté(e)</label>   <input type="checkbox" name="autologging" id="autologging" /><br /><br />
			<input type="submit" value="Se connecter" />
		</form>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/template.php'); ?>
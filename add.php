<?php

require_once __DIR__.'/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates'); // Dossier contenant les templates
$twig   = new Twig_Environment(
    $loader, array(
        'cache' => false,
    )
);

echo $twig->render('header.html.twig');

?>

	<h1>Bienvenue sur la page d'ajout d'article</h1>

<!--Formulaire d'ajout d'article-->
	<form>
		<div class="form-group">
			<label for="title">Titre</label>
			<input type="text" class="form-control" placeholder="Titre" name="title" id="title">
		</div>

		<div class="form-group">
			<label for="author">Auteur</label>
			<input type="text" class="form-control" placeholder="Auteur" name="author" id="author">
		</div>

		<div class="form-group">
			<label for="title">Titre</label>
			<input type="text" class="form-control" placeholder="Titre de l'article" name="title" id="title">
		</div>

		<div class="form-group">
			<label for="image">Image à la une</label>
			<input type="file" class="form-control-file" name="image" id="image">
		</div>

		<div class="form-group">
			<label for="tags">Tags</label>
			<select multiple class="form-control" id="tags" name="tags">
				<option>Mer</option>
				<option>Soleil</option>
				<option>Vacances</option>
				<option>tag 4</option>
				<option>tag 5</option>
			</select>
		</div>
		<div class="form-group">
			<label for="content">Contenu</label>
			<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
		</div>

		<button type="submit">Ajouter</button>
	</form>

<?php

echo $twig->render('footer.html.twig');

?>
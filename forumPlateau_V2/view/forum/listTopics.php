<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<!-- Lien pour revenir à la liste des catégories -->
<a href="index.php?ctrl=forum&action=index"> Return list category </a>

<h1>Liste des topics de la catégorie <?= $category->getName() ?></h1>


<!-- Si il y as des topics dans la catégorie, je les affiches --> 
<?php if (isset($topics)) {

foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
<?php }

// Sinon, je met un message personnalisé
} else { ?>

    <p> No topic here.. </p>

<?php } ?>

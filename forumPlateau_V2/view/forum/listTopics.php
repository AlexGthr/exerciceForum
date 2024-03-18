<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics de la catégorie <?= $category->getName() ?></h1>

<?php if (isset($topics)) {

foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
<?php }
} else { ?>

    <p> No topic here.. </p>

<?php } ?>

<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<!-- Lien pour crée un topic -->
<a href="index.php?ctrl=forum&action=newTopic"> Create topic </a>

<?php

// Affichage de la liste des categories
foreach($categories as $category ){?>

    <div class="img_category">
        <figure>
            <img src="<?= $category->getPicture() ?>" title="<?= $category->getName() ?>">
    </figure>
    
        <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
    </div>
<?php } ?>




  

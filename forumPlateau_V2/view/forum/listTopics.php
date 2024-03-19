<?php
    use App\Session;

    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<!-- Lien pour revenir à la liste des catégories -->
<a href="index.php?ctrl=forum&action=index"> Return list category </a>

<h1>Liste des topics de la catégorie <?= $category->getName() ?></h1>


<!-- Si il y as des topics dans la catégorie, je les affiches --> 
<?php if (isset($topics)) {

foreach($topics as $topic ){ ?>
    <div class="lockListTopic">

        <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId() ?>">
            <?= $topic ?>
        </a>

            <?php if (!$topic->getClosed()) {

                if (App\Session::isAdmin() || App\Session::isModerator()) { ?> 
            
                    <a href="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>">
                        <i class="fa-solid fa-unlock-keyhole green"></i>
                    </a>
        
                <?php } else { ?>

                    <i class="fa-solid fa-unlock-keyhole green"></i>
            
                <?php } ?>

            <?php } else { 

                if (App\Session::isAdmin() || App\Session::isModerator()) { ?> 
            
                    <a href="index.php?ctrl=forum&action=unlockTopic&id=<?= $topic->getId() ?>">
                        <i class="fa-solid fa-lock red"></i>
                    </a>
        
                <?php } else { ?>

                    <i class="fa-solid fa-lock red"></i>
            
                <?php } ?>

            <?php } ?>

    </div>


        <p> par <?= $topic->getUser() ?></p> <br>

<?php }

// Sinon, je met un message personnalisé
} else { ?>

    <p> No topic here.. </p>

<?php } ?>

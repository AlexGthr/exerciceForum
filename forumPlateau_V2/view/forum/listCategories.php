<?php
    $categories = $result["data"]['categories']; 
?>

<section class="list_Category">

<div class="title_popularTopic">
        <h1> BEST CATEGORIES </h1>
        <hr class="after_title" />
    </div>

    <section class="latest_topic">

<!-- Lien pour crée un topic -->
<div class="boxAddTopic">

<a href="index.php?ctrl=forum&action=newTopic"> 
    <p><span class="addActiveAvatar"> New Topic </span></p>
</a>

</div>

<?php

// Affichage de la liste des categories
foreach($categories as $categ ){?>

    <div class="boxCateg">

        <figure class="img_CategList">
            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $categ->getId() ?>">
                <img src="./public/img/imgcateg.svg" title="image top mobile">
            </a>
        </figure> 

        <div class="list_titleCateg">

            <div class="titleCategList">

                <p>
                    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $categ->getId() ?>">
                    <?= $categ->getName(); ?>
                    </a>
                </p>

            </div>
        </div>

        <div class="list_nbPost_">
        <p><i class="fa-solid fa-thumbtack"></i> <?= $categ->getNbTopics(); ?></p>
                    <p><i class="fa-regular fa-message"></i> <?= $categ->getNbPosts(); ?></p>
        </div>

    </div>

<?php } ?>

</section>
</section>




  

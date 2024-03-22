<?php
    use App\Session;

    $topics = $result["data"]['topics'];
    $nbTopics = iterator_to_array($result["data"]['nbTopics']);
    $nbTopic = count($nbTopics);

    $posts = $result["data"]['posts'];
    $nbPosts = iterator_to_array($result["data"]['nbPost']);
    $nbPost = count($nbPosts);

    $category = $result["data"]['category'];
    
?>
<section class="fire_stat">

<!-- Barre de recherche -->
    <div class="searchBar">

        <form action="#" method="post" enctype="multipart/form-data"> <!-- Formulaire pour envoyer un produit -->


            <input type="search" class="research" name="research" placeholder="Research">
            <button type="submit" name="submit" class="fa-mobile"><i class="fa-solid fa-magnifying-glass"></i></button>

        </form>

    </div>


    <div class="best_stat">

        <i class="fa-solid fa-fire"></i>
        <p>Number of Topics : <?= $nbTopic ?></p>

    </div>

    <div class="best_stat">

        <i class="fa-solid fa-fire"></i>
        <p>Number of messages : <?= $nbPost ?> </p>

    </div>

    <div class="best_stat">

        <i class="fa-solid fa-fire"></i>
        <p>Number of members : 643 </p>

    </div>

    <h1> LATEST TOPICS </h1>
    <hr class="after_title" />
</section>

<section class="wrapper_list">
<section class="latest_topic">

    <?php foreach($topics as $topic) { ?> 

    <div class="boxTopic">

        <figure class="img_avatarList">
            <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId() ?>">
                <img src="<?= $topic->getUser()->getAvatar()?>" title="image top mobile">
            </a>
        </figure> 

        <div class="list_titleTopic">
            <div class="titleTopicList">
                <p>
                    <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId() ?>">
                    <?= $topic->getTitle(); ?> </a></p>
            </div>

            <div class="list_infoTopic">

                <p> By <span class="yellow">

                        <a href="index.php?ctrl=home&action=viewProfil&id=<?= $topic->getUser()->getId() ?>"><?= $topic->getUser() ?> </a>

                </span> | <?= $topic->getCreationDate()->format("F jS, Y") ?></p>
                <p> In <span class="yellow">

                        <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topic->getCategory()->getId() ?>"> <?= $topic->getCategory() ?> </a>

                </span></p>
            </div>
        </div>

        <div class="list_nbPost">
            <i class="fa-regular fa-message"></i>
            <p> 17 </p>
        </div>
    </div>

    <?php } ?>

</section>

<div class="title_popularTopic">

    <h1> POPULAR TOPICS </h1>
    <hr class="after_titlePink" />
    
</div>

<section class="latest_topic">


    <?php foreach($posts as $post) { ?> 

    <div class="boxTopic">

        <figure class="img_avatarList">
            <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $post->getTopic()->getId() ?>">
            <img src="<?= $post->getUser()->getAvatar()?>" title="image top mobile">
        </a>
        </figure> 

        <div class="list_titleTopic">
            <div class="titleTopicList">
                <p><a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $post->getTopic()->getId() ?>"> <?= $post->getTopic()->getTitle(); ?></a></p>
            </div>

            <div class="list_infoTopic">

                <p> By <span class="yellow">

                        <a href="index.php?ctrl=home&action=viewProfil&id=<?= $post->getUser()->getId() ?>"><?= $post->getUser() ?> </a>

                </span> | <?= $post->getTopic()->getCreationDate()->format("F jS, Y") ?></p>
                <p> In <span class="yellow">

                        <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $post->getTopic()->getCategory()->getId() ?>"> <?= $post->getTopic()->getCategory() ?> </a>

                </span></p>
            </div>
        </div>

        <div class="list_nbPost">
            <i class="fa-regular fa-message"></i>
            <p> 17 </p>
        </div>
    </div>

    <?php } ?>

</section>

<div class="title_popularTopic">

    <h1> BEST CATEGORIES </h1>
    <hr class="after_title" />
    
</div>

<section class="latest_topic">


    <?php foreach($category as $categ) { ?> 

    <div class="boxCateg">

        <figure class="img_CategList">
            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $categ->getTopic()->getCategory()->getId() ?>">
            <img src="./public/img/imgcateg.svg" title="image top mobile">
        </a>
        </figure> 

        <div class="list_titleCateg">
            <div class="titleCategList">
                <p><a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $categ->getTopic()->getCategory()->getId() ?>"> <?= $categ->getTopic()->getCategory()->getName(); ?></a></p>
            </div>

        </div>

        <div class="list_nbPost_">
            <p><i class="fa-solid fa-thumbtack"></i> 17 </p>
            <p><i class="fa-regular fa-message"></i> 17 </p>
        </div>
    </div>

    <?php } ?>

    
</section>
<div class="viewAll">
    <p> <a href="index.php?ctrl=forum&action=listCategory"> View all </a> </p>
</div>

</section>
<section class="contact">

<div class="title_popularTopic">

    <h1> Contact </h1>
    <hr class="after_titlePink" />
    
</div>

<div class="info_contact">
    <p> <span class="rose_color"> NEWSLETTER </span> </p>

    <!-- Barre de recherche -->
    <div class="searchBar">

        <form action="#" method="post" enctype="multipart/form-data"> <!-- Formulaire pour envoyer un produit -->


            <input type="search" class="research" name="research" placeholder="Research">
            <button type="submit" name="submit" class="fa-mobile"><i class="fa-solid fa-magnifying-glass"></i></button>

        </form>

    </div>

    <p> Do You find a bug ? <br>
        Do you have a problem on the site? </p>
    <p> Contact us : </p>
    <p> <i class="fa-solid fa-envelope-circle-check"></i> <span class="rose_color"> forum@forum.com </span> </p>
</div>

</section>

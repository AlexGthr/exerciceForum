<?php
    use App\Session;

    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<section class="wrapper_listTopic">

<div class="button_listCateg_newTopic">
<!-- Lien pour crée un topic -->
    <div class="listTopic_returnCategory">

        <a href="index.php?ctrl=forum&action=listCategory">
            <p><span class="addActiveAvatar"> Category </span></p>
        </a>

    </div>

    <div class="listTopic_newTopic">

        <a href="index.php?ctrl=forum&action=newTopic"> 
            <p><span class="addActiveAvatar"> New Topic </span></p>
        </a>

    </div>

</div>

<div class="title_popularTopic">
        <h1> Topic of <?= $category->getName() ?> </h1>
        <hr class="after_titlePink" />
</div>

<section class="list_topic">


<!-- Si il y as des topics dans la catégorie, je les affiches --> 
<?php if (isset($topics)) {

foreach($topics as $topic ){ ?>

    <div class="boxListTopic">

        <figure class="img_avatarList">
            <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId() ?>">
                <img src="<?= $topic->getUser()->getAvatar()?>" title="image top mobile">
            </a>
        </figure>

        <div class="list_titleTopic">

            <div class="titleTopicList">

                <p>
                    <a class="nameTopic" href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId() ?>">
                        <?= $topic->getTitle(); ?>
                    </a>
                </p>

            </div>

            <div class="list_infoTopic">

                <p> By <span class="yellow">
                    <a href="index.php?ctrl=home&action=viewProfil&id=<?= $topic->getUser()->getId() ?>">
                        <?= $topic->getUser() ?>
                    </a>
                    </span> | <?= $topic->getCreationDate()->format("F jS, Y") ?>
                </p>

                <p> In <span class="yellow">
                    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topic->getCategory()->getId() ?>">
                        <?= $topic->getCategory() ?>
                    </a>
                    </span> | <?= $topic->getCreationDate()->format("G:i") ?>
                </p>

            </div>
        </div>

        <div class="list_nbPost">

            <i class="fa-regular fa-message"></i>
            <p> <?= $topic->getNbPosts(); ?> </p>
        </div>

        <div class="topicClosed">
                    <?php if (!$topic->getClosed()) {

                if (App\Session::isAdmin() || App\Session::isModerator()) { ?> 
            
                    <a href="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>">
                        <?php App\Session::addFlash("link", $category->getId()); ?>
                        <i class="fa-solid fa-unlock-keyhole green"></i>
                    </a>
        
                <?php } else { ?>

                    <i class="fa-solid fa-unlock-keyhole green"></i>
            
                <?php } ?>

            <?php } else { 

                if (App\Session::isAdmin() || App\Session::isModerator()) { ?> 
            
                    <a href="index.php?ctrl=forum&action=unlockTopic&id=<?= $topic->getId() ?>">
                    <?php App\Session::addFlash("link", $category->getId()); ?>
                        <i class="fa-solid fa-lock red"></i>
                    </a>
        
                <?php } else { ?>

                    <i class="fa-solid fa-lock red"></i>
            
                <?php }} ?>
        </div>

    </div>

            <?php } ?>

<?php }

// Sinon, je met un message personnalisé
 else { ?>

    <p> No topic here.. </p>

<?php } ?>

</section>
</section>


<?php 

$css = "listTopics.css";

?>
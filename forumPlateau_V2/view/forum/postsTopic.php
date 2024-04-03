<?php

use App\Session; ?>

<?php
    $topics = $result["data"]['topics']; 
    $posts = $result["data"]['posts']; 
    $users = $result["data"]["users"];
?>

<?php 
$session = new Session();
echo $session->getFlash("message");
?>

<section class="wrapper_detail">

<div class="button_returnTopic_newTopic">

<!-- Lien pour revenir à la liste des topics -->
    <div class="returnCategory">
        <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topics->getCategory()->getId(); ?>">
            <p><span class="addActiveAvatar"> Topics </span></p>
        </a>
    </div>

<!-- Lien pour crée un topic -->
    <div class="detail_newTopic">

        <a href="index.php?ctrl=forum&action=newTopic"> 
            <p><span class="addActiveAvatar"> New Topic </span></p>
        </a>

    </div>

</div>

<div class="title_popularTopic">

    <div class="lockTopic">

        <h1> <?= $topics ?> </h1>
        <?php if (!$topics->getClosed()) {

            if (App\Session::isAdmin() || App\Session::isModerator()) { ?> 

                <a href="index.php?ctrl=forum&action=lockTopic&id=<?= $topics->getId() ?>">
                    <?php unset($_SESSION["link"]); ?>
                        <i class="fa-solid fa-unlock-keyhole green"></i>
                    </a>

            <?php } else { ?>

                <i class="fa-solid fa-unlock-keyhole green"></i>

            <?php } ?>


            <?php } else { 

            if (App\Session::isAdmin() || App\Session::isModerator()) { ?> 

                <a href="index.php?ctrl=forum&action=unlockTopic&id=<?= $topics->getId() ?>">
                    <?php unset($_SESSION["link"]); ?>
                    <i class="fa-solid fa-lock red"></i>
                </a>

            <?php } else { ?>

                <i class="fa-solid fa-lock red"></i>

            <?php } }?>

    </div>

    <hr class="after_title" />
</div>

<?php if (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator())) { ?>

    <div class="deleteEditAdmin">
        <a id="delTopic" href="#" title="Delete Topic"> <img class="delete_img" src="./public/img/delete.svg" alt="delet"> </a>
        <a href="index.php?ctrl=forum&action=updateTopic&id=<?= $topics->getId() ?>" title="Update Topic"><img class="delete_img" src="./public/img/edit.svg" alt="edit"></a>
    </div>

<?php } ?>

<section class="detail_topic">

    <div class="information_topTopic">

        <div class="created_By">
            <a href="index.php?ctrl=home&action=viewProfil&id=<?= $topics->getUser()->getId() ?>">
                <p> Created by <br> <span class="yellow"> <?= $topics->getUser() ?> </span></p>
            </a>
        </div>

        <div class="created_By Last_message">
            <a href="index.php?ctrl=home&action=viewProfil&id=<?= $users->getUser()->getId() ?>">
                <p> Last post <br> <span class="yellow"> <?= $users->getUser() ?> </span></p>
            </a>
        </div>

        <div class="data_topic">
            <p> <?= $topics->getNbView() ?> <br> <span class="rose_colorNoUnderligne"> VIEW </span> </p>
            <p> <?= $topics->getNbPosts() ?> <br> <span class="rose_colorNoUnderligne"> REPLIES </span> </p>
        </div>
    </div>

</section>

<section id="content_post">

    <div class="content_post">
<?php  // Affichage des messages d'un topic
foreach($posts as $post) { ?>

    <div class="post_picture">
        <figure>
            <img src="<?= $post->getUser()->getAvatar() ?>" alt="avatar">
        </figure>

    <div class="post_NameHours">
        <a href="index.php?ctrl=home&action=viewProfil&id=<?= $post->getUser()->getId() ?>">
            <h2 class="yellow"> <?= $post->getUser() ?> </h2>
        </a>
        <p> <span class="timePost"> <?= $post->getDateCreation()->format("d/m/y - G:i") ?> </span></p>

    </div>
</div>

<h4> <?= $post ?> </h4>

<div class="function_post">
    <!-- // Permet la modification de son propre message ou de tout les messages en fonction du role -->
    <?php if (App\Session::getUser() && $post->getUser() == App\Session::getUser()->getNickName() && !$topics->getClosed()) { ?>
        <div class="deleteOrEdit">

        <a class="delPost" href="#"> <img class="delete_img" src="./public/img/delete.svg" alt="delet"> </a>
        <a href="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>"> <img class="delete_img" src="./public/img/edit.svg" alt="edit"> </a>

        </div>

    <?php } elseif (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator())) { ?>
        <div class="deleteOrEdit">

        <a class="delPost" href="#"> <img class="delete_img" src="./public/img/delete.svg" alt="delete"> </a>
        <a href="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>"> <img class="delete_img" src="./public/img/edit.svg" alt="edit"> </a>
        
        </div>

        <?php } ?>

        <img class="delete_img" src="./public/img/retweet.svg" alt="retweet">
    </div>

    <div class="seperator">
        <hr class="next_post" />
    </div>
    <?php } ?>

<!-- Si l'utilisateur est connecté, il pourra envoyé un message dans le topic -->
<?php if((App\Session::getUser() && !$topics->getClosed()) || (App\Session::isAdmin() || App\Session::isModerator())) { ?>
    <div class="show_boxPost">

        <h3> <?= App\Session::getUser()->getNickName(); ?> </h3>
        <p><span class="addActive"> Add post </span></p>

    </div>

    <div class="boxPost">
        <form action="index.php?ctrl=forum&action=addPost&id=<?= $topics->getId() ?>" method="POST">
        
        <label for="post">Post</label><br>
        <textarea id="post" name="post" placeholder="Votre texte ici..." rows="5"></textarea><br>

    
        
        <div class="button_addPost">
    <input class="button__addPost" type="submit" name="submit" value="Validate">
</div>

        </form>
    </div>
        
<!-- Sinon il aura le droit à un message pour se connecté -->
<?php } else { ?>

    <div class="show_boxPost">

    <?php if ($topics->getClosed()) { ?>
        <p><span class="addActive"> Locked </span></p>
    <?php } else { ?> 
        <p><span class="addActive"> Add post </span></p>
    <?php } ?>
    </div>

    <div class="boxPost">
        
        <?php if ($topics->getClosed()) { ?>
            
            <h2> This topic is closed. </h2>
            
            <?php } else { ?>
                
                <h2> You must be connected to send a post. </h2>
                <a href="index.php?ctrl=security&action=login">Login</a>

        <?php } ?>

    </div>


<?php } ?>
        </div>
</section>
</section>

<div class="boxPopUp_delTopic">
    <div class="popUp_delTopic">
        <p> Delete Topic, Are you sure ? </p>
            <div class="buttonPopup">
                <button id="yes"><a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topics->getId() ?>"> YES </a></button>
                <button id="no"> CANCEL </button>
            </div>
    </div>
</div>

<div class="boxPopUp_delPost">
    <div class="popUp_delPost">
        <p> Delete Post, Are you sure ? </p>
            <div class="buttonPopupPost">
                <button id="yesPost"><a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"> YES </a></button>
                <button id="noPost"> CANCEL </button>
            </div>
    </div>
</div>


<?php

$css = "postTopic.css";

?>
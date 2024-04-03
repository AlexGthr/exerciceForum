<?php

use App\Session; ?>

<?php
    $post = $result["data"]['post']; 
?>

<section class="wrapper_update">
<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>


<?php if (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator()) || App\Session::getUser() == $post->getUser()) { ?>
    
    <div class="title_popularTopic">
        <h1> Update post </h1>
        <hr class="after_title" />
    </div>
    
    <div class="returnTopicButton">
    
    <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $post->getTopic()->getId(); ?>"> 
        <p><span class="addActiveAvatar"> View Topic </span></p>
    </a>
    
    </div>

    <div class="middle_beforeUpdate">

        <div class="post_beforeUpdate">
            <p> <?= $post; ?></p>
            <p> By <span class="yellow"> <?= $post->getUser(); ?></span></p>
        </div>

    </div>


<div class="update_Post">

        <form action="index.php?ctrl=forum&action=addUpdatePost&id=<?= $post->getId() ?>" method="POST">
        

        <br><textarea id="post" name="post" placeholder="Votre texte ici..." rows="5" required><?= $post; ?></textarea><br>

    
        
        <div class="button_addPost">
            <input class="button__addPost" type="submit" name="submit" value="Validate">
        </div>

        </form>
        
</div>

<?php } else {

header("Location: index.php"); exit;

}?>

</section>


<?php

$css = "update.css";

?>
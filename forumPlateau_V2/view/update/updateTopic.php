<?php

use App\Session; ?>

<?php
    $topic = $result["data"]['topic']; 
?>

<section class="wrapper_detail">
<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>


<?php if (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator())) { ?>
    
    <div class="title_popularTopic">
        <h1> Update Topic </h1>
        <hr class="after_title" />
    </div>

    <div class="boxAddTopic">
    
    <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId(); ?>"> 
        <p><span class="addActiveAvatar"> View Topic </span></p>
    </a>
    
    </div>

    <div class="topic_beforeUpdate">
        <p> <?= $topic->getTitle(); ?></p>
        <p>By <span class="yellow"> <?= $topic->getUser(); ?> </span></p><br>
    </div>

<div class="update_Topic">

        <form action="index.php?ctrl=forum&action=addUpdateTopic&id=<?= $topic->getId() ?>" method="POST">
        

        <div class="input-group">
        <input type="text" name="title" id="title" value="<?= $topic->getTitle() ?>" required><br>
        <label> Title : </label>
        </div>
    
        
        <div class="button_addPost">
            <input class="button__addPost" type="submit" name="submit" value="Validate">
        </div>
        </form>
        
</div>

<?php } else {

header("Location: index.php"); exit;

}?>

</section>
<?php

use App\Session; ?>

<?php
    $topic = $result["data"]['topic']; 
?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>

<br><a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $topic->getId(); ?>">View Topic</a>

<?php if (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator())) { ?>

<h1> Detail before update </h1><br>

<p> <?= $topic->getTitle(); ?></p>
<p> <?= $topic->getUser(); ?></p><br>

<div class="update_Topic">

        <form action="index.php?ctrl=forum&action=addUpdateTopic&id=<?= $topic->getId() ?>" method="POST">
        
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?= $topic->getTitle() ?>" required><br>

    
        
            <input type="submit" name="submit" value="Edit topic !">

        </form>
        
</div>

<?php } else {

header("Location: index.php"); exit;

}?>
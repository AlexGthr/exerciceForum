<?php

use App\Session; ?>

<?php
    $post = $result["data"]['post']; 
?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>

<?php if (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator()) || App\Session::getUser() == $post->getUser()) { ?>

<h1> Detail before update </h1><br>

<p> <?= $post->getPost(); ?></p>
<p> <?= $post->getUser(); ?></p>

<div class="update_Post">

        <form action="index.php?ctrl=forum&action=addUpdatePost&id=<?= $post->getId() ?>" method="POST">
        
        <label for="post">Post</label><br>
        <textarea id="post" name="post" placeholder="Votre texte ici..." rows="5" required><?= $post->getPost(); ?></textarea><br>

    
        
            <input type="submit" name="submit" value="Edit post !">

        </form>
        
</div>

<?php } else {

header("Location: index.php"); exit;

}?>
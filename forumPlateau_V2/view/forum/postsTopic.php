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

    <!-- Lien pour revenir à la liste des topics -->
<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topics->getCategory()->getId(); ?>">Return list topic</a>

<h1> <?= $topics ?> </h1>

<?php if (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator())) { ?>

    <a href="index.php?ctrl=forum&action=updateTopic&id=<?= $topics->getId() ?>"> Edit </a>

<?php } ?>

<?php  // Affichage des messages d'un topic
foreach($posts as $post) { ?>

    <br><p> <?= $post->getPost() ?> </p>


    <p> By <?= $post->getUser() ?> </p>

            <!-- // Permet la modification de son propre message ou de tout les messages en fonction du role -->
    <?php if (App\Session::getUser() && $post->getUser() == App\Session::getUser()->getNickName()) { ?>

        <a href="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>"> Update </a>
        <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"> Delete </a>

    <?php } elseif (App\Session::getUser() && (App\Session::isAdmin() || App\Session::isModerator())) { ?>

        <a href="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>"> Update </a>
        <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"> Delete </a>

<?php } } ?>

<!-- Si l'utilisateur est connecté, il pourra envoyé un message dans le topic -->
<?php if(App\Session::getUser()) { ?>
    <div class="show_boxPost">

        <h3> <?= App\Session::getUser()->getNickName(); ?> </h3>
        <p><span class="addActive"> Add post </span></p>

    </div>

    <div class="boxPost">
        <form action="index.php?ctrl=forum&action=addPost&id=<?= $topics->getId() ?>" method="POST">
        
        <label for="post">Post</label><br>
        <textarea id="post" name="post" placeholder="Votre texte ici..." rows="5" required></textarea><br>

    
        
            <input type="submit" name="submit" value="Add post !">

        </form>
    </div>
        
<!-- Sinon il aura le droit à un message pour se connecté -->
<?php } else { ?>

    <div class="show_boxPost">

        <p><span class="addActive"> Add post </span></p>

    </div>

    <div class="boxPost">
        
        <h2> You need to be connected to post à new message </h2>
        <a href="index.php?ctrl=security&action=login">Login</a>

    </div>


<?php } ?>
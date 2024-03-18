<?php

use App\Session; ?>

<?php
    $topics = $result["data"]['topics']; 
    $posts = $result["data"]['posts']; 
    $users = $result["data"]["users"];
?>

    <!-- Lien pour revenir à la liste des topics -->
<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topics->getCategory()->getId(); ?>">Return list topic</a>

<h1> <?= $topics ?> </h1>

<ul>

<?php 
        // Affichage des messages d'un topic
foreach($posts as $post) {
    echo "<li>" . $post->getPost() . "<li><br>", 
            "<p> By <span>" . $post->getUser() . "</span></p>";
}
?>

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
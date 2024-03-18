<?php
    $topics = $result["data"]['topics']; 
    $posts = $result["data"]['posts']; 
    $users = $result["data"]["users"];
?>

<h1> <?= $topics ?> </h1>

<ul>

<?php 

foreach($posts as $post) {
    echo "<li>" . $post->getPost() . "<li><br>", 
            "<p> By <span>" . $post->getUser() . "</span></p>";
}
?>

    <div class="show_boxPost">

        <p><span class="addActive"> Add post </span></p>

    </div>

    <div class="boxPost">
        <form action="index.php?ctrl=forum&action=addPost&id=" method="POST">
        
        <label for="post">Post</label><br>
        <textarea id="post" name="post" placeholder="Votre texte ici..." rows="5" required></textarea><br>

    
        
            <input type="submit" name="submit" value="Add post !">

        </form>
    </div>
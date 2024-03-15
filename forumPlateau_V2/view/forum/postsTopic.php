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
            "<p> By <span>" . $post->getUser() . "</span></p>",
            "<img src='" .  $users->getAvatar() . "' width='100px' height='100px'><br><br>";
}
?>
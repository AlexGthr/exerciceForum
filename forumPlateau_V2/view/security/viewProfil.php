<?php
    use App\Session;

    $user = $result["data"]['user']; 
    $posts = $result["data"]['posts'];
?>

 <!-- Si l'utilisateur est connectés, alors affiche le profil, sinon direction la page de connexion. -->
<?php if(App\Session::getUser()) { ?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>

<div class="display_profil">

    <h1> <?= $user->getNickName() ?> profile </h1><br>

    <p> Avatar </p>
    <img src="<?= $user->getAvatar() ?>" title="Avatar user">

    <p> Last post : </p><br>

    <?php foreach($posts as $post) { ?>

        <p> <?= $post->getTopic()->getTitle() ?> </p>
        <p> <?= $post->getPost() ?> </p>
        <p> <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $post->getTopic()->getId() ?>">
                See topic
            </a> </p>

    <?php } ?>

</div>

<?php } else {
    header('Location: index.php');
} ?>

<?php 

$noFireStat = true;
$noContact = true;

?>
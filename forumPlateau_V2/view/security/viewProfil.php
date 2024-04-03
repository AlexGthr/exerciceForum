<?php
    use App\Session;

    $user = $result["data"]['user']; 
    $posts = $result["data"]['posts'];
?>
<section class="wrapper_profil">
 <!-- Si l'utilisateur est connectés, alors affiche le profil, sinon direction la page de connexion. -->
<?php if(App\Session::getUser()) { ?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>


<div class="title_popularTopic">
    <h1> <?= $user ?> </h1>
    <hr class="after_titlePink" />
</div>

<div class="display_profil">
<section class="latest_topicProfil">

    <p> Avatar </p><br>
    <img src="<?= $user->getAvatar() ?>" title="Avatar user">

    <br><p> Last post : </p><br>

    <?php foreach($posts as $post) { ?>

        <p> <?= $post->getTopic()->getTitle() ?> </p>
        <p> <span class="profilPost"> <?= $post ?> </span> </p>
        <p> <a href="index.php?ctrl=forum&action=findPostsByTopic&id=<?= $post->getTopic()->getId() ?>">
                See topic
            </a> </p>

    <?php } ?>
    </section>
</div>

<?php } else {
    header('Location: index.php');
} ?>

<?php 

$noFireStat = true;
$noContact = true;
$css = "profil.css";

?>
</section>
<?php
    use App\Session;

    $categories = $result["data"]['category']; 
?>

<section class="form_Topic">

    <div class="title_popularTopic">
        <h1> New Topic </h1>
        <hr class="after_title" />
    </div>

 <!-- Si l'utilisateur est connectés, alors affiche le formulaire, sinon direction la page de connexion. -->
<?php if(App\Session::getUser()) { ?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>

<div class="form_newTopic">

    <!-- Formulaire d'ajout d'un topic -->
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= App\Session::getUser()->getId() ?>" method="POST">
        
        <div class="input-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" required><br>
        </div>
        
        <div class="newTopic_post">
            <label for="post">Post</label>
            <textarea id="post" name="post" placeholder="Votre texte ici..." rows="5" required></textarea><br>
        </div>

        <div class="listCategory">
            <label>Category</label>
            <select name="category" required>
        </div>

            <?php foreach($categories as $category) { ?>

                <option value="<?= $category->getId() ?>">
                        <?= $category->getName() ?>
                </option>

            <?php } ?>
        
        </select><br>

    
        
        <div class="newTopic_submit">
            <input class="newTopic_buttonSubmit" type="submit" name="submit" value="Add Topic">
        </div>

    </form>

</div>

<?php } else { // Si l'utilisateur n'est pas connecté, direction la page login

App\Session::addFlash("message", "You must be logged.");
header("Location: index.php?ctrl=security&action=login"); exit;

} ?>


</section>


<?php 

$css = "formTopic.css";

?>

<?php
    use App\Session;

    $categories = $result["data"]['category']; 
?>

 <!-- Si l'utilisateur est connectés, alors affiche le formulaire, sinon direction la page de connexion. -->
<?php if(App\Session::getUser()) { ?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>
    
    <h1> New topic </h1>

<div class="form_newTopic">

    <!-- Formulaire d'ajout d'un topic -->
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= App\Session::getUser()->getId() ?>" method="POST">
        
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required><br>
        
        <label for="post">Post</label>
        <textarea name="post" placeholder="Votre texte ici..." rows="5" required></textarea><br>

        <label>Category</label>
        <select name="category" required>

            <?php foreach($categories as $category) { ?>

                <option value="<?= $category->getId() ?>">
                        <?= $category->getName() ?>
                </option>

            <?php } ?>
        
        </select><br>

    
        
        <input type="submit" name="submit" value="Add topic !">

    </form>

</div>

<?php } else { // Si l'utilisateur n'est pas connecté, direction la page login

App\Session::addFlash("message", "You must be logged.");
header("Location: index.php?ctrl=security&action=login"); exit;

} ?>
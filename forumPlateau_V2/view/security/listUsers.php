<?php
    use App\Session;

    $users = $result["data"]['users']; 
?>

 <!-- Si l'utilisateur est connectés, alors affiche le profil, sinon direction la page de connexion. -->
<?php if(App\Session::isAdmin() || Session::isModerator()) { ?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>

    <ul>

<?php 
    foreach($users as $user) { ?>

    <?php if ($user->getNickName() !== "Admin") { ?>

        <li> <?= $user->getNickName() ?> 

            <form id="editAdminUser" action="index.php?ctrl=security&action=editUserAdmin&id=<?= $user->getId() ?>" method="POST">
                
            <?php if (App\Session::isAdmin()) { ?>
                
                <label for="roleUser">Role :</label>

                    <select name="role" id="RoleUser">
                        <?php if ($user->getRole() == "user") { ?>
                            
                            <option value="user">USER</option>
                            <option value="moderator">MODERATOR</option>

                        <?php } else { ?>
                            
                            <option value="moderator">MODERATOR</option>
                            <option value="user">USER</option>
                        
                        <?php }}?>

                    </select>

                    <label for="BanUser">Banned ?</label>

                        <select name="banned" id="BanUser">

                            <?php if ($user->getBan() == 0) { ?>
        
                                <option value=0>Free</option>
                                <option value=1>BANNED</option>

                            <?php } else { ?>
        
                                <option value=1>BANNED</option>
                                <option value=0>Free</option>
    
                            <?php }?>

                        </select>                    

                    <input type="submit" name="submit" value="Edit">
            </form>
    
    
        </li>
    
    <?php }} ?>

    </ul>

<?php } else { 
    echo "vous n'avez rien à faire la brigand";
} ?>

<?php 

$noFireStat = true;
$noContact = true;

?>
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

<div class="tableau_listUser">

<table class="cinereousTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Banned</th>
            <th>Send</th>
        </tr>
    </thead>
    <tbody>

<?php 
    foreach($users as $user) { ?>

    <tr>

    <?php if ($user->getNickName() !== "Admin") { ?>

            <td> <?= $user->getNickName() ?> </td>
            
            <form id="editAdminUser" action="index.php?ctrl=security&action=editUserAdmin&id=<?= $user->getId() ?>" method="POST">
            
            <td><?php if (App\Session::isAdmin()) { ?>

                    <select name="role" id="RoleUser">
                        <?php if ($user->getRole() == "user") { ?>
        
                            <option value="user">USER</option>
                            <option value="moderator">MODERATOR</option>

                        <?php } else { ?>
        
                            <option value="moderator">MODERATOR</option>
                            <option value="user">USER</option>
    
                        <?php }}?>

                    </select>
            </td>

            <td>  
                <select name="banned" id="BanUser">
    
                    <?php if ($user->getBan() == 0) { ?>

                        <option value=0>Free</option>
                        <option value=1>BANNED</option>

                    <?php } else { ?>

                        <option value=1>BANNED</option>
                        <option value=0>Free</option>

                    <?php }?>

                </select>
            </td> 

            <td> <input type="submit" name="submit" value="Edit"> 
                </form>
            </td> </tr>
    
    <?php }} ?>

    </tbody>
</table>

<?php } else { 
    echo "vous n'avez rien à faire la brigand";
} ?>

</div>

<?php 

$noFireStat = true;
$noContact = true;
$css = "listUser.css";

?>
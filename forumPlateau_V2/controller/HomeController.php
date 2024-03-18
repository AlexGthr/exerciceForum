<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class HomeController extends AbstractController implements ControllerInterface {

    public function index(){
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum"
        ];
    }
        
    public function users(){
        $this->restrictTo("ROLE_USER");

        $manager = new UserManager();
        $users = $manager->findAll(['register_date', 'DESC']);

        return [
            "view" => VIEW_DIR."security/users.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "users" => $users 
            ]
        ];
    }

    public function profile() {

        // Je récupère l'id de mon utilisateur
        $id = Session::getUser()->getId();

        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        
        return [
            "view" => VIEW_DIR."forum/profil.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "user" => $user 
            ]
        ];
    }
}

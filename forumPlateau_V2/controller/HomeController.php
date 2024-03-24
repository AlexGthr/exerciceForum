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

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $userManager = new UserManager();
        $postManager = new PostManager();

        $topics = $topicManager->findAllByDate();
        $posts = $postManager->findPostByNumber();
        $category = $postManager->findPostByNumber();


        // $category = $categoryManager->
        // $users = $userManager->

        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum",
            "data" => [
                "topics" => $topics,
                "posts" => $posts,
                "category" => $category
            ]
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
            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "user" => $user 
            ]
        ];
    }

    public function viewProfil($id) {
        
        $userManager = new UserManager();
        $postManager = new PostManager();
        
        $user = $userManager->findOneById($id);
        $posts = $postManager->findPostsByUser($id);

        if (Session::getUser()->getId() == $id) {

            return [
                "view" => VIEW_DIR."security/profil.php",
                "meta_description" => "Liste des utilisateurs du forum",
                "data" => [ 
                    "user" => $user 
                ]
            ];
            exit;
        } else {

    
            return [
                "view" => VIEW_DIR."security/viewProfil.php",
                "meta_description" => "Profil user",
                "data" => [ 
                    "user" => $user,
                    "posts" => $posts 
                ] 
                ];
        }

    }

    public function editAvatar($id) {
        if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) { 

            $userManager = new UserManager();
            $user = $userManager->findOneById($id);
            $userAvatar = $user->getAvatar();

            $defaultAvatar = "./public/img/avatar/default.webp";

            
            // Je récupère l'image reçu
            $tmpName = $_FILES['file']['tmp_name'];
            $nameImg = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $erreur = $_FILES['file']['error'];
            
            // Je sépare le nom de l'extension
            $tabExtension = explode('.', $nameImg);
            // Je met l'extension en minuscule
            $extension = strtolower(end($tabExtension));
            // Je crée un tableau pour accepter UNIQUEMENT ce genre d'extension
            $extensions = ['jpg', 'png', 'jpeg', 'webp'];
            // Et je crée une condition pour la taille MAX d'une image (1 MO ici)
            $maxSize = 1000000;
            
            $uniqueName = uniqid('', true);
            
            if ($size >= $maxSize) { // Si la taille de l'image n'est pas correct
                
                Session::addFlash("message", "Problem with size image.(size max : 1mo)");
                $this->redirectTo("home", "profile");
                
            } elseif ($erreur > 0) { // Si l'image à une erreur
                
                Session::addFlash("message", "Erreur upload file.");
                $this->redirectTo("home", "profile");
                
            } elseif (!$extensions) {
                Session::addFlash("message", "format not correct");
                $this->redirectTo("home", "profile");
            } else {
                
                if (isset($userAvatar) && $userAvatar !== $defaultAvatar) {
    
                    unlink($userAvatar);
                }

                //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
                $file = $uniqueName.".".$extension;
                move_uploaded_file($tmpName, './public/img/avatar/'.$file);
                
                // Je récupère mon image dans le dossier
                $image = imagecreatefromstring(file_get_contents('./public/img/avatar/' . $file));
                // Je prépare ma nouvelle image
                $webpPath = "./public/img/avatar/" . $uniqueName . ".webp";
                // Je convertie en webP
                imagewebp($image, $webpPath);
                // Et je supprime mon ancienne image
                unlink('./public/img/avatar/'.$file);

                // Je définie le chemin pour le BDD
                $cheminfile = $webpPath;

                $information = [
                    "avatar" => $cheminfile
                ];

                // Puis je l'ajoute dans la BDD
                $userManager->update($information, $id);

                unset($_SESSION["user"]);

                $user = $userManager->findOneById($id);

                Session::setUser($user);


                // Je crée ensuite un message personnalisé en Session, pour confirmer l'inscription et je redirige vers le login
                Session::addFlash("message", "Success !");
                $this->redirectTo("home", "profile");
                exit;
            }
        } else {
            $this->redirectTo("home", "profile");
        }
    }

    public function editPassword($id) {
        
        if($_POST["submit"]) { 

            $userManager = new UserManager();
            $user = $userManager->findOneById($id);
            $idUser = $user->getId();

            if (Session::getUser()->getId() !== $idUser) {

                $this->redirectTo("home", "index");

            } else {

                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $oldPassword = $user->getPassword();

                if (!password_verify($password, $oldPassword)) {

                    Session::addFlash("message", "Wrong password");
                    $this->redirectTo("home", "profile");

                } elseif ($pass1 !== $pass2) {

                    Session::addFlash("message", "New password as different.");
                    $this->redirectTo("home", "profile");

                } elseif (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $pass1)) {

                    Session::addFlash("message", "This password is not correct");
                    $this->redirectTo("home", "profile");

                } else {
                    
                    $information = [
                        "password" => password_hash($pass1, PASSWORD_DEFAULT)
                    ];

                    $userManager->update($information, $id);

                    Session::addFlash("message", "New password SUCCESS");
                    $this->redirectTo("home", "profile");
                }
            }
        } else {
        $this->redirectTo("home", "index");
        }
    }
}

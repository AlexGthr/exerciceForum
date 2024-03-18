<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    // Method pour afficher la liste des topics par ID d'une catégorie
    public function listTopicsByCategory($id) {

        // Je crée mes nouveaux objet dans mes managers
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();

        // Je recupère mes éléments
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        // Et je retourne mes infos à la vue
        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    // Method pour recupérer les posts pas ID d'un topic
    public function findPostsByTopic($id) {

        // Je crée mes objets
        $topicManager = new TopicManager();
        $userManager = new UserManager();
        $postManager = new PostManager();

        // Je recupère mes éléments
        $topics = $topicManager->findOneById($id);
        $users = $userManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        // Et j'envoi le tout dans ma vue
        return [
            "view" => VIEW_DIR."forum/postsTopic.php",
            "meta_description" => "Posts du topic",
            "data" => [
                "posts" => $posts,
                "topics" => $topics,
                "users" => $users
            ]
        ];
    }

    // MEthod pour le formulaire d'un nouveau topic
    public function newTopic() {

        // Je récupère mes catégories
        $categoryManager = new CategoryManager();

        $category = $categoryManager->findAll();

        // Et j'envoi le tout à ma vue
        return [
            "title" => "Forum - New topic",
            "view" => VIEW_DIR."forum/formTopic.php",
            "meta_description" => "Add new topic !",
            "data" => [
                "category" => $category
            ]
        ];
    }

    // Method pour la création d'un nouveau topic
    public function addTopic($id) {

        // Si je recois un envoi par le boutton submit
        if($_POST["submit"]) { 

        // Je vérifie que l'utilisateur est bien connecté, sinon, direction l'index
        if (!Session::getUser()) {
            $this->redirectTo("home", "index");
        } else {

            // Je récupère l'id de mon utilisateur
        $idUser = Session::getUser()->getId();

        // Je compare l'id de mon url avec celle de mon user, pour éviter la création de topic avec un autre ID
        if($id == $idUser) {

            // Je filtre les données reçus
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $post = filter_input(INPUT_POST, "post", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $category = filter_input(INPUT_POST, "category", FILTER_VALIDATE_INT);

            // Je vérifie si tout est bien remplis
            if (empty($title)) {

                Session::addFlash("message", "You cannot have an empty title...");
                $this->redirectTo("forum", "newTopic");
                
            } elseif (empty($post)) {

                Session::addFlash("message", "You cannot have an empty post...");
                $this->redirectTo("forum", "newTopic");

            } elseif (empty($category)) {

                Session::addFlash("message", "You cannot have an empty category...");
                $this->redirectTo("forum", "newTopic");

            } else {

                // Si tout est bon, je récupère vérifie que la catégorie existe également
                $categories = new CategoryManager();
                $categorie = $categories->findOneById($category); 

                if ($categorie != false) {

                    // Si la catégorie existe, alors je crée mes objets et j'insère le nouveau topic / post
                    $newTopic = new TopicManager();
                    $newPost = new PostManager();

                    $informationTopic = [
                        "title" => $title,
                        "closed" => 0,
                        "user_id" => $id,
                        "category_id" => $category
                    ];

                    $idNewTopic = $newTopic->add($informationTopic);

                    $informationPost = [
                        "post" => $post,
                        "topic_id" => $idNewTopic,
                        "user_id" => $idUser
                    ];

                    $newPost->add($informationPost);

                    Session::addFlash("message", "Success");
                    $this->redirectTo("forum", "findPostsByTopic", $idNewTopic);

                } else {

                    Session::addFlash("message", "You trying something wrong...");
                    $this->redirectTo("forum", "newTopic");

                }
                
            }

        } else {

            Session::addFlash("message", "You trying something wrong...");
            $this->redirectTo("forum", "newTopic");

        }
    }} else {
        $this->redirectTo("forum", "newTopic");
    }
    }

    public function addPost($id) {

        // Si je recois un envoi par le boutton submit
        if($_POST["submit"]) { 

            // Je vérifie que l'utilisateur soit connecté, si ce n'est pas le cas, direction l'INDEX
        if (!Session::getUser()) {
            $this->redirectTo("home", "index");
        } else {

            // Je récupère l'id de mon utilisateur
            $idUser = Session::getUser()->getId();
    
            // Je filtre les résultats
            $post = filter_input(INPUT_POST, "post", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Je vérifie que le post ne soit pas vide
            if (empty($post)) {
                Session::addFlash("message", "You trying something wrong...");
                $this->redirectTo("forum", "findPostsByTopic", $id);
            } else {

                // Et si c'est bon, je crée un new objet, et j'ajoute mon post
                $newPost = new PostManager();

                $informationPost = [
                    "post" => $post,
                    "topic_id" => $id,
                    "user_id" => $idUser
                ];

                $newPost->add($informationPost);

                $this->redirectTo("forum", "findPostsByTopic", $id);
            }

        }
    } else {
        $this->redirectTo("forum", "findPostsByTopic", $id);
    }
}
}
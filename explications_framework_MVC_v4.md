# Mini-framework MVC Elan
Pour visualiser cette documentation sur VSCode 
```
CTRL + SHIFT + V
```

## 📖 Table des matières
- [Mini-framework MVC Elan](#mini-framework-mvc-elan)
  - [📖 Table des matières](#-table-des-matières)
  - [✍️ Rappel des notions](#️-rappel-des-notions)
    - [✅ Design pattern (patron de conception)](#-design-pattern-patron-de-conception)
    - [✅ Modèle Vue Contrôleur (MVC)](#-modèle-vue-contrôleur-mvc)
    - [✅ Programmation orientée objet (POO)](#-programmation-orientée-objet-poo)
  - [✍️ Structure du framework et responsabilité de chaque couche de l'application](#️-structure-du-framework-et-responsabilité-de-chaque-couche-de-lapplication)
    - [✅ index.php](#-indexphp)
    - [✅ public](#-public)
    - [✅ App](#-app)
    - [✅ Controller](#-controller)
    - [✅ Model](#-model)
      - [⭐ Entities](#-entities)
      - [⭐ Managers](#-managers)
    - [✅ View](#-view)


## ✍️ Rappel des notions
### ✅ Design pattern (patron de conception)
Un design pattern est une solution réutilisable à un problème de conception logicielle courant, offrant une structure éprouvée pour résoudre des problèmes similaires. Il fournit un moyen standardisé de décrire les bonnes pratiques de conception, facilitant la communication entre les développeurs. Les design patterns favorisent la maintenabilité, la flexibilité et la scalabilité des systèmes logiciels en fournissant des modèles de conception éprouvés.

### ✅ Modèle Vue Contrôleur (MVC)
Le design pattern MVC (Modèle-Vue-Contrôleur) est une *architecture logicielle* qui divise une application en trois composants principaux : le Modèle, qui représente les données et la logique métier, la Vue, qui affiche l'interface utilisateur, et le Contrôleur, qui agit comme un intermédiaire entre le Modèle et la Vue en gérant les interactions utilisateur et en mettant à jour le Modèle en conséquence. Ce pattern favorise la séparation des préoccupations, permettant une meilleure organisation du code, une réutilisabilité accrue et une maintenance plus facile des applications.

### ✅ Programmation orientée objet (POO)
1. **Namespace / Use** : un *namespace* en PHP est un moyen de regrouper des classes, des interfaces, des fonctions et des constantes dans un espace de noms logique afin d'éviter les conflits de noms. L'utilisation du mot-clé namespace permet de définir un espace de noms, tandis que le mot-clé *use* permet d'importer un espace de noms dans un fichier pour pouvoir utiliser ses éléments sans spécifier le chemin complet à chaque fois.

``` php
namespace Model\Entities;
use App\Entity;
```

2. **Classe Abstraite** et **Héritage** : une classe abstraite est une *classe qui ne peut pas être instanciée* directement mais qui peut contenir des méthodes abstraites et des méthodes concrètes. Les méthodes abstraites sont des méthodes déclarées mais non implémentées dans la classe abstraite, ce qui signifie que les classes filles doivent les implémenter.
L'héritage est un concept de la programmation orientée objet qui permet à une classe (appelée classe fille ou sous-classe) d'hériter des propriétés et des méthodes d'une autre classe (appelée classe parent ou superclasse). Cela permet la réutilisation du code et la création de hiérarchies de classes.

``` php
/* app/AbstractController.php */
namespace App;

abstract class AbstractController
```
``` php
/* controller/HomeController.php */
namespace Controller;
use App\AbstractController;

class HomeController extends AbstractController
```

3. **Interface** : une interface en PHP est un *contrat définissant un ensemble de méthodes* que les classes qui l'implémentent doivent fournir. Contrairement aux classes abstraites, les interfaces ne contiennent pas d'implémentation de méthodes, seulement leur signature. Une classe peut implémenter plusieurs interfaces.

```php	
/* app/ControllerInterface.php */
namespace App;

interface ControllerInterface{

    public function index();
}
```

``` php
/* controller/HomeController.php */
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

class HomeController extends AbstractController implements ControllerInterface
```

4. **Classe Finale** : une classe finale est une classe qui ne peut pas être étendue. Cela signifie qu'aucune autre classe ne peut hériter de cette classe finale. On utilise généralement ce concept lorsqu'on veut empêcher une classe d'être modifiée ou étendue.

``` php
/* model/entities/Category.php */
namespace Model\Entities;

use App\Entity;

final class Category extends Entity
```

5. **Autoloader** : l'autoloader est un mécanisme en PHP qui permet de charger automatiquement les classes au moment de leur utilisation, sans avoir besoin d'inclure manuellement les fichiers qui les définissent. Cela simplifie le processus de chargement des classes et évite les erreurs d'inclusion manuelle.
6. **Hydratation** : l'hydratation est un processus où les données sont utilisées pour initialiser un objet. En PHP, cela signifie généralement prendre des données provenant d'une source externe (comme une base de données) et les utiliser pour remplir les propriétés d'un objet.

``` php
/* app/Entity.php */
namespace App;

abstract class Entity {
    protected function hydrate($data){ /* code */ }
}
```

## ✍️ Structure du framework et responsabilité de chaque couche de l'application

### ✅ index.php
Le fichier index.php à la racine de notre framework va permettre de définir toutes les constantes nécessaires à notre configuration initiale, la gestion de la session, la prise en charge de la requête HTTP provenant du client ainsi que la temporisation de sortie pour charger nos vues de la bonne façon.

Chaque requête HTTP dans notre navigateur aura la forme suivante : 
```
http://serveur/projet/index.php?ctrl=home&action=index&id=x
```
- l'argument **"ctrl"** désigne le controller à appeler (sans "Controller", dans notre exemple "home" pour "HomeController") : à défaut ce sera HomeController qui sera appelé si aucun argument n'est passé
- l'argument **"action"** désigne la méthode du controller à appeler (attention à la casse !). Dans notre exemple, nous appelons la méthode "index" de "HomeController". Si l'action n'est pas précisée, c'est la méthode "index" qui sera invoquée.
- l'argument **"id"** désigne l'identifiant souhaité si la méthode nécessite de passer un argument de ce type.

<u>Exemple</u> : afficher la liste des topics d'une catégorie :
```
http://serveur/projet/index.php?ctrl=forum&action=listTopicsByCategory&id=3
```
renverra la liste des topics de la catégorie 3 (la méthode "listTopicsByCategory" sera ici implémentée dans "ForumController").

### ✅ public
Le dossier public contiendra tous les assets nécessaires à notre projet
- fichiers CSS
- fichiers JavaScript
- images
- ...

### ✅ App
Le dossier "app" contient l'ensemble des classes nécessaires au bon fonctionnement du framework et ainsi fournir des classes et méthodes génériques pour éviter d'avoir à répéter des portions de code. 
- **AbstractController.php** : fournit 2 méthode pour la restriction de rôle et une méthode facilitant la redirection <br>
Ainsi on pourra implémenter ceci : 
``` php
// Donner accès à la méthode "users" uniquement aux utilisateurs qui ont le rôle ROLE_USER
public function users(){
    $this->restrictTo("ROLE_USER");
}
```
ou
``` php
// Rediriger vers la méthode login du controller "SecurityController"
$this->redirectTo("security", "login");
```

- **Autoloader.php** : permet un auto-chargement des classes du projet (appelé dans index.php)
- **ControllerInterface.php** : permet d'imposer la méthode "index" aux controllers qui l'implémente 
- **DAO.php** : fournit toutes les méthodes génériques qui interagissent avec la base de données : connexion, SELECT, INSERT, UPDATE, DELETE
- **Entity.php** : fournit la méthode d'hydratation des instances de classes du projet (transformer un tableau associatif en objet ou collection d'objets comme le ferait un ORM comme Doctrine dans Symfony)
- **Manager.php** : fournit les méthodes permettant de renvoyer les résultats du Manager vers le Controller correspondant
- **Session.php** : fournit les méthodes relatives à la session (messages flash et gestion des utilisateurs) <br>
La méthode suivante permet de vérifier qu'un utilisateur est bien connecté :
``` php
public static function getUser(){
    return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
}
```
Et ainsi vérifier ceci directement dans un controller : 
``` php
/* controller */
if(\App\Session::getUser())
```
ou directement dans une vue du projet :
``` php
/* view */
($topic->getUser()->getId() == App\Session::getUser()->getId())
```

### ✅ Controller
Les controllers permettent d'intercepter / prendre en charge la requête HTTP émise par le client (à travers index.php).
Chaque controller (namespace Controller) doit hériter d'AbstractController et implémenter ControllerInterface

``` php
/* controller/HomeController.php */
class HomeController extends AbstractController implements ControllerInterface
```

Chaque controller va implémenter "ControllerInterface" et devra donc posséder toutes les méthodes de celle-ci (en l'occurence dans notre cas, la méthode "index").
Nous remarquerons que le controller fait bien le lien avec la vue correspondante à travers le 1er argument du tableau retourné "view"

``` php
/* controller/HomeController.php */
public function index(){
    return [
        "view" => VIEW_DIR."home.php",
        "meta_description" => "Page d'accueil du forum"
    ];
}
```

Dans cet exemple plus complet, nous implémentons la méthode <u>**listTopicsByCategory($id)**</u>.
- Nous instancions les managers nécessaires (ici TopicManager et CategoryManager)
- Nous récupérons les objets fournis par la méthode du manager correspondant (voir la partie [Managers](#managers) de la documentation)
- Nous transmettons les informations à la vue "listTopics.php" 

``` php
/* controller/ForumController.php */
public function listTopicsByCategory($id) {

    $topicManager = new TopicManager();
    $categoryManager = new CategoryManager();
    $category = $categoryManager->findOneById($id);
    $topics = $topicManager->findTopicsByCategory($id);

    return [
        "view" => VIEW_DIR."forum/listTopics.php",
        "meta_description" => "Liste des topics par catégorie : ".$category,
        "data" => [
            "category" => $category,
            "topics" => $topics
        ]
    ];
}
```

### ✅ Model
#### ⭐ Entities
Chaque table de la base de données doit avoir son équivalent sous forme de classe (namespace Model\Entities). Chaque entité doit hériter de la classe Entity (App). Chaque entité a le même constructeur qui hydrate les objets de la classe concernée (la méthode hydrate appartient à la classe parent "Entity" et peut être donc utilisée par héritage). On génère les getters et les setters pour toutes les propriétés de la classe et on ajoute un __toString() pour faciliter nos affichages

``` php
/* model/entities/Category.php */
namespace Model\Entities;

use App\Entity;

final class Category extends Entity{

    private $id;
    private $name;

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){         
        $this->hydrate($data);        
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
```

#### ⭐ Managers
Les managers sont responsables de l'interaction avec la base de données.
Comme tous les managers héritent de la classe abstraite "App\Manager", nul besoin de définir les méthodes classiques suivantes dans chaque manager : 
- **findAll(array $order)** : retourne une collection d'objets de la classe spécifiée dans le Manager. Possibilité de trier selon un ou plusieurs critères
- **findOneById(int $id)** : retourne un objet de la classe spécifiée dans le Manager (dont l'identifiant est passé en paramètre)
- **add(array $data)** : ajoute un enregistrement en base de données
- **delete(int $id)** : supprime un enregistrement en base de données (dont l'identifiant est passé en paramètre)
- ...

``` php
/* model/managers/CategoryManager.php */
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategoryManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct(){
        parent::connect();
    }
}
```

En revanche, si l'on a besoin d'exécuter des requêtes SQL spécifiques, nous pouvons implémenter nos propres méthodes dans le Manager de son choix. <br>

- Si la requête renvoie <u>**plusieurs enregistrements**</u>, par exemple la liste des topics par catégorie, on utilise la méthode getMultipleResults()

``` php
/* model/managers/TopicManager.php */
public function findTopicsByCategory($id) {

    $sql = "SELECT * 
            FROM ".$this->tableName." t 
            WHERE t.category_id = :id";
    
    return  $this->getMultipleResults(
        DAO::select($sql, ['id' => $id]), 
        $this->className
    );
}
```

- Si la requête renvoie <u>**un seul enregistrement**</u>, nous utiliserons la méthode getOneOrNullResult :

``` php
public function findOneElement($id) {

    $sql = "";
    
    return  $this->getOneOrNullResult(
        DAO::select($sql, ['id' => $id]), 
        $this->className
    );
}
```

### ✅ View
Le dossier "view" contiendra l'ensemble des vues du projet
- Nativement, un fichier "home.php" a été crée pour une base de page d'accueil

``` html 
<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<p>
    <a href="index.php?ctrl=security&action=login">Se connecter</a>
    <a href="index.php?ctrl=security&action=register">S'inscrire</a>
</p>
```

- le fichier "layout.php" permet d'implémenter la structure commune à l'ensemble des vues du projet : DOCTYPE, liens externes / internes (notamment librairies CSS et/ou Javascript), "meta" tags, navigation (avec les conditions potentielles concernant le rôle de l'utilisateur connecté par exemple), footer, gestion des messages de succès / d'erreur, etc.
- Toutes les vues héritent donc de "layout.php" concernant le squelette globale de la page et sont donc réduites au strict nécessaire : 

``` php
/* controller/ForumController.php */
$categories = $categoryManager->findAll(["name", "DESC"]);

// le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
return [
    "view" => VIEW_DIR."forum/listCategories.php",
    "meta_description" => "Liste des catégories du forum",
    "data" => [
        "categories" => $categories
    ]
];
```

``` php
/* exemple pour lister toutes les catégories du forum */

// on initialise une variable permettant de récupérer ce que nous renvoie le controller à l'index "categories" du tableau de "data"
$categories = $result["data"]['categories']; 
<h1>Liste des catégories</h1>

foreach($categories as $category ){ ?>
    <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
}
```


A vous de jouer ! 🚀
<?php
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

    public function NbTopicByCategory() {

        $sql = "SELECT 
                    category.id_category, 
                    category.name, 
                    category.picture, 
                    COUNT(DISTINCT topic.id_topic) AS nbTopics,
                    COUNT(post.id_post) AS nbPosts
                FROM category
                LEFT JOIN topic ON category.id_category = topic.category_id
                LEFT JOIN post ON topic.id_topic = post.topic_id
                GROUP BY category.id_category
                ORDER BY nbTopics DESC
                LIMIT 3;";
        
        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

    public function ListCategory() {

        $sql = "SELECT 
                    category.id_category, 
                    category.name, 
                    category.picture, 
                    COUNT(DISTINCT topic.id_topic) AS nbTopics,
                    COUNT(post.id_post) AS nbPosts
                FROM category
                LEFT JOIN topic ON category.id_category = topic.category_id
                LEFT JOIN post ON topic.id_topic = post.topic_id
                GROUP BY category.id_category
                ORDER BY category.name";
        
        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

}
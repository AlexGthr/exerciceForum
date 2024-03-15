<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    public function findByNickName($nickName) {

        $sql = "SELECT * 
        FROM ".$this->tableName." u 
        WHERE u.nickName = :nickName";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
        DAO::select($sql, ['nickName' => $nickName]), 
        $this->className
);
    }
}
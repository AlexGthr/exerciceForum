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

    // Public function pou retrouver un user via son NickName
    public function findByNickName($nickName) {

        $sql = "SELECT * 
        FROM ".$this->tableName." u 
        WHERE u.nickName = :nickName";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return $this->getOneOrNullResult(
        DAO::select($sql, ['nickName' => $nickName], false), 
        $this->className
);
    }
}
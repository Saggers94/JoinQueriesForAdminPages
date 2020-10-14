<?php

//adding up the namespace
namespace App\Model;

//declaring the class
class ModelFinalClass
{
    
    //setting up the dbh and table and key variable with the protected accessiblity
    static protected $dbh;

    protected $table;
    protected $key;

    //initialize the database with this function
    static public function init($dbh)
    {
        self::$dbh = $dbh;
    }

    //extracting the all the data from the given table
    public function all()
    {
        $query = "select * from {$this->table}";

        $stmt = self::$dbh->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //extracting one data from the table
    public function one($id)
    {
        $query = "select * from {$this->table} where {$this->key} = :id";

        $stmt = self::$dbh->prepare($query);

        $params = array(
            ':id' => $id
        );

        $stmt->execute($params);

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    //general simple executing query without any params for admin data
     public function getNecessaryDataForDashboard($query){
          
        $stmt = self::$dbh->prepare($query);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


}
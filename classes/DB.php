<?php

class DB {
    protected $db = null;

    public function connectToDB() {        
        try {
            /*$this refers to the DB class, who calls the db method. 
            think of it like this.db = new PDO(connection to db);*/
            $this->db = new PDO(Config::DB_DNS, Config::DB_USER, Config::DB_PASSWORD);
        } 
        catch (Exception $ex) {
            /*when you null a PDO object is automatically closes 
            the connection to the database.*/
           $this->db = null;
        }
        return $this->db;        
    }
    
    public function closeDB() {        
        $this->db = null;        
    }//end closeDB()    
    
    /*returns a fetch all (all records) from DB*/
    public function returnAFetchAll($sqlString){
        $db = $this->connectToDB();
        
        if($db != NULL){
            $stmt = $db->prepare($sqlString);
            $stmt->execute();
            $listReturned = $stmt->fetchAll();
            
            if( $stmt->execute() ){
                $this->closeDB();
                return $listReturned;
            }
        }
    }//end returnAFetchAll()
    
}//end DB class

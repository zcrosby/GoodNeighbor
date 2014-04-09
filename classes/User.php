<?php

class User extends DB{
    
    public function getUserName($userID){
        $db = $this->connectToDB();
        if($db != NULL){
            $stmt = $db->prepare( "SELECT name "
                                . "FROM user_info "
                                . "WHERE user_id = :userID; ");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if( $stmt->execute() ){  
                $name = $result["name"];
                $this->closeDB();
                return $name;              
            }
        }
    }
    
    public function getUserID($email, $password){
        //goes into db and returns user id
        $db = $this->connectToDB();
        try {
            if( $db != NULL){
                $stmt = $db->prepare("SELECT user_id "
                                   . "FROM user_info " 
                                   . "WHERE user_email = :email " 
                                   . "AND password = :password limit 1 ;");

                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                //DEBUG var_dump($result);

                if( $stmt->execute() ){  
                    $idNum = $result["user_id"];
                    $this->closeDB();
                    return $idNum;              
                }
            }//end if db not null
        }
        catch (Exception $ex) {
           //debug var_dump($ex);
           $this->db = null;
           echo $ex;
       }  
    }//end getUserID()
    
    public function addUser(){
        $name = filter_input(INPUT_POST, "name");
        $address = filter_input(INPUT_POST, "address");
        
        $city = filter_input(INPUT_POST, "city");
        $neighborhood = filter_input(INPUT_POST, "neighborhood");
        
        $email = filter_input(INPUT_POST, "email");
        $phone = filter_input(INPUT_POST, "phone");
        
        $password = filter_input(INPUT_POST, "secondPassword");
        $password = sha1($password);
        
        $db = $this->connectToDB();
        
        if ( null != $db ) {  
            $stmt = $db->prepare("INSERT INTO user_info SET "
                    . "name = :name,"
                    . "user_address = :address,"
                    . "city_id = :cityID, "
                    . "neighborhood_id = :neighborhoodID,"
                    . "user_email = :email,"
                    . "user_phone = :phone,"
                    . "password = :password;");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':cityID', $city, PDO::PARAM_STR);
            $stmt->bindParam(':neighborhoodID', $neighborhood, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            
            if ( $stmt->execute() ){
                  $this->closeDB();
                  return true;
            }
            else{
                return false;
            }
        }
    }
    
/********Login Check***********/
    public function userExists($email, $password){
       $db = $this->connectToDB();
       try {
            //debug var_dump($db);
            if( NULL != $db ){
                $stmt = $db->prepare( 'SELECT * '
                                    . 'FROM user_info '
                                    . 'WHERE user_email = :email '
                                    . 'AND password = :password limit 1');
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                //debug var_dump($result);
                if( $stmt->execute() ){
                    //a check to make sure that actual values are returned, if they are, the user exists and their login is valid.
                    if ( is_array($result) && count($result) ) {
                        $this->closeDB();
                        return true;  
                    }
                }//end $stmt execute
            }//end $db!= null 
       }//end try
       catch (Exception $ex) {
           //when you null a PDO object is automatically closes the connection to the database.
           //debug var_dump($ex);
           $this->db = null; 
       }
       
       return false;
    }//end userExists(
    
    public function emailIsTaken($email){
        $db = $this->connectToDB();
        $exists = false;
        if ( NULL != $db ) {
            $stmt = $db->prepare( 'SELECT user_email '
                                . 'FROM user_info '
                                . 'WHERE user_email = :email limit 1');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            //the fetch function allows you to get the associated value to email
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            //(although, fethc may return other things besides arrays)
            if ( is_array($result) && count($result) ) {
                $this->closeDB();
                $exists = true;
            }
        } 
        return $exists;
    }//end emailExists()
}

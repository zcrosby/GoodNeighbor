<?php


class Profile extends DB {
    //put your code here
/*******MOVED to User class*****************  
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
   *******MOVED to User class*****************/ 
    
   
    
    
 /*******MOVED to Favor CLass*****************    
    public function getFavorsUserRequested($userID){
        $db = $this->connectToDB();
        if($db != NULL){
            
            $stmt = $db->prepare("SELECT favor.favor_id, favor_type_id, date_submitted, status "
                               . "FROM favor, favor_resquester "
                               . "WHERE favor_resquester.favor_id = favor.favor_id "
                               . "AND favor_resquester.user_id = :userID ;");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->execute();
            $fieldsReturned = $stmt->fetchAll();
            
            if( $stmt->execute() ){
                $this->closeDB();
                return $fieldsReturned;
            }
        }
    }
    
    public function getPendingFavors($userID){
        $db = $this->connectToDB();
        if($db != NULL){
            $stmt = $db->prepare("SELECT favor.favor_id, favor_type_id, date_of_favor, details "
                               . "FROM favor, favor_responder "
                               . "WHERE favor_responder.favor_id = favor.favor_id "
                               . "AND favor_responder.user_id = :userID "
                               . "AND favor.status = 'P';");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            //$stmt = $db->prepare("SELECT * FROM favor_responder; ");
            $stmt->execute();
            $fieldsReturned = $stmt->fetchAll();
            
            if( $stmt->execute() ){
                $this->closeDB();
                return $fieldsReturned;
            }
        }
    }

public function getPendingFavorUserInfo($favorID){
        $db = $this->connectToDB();
        if($db != NULL){
            $stmt1 = $db->prepare("SELECT user_id "
                                . "FROM favor_resquester "
                                . "WHERE favor_id = :favorID;");
            $stmt1->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            $stmt1->execute();
            $stmt1Returned = $stmt1->fetch();
            $userID = $stmt1Returned["user_id"]; 
            //var_dump($stmt1Returned); //DEBUG
            //var_dump($userID); //DEBUG         
            
            if( $stmt1->execute() ){
                $stmt2 = $db->prepare("SELECT name, user_address, user_phone "
                                    . "FROM user_info "
                                    . "WHERE user_id = :userID ;");
                $stmt2->bindParam(':userID', $userID, PDO::PARAM_STR);
                $stmt2->execute();
                $stmt2Returned = $stmt2->fetch();
                $this->closeDB();
                //var_dump($stmt2Returned); //DEBUG
                return $stmt2Returned;
            }
        }
    }
    
    

    public function getPendingFavorUserInfo($favorID){
        $db = $this->connectToDB();
        if($db != NULL){
            $stmt = $db->prepare("SELECT name, user_address "
                               . "FROM user_info, favor_resquester "
                               . "WHERE favor_resquester.favor_id = '' "
                               . "AND user_info.user_id = favor_resquester.user_id;");
            //$stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            //$stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            echo $favorID;//DEBUG 
            $stmt->execute();
            $fieldsReturned = $stmt->fetchAll();
            
            if( $stmt->execute() ){
                $this->closeDB();
                //var_dump($fieldsReturned);
                return $fieldsReturned;
            }
        }
    }
*/  
    
}//end profile class



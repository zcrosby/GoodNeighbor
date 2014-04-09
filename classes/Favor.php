<?php

class Favor extends DB{
    //Globals
    protected $errors = array();
    
    public function getErrors() {
        return $this->errors;
    }
    
    function getFavorTypes(){
        $sqlString = 'SELECT favor_type_id, description FROM favor_type';
        $favorList = $this->returnAFetchAll($sqlString);
        return $favorList; 
    }
    
    public function getFavorTypeDescription($favorTypeID){
        $db = $this->connectToDB();
        if($db != NULL){
            $stmt = $db->prepare("SELECT description "
                               . "FROM favor_type "
                               . "WHERE favor_type_id = :favorTypeID; ");
            $stmt->bindParam(':favorTypeID', $favorTypeID, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if( $stmt->execute() ){  
                $description = $result["description"];
                $this->closeDB();
                return $description;              
            }
        }
    }
 
/****BEGIN requestFavor.php*********************/        
    public function addNewFavorRequest($userID){ 
       
        $this->favorTypeInputCheck();
        $this->dateInputCheck();
        $this->userFavorCount($userID);
        
        if( count($this->errors) ){
            //print_r($this->errors); 
            return false;
        }
        else{
            $favorID = $this->insertFavorRequest();
            $this->addFavorToCurrentUser($userID, $favorID);
            //var_dump($f);
            return true;
        }
    }
    
    public function favorTypeInputCheck(){  
        if( array_key_exists("FavorType", $_POST) ){
            $f = filter_input(INPUT_POST, "FavorType");
            if( $f == "" ){
                $this->errors["FavorType"] = "*Select a favor type";
            }   
        }
    }
    
    public function dateInputCheck(){
        if( array_key_exists("Date", $_POST) ){
            $date = filter_input(INPUT_POST, 'Date');
            if( empty($date) ){
                $this->errors["Date"] = "*Must include a date";
            }   
        }
    }
    
    public function insertFavorRequest(){
        $now = new DateTime();
        
        $currentDate = $now->format('Y-m-d H:i:s');;
        $favorType = filter_input(INPUT_POST, "FavorType");
        
        $d = strtotime(filter_input(INPUT_POST, "Date"));
        $dateOfFavor = date('Y-m-d',$d);
        
        $favorDetails = filter_input(INPUT_POST, "FavorDetails");
        $helpNow = filter_input(INPUT_POST, "NeedHelpNow");
        
        if($helpNow == "on"){
            $helpNow = "Y";
        }
        else{
            $helpNow = "N";
        }
        
        $db = $this->connectToDB();
        
        if ( null != $db ) {  
            $stmt = $db->prepare("INSERT INTO favor SET "
                               . "favor_type_id = :favorType, "
                               . "date_submitted = :currentDate, "
                               . "date_of_favor = :dateOfFavor, "
                               . "need_asap = :helpNow, "
                               . "details = :favorDetails, "
                               . "status = 'O';");
            
            $stmt->bindParam(':favorType', $favorType, PDO::PARAM_STR);
            $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
            $stmt->bindParam(':dateOfFavor', $dateOfFavor, PDO::PARAM_STR);
            $stmt->bindParam(':helpNow', $helpNow, PDO::PARAM_STR);
            $stmt->bindParam(':favorDetails', $favorDetails, PDO::PARAM_STR);

            if ( $stmt->execute() ){
                  $favorID =  $db->lastInsertId(); 
                  $this->closeDB();
                  return $favorID;
            }    
        }
    }
    
    public function addFavorToCurrentUser($userID, $favorID){
        $wasAdded = false;
        $wantsContact = filter_input(INPUT_POST, "WantsContact"); 
        if($wantsContact == "on"){
            $wantsContact = "Y";
        }
        else{
            $wantsContact = "N";
        }
        $db = $this->connectToDB();
        
        if ( null != $db ) {  
            $stmt = $db->prepare("INSERT INTO favor_resquester SET "
                               . "favor_id = :favorID, "
                               . "user_id = :userID, "
                               . "wants_to_be_contacted = :wantsContact ;");
            
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->bindParam(':wantsContact', $wantsContact, PDO::PARAM_STR);
            
            if ( $stmt->execute() ){
                  //$favorID =  $db->lastInsertId(); 
                  $this->closeDB();
                  $wasAdded = true;
            }
        }
        return $wasAdded;
    }
    
    public function userFavorCount($userID){
        $userFavorMax = 3;
        $favorCount = $this->getFavorCount($userID);
        
        if($favorCount >= $userFavorMax){
            $this->errors["FavorCount"] = "Uh oh! you already have 3 open favors. Please complete or delete one more of your other requests.";
        }
    }
    
    public function getFavorCount($userID){
        $db = $this->connectToDB();
        if($db != NULL){
            $stmt = $db->prepare("SELECT COUNT(*) AS Num_Of_Favors "
                               . "FROM favor_resquester "
                               . "WHERE user_id = :userID ;");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            
            if( $stmt->execute() ){
                $this->closeDB();
                return $row["Num_Of_Favors"];
            }
        }
    }
/****END requestFavor.php*****************/   
    
    
/****BEGIN acceptFavor.php*****************/     
    public function getOpenFavors($userID){
        $date = new DateTime();
        $currentDate =  date('Y-m-d');
        
        $db = $this->connectToDB();
        if($db != NULL){
            $stmt = $db->prepare("SELECT favor.favor_id, favor_type_id, date_of_favor, details "
                               . "FROM favor, favor_resquester "
                               . "WHERE status = 'O' "
                               . "AND date_of_favor >= :currentDate "
                               . "AND favor_resquester.favor_id = favor.favor_id "
                               . "AND favor_resquester.user_id != :userID;");
            $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->execute();
            $favors = $stmt->fetchAll();
            
            if( $stmt->execute() ){
                $this->closeDB();
                return $favors;
            }
        }
    }
    
    public function setUserAsResponder($userID, $favorID){
        $db = $this->connectToDB();
        $wasAdded = false;
        if ( null != $db ) {  
            $stmt = $db->prepare("INSERT INTO favor_responder SET "
                               . "favor_id = :favorID, "
                               . "user_id = :userID;");
            
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            
            $markedAsPending = $this->markAsPendingFavor($favorID);
            
            if ( $stmt->execute() && $markedAsPending){ 
                  $this->closeDB();
                  $wasAdded = true;
            }
        }
        return $wasAdded;
    }
 /****END acceptFavor.php*****************/ 
    
    
    public function markAsPendingFavor($favorID){
        $db = $this->connectToDB();
        $marked = false;
        
        if ( null != $db ) {  
            $stmt = $db->prepare("UPDATE favor "
                                . "SET status = 'P' " 
                                . "WHERE favor_id = :favorID ;" );  
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
                        
            if ( $stmt->execute() ){ 
                  $this->closeDB();
                  $marked = true;
            }
        }
        return $marked;
    }
    
    
    public function deleteFavor($favorID){
        $db = $this->connectToDB();
        $wasDeleted = false;
        
        if ( null != $db ) {  
            $stmt = $db->prepare("DELETE FROM favor "
                               . "WHERE favor_id = :favorID;");
            
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            
            if ( $stmt->execute() ){ 
                  $this->closeDB();
                  $wasDeleted = true;
            }
        }
        return $wasDeleted;
    }
    
    public function deleteRequesterAssocToFavor($favorID, $userID){
        $db = $this->connectToDB();
        $wasDeleted = false;
        
        if ( null != $db ) {  
            $stmt = $db->prepare("DELETE FROM favor_resquester "
                               . "WHERE favor_id = :favorID "
                               . "AND user_id = :userID; ");
            
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            
            if ( $stmt->execute() ){ 
                  $this->closeDB();
                  $wasDeleted = true;
            }
        }
        return $wasDeleted;
    }
    
    public function deleteResponderAssocToFavor($favorID, $userID){
        $db = $this->connectToDB();
        $wasDeleted = false;
        
        if ( null != $db ) {  
            $stmt = $db->prepare("DELETE FROM favor_responder "
                               . "WHERE favor_id = :favorID "
                               . "AND user_id = :userID; ");
            
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            
            if ( $stmt->execute() ){ 
                  $this->closeDB();
                  $wasDeleted = true;
            }
        }
        return $wasDeleted;
    }
    
    public function markAsCompletedFavor($favorID, $userID){
        $db = $this->connectToDB();
        $complete = false;
        
        if ( null != $db ) {  
            $stmt = $db->prepare("UPDATE favor "
                                . "SET status = 'C' " 
                                . "WHERE favor_id = :favorID ;" );  
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            
            $removedFromReqTable = $this->deleteRequesterAssocToFavor($favorID, $userID);
            $removeFromRespondTable = $this->deleteResponderAssocToFavor($favorID, $userID);
            
            if ( $stmt->execute() && $removedFromReqTable && $removeFromRespondTable){ 
                  $this->closeDB();
                  $complete = true;
            }
        }
        return $complete;
    }
    
    public function reponderCannotComplete($favorID, $userID){
        $db = $this->connectToDB();
        $wasUpdated = false;
        
        if ( null != $db ) {  
            $stmt = $db->prepare("DELETE FROM favor_responder "
                               . "WHERE favor_id = :favorID "
                               . "AND user_id = :userID; ");            
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            
            $markedAsOpen = $this->markFavorAsOpen($favorID);
            
            if ( $stmt->execute() && $markedAsOpen){ 
                  $this->closeDB();
                  $wasUpdated = true;
            }
        }
        return $wasUpdated;
    }
    
    public function markFavorAsOpen($favorID){
        $db = $this->connectToDB();
        $isOpen = false;
        
        if ( null != $db ) {  
            $stmt = $db->prepare("UPDATE favor "
                                . "SET status = 'O' " 
                                . "WHERE favor_id = :favorID ;" );
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
           
            if ( $stmt->execute() ){ 
                  $this->closeDB();
                  $isOpen = true;
            }
        }
        return $isOpen;
    }
    
    public function getResponderInfo($favorID){
        $db = $this->connectToDB();
        $error = "error11111";
        $responderInfo = array();
                
        if ( null != $db ) {  
            $stmt = $db->prepare("SELECT user_info.user_id, name, user_email, user_phone " 
                                ."FROM user_info, favor_responder " 
                                ."WHERE favor_responder.user_id = user_info.user_id " 
                                ."AND favor_responder.favor_id = :favorID;" );
            
            $stmt->bindParam(':favorID', $favorID, PDO::PARAM_STR);
            $stmt->execute();
            $responderInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ( $stmt->execute() ){ 
                  $this->closeDB();
                  return $responderInfo;
            }
        }
        return $error;
    }
    
/**********BEGIN Profile Favor Related Fucntions***********/      
    public function displayFavorAsOpenOrPending($status, $favorID){
        if($status == "O"){
            return '<i id="'.$favorID.'" class="fa fa-flag status-symbols open-favor">Open</i>';
        }
        else if($status == "P"){//if pending maybe retrieve responderinfo here and pass it in an attribute here!!
            return '<i id="'.$favorID.'" class="fa fa-clock-o status-symbols pending-responder">Pending</i>';
        }
    }
    
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
    
}   
/*
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
/**********END Profile Favor Related Fucntions***********/   
    /*     
    public function fieldsAreValid(){    
        $this->favorTypeValidation();
        $this->DateValidation();
        
        if( count($this->errors) ){
            return false;
        }
        else{
            return true;
        }
    }//end fieldsAreValid()
*/


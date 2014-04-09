<?php
include 'dependency.php'; 

$favorID = $_GET["favorID"];
$userID = $_GET["userID"];
$table = $_GET["table"];
$action = $_GET["action"];

$fav = new Favor();

if($table == "requested"){
    if($action == "complete"){
        $markedAsCompleted = $fav->markAsCompletedFavor($favorID, $userID);

        if( $markedAsCompleted ){
            echo "success";
        }
        else{
            echo "error";
        }        
    }
    else if($action == "delete"){
        //remove from favor table
        //remove favor and user from
        $favorWasDeleted = $fav->deleteFavor($favorID);
        $assocRequesterWasDeleted = $fav->deleteRequesterAssocToFavor($favorID, $userID);
        $assocResponderWasDeleted = $fav->deleteResponderAssocToFavor($favorID, $userID);
        
        if( $favorWasDeleted && $assocRequesterWasDeleted && $assocResponderWasDeleted ){
            echo "success";
        }
        else{
            echo "error";
        }

        //DONT FORGET to check if someone already responded to favor,
        //if so, retrieve responder id
        //send a message to responder telling them that favor has been deleted

       //print_r($_GET);
    }
    else if($action == "getResponderInfo"){
        $responderInfo = array();
        $responderInfo = $fav->getResponderInfo($favorID);
       
        echo json_encode($responderInfo);
    }
}
else if($table == "pending"){
    if($action == "cannotFulfill"){
        $favorWasMadeOpenAgain = $fav->reponderCannotComplete($favorID, $userID);
        
        if( $favorWasMadeOpenAgain ){
          echo "success";  
        }
        else{
            echo "error";
        }       
    }//end if($action == "cannotFulfill")
}
else if($table == "respond"){
    if($action == "willFulfill"){
        $markedUserAsResponder = $fav->setUserAsResponder($userID, $favorID);
        
        if( $markedUserAsResponder ){
          echo "success";  
        }
        else{
            echo "error";
        }       
    }//end if($action == "willFulfill")
}


/*

     public function getResponderInfo($favorID){
        $db = $this->connectToDB();
        $error = "error11111";
        $responderInfo = array();
                
        if ( null != $db ) {  
            $stmt = $db->prepare("SELECT user_info.user_id, name, user_email, user_phone " 
                                ."FROM user_info, favor_responder " 
                                ."WHERE favor_responder.user_id = user_info.user_id " 
                                ."AND favor_responder.favor_id = 68;" );
            
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
    
    
    
*/

<?php
/**
 * Description of Registration
 *
 * @author Zalyn
 */
class Registration extends DB {
  
    /****Moved to UtilityClass********
    public function getNeighborhoods(){
        $sqlString = 'SELECT neighborhood_id, neighborhood_name FROM neighborhood';
        $neighborhoodList = $this->returnAFetchAll($sqlString);
        return $neighborhoodList; 
    }//end getNeighborhoods()
    
    public function getCities(){
        $sqlString = 'SELECT city_id, city_name FROM city';
        $cityList = $this->returnAFetchAll($sqlString);
        return $cityList;
    }//end getCities()
 ****Moved to UtilityClass********/
 }//end registration class
 
/******* addUser() Moved to User Class*********** 
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
 *******Moved to Validator Class************/
   
 
 
 
 
 
 
/*******Validations Moved to Validator Class*********** 
    protected $errors = array();
    protected $fpassIsThere = true;
    
    public function getErrors() {
        return $this->errors;
    }
  
    public function fieldsAreValid(){    
        $this->nameValidation();
        $this->emailValidation();       
        $this->phoneNumValidation();    
        $this->addressValidation();
        $this->passwordValidation();
        $this->secondPasswordValidation();
        $this->neighborhoodValidation();
        $this->cityValidation();
        if( count($this->errors) ){
            return false;
        }
        else{
            return true;
        }
    }//end fieldsAreValid()
  
   
    public function neighborhoodValidation(){  
        if( array_key_exists("neighborhood", $_POST) ){
            $n = filter_input(INPUT_POST, "neighborhood");
            if( $n == "" ){
                $this->errors["neighborhood"] = "*Select a neighborhood";
            }   
        }
    }
    
    public function cityValidation(){  
        if( array_key_exists("city", $_POST) ){
            $c = filter_input(INPUT_POST, "city");
            if( $c == "" ){
                $this->errors["city"] = "*Select a city";
            }   
        }
    }
    
    public function nameValidation(){  
        //$username = filter_input(INPUT_POST, 'username');
        if( array_key_exists("name", $_POST) ){
            $name = filter_input(INPUT_POST, 'name');
            if( empty($name) ){
                $this->errors["name"] = "*Must include your name";
            }   
        }
    }
    
    public function emailValidation(){ 
        if( array_key_exists("email", $_POST) ){
            if( !Validator::emailIsValid($_POST["email"]) ){
                $this->errors["email"] = "*Email is invalid";
            }
            else if( $this->emailExists() ){
                $this->errors["email"] = "*This email is already taken";
            }
        }   
    }// end emailValidation
    
    public function emailExists(){
        $email = filter_input(INPUT_POST, 'email');
        $db = $this->connectToDB();
        if ( NULL != $db ) {
            $stmt = $db->prepare('SELECT user_email FROM user_info WHERE user_email = :email limit 1');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            //the fetch function allows you to get the associated value to email
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            //(although, fethc may return other things besides arrays)
            if ( is_array($result) && count($result) ) {
                $this->closeDB();
                return true;
            }
        }  
    }//end emailExists()
    
    public function phoneNumValidation(){ 
        if( array_key_exists("phone", $_POST) ){
            $pNum = filter_input(INPUT_POST, "phone");
            
            if( empty($pNum) ){
                $this->errors["phone"] = "*Must include a phone number";
            }
            else if( !Validator::phoneNumIsValid($_POST["phone"]) ){
                    $this->errors["phone"] = "*Phone number is invalid. Ex. (555)555-5555";
            } 
        }   
    }// end phone num validation
    
    public function addressValidation(){  
        //$username = filter_input(INPUT_POST, 'username');
        if( array_key_exists("address", $_POST) ){
            $address = filter_input(INPUT_POST, 'address');
            
            if( empty($address) ){
                $this->errors["address"] = "*Must include an address";
            }
        }
    }
    
    public function passwordValidation(){ 
        if( array_key_exists("firstPassword", $_POST) ){
           $firstPassword = filter_input(INPUT_POST, 'firstPassword');
           
           if( empty($firstPassword) ){
                $this->errors["firstPassword"] = "*Must include a password";
                $this->fpassIsThere = false;
            }
            else if( !Validator::passwordIsValid($_POST["firstPassword"]) ){
                    $this->errors["firstPassword"] = "*Password is invalid";
                    $this->fpassIsThere = false;
            }
        }   
    }// end emailValidation
    
    public function secondPasswordValidation(){
        if( array_key_exists("secondPassword", $_POST) ){
           $secondPassword = filter_input(INPUT_POST, 'secondPassword');
           $firstPassword = filter_input(INPUT_POST, 'firstPassword');
           
           if( !empty($firstPassword) ){
                if( empty($secondPassword) ){
                     $this->errors["secondPassword"] = "*Must re-enter your password";
                 }
                 else if( $this->fpassIsThere == true ){ 
                     if($secondPassword != $firstPassword){
                     $this->errors["secondPassword"] = "*Passwords do not match";
                     }
                 }
            }
        }//end array key excists
    }
   *******Moved to Validator Class***********/ 


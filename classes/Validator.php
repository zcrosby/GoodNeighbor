<?php

class Validator {
    protected static $errors = array();
    protected static $fpassIsThere = true;
    
    public static function getErrors() {
        return self::$errors;
    }
    
/*******Registration Validations *********/
    public static function fieldsAreValid(){    
        self::nameValidation();
        self::emailValidation();       
        self::phoneNumValidation();    
        self::addressValidation();
        self::passwordValidation();
        self::secondPasswordValidation();
        self::neighborhoodValidation();
        self::cityValidation();
        if( count(self::$errors) ){
            return false;
        }
        else{
            return true;
        }
    }//end fieldsAreValid()
    
    
    public static function neighborhoodValidation(){  
        if( array_key_exists("neighborhood", $_POST) ){
            $n = filter_input(INPUT_POST, "neighborhood");
            if( $n == "" ){
                self::$errors["neighborhood"] = "*Select a neighborhood";
            }   
        }
    }
    
    public static function cityValidation(){  
        if( array_key_exists("city", $_POST) ){
            $c = filter_input(INPUT_POST, "city");
            if( $c == "" ){
                self::$errors["city"] = "*Select a city";
            }   
        }
    }
    
    public static function nameValidation(){  
        //$username = filter_input(INPUT_POST, 'username');
        if( array_key_exists("name", $_POST) ){
            $name = filter_input(INPUT_POST, 'name');
            if( empty($name) ){
                self::$errors["name"] = "*Must include your name";
            }   
        }
    }
    
    public static function emailValidation(){ 
        if( array_key_exists("email", $_POST) ){
            if( !self::emailIsValid($_POST["email"]) ){
                self::$errors["email"] = "*Email is invalid";
            }
        }   
    }// end emailValidation
    
    public static function phoneNumValidation(){ 
        if( array_key_exists("phone", $_POST) ){
            $pNum = filter_input(INPUT_POST, "phone");
            
            if( empty($pNum) ){
                self::$errors["phone"] = "*Must include a phone number";
            }
            else if( !self::phoneNumIsValid($_POST["phone"]) ){
                    self::$errors["phone"] = "*Phone number is invalid. Ex. (555)555-5555";
            } 
        }   
    }// end phone num validation
    
    public static function addressValidation(){  
        //$username = filter_input(INPUT_POST, 'username');
        if( array_key_exists("address", $_POST) ){
            $address = filter_input(INPUT_POST, 'address');
            
            if( empty($address) ){
                self::$errors["address"] = "*Must include an address";
            }
        }
    }
    
    public static function passwordValidation(){ 
        if( array_key_exists("firstPassword", $_POST) ){
           $firstPassword = filter_input(INPUT_POST, 'firstPassword');
           
           if( empty($firstPassword) ){
                self::$errors["firstPassword"] = "*Must include a password";
                self::$fpassIsThere = false;
            }
            else if( !self::passwordIsValid($_POST["firstPassword"]) ){
                    self::$errors["firstPassword"] = "*Password is invalid";
                    self::$fpassIsThere = false;
            }
        }   
    }// end emailValidation
    
    public static function secondPasswordValidation(){
        if( array_key_exists("secondPassword", $_POST) ){
           $secondPassword = filter_input(INPUT_POST, 'secondPassword');
           $firstPassword = filter_input(INPUT_POST, 'firstPassword');
           
           if( !empty($firstPassword) ){
                if( empty($secondPassword) ){
                     self::$errors["secondPassword"] = "*Must re-enter your password";
                 }
                 else if( self::$fpassIsThere == true ){ 
                     if($secondPassword != $firstPassword){
                     self::$errors["secondPassword"] = "*Passwords do not match";
                     }
                 }
            }
        }//end array key excists
    }
    
/***END registration.php Validations************/ 
    
    
    public static function emailIsValid( $email ) {
       if ( is_string($email) && !empty($email) && preg_match("/[A-Za-z0-9_]{2,}+@[A-Za-z0-9_]{2,}+\.[A-Za-z0-9_]{2,}/", $email) != 0 ) {
           return true;
       }        
       return false; 
    }

    public static function phoneNumIsValid( $phoneNum ) {
       if ( is_string($phoneNum) && preg_match("/((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/", $phoneNum) != 0 ) {
           return true;
       }        
       return false; 
    }

    public static function passwordIsValid( $password ) {
       if ( is_string($password) && preg_match("/^(?=.*\d).{4,8}$/", $password) != 0 ) {
           /*Password must be between 4 and 8 digits long and include at least one numeric digit.*/
           return true;
       }        
       return false; 
    }
    
    //need to find an address regex
    public static function addressIsValid( $address) {
       if ( is_string($address) && preg_match("", $address) != 0 ) {
           return true;
       }        
       return false; 
    }
    
    
   
    
}

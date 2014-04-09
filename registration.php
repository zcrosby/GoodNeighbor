<?php
    include("templates/master.php");
    include("templates/menu.php");
    
    $errors = array();
    $U = new User();
    $util = new Utility();
    $displaySuccessMessage = null;
    
    
    if( count($_POST) ){
        $email = filter_input(INPUT_POST, 'email');
        
        if( $U->emailIsTaken($email) == false){
            
            if(Validator::fieldsAreValid()){
                
                $userWasAdded = $U->addUser();
                if( $userWasAdded ){ 
                  $displaySuccessMessage = true;  
                }
                else{
                    echo '<div id="reg-message" class="error">There was an error with the server, please try again later.</div>';
                }
            }
            else{
              $errors = Validator::getErrors();  
            }
        }
        else{
            $errors["emailTaken"] = "This email is already taken";
        }
        
    }//end count post
    
?>

<div class="grid">
    <div id="welcome-box">
        <div class="col_2"></div>
        <div class="col_8">
            <h3>Why become a member?</h3>
            <ul> 
                <li><i class="icon-chevron-right"></i>Make new friends with your neighbors.</li>
                <li><i class="icon-chevron-right"></i>Depending on one another creates a sustainable community.</li>
                <li><i class="icon-chevron-right"></i>So that everyone can be a good samaritan. </li>  
                <li><i class="icon-chevron-right"></i>Our neighborhoods become safer when we care about each other. </li>
            </ul>
        </div>
        <div class="col_2"></div>
    </div>
<div class="col_12">
    <div class="col_2"></div>
    <div id="reg-form-box" class="col_8" >
        <fieldset>
            <legend>Join Us!</legend>
            <form id="reg-form" name="regForm" action="registration.php" method="post">
                <div id="reg-b1">
                    <label>Name:</label><input type="text" name="name" placeholder="Name" />
                        <?php 
                            if(!empty($errors["name"])){
                                echo '<span class="error">', $errors["name"],'</span>';
                            }
                        ?>

                    <label>Email Address:</label><input type="text" name="email" placeholder="Email Address"/>
                        <?php  
                            if(!empty($errors["email"])){
                                echo '<span class="error">', $errors["email"],'</span>';
                            }
                            else if(!empty($errors["emailTaken"])){
                                echo '<span class="error">', $errors["emailTaken"],'</span>';
                            }
                        ?>

                    <label>Password:</label><input type="password" name="firstPassword" placeholder="Password"/>
                        <?php  
                            if(!empty($errors["firstPassword"])){
                                echo '<span class="error">', $errors["firstPassword"],'</span>';
                            }      
                        ?>

                    <label>Verify Password:</label><input type="password" name="secondPassword" placeholder="Password"/>
                        <?php  
                            if( !empty($errors["secondPassword"]) ){
                                echo '<span class="error">', $errors["secondPassword"],'</span>';
                            }
                        ?>
                </div>
                
                <div id="reg-b2" >
                    <label>Phone Number:</label><input type="text" name="phone" placeholder="Phone Number"/>
                        <?php  
                            if(!empty($errors["phone"])){
                                echo '<span class="error">', $errors["phone"],'</span>';
                            }     
                        ?>

                    <label>Address:</label><input type="text" name="address" placeholder="Address"/>
                        <?php  
                            if(!empty($errors["address"])){
                                echo '<span class="error">', $errors["address"],'</span>';
                            }      
                        ?>

                    <label>Neighborhood:</label>
                    <select id="reg-form-select" class="fancy" name="neighborhood">
                        <option value="">--Neighborhood--</option>
                        <?php
                            $neighbohood = array();
                            $neighbohood = $util->getNeighborhoods();
                            //print_r($neighbohood);
                            foreach($neighbohood as $n){
                                echo '<option value=',$n["neighborhood_id"],'>', $n["neighborhood_name"],'</option>';
                            }
                        ?>
                    </select>
                        <?php
                            if( !empty($errors["neighborhood"]) ){
                                echo '<span class="error">', $errors["neighborhood"],'</span>';
                            }
                        ?>

                    <label>City:</label>
                    <select id="reg-form-select" class="fancy" name="city">
                        <option value="">--City--</option>
                        <?php
                            $city = array();
                            $city = $util->getCities();
                            foreach($city as $c){
                                echo '<option value=',$c["city_id"],'>', $c["city_name"],'</option>';
                            }                                               
                        ?>
                    </select>
                        <?php
                            if( !empty($errors["city"]) ){
                                echo '<span class="error">', $errors["city"],'</span>';
                            }
                        ?>
                    <input type="submit" class="small green" value="Submit" />
                </div><!--END rg-b2 -->  
            </form>
            <?php
                if( isset($displaySuccessMessage) && $displaySuccessMessage == true ){
                    echo '<div id="reg-message" class="success">You were added! Please <a href="index.php">login</a> to view your profile</div>';
                }
            ?>          
        </fieldset>
    </div><!--End reg box form-->
    <div class="col_2"></div>
</div><!--End col 12-->
</div>
       
<?php
    include("templates/footer.php"); 
?>

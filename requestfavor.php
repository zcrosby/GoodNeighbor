
<?php
    include("templates/master.php"); 
    include("templates/loggedInMenu.php");
    
    if( $_SESSION['isLoggedIn'] == true){
        $userID = $_SESSION['UserID'];
        $fav = new Favor();
        $displaySuccessMessage = false;
        
        if(count($_POST)){
            $favorWasAdded = $fav->addNewFavorRequest($userID);
            
            if($favorWasAdded){
                $displaySuccessMessage = true;
            }
            else{
                $errors = $fav->getErrors();
            }
        }
    }
    else{
        header("Location: index.php");
    }
       
?>

<div class="grid">
    <div id="welcome-box">
        <div class="col_2"></div>
        <div class="col_8">
            <h3>Need some help?</h3>
            <p>
                Use this form to place a favor request. 
                Remember you can only have up to 3 open favor at a time.
            </p>
        </div>
        <div class="col_2"></div>
    </div>
    <div id="request-wrap" class="col_12">
        <div class="col_2"></div>
        <div id="request-form" class="col_8">
            <fieldset>
                <legend>Request A Favor</legend>
                <form action="requestfavor.php" method="post">

                    <label>Favor Requested:</label>
                    <select name="FavorType" class="fancy">
                        <option value="">--Select one--</option>
                        <?php
                            $favor = $fav->getFavorTypes();
                            //print_r($favor); //DEBUG
                            foreach($favor as $f){
                                echo '<option value=',$f["favor_type_id"],'>', $f["description"],'</option>';
                            }
                        ?>
                    </select>
                        <?php                            
                            if(!empty($errors["FavorType"])){
                                echo '<span class="error">', $errors["FavorType"],'</span>';
                            }
                        ?>
                    
                    <label>Date of Favor:</label><input type="text" name="Date" id="SelectedDate" readonly onClick="GetDate(this);" placeholder="Date" />
                        <?php  
                            if(!empty($errors["Date"])){
                                echo '<span class="error">', $errors["Date"],'</span>';
                            }     
                        ?>
                    
                    
                    <label>Additional Info:</label><textarea name="FavorDetails" id="additional-info" placeholder="Additional Info?"></textarea>
                    
                    <div class="req-ck">
                        <label>Need Help Now!</label><input name="NeedHelpNow" class="checkBox" type="checkbox" id="nowcheck" />
                        
                        <label>Please Contact Me:</label><input name="WantsContact" class="checkBox" type="checkbox" id="contactcheck" />
                        
                    </div>
                    
                    <?php
                        if(!empty($errors["FavorCount"])){
                            echo '<span class=" error f-count-err">', $errors["FavorCount"],'</span>';
                        }
                    
                        if( isset($displaySuccessMessage) && $displaySuccessMessage == true ){
                            echo '<div class="success request-success">Your favor was added!</div>';
                        }
                    ?> 
                    
                    <input class="large green" type="submit" value="Submit" />
                    
                </form>
            </fieldset>
        </div>
        <div class="col_2"></div>
    </div><!--END request-wrap-->
</div><!--END Grid-->
<?php
    include("templates/footer.php"); 
?>


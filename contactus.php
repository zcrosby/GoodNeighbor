
<?php
   include("templates/master.php");
   
   if( $_SESSION['isLoggedIn'] == true){
        include("templates/loggedInMenu.php");
    }
    else{
        include("templates/menu.php");
    }

?>

<div class="col_12" style="margin-left:70px; position:relative;height:550px; text-align:center;">
    <h4>Please feel free to drop us a line if you want your neighborhood be added 
        to our list, if you have an issue you wish to let us know about, or just to 
        say hello.
    </h4>
    <div class="col_3"></div>
    <div class="col_6">
        <fieldset>
            <legend>Contact Form</legend>

            <div id="contactmain2" style="position:relative; text-align: left;">
                 <input type="text" name="contactname" placeholder="Name" />
                <br/><br/>
                <input type="text" name="contactaddress" placeholder="Address" />
                <br/><br/>
                <input type="text" name="contactphone" placeholder="Phone Number" />
                <br/><br/>
                <input type="text" name="contactemail" placeholder="Email Address" />
                <br/><br/>
                <textarea id="contactmessage" style="width:400px; height:125px;" placeholder="Message"></textarea>
                <br/><br/>
                <input class="large" type="submit"/>

            </div>
        </fieldset>
    </div>
    <div class="col_3"></div>
</div>
<?php
    include("templates/footer.php"); 
?>


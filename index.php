
<?php
    include("templates/master.php");
    include("templates/menu.php");

    $_SESSION['isLoggedIn'] = false; 

    $sess = new Session();
    $U = new User();
    $loginSuccessful = null;

    
   if( count($_POST) ){
        $loginSuccessful = $sess->verifyUser();
        if( $loginSuccessful ){
            header("Location: profile.php"); 
        }
    }

?>

<div class="grid">
<!-- WELCOME TEXT -->
    <div id="welcome-box">
        <div class="col_2"></div>
        <div class="col_8">
            <h3>Welcome to The Good Neighbor Project!</h3>
            <p>
                This site is dedicated to neighbors helping neighbors. Join our site
                to request that little helping hand you might need or to help your fellow
                neighbor in need. if you need a jump on your car a a cup of sugar, login 
                and ask for the favor from your neighbor.
            </p>
        </div>
        <div class="col_2"></div>
    </div>
        
    <div class="col_12" >     

        <div class="col_3"></div>
        <div class="col_6">
            <div id="login-box" >
                <fieldset>
                    <legend><i class="icon-lock"></i></legend>
                    <form action="index.php" method="post">
                        <label>Email:</label>
                        <input id="email" type="text" name="email" placeholder="Email" />
                        <br />
                        <br />
                        <label>Password:</label>
                        <input id="input-password" type="password" name="password" placeholder="Password" />
                        <?php
                            if( count($_POST) ){
                                if( $loginSuccessful == false ){
                                    echo '<span class="lg-notFound">*No login found</span>';
                                }
                            }
                        ?>
                        <input type="submit" class="small green" value="Submit" />
                    </form>
                    <div class="login-extras">
                        <p>Not a member? <a href="registration.php">Register Here</a></p>
                        <br />
                        <p><a href="contactus.php" >Need Help?</a></p>
                    </div>
                </fieldset>
            </div>          
        </div>
        <div class="col_3"></div>
    </div> <!-- end col_12 -->   
</div><!-- end Grid -->

<?php
    include("templates/footer.php"); 
?>
<?php
    include("templates/master.php");
    
    if($_SESSION["isLoggedIn"] == true){
        include("templates/loggedInMenu.php");
    }
    else{
        include("templates/menu.php");
    }
?>


<div class="col_10" style="margin-left:320px; position:relative; width:60%; text-align:left;">
    
    <fieldset>
        <legend>Welcome to The Good Neighbor Project</legend>
        <br/>
        <h5>Zalyndia Crosby and Richard Tapalian are established programmers with advanced
            degrees in software engineering.  They have dedicated their lives to community 
            service and fostering better relationships within the community.  This 
            application was developed with the sole intention of allowing neighbors to 
            reach out to each other and asking for and giving help to those in need.  
            Neighbors used to knock on each others' doors all the time and ask for help
            if they needed it.  In present times, residents are less and less likely to do
            this for a variety of reasons.  This application will give neighbors a tool to
            communicate with each other, and hopefully develop life long friendships and 
            bring back that neighborly relationship that existed in times past.  We hope
            that by helping each other out that they will find out that the little things
            mean alot.  We constantly monitor our site for abuse and want residents that
            sign up to be responsible whether it is requesting or responding to a favor.  
            Our hope is that more and more residents will ask for their neighborhoods to
            be added to our network, and that our communities are once again joined in
            hospitality and friendship.</h5>
            
        </div>
    </fieldset>
<?php
    include("templates/footer.php"); 
?>


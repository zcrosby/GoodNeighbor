<?php
    include("templates/master.php");
    include("templates/menu.php"); 
?>
<div id="registration2" style="position:relative; text-align:center; margin:auto; height:300px;">
    <div class="col_12">
        <h4>Password Retrieval</h4>
        <br/>
        <div id="forgotpassform" style="position:relative; margin:auto; text-align:center; width:25%;">
            <form>
                <label for="text40">Enter Email Address:</label>
                <input id="text1" type="text" name="text40" placeholder="Enter Email Address" />
                <br/><br/>
                <input class="large green" type="submit" text="Submit" />
                <br/>
                <br/>
            </form>
        </div>
    </div>
</div>      
<?php
    include("templates/footer.php"); 
?>

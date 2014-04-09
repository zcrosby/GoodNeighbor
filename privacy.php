<?php
    include("templates/master.php");
    
    if($_SESSION["isLoggedIn"] == true){
        include("templates/loggedInMenu.php");
    }
    else{
        include("templates/menu.php");
    }
?>
<br/>

<div class="col_10" style=" position:relative; width:100%; text-align:left;">
    
    <fieldset>
        <legend>Privacy Statement</legend>
        <br/>
<blockquote class="small">
            <p>
                Your privacy is important to The Good Neighbour Project. <br/>
            This privacy statement provides information about the personal information that The Good Neighbour Project collects,<br/>
            and the ways in which The Good Neighbour Project uses that personal information.<br/><br/>


Personal information collection<br/>

The Good Neighbour Project may collect and use the following kinds of personal information: <br/><br/>
            <ul>
                <li>	Amount of favours requested and responded to.</li>
                <li>	Registration information such as Name, Address, Phone Number, and Email Address</li>
                <li>	Information contained in the favour request page including other information.</li>
                <li>	Any information sent through the Contact Us page to The Good Neighbour Project.</li><br/>
            </ul>
Using personal information<br/>

The Good Neighbour Project may use your personal information to:<br/><br/> 
<ul>
    <li>	Properly administer this website</li>
    <li>	Customize the My Profile page</li>
    <li>	Enable your access to and use of the website services</li>
    <li>	Publish information about you on the website for good deeds done</li>
    <li>	Send you informational emails concerning the website</li>
    <li>	Send you updates on improvements and maintenance of the website</li>
    <li>	Send you policy violation emails and/or cancelation of service</li><br/>
</ul>
Where The Good Neighbour Project discloses your personal information to its agents or sub-contractors for these<br/>
purposes, the agent or sub-contractor in question will be obligated to use that personal information in accordance<br/>
with the terms of this privacy statement. In addition to the disclosures reasonably necessary for the purposes<br/>
identified elsewhere above, The Good Neighbour Project may disclose your personal information to the extent that it<br/>
is required to do so by law, in connection with any legal proceedings or prospective legal proceedings, and in order<br/>
to establish, exercise or defend its legal rights.<br/><br/>

Securing your data<br/>

The Good Neighbour Project will take reasonable technical and organisational precautions to prevent the loss,<br/>
misuse or alteration of your personal information. The Good Neighbour Project will store all the personal information<br/>
you provide on its secure servers. <br/><br/>

All passwords are encrypted with the latest technology for your security.<br/><br/>

The Good Neighbour Project may update this privacy policy by posting a new version on this website.<br/>  
You should check this page occasionally to ensure you are familiar with any changes.  <br/><br/>

Other websites<br/>

This website may contain links to other websites.  <br/>

The Good Neighbour Project is not responsible for the privacy policies or practices of any third party.<br/><br/>

If you have any questions about this privacy policy or The Good Neighbour Project treatment of your personal information, please write:<br/><br/>

	by email to thegoodneighborproject@gmail.com;

</p>         
</blockquote>

            
        </div>
    </fieldset>
<?php
    include("templates/footer.php"); 
?>


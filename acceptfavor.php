<?php
    include("templates/master.php");
    include("templates/loggedInMenu.php");
    
    if( $_SESSION['isLoggedIn'] == true){
        $userID = $_SESSION['UserID'];
        $fav = new Favor();   
    }
    else{
        header("Location: index.php");
    }
      
?>

<div class="grid">
    <div id="welcome-box">
        <div class="col_2"></div>
        <div class="col_8">
            <h3>Ready to give a helping hand?</h3>
            <ul> 
                <li><i class="icon-chevron-right"></i>When accepting a favor, pay attention to the date of the favor.</li>
                <li><i class="icon-chevron-right"></i>View your existing pending favors on your profile page.</li>
            </ul>
        </div>
        <div class="col_2"></div>
    </div>
    <div class="col_12">
        <div class="col_1"></div>
        <div class="col_10" >
            <div id="respond-form">
                <fieldset>
                    <legend>Favor Respond Page</legend>
                    <table class="sortable" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Favor</th>
                                <th>Date of Favor</th>
                                <th>Details</th>
                                <th>I can do that!</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //$openFavorList = array();
                                $openFavorList = $fav->getOpenFavors($userID);
                                foreach($openFavorList as $o){
                                    $date = DateTime::createFromFormat('Y-m-d', $o["date_of_favor"]);
                                    $reformattedDate = $date->format('F j, Y');
                                    
                                    echo '<tr class="accept-favor-row" title="', $o["favor_id"],'">
                                            <td>', $fav->getFavorTypeDescription($o["favor_type_id"]), '</td>
                                            <td>', $reformattedDate, '</td>
                                            <td>', $o["details"], '</td>    
                                            <td><i class="icon-ok-sign action-btns will-fulfill-favor completed-favor" id="', $o["favor_id"],'" title="I will fulfill this favor">Accept</i></td>
                                            <input type="hidden" name="uID" value="',$userID,'" />
                                          </tr>';
                                }
                            ?>
                           
                        </tbody>  
                    </table>       
                </fieldset>
            </div>
        </div>
        <div class="col_1"></div>
    </div>
</div>
<?php
    include("templates/footer.php"); 
?>


<?php
    include("templates/master.php"); 
    include("templates/loggedInMenu.php");

    if( $_SESSION['isLoggedIn'] == true){
        $userID = $_SESSION['UserID'];
        //print_r( $_SESSION); //DEBUG
        $fav = new Favor();
        $U = new User();
    }
    else{
        header("Location: index.php");
    }
        
?>

<div class="grid">
    <div id="welcome-box">
        <div class="col_2"></div>
        <div class="col_8">
            <h3>
                <?php
                        $name = $U->getUserName($userID);
                        echo 'Welcome ', $name, '!';            
                 ?> 
            </h3>
            <ul> 
                <li><i class="icon-chevron-right"></i>View open and pending favors here.</li>
                <li><i class="icon-chevron-right"></i>If you need to cancel any of your favors, see the action links below.</li>
                <li><i class="icon-chevron-right"></i>Remember, you may have only 3 open favors at a time.</li>                
            </ul>
        </div>
        <div class="col_2"></div>
    </div>
    <div class="col_12">
        <div class="col_1"></div>
        <div id="profile-main" class="col_10" >
            <fieldset>
                <legend>Your favors</legend>
                <div class="col_10">
                    <h5>Favors you requested</h5>
                    <table class="sortable" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Favor</th>
                                <th>Date Requested</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $favorRequestList = array();
                                $favorRequestList = $fav->getFavorsUserRequested($userID);
                                //var_dump($favorRequestList);//DEBUG
                                
                                foreach($favorRequestList as $f){
                                    //$date = DateTime::createFromFormat('Y-m-d', $f["date_submitted"]);
                                    $date = new DateTime($f["date_submitted"]);
                                    $reformattedDate = date_format($date, 'g:ia \o\n l jS F Y');
                                    $favID = $f["favor_id"];
                                    $description = $fav->getFavorTypeDescription($f["favor_type_id"]);
                                    $statusType = $fav->displayFavorAsOpenOrPending($f["status"], $favID);
                                    
                                    echo '<tr title="',$f["favor_id"],'" class="favor-request-row" id="',$f["favor_id"], '">
                                            <td>', $description , '</td>
                                            <td>', $reformattedDate , '</td>
                                            <td>', $statusType ,'</td>
                                            <td><i class="icon-remove action-btns delete-favor" id="', $favID ,'" title="Delete this favor"></i> &nbsp &nbsp
                                                <i class="icon-check action-btns completed-favor" id="', $favID ,'" title="Mark as completed"></i></td>
                                            <input type="hidden" name="uID" value="',$userID,'" />
                                         </tr>';
                                }
                                
                            ?>
                        </tbody>
                    </table>
                    <div id="responder-popup"></div>
                </div>

                <br/>
                <div class="col_12">
                    <h5>Pending Promises (your neighbors are counting on you)</h5>
                    <table class="sortable" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Favor</th>
                                <th>Date of Favor</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Details</th>
                                <th>Cannot Complete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $pendingFavorsList = array();
                                $pendingFavorsList = $fav->getPendingFavors($userID);
                                //var_dump($pendingFavorsList);//DEBUG
                                foreach($pendingFavorsList as $p){
                                    $user = $fav->getPendingFavorUserInfo($p["favor_id"]);
                                    $date = DateTime::createFromFormat('Y-m-d', $p["date_of_favor"]);
                                    $reformattedDate = $date->format('F j, Y');
                                    
                                    echo '<tr class="pending-favor-row" title="', $p["favor_id"], '">
                                            <td>', $fav->getFavorTypeDescription($p["favor_type_id"]), '</td>
                                            <td>', $reformattedDate, '</td>
                                            <td>', $user["name"], '</td>
                                            <td>', $user["user_address"], '</td>
                                            <td>', $user["user_phone"], '</td>
                                            <td>',$p["details"], '</td>
                                            <td><i class="icon-remove action-btns cannot-fulfill-favor" id="', $p["favor_id"],'" title="Cannot fulfill this favor"></i></td>
                                            <input type="hidden" name="uID" value="',$userID,'" />
                                         </tr>';
                                }
                            ?>
                        </tbody>
                    </table>

                </div>
             </fieldset>        
        </div>
        <div class="col_1"></div>
    </div>
</div>
   
<?php
    include("templates/footer.php"); 
?>
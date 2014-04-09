
<?php

    //unset($_SESSION['isLoggedIn']);
    //unset($_SESSION['UserID']);

    $_SESSION['isLoggedIn'] = false;
    //$_SESSION['UserID'] = "";

    //session_destroy();
    header("Location: index.php");
/*
	$sd = session_destroy();
    //DEBUG
    if ($sd){
    	header("Location: index.php");
    }
*/    
?>


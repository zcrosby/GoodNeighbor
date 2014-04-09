
$( document ).ready(function() {
/************BEGIN PROFILE.PHP js************************************/
    $(".delete-favor, .cannot-fulfill-favor").hover( function() {
        $( this ).css({
                        "color": "red",
                        "font-size": "21px"
         })}, function() {
          $( this ).css({
                        "color": "#4D99E0",
                        "font-size": "17px"
         })}
    );
    
    $(".completed-favor").hover( function() {
        $( this ).css({
                        "color": "green",
                        "font-size": "21px"
         })}, function() {
          $( this ).css({
                        "color": "#4D99E0",
                        "font-size": "17px"
         })}
    );
    
    $(".pending-responder").hover( function() {
        $( this ).css({
                        "color": "#4D99E0",
                        "font-size": "21px"
         })}, function() {
          $( this ).css({
                        "color": "#1fa67a",
                        "font-size": "17px"
         })}
    );
     
    $(".favor-request-row .delete-favor").click(function() {
      
      var favorID = $(this).attr("id");
      var userID = $(".favor-request-row input:hidden[name=uID]").val();
      var action = "delete";
      var table  = "requested";
      ajaxRequestFavorTable(userID, favorID, table, action);
      
    });//end delete favor.click
    
    $(".favor-request-row .completed-favor").click(function() {        
        var favorID = $(this).attr("id");
        var userID = $(".favor-request-row input:hidden[name=uID]").val();
        var action = "complete";
        var table  = "requested";
        ajaxRequestFavorTable(userID, favorID, table, action);
    });//end complete favor.click
    
    $(".pending-responder").click(function(){
        var favorID = $(this).attr("id");
        var userID = $(".favor-request-row input:hidden[name=uID]").val();
        var action = "getResponderInfo";
        var table  = "requested";
        ajaxRequestFavorTable(userID, favorID, table, action);
    });
    
    $(".pending-favor-row .cannot-fulfill-favor").click(function() {        
        var favorID = $(this).attr("id");
        var userID = $(".pending-favor-row input:hidden[name=uID]").val();
        var action = "cannotFulfill";
        var table  = "pending";
        ajaxRequestFavorTable(userID, favorID, table, action);
    });//end complete favor.click
    /************END PROFILE.PHP js**************************************/
    
    
    
    /************BEGIN ACCEPTFAVOR.PHP js********************************/
    $(".accept-favor-row .will-fulfill-favor").click(function() {       
        var favorID = $(this).attr("id");
        var userID = $(".accept-favor-row input:hidden[name=uID]").val();
        var action = "willFulfill";
        var table  = "respond";
        ajaxRequestFavorTable(userID, favorID, table, action);
       
    });//end complete favor.click
    /************END ACCEPTFAVOR.PHP js***********************************/
    
    
    /************BEGIN AJAX CALL FOR ACCEPTFAVOR.PHP & PROFILE.PHP js*****/
    function ajaxRequestFavorTable(userID, favorID, table, action){
        $.ajax({
            type: "GET",
            url: "handlesDynamics.php",
            data: {userID: userID,
                   favorID: favorID,
                   table: table,
                   action: action
                   }
            }).done(function(d) {                
                if(d == "success"){
                    var row = $("tr[title='" + favorID + "']");
                    row.remove();
                    console.log(d + favorID);
                }
                else if(d == "error"){
                    console.log(d);
                }
                else{
                    //make a pop up of responding user info
                    displayResponderInfo(d)                   
                }
        });//end ajax done
    }//end ajaxRequestFavorTable
    
    function displayResponderInfo(data) {
        
        var d = JSON.parse(data);
        console.log(d);
        var id = d["user_id"];
        var name = d["name"];
        var email = d["user_email"];
        var phone = d["user_phone"];
        
        $("#responder-popup").append("<h5>Responder Info</h5>" + 
                                     "<b>Name: </b>"  + name + "<br />" +
                                     "<b>Email: </b>" + email + "<br />" + 
                                     "<b>Phone: </b>" + phone);  
        //$("#responder-popup").css("display", "inline-block");
        $("#responder-popup").show(1000);
        
       
    }
    
    $("body").click(function(){
        //hide the responder info popup
            $("#responder-popup").empty();
            $("#responder-popup").hide(1000);
    });
            
});//end doc.redy        
        



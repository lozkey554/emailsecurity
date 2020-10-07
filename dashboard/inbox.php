<?php
include "../app.controller/appFunctions.php";
include "redirect.php";

$email = $_SESSION["email"];
$query = $conn->query("SELECT `id` FROM tbl_sentmessages WHERE receiver_email = '$email' AND `operation` = 'unread' AND `status` = 'sent'") or die(mysqli_error($conn));

$query2 = $conn->query("SELECT `id` FROM tbl_sentmessages WHERE receiver_email = '$email' AND `operation` = 'unread' AND `status` = 'spam'") or die(mysqli_error($conn));

$count = 0;
while($row = mysqli_fetch_array($query))
{
    // $rowid = $row["id"];
    $count = $count+1;
}

$count2 = 0;
while($row = mysqli_fetch_array($query2))
{
    // $rowid = $row["id"];
    $count2 = $count2+1;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- bootstarp link -->
   <link rel="stylesheet" href="../class/css/bootstrap.min.css">
   <link rel="stylesheet" href="../class/css/w3.css">
<!-- style style link -->
<!-- <link rel="stylesheet" href="../class/css/main.min.css"> -->
<link rel="stylesheet" href="../class/MDB-Free_4.19.0/css/mdb.min.css">
<link rel="stylesheet" href="../class/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="style.css">


<!-- scripts -->
<!-- <script src="../class/js/jquery.js"></script> -->
<script src="../class/js/header.js"></script>

<style>
    



</style>
</head>
<body>
    
    <!-- light mode -->
        
<!-- Sidebar -->
<!-- mobile -->
<div class="w3-sidebar w3-bar-block w3-border-right" id="mySidebar" style="display:none">
  <button onclick="w3_close()" class="w3-bar-item w3-large"><span class="fa fa-times" style = "float:right;"></span></button>
  <img src="../images/icons/user.png" alt="">  <?php echo $_SESSION["email"];?> <hr>

  <!-- <a href="#" class="w3-bar-item w3-button mt-2"> &nbsp;&nbsp;</a> <hr> -->

  <a href="inbox.php" class="w3-bar-item w3-button active"><img src="../images/icons/Gmail Login_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Inbox <?php if($count !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count; }?></span></a>
  <a href="compose.php" class="w3-bar-item w3-button"><img src="../images/icons/New Message_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Compose </a>
  <a href="sent.php" class="w3-bar-item w3-button"><img src="../images/icons/Feedback_48px.png " alt="" height="20" width="20">&nbsp;&nbsp; Sent Mails</a>
  <a href="draft.php" class="w3-bar-item w3-button"><img src="../images/icons/New Post_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Draft </a>
  
  <a href="spam.php" class="w3-bar-item w3-button"><img src="../images/icons/High Priority_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Spam Mails <?php if($count2 !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count2; }?></span></a>
  <a href="settings.php" class="w3-bar-item w3-button"><img src="../images/icons/Settings_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Settings </a> 
  <a href="../logout.php" class="w3-bar-item w3-button logout"><img src="../images/icons/Shutdown_48px.png" height="20" width="20" alt=""> Logout </a> 

</div>

<!-- desktop -->

<div class="w3-sidebar w3-bar-block w3-border-right" id="hidesidebar">
<img src="../images/icons/user.png" alt=""> <?php echo $_SESSION["email"]; ?> <hr>
  <!-- <a href="#" class="w3-bar-item w3-button mt-2"> &nbsp;&nbsp;</a> <hr> -->
  <a href="#" class="w3-bar-item w3-button active"><img src="../images/icons/Gmail Login_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Inbox <?php if($count !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count; }?></span></a>
  <a href="compose.php" class="w3-bar-item w3-button"><img src="../images/icons/New Message_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Compose </a>
  <a href="sent.php" class="w3-bar-item w3-button"><img src="../images/icons/Feedback_48px.png " alt="" height="20" width="20">&nbsp;&nbsp; Sent Mails </a>
  <a href="draft.php" class="w3-bar-item w3-button"><img src="../images/icons/New Post_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Draft </a>
  
  <a href="spam.php" class="w3-bar-item w3-button"><img src="../images/icons/High Priority_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Spam Mails  <?php if($count2 !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count2; }?></span></a>
  <a href="settings.php" class="w3-bar-item w3-button"><img src="../images/icons/Settings_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Settings </a> 
  <a href="../logout.php" class="w3-bar-item w3-button logout"><img src="../images/icons/Shutdown_48px.png" height="20" width="20" alt=""> Logout </a> 

</div>

<!-- Page Content -->
<!-- mobile -->
<div class="w3">
  <button class="w3-button w3 w3-xlarge" onclick="w3_open()" id="showbars"><span class="fa fa-bars" ></span></button>
  <div class="w3-container">
    <!-- <h4>Welcome <span class="fa fa-wave"></span></h4> -->
  </div>
</div>

<!-- desktop -->
<div class="w3">
    <p class="text-center" style="font-size: 30px;color: white;font-weight: bold;">Inbox</p>
    <div class="" style="float: right;margin-top: -80px;margin-right: 10px;">
        <img src="../images/icons/user.png"  alt="">
        <div class="panel" style="display: none;">
            <ul>
                <a href=""><li><img src="../images/icons/Add User Male_48px.png" height="20" width="20" alt=""> Profile</li></a>
                <a href=""><li> <img src="../images/icons/Shutdown_48px.png" height="20" width="20" alt=""> Logout</li></a>
            </ul>
        </div>
    </div>
    
</div>
<?php if(isset($_SESSION["login_suc"])){?>
        <div class="alert alert-success text-center"><?php echo $_SESSION["login_suc"]; ?></div>
    <?php } ?>
    
<div class="jumbotron">
    <div class="alert alert-danger" id="nomessage" style="display: none;"><img src="../images/icons/Cancel 2_48px.png" alt=""><span style="font-size: 20px;text-align: center;"> Inbox is Empty</div>
        <div>
            <ul id="messages">
            
            </ul>
        </div>
        <audio id="sound" style="display:none;" controls>
        <source src="../insight.mp3" type="audio/mpeg">
        <!-- <source src="../insight.mp3" type="audio/ogg"> -->
    </audio>
</div>


<script src="../class/js/jquery.js"></script>
<script>
   function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
$(document).ready(function(){
    $(".logout").on("click", function(e){
                e.preventDefault();
                var res = confirm('Are you Sure you want to logout?');
                if(res){
                    window.location.href = $(this).attr('href');
                }
                else{
                    return false;
                }
            
     });
    
    $(".alert-success").show().delay(2000).hide().delay(2000);

    // load all inbox messages

    $.ajax({
        url: "../app.controller/appFunctions.php",
        type: "POST",
        data: {"function": "inbox"},
        dataType: "json",
        success: function(tx){
            if(tx.status == 0){
                $("#nomessage").show();
            }
            else if(tx.status == 1){
            let allmessage = [], eachmessage;
            var xx = "";
            tx.subject.forEach((value,key) => {
              
                let eachmessage = `<li class='list'> <span class='send'> ${tx.sender[key]}</span> <a href='viewreceived.php?id=${ tx.id[key] }'> ${value} </a></li>`;
                allmessage.push(eachmessage);                    
            });
            // document.getElementById('sound').play();
            $("#messages").append(allmessage);
            tx.operation.forEach((value,key) => {
            if(tx.operation[key] =="read"){
               
                $(".list").addClass("alert alert-primary");
                
             

                }
                else if(tx.operation[key] == "unread"){
                        
                            $(".list").addClass("alert alert-danger");
                        
                  
                   
                }
            });
            
            }
            
            
        }
    }); 




});


</script>
</body>
</html>
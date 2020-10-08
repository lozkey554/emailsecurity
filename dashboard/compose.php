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
    <title>Compose Mail</title>
    <!-- bootstarp link -->
   <link rel="stylesheet" href="../class/css/bootstrap.min.css">
   <link rel="stylesheet" href="../class/css/w3.css">
<!-- style style link -->
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="../class/MDB-Free_4.19.0/css/mdb.min.css"> 
<link rel="stylesheet" href="../class/font-awesome/css/font-awesome.min.css">


<!-- scripts -->
<script src="../class/js/jquery.js"></script>
<script src="../class/js/header.js"></script>

</head>
<body>
    
    <!-- light mode -->
        
<!-- Sidebar -->
<!-- mobile -->
<!-- <div class="container-fluid"> -->

<div class="w3-sidebar w3-bar-block w3-border-right" id="mySidebar" style="display:none">
  <button onclick="w3_close()" class="w3-bar-item w3-large"><span class="fa fa-times" style = "float:right;"></span></button>
  <img src="../images/icons/user.png" alt=""> <?php echo $_SESSION["email"]; ?> <hr>

  <!-- <a href="#" class="w3-bar-item w3-button mt-2"> &nbsp;&nbsp;</a> <hr> -->
  <a href="inbox.php" class="w3-bar-item w3-button"><img src="../images/icons/Gmail Login_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Inbox  <?php if($count !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count; }?></span></a>
  <a href="compose.php" class="w3-bar-item w3-button active"><img src="../images/icons/New Message_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Compose </a>
  <a href="sent.php" class="w3-bar-item w3-button"><img src="../images/icons/Feedback_48px.png " alt="" height="20" width="20">&nbsp;&nbsp; Sent Mails</a>
  <a href="draft.php" class="w3-bar-item w3-button"><img src="../images/icons/New Post_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Draft</a>
  
  <a href="spam.php" class="w3-bar-item w3-button"><img src="../images/icons/High Priority_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Spam Mails <?php if($count2 !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count2; }?></span></a>
  <a href="settings.php" class="w3-bar-item w3-button"><img src="../images/icons/Settings_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Settings </a> 
  <a href="../logout.php" class="w3-bar-item w3-button logout"><img src="../images/icons/Shutdown_48px.png" height="20" width="20" alt=""> Logout </a> 
</div>

<!-- desktop -->

<div class="w3-sidebar w3-bar-block w3-border-right" id="hidesidebar">
<img src="../images/icons/user.png" alt=""><?php echo $_SESSION["email"]; ?> <hr>
  <!-- <a href="#" class="w3-bar-item w3-button mt-2"> &nbsp;&nbsp;</a> <hr> -->
  <a href="inbox.php" class="w3-bar-item w3-button "><img src="../images/icons/Gmail Login_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Inbox  <?php if($count !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count; }?></span></a>
  <a href="compose.php" class="w3-bar-item w3-button active"><img src="../images/icons/New Message_48px.png" alt="briefcase" height="20" width="20"></span>&nbsp;&nbsp; Compose </a>
  <a href="sent.php" class="w3-bar-item w3-button"><img src="../images/icons/Feedback_48px.png " alt="" height="20" width="20">&nbsp;&nbsp; Sent Mails</a>
  <a href="draft.php" class="w3-bar-item w3-button"><img src="../images/icons/New Post_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Draft</a>
  
  <a href="spam.php" class="w3-bar-item w3-button "><img src="../images/icons/High Priority_48px.png" alt="" height="20" width="20">&nbsp;&nbsp; Spam Mails <?php if($count2 !=0){ ?> <span style="padding:5px; border-radius: 50%;background-color: darkred;color: white;"><?php echo $count2; }?></span></a>
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
    <p class="text-center" id="st" style="font-size: 20px;color: white;font-weight: bold;">Compose Mail</p>
    <div class="" style="float: right;margin-top: -80px;margin-right: 10px;">
        <img src="../images/icons/user.png"  alt="" id="userAccount">
        <div class="panel" style="display: none;">
            <ul>
                <a href=""><li><img src="../images/icons/Add User Male_48px.png" height="20" width="20" alt=""> Profile</li></a>
                <a href=""><li> <img src="../images/icons/Shutdown_48px.png" height="20" width="20" alt=""> Logout</li></a>
            </ul>
        </div>
    </div>
    
</div>

<div class="jumbotron">
    <segun id="main-panel">
        <div class="input-group mb-3">
            <label for="from" style="font-size:18px">From</label>
            <div class="input-group-prepend" style="margin-left: 20px;">
                <span class="input-group-text" id="basic-addon1"><img src="../images/icons/Email_48px.png" alt="" width="20" height="20"></span>
            </div>
            <input type="email" class="form-control" id="senderemail" value="<?php echo $_SESSION["email"]; ?>" aria-label="Email" aria-describedby="basic-addon1" disabled>
        </div><hr>
        <div class="input-group">
            <label for="from" style="font-size:18px">To</label>
            <div class="input-group-prepend" style="margin-left: 20px;">
                <span class="input-group-text" id="basic-addon1"><img src="../images/icons/Email_48px.png" alt="" width="20" height="20"></span>
            </div>
            <input type="email" class="form-control" id="receiveremail" placeholder="Receiver Email Address" aria-label="Email" aria-describedby="basic-addon1" required>
        </div> 
        <p class="alert alert-danger" id="emailinvalid" style="margin-left: 40px;display: none;"></p>

        <hr>
        <div class="input-group">   
            <input type="text" class="form-control" id="subject" placeholder="Subject (optional)" aria-label="Email" aria-describedby="basic-addon1" style="height: 50px;">
        </div>
        <div class="input-group">
            <textarea name="composemail" id="composemail" placeholder="Compose Email" aria-label="Email" aria-describedby="basic-addon1" class="form-control" cols="20" rows="10" style="resize: none;" required></textarea>
        </div>
    <button class="btn btn-danger btn-md" id="draft">Save as Draft <img src="../images/loading51.gif" width="30" height="20" alt="" id="draftloading" style="display: none;"> </button>

    <p style="float:right">
    <button class="btn btn-primary btn-md" id="encrypt"> Encrypt Message <img src="../images/loading51.gif" width="30" height="20" alt="" id="encloading" style="display: none;"> </button>

        <button class="btn btn-success btn-md sendmail"> Send Message <img src="../images/loading51.gif" width="30" height="20" alt="" id="sendloading" style="display: none;"> </button>
    </p>

    <p class="pop" style="font-weight: bold;display: none;text-align: center;"> Message Sent <span class="fa fa-check"></span></p>
    <audio id="sound" style="display:none;" controls>
        <source src="../insight.mp3" type="audio/mpeg">
        
    </audio>

</segun>
<div class="enc-panel" style="display:none;">
    <label for="encryption-key">Enter a Key to secure Message</label>
    <input type="text" name="enc-key" id="enc-key" placeholder="enter key here" class="form-control" value="" style="width: 50%;">
    <button class="btn btn-success btn-md" id="enc-message"> Send Message <img src="../images/loading51.gif" width="30" height="20" alt="" id="eloading" style="display: none;"> </button>
    <p class="text-danger">Note down this key and send it to the recepient to decrypt the message</p>
</div>
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

    $("#encrypt").on("click", function(){
    var rm = $("#receiveremail").val();
    var message = $("#composemail").val();
    if(rm == ""){
        alert("Enter Receiver Email");

        } 
        else if(message == ""){
        alert("Enter Message");
        }
    else{
        $("#main-panel").hide();
        $(".enc-panel").show();
    }
    
});
    
$("#enc-message").on("click", function(){
    var rm = $("#receiveremail").val();
    var sm = $("#senderemail").val();
    var message = $("#composemail").val();
    var key = $("#enc-key").val();
    var sub = $("#subject").val();

    var array = [sm, rm, sub, message, key];

    if(key == ""){
        alert("You must provide a key");
    }
    else{
        $.ajax({
            url: "../app.controller/appFunctions.php",
            type: "POST",
            beforeSend: function(){
                $("#eloading").show().delay(1000);
            },
            data: {
                "function": "encrypt",
                "array": array
            },
            success: function(){
                $("#eloading").hide(function(){
                document.getElementById("sound").play();

            });
            }
        });

    }
    
});

    $(".sendmail").on("click", function(){
        var sm = $("#senderemail").val();
        var rm = $("#receiveremail").val();
        var key = $("#enc-key").val();
        var sub = $("#subject").val();
        var message = $("#composemail").val();

        var array = [sm, rm, sub, message, key];

        if(rm == ""){
        alert("Enter Receiver Email");

        } 
        else if(message == ""){
        alert("Enter Message");
        }
        else{
        $.ajax({
            url: "../app.controller/appFunctions.php",
            type: "POST",
            beforeSend: function(){
                $("#sendloading").show();
            },
            cache: false,
            data: {
                "function": "composemail",
                "array": array
            },
            dataType: "json",
            success: function(tx){
                if(tx.code == 1){
                    $(".pop").show(function(){
                        $("#sendloading").hide();
                        document.getElementById("sound").play();
                        
                    });
                    
                }
                else if(tx.code == 2){
                    $("#emailinvalid").html("Email is not found").show(function(){
                        $("#sendloading").hide(1000);
                       
                    });
                }
            }
              
        });
        }
    });

    // draft 


    $("#draft").on("click", function(){
      
        var message = $("#composemail").val();
        
        if(message == ""){
            alert("Enter to Message");
        }

        else{
            $.ajax({
            url: "../app.controller/appFunctions.php",
            type: "POST",
            beforeSend: function(){
                $("#draftloading").show().delay(1000);
            },
            dataType: "json",
            data: {
                "function": "draft",
                "message": message
            },
            success: function(tx){
                console.log(tx.status);
                if(tx.status == 0){
                    $("#draftloading").hide(function(){
                    alert("Message not Saved");
                });
                }
                else if(tx.status == 1){
                $("#draftloading").hide(function(){
                    document.getElementById("sound").play();
                    alert("Message Saved Successful");


                });
                }
            }
        });
        }


    });

});




</script>
</body>
</html>
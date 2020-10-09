<?php
    include "../app.controller/appFunctions.php";
 include "redirect.php";
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mbs - view</title>
    <link rel="stylesheet" href="../class/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        body{
            background-color: lightgrey;
        }
        #light{
            font-weight: lighter;
            font-size: 14px;
            color: #7952B3;   
        }
        .jumbotron{
            margin: auto;
            width: 50%;
            height: fit-content;
            background-color: white;
        }

        @media screen and (max-width:992px)
{
    .jumbotron{
    margin: auto;
    width: 80%;
    margin-top: 60px;
    height: fit-content;
}

}

/* responsiveness */
@media screen and (max-width:992px)
{
.jumbotron{
    margin: auto;
    width: 80%;
    margin-top: 60px;
    height: fit-content;
}
}

@media screen and (max-width:320px)
{
.jumbotron{
    margin: auto;
    width: 90%;
    margin-top: 60px;

}
}

@media screen and (max-width:414px)
{
.jumbotron{
    margin: auto;
    width: 80%;
    margin-top: 30px;

}
}

@media screen and (max-width:360px)
{
.jumbotron{
    margin: auto;
    width: 80%;
    margin-top: 20px;
}

}

@media screen and (max-width:375px)
{
.jumbotron{
    margin: auto;
    width: 90%;
    margin-top: 50px;
}

}

@media screen and (max-width:280px)
{
.jumbotron{
    margin: auto;
    width: 90%;
    margin-top: 20px;
}

}
    </style>
</head>
<body>
    <?php
    date_default_timezone_set("Africa/Lagos");

    if(isset($_GET["id"])){
        $gtid = $_GET["id"];
        $query = $conn->query("SELECT * FROM tbl_draft WHERE id = '$gtid'") or die(mysqli_error($conn));
        $draft = mysqli_fetch_assoc($query);
        $message = $draft["messages"];

        $date = $draft["date_saved"];
        $exdate = explode("-",$date);
        $regmonth = $exdate[1];

        $regday = $exdate[2];
        
        $realdate = date("Y-m-d");
        $exrealdate = explode("-",$realdate);
        $realmonth = $exrealdate[1];
   

        $monthago = $realmonth - $regmonth;
        $realday = $exrealdate[2];
        $dayago = $realday-$regday;
       
        
        if($dayago == 0){
            $dayago = "Today";
        }
        elseif($dayago < 30 && $monthago == 0)
        {
            $dayago = $dayago." days ago";
        }
        elseif($dayago < 30 && $monthago > 0){
            $dayago = $monthago." months ago";
        }
    //     elseif($dayago > 30 && $monthago < 0)
    //     print_r($exdate);
    //    $draft = fetchdetails($gtid);
        
        
       
    }   
    ?>
    <div class="jumbotron">
        
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-sm" href="draft.php"> Back <span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="btn btn-danger btn-sm delete" href="deletedraft.php?id=<?php echo $gtid;?>" style="float: right;"> Delete </a>
            </div>
        
            <div class="col-md-12 mt-4">
                
                <p style="font-size: 18px;font-weight: bold;"> <span style="font-size:18px;"><?php echo $draft["user_id"]; ?> </span> <span style="font-size:14px; font-weight: lighter;"><?php echo $dayago; ?></span> <button class="btn btn-secondary btn-sm" id="reply" name="reply" style="float: right;"> Send </button> </p> <hr>
            </div>
               <div class="col-md-12 hide-message" style="width: fit-content;">
                <?php echo $message; ?>
            </div>
        </div>


        <div class="input-group" id="response" style="display: none;">
            
                <div class="col-sm-7 mt-4" id="messageview">
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


                <input type="text" class="form-control" id="subject" placeholder="Subject (optional)" aria-label="Email" aria-describedby="basic-addon1" style="height: 50px;">
                    <textarea name="composemail" id="composemail" placeholder="Reply Message" aria-label="Email" aria-describedby="basic-addon1" class="form-control" cols="5" rows="10" style="resize: none;" required> <?php echo $message; ?></textarea>
                
                    <p style="float:right">
                    <button class="btn btn-primary btn-md" id="encrypt"> Encrypt Message <img src="../images/loading51.gif" width="30" height="20" alt="" id="encloading" style="display: none;"> </button>
                    <button class="btn btn-success btn-md sendmail"> Send Message <img src="../images/loading51.gif" width="30" height="20" alt="" id="sendloading" style="display: none;"> </button></p>
                    <audio id="sound" style="display:none;" controls>
                        <source src="../insight.mp3" type="audio/mpeg">
        
                    </audio>
                </div>

                <div class="enc-panel" style="display:none;">
                    <label for="encryption-key">Enter a Key to secure Message</label>
                    <input type="text" name="enc-key" id="enc-key" placeholder="enter key here" class="form-control" value="" style="width: 50%;">
                    <button class="btn btn-success btn-md" id="enc-message"> Send Message <img src="../images/loading51.gif" width="30" height="20" alt="" id="eloading" style="display: none;"> </button>
                    <p class="text-danger">Note down this key and send it to the recepient to decrypt the message</p>
                </div>
            
        </div>



            
    </div>

    <script src="../class/js/jquery.js"></script>

    <script>
        $(document).ready(function(){
            $(".delete").on("click", function(e){
                e.preventDefault();
                var res = confirm('Are you Sure you want to delete this Mail?');
                if(res){
                    window.location.href = $(this).attr('href');
                }
                else{
                    return false;
                }
            
            });


            $("#reply").on("click", function(e){
                e.preventDefault();
                $("#response").show();
                $(".hide-message").hide();
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
                $("#messageview").hide();
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
                data: {
                    "function": "composemail",
                    "array": array
                },
                dataType: "json",
                beforeSend: function(){
                 
                 $("#sendloading").show().delay(1000);
             },
                success: function(tx){
                    if(tx.code == 1){
                        $("#sendloading").hide(function(){
                            document.getElementById("sound").play();
                        });
                    }
                        else if(tx.code == 2)
                        {
                            $("#emailinvalid").html("Email is not found").show(function(){
                            $("#sendloading").hide(1000);
                       
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
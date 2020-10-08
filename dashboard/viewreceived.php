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
    height: 600px;
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

        
        $row = fetchdetails($gtid);
        $date = $row["dateSent"];
        $exdate = explode("-",$date);
        $regmonth = $exdate[1];
        // echo $regmonth;
        $regday = $exdate[2];
        
        $realdate = date("Y-m-d");
        $exrealdate = explode("-",$realdate);
        $realmonth = $exrealdate[1];
        // echo $realmonth;

        $monthago = $realmonth - $regmonth;
        $realday = $exrealdate[2];
        $dayago = $realday-$regday;
        // echo $monthago;
        
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
        // elseif($dayago > 30 && $monthago < 0)
        // print_r($exdate);
        $sender = $row["sender_id"];
        $query = $conn->query("SELECT * FROM tbl_user WHERE email = '$sender'") or die(mysqli_error($conn));
        $data = mysqli_fetch_array($query);
        
        $upd = $conn->query("UPDATE tbl_sentmessages SET operation = 'read' WHERE id = '$gtid'") or die(mysqli_error($conn));
        
    }
if(isset($_POST["decrypt"])){
    echo $_POST["dec-key"];
}
    ?>
    <div class="jumbotron">
        <?php
            if($row['key'] != ''){ ?>
            
                <!-- <form action="" method="post"> -->

                
                <div class="row" id="show">
                    <label for="decryption key">Enter Decryption key here to view this message</label>
                    <input type="text" class="form-control" placeholder="enter decryption key here" value="" name="dec-key" id="dec-key">
                    <input type="text" id="dec-message" value="<?php echo $row["messages"]; ?>" hidden>
                    <button class="bt btn-primary mt-3" name="decrypt" id="decrypt">Decrypt Message</button>
                </div>
               
                <!-- after decryption -->
        <div class="row hide" style="display:none">
            <div class="col-md-12">
                <a class="btn btn-primary btn-sm" href="inbox.php"> Back <span class="glyphicon glyphicon-chevron-left"></span></a>
               
                <a class="btn btn-danger btn-sm delete" href="deletereceived.php?id=<?php echo $gtid;?>" style="float:right;"> Delete </a>
            </div>
            <div class="col-md-12 mt-4">
                <h4><?php echo $row["subject"]; ?></h4>
                <p style="font-size: 18px;font-weight: bold;"><?php echo strtoupper($data["fullname"]);?> <span style="font-size: 14px;"> <?php echo $data["email"]; ?></span> <span id = "light"> <?php echo $dayago; ?></span> <button class="btn btn-secondary btn-sm" id="reply" name="reply" style="float: right;"> Reply </button> </p> <hr>
            </div>
               <div class="col-md-12" id="newMessage" style="width: fit-content;"></div>
        </div>
                <!-- </form> -->
            <?php }
        else{
        ?>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-sm" href="inbox.php"> Back <span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="btn btn-danger btn-sm delete" href="deletereceived.php?id=<?php echo $gtid;?>" style="float:right;"> Delete </a>
            </div>
        
            <div class="col-md-12 mt-4">
                <h4><?php echo $row["subject"]; ?></h4>
                <p style="font-size: 18px;font-weight: bold;"><?php echo strtoupper($data["fullname"]);?> <span style="font-size: 14px;"> <?php echo $data["email"]; ?></span> <span id = "light"> <?php echo $dayago; ?></span> <button class="btn btn-secondary btn-sm" id="reply" name="reply" style="float: right;"> Reply </button>  </p> <hr>
            </div>
               <div class="col-md-12" style="width: fit-content;">
                <?php echo $row["messages"]; ?>
            </div>
        </div>
        <?php } ?>
        


        <div class="input-group" id="response" style="display: none;">
            
                <div class="col-sm-7 mt-4" id="messageview">
                <input type="text" class="form-control" id="subject" placeholder="Subject (optional)" aria-label="Email" aria-describedby="basic-addon1" style="height: 50px;">
                    <textarea name="composemail" id="composemail" placeholder="Reply Message" aria-label="Email" aria-describedby="basic-addon1" class="form-control" cols="5" rows="10" style="resize: none;" required></textarea>
                <input type="text" value="<?php echo $_SESSION["email"]; ?>" id="from_me" style="display: none;">
                <input type="text" value="<?php echo $data["email"]; ?>" id="to" style="display: none;">
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
            });


        $("#encrypt").on("click", function(){
            var rm = $("#to").val();
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

            $("#decrypt").on("click", function(e){
                // e.preventDefault();
                var key = $("#dec-key").val();
                var message = $("#dec-message").val();
                // console.log(message);
                var senddata = [key, message];
                if(key == ""){
                    alert("Enter Key");
                }
                else{
                    $.ajax({
                        url: "../app.controller/appFunctions.php",
                        type: "POST",
                        cache: false,
                        dataType: "json",
                        data: {
                            "function": "decrypt",
                            "data": senddata
                        },
                        success: function(tx)
                        {
                           var newMessage = tx.decryptedMessage;

                           if(newMessage == false)
                           {
                               alert("Key is not correct");
                           }
                           else{
                                $("#show").hide();
                                $(".hide").show(function(){
                                    $("#newMessage").html(newMessage);
                                });
                           }
                           
                        }
                    });
                }

            });
            
            $("#enc-message").on("click", function(){
                var rm = $("#to").val();
                var sm = $("#from_me").val();
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
                            document.getElementsById("sound").play();

                        });
                        }
                    });

                }
    
});

    $(".sendmail").on("click", function(){
        var sm = $("#from_me").val();
        var rm = $("#to").val();
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
                    // alert(0);
                    $("#sendloading").show().delay(1000);
                },
                data: {
                    "function": "composemail",
                    "array": array
                },
                // dataType: "json",
                success: function(tx){
                
                    $("#sendloading").hide(function(){
               
                        document.getElementById("sound").play();
                    
                });

                }
                
            });
        }
    });

            

    });
    
    </script>
</body>
</html>
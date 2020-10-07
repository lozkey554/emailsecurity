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
            height: 500px;
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
    height: 600px;
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
        
        $sender = $row["sender_id"];
        $query = $conn->query("SELECT * FROM tbl_user WHERE email = '$sender'") or die(mysqli_error($conn));
        $data = mysqli_fetch_array($query);
        
        $upd = $conn->query("UPDATE tbl_sentmessages SET operation = 'read' WHERE id = '$gtid'") or die(mysqli_error($conn));
        

          
    }


    ?>
    <div class="jumbotron">
        <?php
            if($row['key'] != ''){ ?>
            
                <div class="row" id="show">
                    <label for="decryption key">Enter Decryption key here to view this message</label>
                    <input type="text" class="form-control" placeholder="enter decryption key here" value="" name="dec-key" id="dec-key">
                    <input type="text" id="dec-message" value="<?php echo $row["messages"]; ?>" hidden>
                    <button class="bt btn-primary mt-3" name="decrypt" id="decrypt">Decrypt Message</button>
                </div>

                <!-- after decryption -->
        <div class="row hide" style="display:none">
            <div class="col-md-12">
                <a class="btn btn-primary btn-sm" href="spam.php"> Back <span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="btn btn-danger btn-sm delete" href="deletereceived.php?id=<?php echo $gtid;?>" style="float:right;"> Delete </a>
            </div>
        
            <div class="col-md-12 mt-4">
                <h4><?php echo $row["subject"]; ?></h4>
                <p style="font-size: 18px;font-weight: bold;"><?php echo strtoupper($data["fullname"]);?> <span id = "light"> <?php echo $dayago; ?></span> </p><hr>
            </div>
               <div class="col-md-12" id="newMessage" style="width: fit-content;">
                
            </div>
        </div>
            <?php }
        else{
        ?>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-sm" href="spam.php"> Back <span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="btn btn-danger btn-sm delete" href="deletereceived.php?id=<?php echo $gtid;?>" style="float:right;"> Delete </a>
            </div>
        
            <div class="col-md-12 mt-4">
                <h4><?php echo $row["subject"]; ?></h4>
                <p style="font-size: 18px;font-weight: bold;"><?php echo strtoupper($data["fullname"]);?> <span style="font-size: 14px;"> <?php echo $data["email"]; ?></span> <span id = "light"> <?php echo $dayago; ?></span>  </p> <hr>
            </div>
               <div class="col-md-12" style="width: fit-content;">
                <?php 
                // check restrcited string
                $mess = $row["messages"];
                filter_content($mess);
          
               ?>
            </div>
        </div>
        <?php } ?>
        
            
    </div>

    <script src="../class/js/jquery.js"></script>

    <script>

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
            

        $(document).ready(function(){

            $("#decrypt").on("click", function(){
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
        
            

        });
    
    </script>
</body>
</html>
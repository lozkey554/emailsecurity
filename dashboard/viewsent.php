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

        $upd = $conn->query("UPDATE tbl_sentmessages SET operation = 'read' WHERE id = '$gtid'") or die(mysqli_error($conn));
        
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
        $receiver_email = $row["receiver_email"];
        $query = $conn->query("SELECT * FROM tbl_user WHERE email = '$receiver_email'") or die(mysqli_error($conn));
        $data = mysqli_fetch_array($query);
        $message = $row["messages"];
        
        $key = $row["key"];
        if(!empty($key)){
        $encryption_key = base64_decode($key);
        list($encryption_data, $iv) = array_pad(explode("::", base64_decode($message), 2),2, null);
        $message = openssl_decrypt($encryption_data, "aes-256-cbc", $encryption_key, 0, $iv);
        }
    }   
    ?>
    <div class="jumbotron">
        
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-sm" href="sent.php"> Back <span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="btn btn-danger btn-sm delete" href="deletesent.php?id=<?php echo $gtid;?>" style="float: right;"> Delete </a>
            </div>
        
            <div class="col-md-12 mt-4">
                <h4><?php echo $row["subject"]; ?></h4>
                <p style="font-size: 18px;font-weight: bold;">To: <?php echo strtoupper($data["fullname"]);?> <span id = "light"><?php echo $dayago; ?></span> <span style="font-size:14px;"><?php echo $data["email"]; ?> </span></p> <hr>
            </div>
               <div class="col-md-12" style="width: fit-content;">
                <?php echo $message; ?>
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
            

        });
    
    </script>
</body>
</html>
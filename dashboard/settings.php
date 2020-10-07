<?php
    include "../app.controller/appFunctions.php";
    include "redirect.php";
    

    if(isset($_POST["updateProfile"])){
        $name = $_POST['fullname'];
        $email = $_SESSION["email"];
        $dob = $_POST['dob'];
        $phoneno = $_POST['phoneno'];
       
      $upd = $conn->query("UPDATE tbl_user SET `fullname` = '$name', `phoneNo` = '$phoneno', `dob` = '$dob' WHERE `email` = '$email'") or die(mysqli_error($conn));

        if($upd){ 
            ?>
         <script>
        alert('Profile Changed Successful');
       </script>
    <?php 
          }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mbs - Account</title>
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
            /* height: 750px; */
            height: max-content;
            background-color: white;
            overflow-y: scroll;
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
    
    <div class="jumbotron">
        <?php

        $user = $_SESSION['email'];
            $sel = $conn->query("SELECT * FROM tbl_user WHERE `email` = '$user'") or die(mysqli_error($conn));
            $userdata = mysqli_fetch_assoc($sel);

    ?>
                <h4 class="text-success">My Account</h4>
        <div class="panel1">
            <table class="table table-responsive" style="border: none;">
                <tr>
                    <td>Name</td>
                    <td> <?php echo strtoupper($userdata['fullname']); ?> </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td> <?php echo $userdata['email']; ?> </td>
                </tr>
                <tr>
                    <td>Phone No.</td>
                    <td><?php echo $userdata['phoneNo']; ?></td>
                </tr>
                <tr>
                    <td>DOB</td>
                    <td><?php echo $userdata['dob']; ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><?php echo $userdata['gender']; ?></td>
                </tr>
                <tr>
                
                    <td><a href="inbox.php"> <button class="btn btn-info btn-sm" id="">Back</button> </a> </td>
                    <td><button class="btn btn-primary btn-sm" id="editProfile">Edit Profile</button> </td>
                </tr>
                
            </table>
        </div>
           
            <div class="panel2" style="display: none;">
            <table class="table table-responsive" style="border: none;">
            <form action="" method="POST">
                <tr>
                    <td>Name</td>
                    <td> <input type="text" name="fullname" class="form-control" value="<?php echo $userdata["fullname"]; ?>"> </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td> <input type="text" name="mail" class="form-control" value="<?php echo $userdata["email"]; ?>" disabled> </td>
                </tr>
                <tr>
                    <td>Phone No.</td>
                    <td><input type="text" name="phoneno" class="form-control" value="<?php echo $userdata["phoneNo"]; ?>"></td>
                </tr>
                <tr>
                    <td>DOB</td>
                    <td>
                        <input type="date" name="dob" class="form-control" value="<?php echo $userdata["dob"]; ?>">
                    </td>
                </tr>
                
                <tr>
                    <td><button class="btn btn-info btn-sm" id="back">Back </button></td>
                    <td><button class="btn btn-success btn-sm" name="updateProfile" id="editProfile">Update Profile</button> </td>
                </tr>
            </form>
            </table>

            </div>
        
    </div>

    <script src="../class/js/jquery.js"></script>

    <script>
        $(document).ready(function(){
            $("#editProfile").on("click", function(e){
               $(".panel1").hide();
               $(".panel2").show();
            });

            $("#back").on("click", function(e){
               $(".panel1").show();
               $(".panel2").hide();

            
            });
            

        });
    
    </script>
</body>
</html>
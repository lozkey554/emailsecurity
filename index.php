<?php
    include "app.controller/appFunctions.php";

   



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mbs - index</title>
    <link rel="stylesheet" href="class/css/bootstrap.min.css">
    <link rel="stylesheet" href="class/main_style.css">
    <style>
        .up{
            margin-top: -30px;;
        }
    </style>
</head>
<body>
    <div class="jumbotron">
        <?php if(isset($_SESSION["passchange"])){
            $message = $_SESSION['passchange'];
            echo "<div class = 'alert alert-success text-center up'> $message </div>"; 
        }
        unset($_SESSION["passchange"]);
            ?>
        <div class="text-center" style="font-weight: bold;">LOGIN</div>
        <!-- <div class="alert alert-info push text-center"> USER LOGIN</div> -->
        <div class="logo text-center"> <img src="images/icons/user.png" alt="" ></div>
       
        <div class="alert alert-danger text-center" id="message" style="display: none;"></div>
      
            <div class="form-input">
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Businessman_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="text" class="form-control" id="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                </div>
                
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Lock_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="password" class="form-control" id="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mt-4">
                    <button class="btn btn-block btn-info" id="login"> Login Now &nbsp;&nbsp; <img src="images/loading51.gif" id="loader" height="30" width="30" alt="" style="display: none;"></button>
                </div>
                <div class="input-group mt-4">
                    <h5 class="h5"> Not a Member yet? </h5> <a href="register.php"><span class="span"> Create an account</span></a>
                    <a href="recover.php" id="resetPass"><p class="text-center span">Forget Password?</p></a>
                </div>
            </div>
            <div class="alert alert-warning" style="font-size:12px;color:#838D99">By Sign in or Signup to mbs.com, you are agreeing to our <span>Terms of Use</span> and <span> Privacy Policy</span></div>
    </div>


    <script src="class/js/jquery.js"></script>

<script>
    $(document).ready(function(){
        $("#loader").bind("ajaxStart", function(){
            $(this).show();
        }).bind("ajaxStop", function(){
            $(this).hide();
        });
      
        function verifyinput($input){
            $input.on("blur", function(){
                if($input.val() == ""){
                
                    $("#message").html("All fields are required").slideDown(1000).slideUp(1000);
                }
            });
        }

        $("#login").on("click",function(e){
            
            e.preventDefault();
            var email = $("#email").val();
            var password = $("#password").val();

            var info = [email, password];

            if(email == "" || password == "" )
            {
                $("#message").html("All fields are required").slideDown(1000).slideUp(2000);
            }
            else{
                $.ajax({
                    type: "post",
                    url: "app.controller/appFunctions.php",
                    cache: false,
                    dataType: 'json',
                    data: {
                        "function": "login",
                        "data": info
                    },
                    beforeSend: function() {
                        $("#loader").show().delay(2000);
                    },
                    
                    success: function(tx){
                    let status = tx.status;
                    
                    // console.log(status);
                    if(status == 1)
                    {
                       
                        window.location.href ='dashboard/inbox.php'; 
  
                    }
                    else if(status == 2)
                    {
                        window.location.href ='complete-reg.php';
                    }
                    else if(status == 0)
                    {
                        $("#message").html("Username or Password incorrect, Try Again!!").slideDown(2000, function(){
                                $("#loader").hide().delay(2000);
                        });
                    }

                }

                });

                
            }
        });

        verifyinput($("#email"));
        verifyinput($("#password"));
       
        });
</script>
</body>
</html>
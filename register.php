<?php
    include "app.controller/appFunctions.php";
//  include "app.controller/redirect.php";

    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mbs - Register</title>
    <link rel="stylesheet" href="class/css/bootstrap.min.css">
    <link rel="stylesheet" href="class/main_style.css">
    <style>
   
    </style>
</head>
<body>
    <div class="jumbotron">
        <div class="text-center" style="margin-top: -20px;font-weight: bold;">REGISTER</div>
        <!-- <div class="alert alert-info push text-center"> USER LOGIN</div> -->
        <div class="logo text-center"> <img src="images/icons/user.png" alt="" ></div>
        <div class="alert alert-danger text-center" id="message" style="display: none;"></div>

        <form action="" method="post">
            <div class="form-input">
            <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Businessman_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="text" class="form-control" id="fullname" placeholder="Full Name" aria-label="fullname" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Email_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="text" class="form-control" id="email" placeholder="Email Address" aria-label="Email" aria-describedby="basic-addon1" required>
                </div>
                
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Lock_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="password" class="form-control" id="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Lock_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="password" class="form-control" id="cPassword" placeholder="Retype Password" aria-label="Retype Password" aria-describedby="basic-addon1" required>
                </div>


                <div class="input-group mt-4">
                    <button class="btn btn-block btn-info" id="register">Register Now</button>
                </div>
                <div class="input-group mt-4">
                    <h5 class="h5">Already have a Account? </h5> <a href="index.php"><span class="span"> Login Now</span></a>
                   
                </div>
            </div>
        </form>
            <div class="alert alert-warning" style="font-size:12px;color:#838D99"> By Sign in or Signup to mbs.com, you are agreeing to our <span>Terms of Use</span> and <span> Privacy Policy</span></div>
    </div>

    <script src="class/js/jquery.js"></script>

    <script>
        $(document).ready(function(){

            function verifyinput($input){
                $input.on("blur", function(){
                    if($input.val() == ""){
                       
                        $("#message").html("All fields are required").slideDown(1000).slideUp(1000);
                    }
                });
            }
            $("#register").on("click",function(e){
                e.preventDefault();
                var fullname = $("#fullname").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var cPassword = $("#cPassword").val();
                var info = [fullname, email, password, cPassword];
                if(password != cPassword)
                {
                    $("#message").html("Password does not match").slideDown(1000).slideUp(1000);
                }
                else{

                    $.ajax({
                        type: "post",
                        url: "app.controller/appFunctions.php",
                        dataType: 'json',
                        data: {
                            "function": "register",
                            "data": info
                        },
                        success: function(tx){
                            let status = tx.status;
                            if(status == 1){
                                window.location.href ='complete-reg.php';
                            }
                            else if(status == 0)
                            {
                                $("#message").html("Email Address Already registered").slideDown(2000).slideUp(2000);
                            }
                        }
                    });

                    
                }
            });

            verifyinput($("#fullname"));
            verifyinput($("#email"));
            verifyinput($("#password"));
            verifyinput($("#cPassword"));

        });
    
    </script>
</body>
</html>
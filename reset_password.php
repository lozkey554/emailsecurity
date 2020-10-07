<?php
    include "app.controller/appFunctions.php";
//  include "app.controller/redirect.php";

    if(isset($_POST["reset"]))
    {
    
    $ar = array($_POST["newPassword"],$_POST["retypePassword"], $_SESSION['email']);
        reset_password($ar);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mbs - Reset Password</title>
    <link rel="stylesheet" href="class/css/bootstrap.min.css">
    <link rel="stylesheet" href="class/main_style.css">
    <style>
  
    </style>
</head>
<body>
    <div class="jumbotron">
        <div class="text-center" style="margin-top: -30px;font-weight: bold;">RECOVER PASSWORD</div>
        <!-- <div class="alert alert-info push text-center"> USER LOGIN</div> -->
        <div class="logo text-center"> <img src="images/icons/Key_48px.png" alt="" height="30" width="30" ></div>
        
        <?php if(isset($_SESSION['changemessage'])){?>
            <div class="alert alert-danger text-center" id="message"><?php echo $_SESSION['changemessage']; ?></div>
        <?php } unset($_SESSION["changemessage"]);?>
      <form action="" method="POST">
            <div class="form-input">
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Password_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="password" class="form-control" name="newPassword" placeholder="New Password" required aria-label="email" aria-describedby="basic-addon1">
                </div>

                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Password_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="password" class="form-control" name="retypePassword" placeholder="Retype Paasword" required aria-label="email" aria-describedby="basic-addon1">
                </div>
                
                <div class="input-group" style="margin-top: 50px;">
                    <button class="btn btn-block btn-success" name="reset" id="submit"> Reset </button>
                </div>
                
            </div>
        </form>
    </div>
</body>
</html>
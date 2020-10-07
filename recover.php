<?php
    include "app.controller/appFunctions.php";
 include "app.controller/redirect.php";

    // check if user already completed registration


    if(isset($_POST["submit"]))
    {
        check_email_exist($_POST["email"]);
    }
    


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
  
    </style>
</head>
<body>
    <div class="jumbotron">
        <div class="text-center" style="margin-top: -30px;font-weight: bold;">RECOVER PASSWORD</div>
        <!-- <div class="alert alert-info push text-center"> USER LOGIN</div> -->
        <div class="logo text-center"> <img src="images/icons/user.png" alt="" ></div>
        <?php if(isset($_SESSION['message'])){?>
        <div class="alert alert-danger text-center" id="message"><?php echo $_SESSION['message']; ?></div>
        <?php } unset($_SESSION["message"]); ?>
      <form action="" method="POST">
            <div class="form-input">
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Email_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="email" class="form-control" name="email" placeholder="Email" required aria-label="email" aria-describedby="basic-addon1">
                </div>
                
                <div class="input-group" style="margin-top: 50px;">
                    <button class="btn btn-primary btn-block" id="submit" name="submit"> Submit</button>
                </div>
                
            </div>
      </form>
    </div>
</body>
</html>
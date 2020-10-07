<?php
    include "app.controller/appFunctions.php";
    // include "app.controller/redirect.php";


    $email = $_SESSION["email"];

    $query = $conn->query("SELECT * FROM tbl_user WHERE email = '$email'") or die(mysqli_error($conn));
    $row = mysqli_fetch_array($query);
    $question = $row["security_question"];
    if(empty($question)){
        header("Location: complete-reg.php");
    }
    
    else{
        $dbanswer = strtoupper($row["security_answer"]);
        
        if(isset($_POST["response"])){
            $answer = clean_string($conn, $_POST["answer"]);
            // $answer = strtoupper($answer);
            if($answer != $dbanswer){
                $message = "Answer is not correct, check if it is in Uppercase";
            }
            else{
                header("Location: reset_password.php");
            }
        }
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
        <div class="text-center" style="margin-top: -30px;font-weight: bold;"> SECURITY QUESTION </div>
        <!-- <div class="alert alert-info push text-center"> USER LOGIN</div> -->
        <div class="logo text-center"> <img src="images/icons/Key_48px.png" alt="" width="30" height="30"></div>
    <?php if(isset($message)){?> 
    <div class="alert alert-danger text-center" id="message"><?php echo $message; ?></div>
    <?php } unset($message); ?>

        <form action="" method="POST">
            <div class="form-input">
                <span style="font-weight: bold;">Question:</span> <?php echo $question; ?>
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><img src="images/icons/Key_48px.png" alt="" width="20" height="20"></span>
                    </div>
                    <input type="text" class="form-control" name="answer" placeholder="Enter Answer" required aria-label="Answer" aria-describedby="basic-addon1">
                </div>
                <div class="alert alert-info text-center">Answer must be in Uppercase All through</div>
                <div class="input-group" style="margin-top: 50px;">
                    <button class="btn btn-block btn-primary" id="submit" name="response"> Submit </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
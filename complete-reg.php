<?php
    include "app.controller/appFunctions.php";
 include "app.controller/redirect.php";

    // session_start();
    
    
        //  print_r($_SESSION["email"]);
    

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
        <div class="text-center" style="margin-top: -30px;font-weight: bold;text-transform: uppercase;">Complete Registration</div>
        <!-- <div class="alert alert-info push text-center"> USER LOGIN</div> -->
        <div class="logo text-center"> <img src="images/icons/user.png" alt="" ></div>
            <?php 
                if(isset($_SESSION["success"])){
                    $success = $_SESSION["success"];
                    echo "<div class = 'alert alert-success text-center'> $success </div>";
                }
                unset($_SESSION["success"]);
            ?>
        <div class="alert alert-danger text-center" id="message" style="display: none;"></div>
            <form action="">
                <div class="form-input">
                    <div class="input-group mb-3 mt-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><img src="images/icons/Phone_48px.png" alt="" width="20" height="20"></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Link Phone No." aria-label="Phone Number" id="phoneNo" maxlength="11" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group mb-3 mt-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><img src="images/icons/user.png" alt="" width="20" height="20"></span>
                        </div>
                        <select name="" class="form-control" id="gender" required>
                            <option value="" selected>--Gender--</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="input-group mb-3 mt-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><img src="images/icons/Calendar.png" alt="" width="20" height="20"></span>
                        </div>
                        <input type="date" class="form-control" placeholder="DOB" aria-label="dateofbirth" aria-describedby="basic-addon1" id="dob" required>
                    </div>

                    <div class="alert alert-primary" style="font-size:14px;"> Select Security Question & Answers for Password recovery</div>
                    <div class="input-group mb-3">
                        <select name="" class="form-control" id="security" required>
                            <option value="" selected disabled> -- Select Question --</option>
                            <option value="What is the name of your favorite childhood friend?"> What is the name of your favorite childhood friend? </option>
                            <option value="Where were you when you had your first kiss?">Where were you when you had your first kiss?</option>
                            <option value="What is the first name of the boy or girl that you first kissed?"> What is the first name of the boy or girl that you first kissed?</option>
                            <option value="In what year was your mother born?">In what year was your mother born?</option>
                            <option value="What is the title of your favorite song?">What is the title of your favorite song?</option>
                            <option value="What is the title of your favorite book?">What is the title of your favorite book?</option>
                            <option value="In what city were you born?">In what city were you born?</option>
                            <option value="What was the first movie you saw in the theater?">Wha was the first movie you saw in the theater?</option>
                            <option value="Where did you meet your Spouse?">Where did you meet your Spouse?</option>
                            <option value="What was your grandfather`s occupation?">What was your grandfather`s occupation?</option>
                            <option value="What was your grandmother`s occupation?">What was your grandmother`s occupation?</option>
                        </select>
                    </div>
                    <input type="text" value="<?php echo $_SESSION['email']; ?>" id="email" hidden>
                        <input type="text" class="form-control" placeholder="Security Answer" aria-label="Security Answer" aria-describedby="basic-addon1" id="answer" required>
                    <div class="input-group mt-4">
                        <button class="btn btn-block" id="submit" style="background-color:#FF7043"> Submit</button>
                    </div>
                </div>
            </form>
               
            <div class="alert alert-warning mt-4" style="font-size:12px;color:#838D99">By Sign in or Signup to mbs.com, you are agreeing to our <span>Terms of Use</span> and <span> Privacy Policy</span></div>
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

            $("#submit").on("click",function(e){
                
                e.preventDefault();
                var phoneNo = $("#phoneNo").val();
                var gender = $("#gender").val();
                var dob = $("#dob").val();
                var security_question = $("#security").val();
                var security_answer = $("#answer").val();
                var useremail = $("#email").val();

                var info = [phoneNo, gender, dob, security_question, security_answer, useremail];

                if(phoneNo == "" || gender == "" || dob == "" || security_question == "" || security_answer == "")
                {
                    $("#message").html("All fields are required").slideDown(1000).slideUp(2000);
                }
                else{
                    $.ajax({
                        type: "post",
                        url: "app.controller/appFunctions.php",
                        dataType: 'json',
                        data: {
                            "function": "complete_reg",
                            "data": info
                        },
                        success: function(tx){
                            let status = tx.status;
                            console.log(status);
                            if(status == 1){
                                window.location.href ='dashboard/inbox.php';
                            }
                            else if(status == 0)
                            {
                                $("#message").html("Registration Not Successful, Try Again!!").slideDown(2000);
                            }
                        }
                    });

                    
                }
            });

            verifyinput($("#phoneNo"));
            verifyinput($("#gender"));
            verifyinput($("#dob"));
            verifyinput($("#security"));
            verifyinput($("#answer"));

            });
    </script>
</body>
</html>
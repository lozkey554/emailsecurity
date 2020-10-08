<?php
    include "connect.php";
    // error_reporting(1);
    session_start();
  
    $app = new DBConnect;
    $conn=$app->connect();

    if(isset($_POST["function"]))
    {
        $function = $_POST["function"];
        // echo $function

        switch($function){
            case "register":
                echo (new user)->register();
            break;
            case "complete_reg":
                echo (new user)->complete_reg();
            break;
            case "login":
                echo (new user)->userlogin();
            break;
            case "composemail":
                echo (new mail)->composemail();
            break;
            case "inbox":
                echo (new mail)->inboxmail();
            break;
            case "spam":
                echo (new mail)->spam();
            break;
            case "allsent":
                echo (new mail)->sentmail();
            break;
            case "encrypt":
                echo (new mail)->encrypt();
            break;
            case "draft":
                echo (new mail)->draft();
            break;
            case "alldraft":
                echo (new mail)->draftmail();
            break;
            case "decrypt":
                echo (new mail)->decrypt();
            break;
            }
    }


function clean_string($conn,$string){
    return mysqli_real_escape_string($conn, $string);
}

function checkUser($email){
    global $conn;
    return $conn->query("SELECT email FROM tbl_user WHERE email = '$email'");
}

class user{
        
    function register()
    {

        global $conn;
        $data = $_POST["data"];
        $fullname = clean_string($conn, $data[0]);
        $email = clean_string($conn, $data[1]);
        $password = clean_string($conn, $data[2]);
        $cPassword = clean_string($conn, $data[3]);

        if(empty($fullname) || empty($email) || empty($password) || empty($cPassword))
        {
            $status = 2;
        }
        else
        {
            $sel = checkUser($email);
            if(mysqli_num_rows($sel) > 0)
            {
                $status = 0;
            }
            else{
                $qry = $conn->query("INSERT INTO tbl_user(fullname, email, pass, registration) VALUES('$fullname', '$email', '$password','not completed')");
                if($qry){
                    $_SESSION = array("success"=>"You are almost done, Kindly Complete Your Registration", "email"=>$email);
                    $status = 1;

                }
            }
        }
    
        return json_encode(['status'=>$status]);
    
    }

    function complete_reg()
    {
        global $conn;

        $gtdata = $_POST['data'];
        // print_r($gtdata);
        $phoneNo = clean_string($conn,$gtdata[0]);
        $gender = clean_string($conn,$gtdata[1]);
        $dob = clean_string($conn,$gtdata[2]);
        $security = clean_string($conn,$gtdata[3]);
        $answer = clean_string($conn,$gtdata[4]);
        $email = clean_string($conn,$gtdata[5]);
        
        $status = '';
        if(!empty($phoneNo) || !empty($gender) || !(empty($dob) || !empty($security) || !empty($answer)))
        {
            $qry = $conn->query("UPDATE tbl_user SET `phoneNo` = '$phoneNo', `gender` = '$gender', `dob`= '$dob', `security_question`='$security', `security_answer` = '$answer', `registration` = 'completed' WHERE `email` = '$email'") or die(mysqli_error($conn));

            if($qry)
            {
                $_SESSION["reg_succ"] = "Your Registration is Successful";
                $status = 1;
            }
            else{
                $status = 0;
            }
        }

        return json_encode(['status'=>$status]);
    }

    function userlogin(){
        global $conn;

        $data = $_POST["data"];
        // print_r($data);

        $email = clean_string($conn,$data[0]);
        $password = clean_string($conn,$data[1]);

        $sel = $conn->query("SELECT `email`,`pass`,`registration` FROM tbl_user WHERE email = '$email' AND `pass` = '$password'") or die(mysqli_error($conn));

        if(mysqli_num_rows($sel) > 0)
        {
            $row = mysqli_fetch_assoc($sel);
            $regStatus = $row["registration"];
            if($regStatus == "completed")
            {
                $_SESSION["login_suc"] = "Login Successful!!!";
                $_SESSION["email"] = $email; 
                $status = 1;
            }
            elseif($regStatus == "not completed"){

                $_SESSION["email"] = $email;  
                $status = 2;
            }
            
        }
        else{
            $status = 0;

        }
        return json_encode(['status'=>$status]);
    }
    }

    // CLass user ends here

function check_email_exist($email){
    global $conn;
    $email = clean_string($conn, $email);
    // check if email exist

    $query = $conn->query("SELECT * FROM tbl_user WHERE email = '$email'") or die(mysqli_error($conn));
    if(mysqli_num_rows($query) > 0){        

        $_SESSION["email"] = $email;
        header("location:security.php");
        
    }
    else{
        $_SESSION['message'] = "Email does not exist";
    }

}

function reset_password($array){
    global $conn;
    $np = $array[0];
    $rp = $array[1];
    $em = $array[2];
    
    if($np == $rp){
        $query = $conn->query("UPDATE tbl_user SET pass = '$np' WHERE email = '$em'") or die(mysqli_error($conn));
        if($query){ 
            
            $_SESSION["passchange"]="Password changed Successful";
            header('Location: index.php');  
            }
    
        }
    else{
        $_SESSION['changemessage'] = 'Password does not match';
    }

    }

    function decrypt($message, $key)
    {
        $encryption_key = base64_decode($key);
        list($encryption_data, $iv) = array_pad(explode("::", base64_decode($message), 2),2, null);
        return openssl_decrypt($encryption_data, "aes-256-cbc", $encryption_key, 0, $iv);
    }


// class mail starts here
class mail{

    function encrypt(){
        global $conn;    
        $array = $_POST["array"];
        $sender = $array[0];
        $receiver = $array[1];
        $subject = $array[2];
        $message = $array[3];
        $key = $array[4];
        $key = hash("md5",$key);
    
        $status = "";
        $headers = "";
        
        if(empty($subject)){
            $subject = "No Subject";
        }
        if(!empty($receiver) && !empty($message && !empty($key))){
    
            // Check if receiver email exist
    
            $chk = checkUser($receiver);
            if(mysqli_num_rows($chk) > 0){
                $printmes = "";
                // check restricted string
                $k = '';
                $sel = $conn->query("SELECT * FROM tbl_restricted");
                while($res = mysqli_fetch_array($sel)){
                    $k .= $res['words'].',';
                    $ex = explode(',',$k);
                }
                $expMessage = explode(' ',$message);
                $gtres = "";
                    foreach ($expMessage as $msg) {
                        foreach($ex as $x){
                            $xe = $x;
                            if($xe == $msg){
                                                
                                $msg =  $xe;
                                $gtres .= $xe.",";
                                $expres = explode(",",$gtres);
                                $expres = array_filter($expres);
                                            
                            }
                    }
                        $printmes .= $msg." ";
                    
                }
                // echo $printmes;
                $count = count($expres);
                // echo $count;
                if($count > 5)
                {
                    $status = "spam";
                }
                else{
                    $status = "sent";
                }

                    // $headers .= "Content-type: text/html;\r\n";
                    // $headers .= "From: $sender";
                    // mail($receiver, $subject, $message, $headers);

                    $encryption_key = base64_decode($key);
                    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
                    $encrypted = openssl_encrypt($message, "aes-256-cbc", $encryption_key,0,$iv);
                    $encrypted_message = base64_encode($encrypted.'::'.$iv);
    
                    $query = $conn->query("INSERT INTO tbl_sentmessages(`sender_id`, `receiver_email`, `subject`, `messages`, `key`, `status`,`operation`) VALUES('$sender', '$receiver', '$subject', '$encrypted_message', '$key', '$status','unread')") or die(mysqli_error($conn));
                    
                    if($query && $status == "sent"){
                        $code = 1;
                    }
                    else{   
                    //  sent not successful
                        $code = 0;
                    }
                }
            else{
            
                // email not found
                $code = 2;
            }
        
        }
            return json_encode(["status"=>$status, "code"=>$code]);
    }
        function decrypt(){
            $data = $_POST["data"];
            $key = hash("md5", $data[0]);
            $message = $data[1];

            $encryption_key = base64_decode($key);
            list($encryption_data, $iv) = array_pad(explode("::", base64_decode($message), 2),2, null);
            $decryptedMessage = openssl_decrypt($encryption_data, "aes-256-cbc", $encryption_key, 0, $iv);
            
            return json_encode(["decryptedMessage"=>$decryptedMessage]);
        }
            
    function composemail(){
        global $conn;
        $array = $_POST["array"];
        $sender = $array[0];
        $receiver = $array[1];
        $subject = $array[2];
        $message = $array[3];
        $key = $array[4];
        $key = hash("md5",$key);

        $status = "";
        $headers = "";
       
        if(empty($subject)){
            $subject = "No Subject";
        }
        if(!empty($receiver) || !empty($message)){

            // Check if receiver email exist

            $chk = checkUser($receiver);
            if(mysqli_num_rows($chk) > 0){
                $printmes = "";
                // check restricted string
                $k = '';
                $sel = $conn->query("SELECT * FROM tbl_restricted");
                while($res = mysqli_fetch_array($sel)){
                    $k .= $res['words'].',';
                    $ex = explode(',',$k);
                }
                $expMessage = explode(' ',$message);
                $gtres = "";
                    foreach ($expMessage as $msg) {
                        foreach($ex as $x){
                            $xe = $x;
                            if($xe == $msg){        
                                $msg =  $xe;
                                $gtres .= $xe.",";
                                $expres = explode(",",$gtres);
                                $expres = array_filter($expres);        
                            }
                    }
                        $printmes .= $msg." ";
                }
                $count = count($expres);
                if($count > 5)
                {
                    $status = "spam";
                }
                else{
                    $status = "sent";
                }
                    $query = $conn->query("INSERT INTO tbl_sentmessages(`sender_id`, `receiver_email`, `subject`, `messages`, `status`,`operation`) VALUES('$sender', '$receiver', '$subject', '$printmes', '$status','unread')") or die(mysqli_error($conn));

                    // $headers .= "Content-type: text/html;\r\n";
                    // $headers .= "From: $sender";
                    // mail($receiver, $subject, $message, $headers);
                    if($query){
                        $code = 1;
                     }
                    
            }
            else{
            
                // email not found
                $code = 2;
            }
            
        }
            // return json_encode(["code"=>$code]);
        
    }
            
    function draft(){
        global $conn;
        $message = clean_string($conn,$_POST["message"]);
        $user_id = $_SESSION["email"];
        $query = $conn->query("INSERT INTO tbl_draft(`user_id`, `messages`) VALUES('$user_id','$message')") or die(mysqli_error($conn));
        
        if($query){
            $status = 1;
        }
        else{
            $status = 0;
        }

        return json_encode(["status"=>$status]);
    }

    function draftmail(){
        global $conn;
        $email = $_SESSION["email"];
        $query = $conn->query("SELECT * FROM tbl_draft WHERE user_id = '$email' ORDER BY id DESC") or die(mysqli_error($conn));
        
        $draft = [];
        $id = [];
        $date = [];
        $status = "";
        if(mysqli_num_rows($query) == 0){
            $status = 0;
        }
        else{
            $status = 1;
            while($row = mysqli_fetch_array($query)){
            $draft[] .= $row["messages"];
            $date[] = $row["date_saved"];
            $id[] .= $row["id"];
        }
    }
        return json_encode(["status"=>$status,"id"=>$id,"date"=>$date,"draftmail"=>$draft]);
    }
    function inboxmail(){
        global $conn;
        $email = $_SESSION["email"];
        $query = $conn->query("SELECT * FROM tbl_sentmessages WHERE receiver_email = '$email' AND `status` = 'sent' ORDER BY id DESC") or die(mysqli_error($conn));
        
        $inbox = [];
        $id = [];
        $sender = [];
        $subject = [];
        $status = "";
        $operation = [];
        if(mysqli_num_rows($query) == 0){
            $status = 0;
        }
        else{
            $status = 1;

            while($row = mysqli_fetch_array($query)){
            $inbox[] .= $row["messages"];
            $sender[] .= $row["sender_id"];
            $subject[] .= $row["subject"];
            $operation[] .= $row["operation"];
            $id[] .= $row["id"];
            
        }
    }
            return json_encode(["status"=>$status,"id"=>$id,"sender"=>$sender,"subject"=>$subject,"inbox"=>$inbox,"operation"=>$operation]);
    }

        
    function spam(){
        global $conn;
        $email = $_SESSION["email"];
        $query = $conn->query("SELECT * FROM tbl_sentmessages WHERE receiver_email = '$email' AND `status` = 'spam' ORDER BY id DESC") or die(mysqli_error($conn));

        $inbox = [];
        $id = [];
        $sender = [];
        $subject = [];
        $status = "";
        if(mysqli_num_rows($query) == 0){
            $status = 0;
        }
        else{
            $status = 1;
            while($row = mysqli_fetch_array($query)){
            $inbox[] .= $row["messages"];
            $sender[] .= $row["sender_id"];
            $subject[] .= $row["subject"];
            $id[] .= $row["id"];
        }
        }
            return json_encode(["status"=>$status,"id"=>$id,"sender"=>$sender,"subject"=>$subject,"inbox"=>$inbox]);
    }


    function sentmail(){
        global $conn;
        $email = $_SESSION["email"];
        $query = $conn->query("SELECT * FROM tbl_sentmessages WHERE sender_id = '$email' ORDER BY id DESC") or die(mysqli_error($conn));
        
        $inbox = [];
        $id = [];
        $sender = [];
        $subject = [];
        $status = "";
        if(mysqli_num_rows($query) == 0){
            $status = 0;
        }
        else{
            $status = 1;
            while($row = mysqli_fetch_array($query)){
            $inbox[] .= $row["messages"];
            $sender[] .= $row["sender_id"];
            $subject[] .= $row["subject"];
            $id[] .= $row["id"];
        }
    }
        return json_encode(["status"=>$status,"id"=>$id,"sender"=>$sender,"subject"=>$subject,"inbox"=>$inbox]);
}
}


function fetchdetails($id){
    global $conn;
    $query = $conn->query("SELECT * FROM tbl_sentmessages WHERE id = '$id'") or die(mysqli_error($conn));
    return mysqli_fetch_array($query);
    // echo $row["messages"];

}

function filter_content($message){
    global $conn;

    $sel = $conn->query("SELECT * FROM tbl_restricted");
    $s = "";
    while($res = mysqli_fetch_array($sel)){
        $s .= $res['words'].',';
        $explodech = explode(',',$s);
    }


    $ex = explode(" ", $message);
    foreach ($ex as $expo) {
        foreach ($explodech as $ch) {
            $ch = $ch;
            if($expo == $ch){

            $expo = "<span style='color:red'> $ch </span>";    
        }

    }
        echo $expo.' ';
    }
}

    
?>
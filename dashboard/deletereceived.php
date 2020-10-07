<?php
    include '../app.controller/connect.php';
    $app = new DBConnect;
    $conn=$app->connect();

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $del = mysqli_query($conn,"DELETE FROM `tbl_sentmessages` WHERE `id` = '$id'") or die(mysqli_error($conn));?>
        <script>
            window.location.href = "inbox.php";
        </script>
        <?php 
                    
      }
    
?>
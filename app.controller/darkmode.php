<?php

    session_start();
    $function = $_POST["function"];

    if($function == "darkmode")
    {
        echo (new mode)->darkmode();
    }

        class mode{
            function darkmode(){
                $_SESSION["darkmode"] = "Enabled";
                $mode = $_SESSION["darkmode"];
                // echo $mode;
            
            return json_encode(["darkmode"=> $mode]);

        }
    }

?>
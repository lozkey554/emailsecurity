<?php

    class DBConnect{
        private $HOST = "localhost";
        private $USER = "root";
        private $PASS = "";
        private $DBNAME = "email_checker";
        public $conn;

        function connect()
        {
            try {
                $conn = @mysqli_connect($this->HOST, $this->USER, $this->PASS,$this->DBNAME);
                if(!$conn) throw new Exception("Server not found", 1);
                else return $conn;
                
            } catch (Exception $th) {
                die($th->getMessage());
            }
        }
    }



?>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$databaseHost = "localhost"; 
$databaseName = "";
$dbusername = "";
$dbpassword = "";

         $conn = new mysqli($databaseHost, $dbusername, $dbpassword, $databaseName);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            

        $seva = $_POST['donation-category'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $amount = $_POST['amount'];
        $pan = $_POST['pan'];
        $message = $_POST['message'];


            $sql = "INSERT INTO `donations`(`name`, `phone`, 'email',  `pan`, `amount`, `seva`, `message`) VALUES ('$name','$phone','$email','$pan','$amount','$seva','$message')";


        if ($conn->query($sql) === TRUE) {
            echo "
            <form id='redirectForm' action='payment-methods.php' method='POST'>
                <input type='hidden' name='amount' value='{$amount}'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>
            ";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }


?>
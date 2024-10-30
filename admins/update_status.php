<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Set timezone and error logging settings
date_default_timezone_set('Asia/Kolkata');
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
error_reporting(E_ALL);

// Database connection configuration
$databaseHost = "localhost";
$databaseName = "   ";
$dbusername = "   ";
$password = "   ";

try {
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $dbusername, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    handleError($e->getMessage());
}

// Error handling function
function handleError($error) {
    error_log("Error: " . $error); // Log error for debugging
    echo json_encode(["success" => false, "error" => $error]); // Return error message for modal
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Input sanitization
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $action = ($_POST['action'] === 'approve') ? 1 : 2;
    $timestamp = date("Y-m-d H:i:s");

    if (!$id) {
        handleError("ID is missing or invalid.");
    }

    // Prepare the update query
    $stmt = $conn->prepare("UPDATE donations SET approved = :action, lastActionTimestamp = :timestamp WHERE id = :id");
    $stmt->bindParam(':action', $action, PDO::PARAM_INT);
    $stmt->bindParam(':timestamp', $timestamp);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            // Send email if approved
            if ($action === 1) {
                $donorEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); 
                $donorName = htmlspecialchars($_POST['name'], ENT_QUOTES);
                $donorAmount = htmlspecialchars($_POST['amount'], ENT_QUOTES);
                sendApprovalEmail($donorEmail, $donorName, $donorAmount);
            }
            echo json_encode(["success" => true]);
        } else {
            handleError("Database update failed.");
        }
    } catch (PDOException $e) {
        handleError($e->getMessage());
    }
}

function sendApprovalEmail($email, $name, $amount) {
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'services@srividyacharities.org';
        $mail->Password   = '  ';  
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Set email content
        $mail->setFrom('services@srividyacharities.org', 'Srividya Charities');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = "Thank You! Your Generosity is Making a Difference";
        if (isset($name) && isset($amount)) {
             $mail->Body = "Namaste $name,<br><br>
                 Your generosity shines! We are deeply grateful for your donation of INR $amount, which will go a long way in supporting our mission. Your contribution isn't just a number; it’s a step towards a brighter future for our community.<br><br>
                 Thank you for being a part of this journey with us.<br><br>
                 With Regards,<br>
                 Srividya Charities Trust";
         } else {
             $mail->Body = "Namaste,<br><br>Your generosity shines! We are deeply grateful for your donation, which will go a long way in supporting our mission. Your contribution isn't just a number; it’s a step towards a brighter future for our community.<br><br>
                 Thank you for being a part of this journey with us.<br><br>
                 With Regards,<br>Srividya Charities Trust";
         }

         
        // Send the email
        $mail->send();
    } catch (PHPMailer\PHPMailer\Exception $e) {
        error_log("Email could not be sent. Mailer Error: " . $mail->ErrorInfo);
        handleError("Failed to send email notification.");
    }
}

<?php

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $databaseHost = "localhost";
    $databaseName = "";
    $dbusername = "";
    $dbpassword = "";

    try {
        $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $id = $_POST['id'];
        $action = $_POST['action'];
        $status = ($action === 'approve') ? 1 : 2; // 1 for approved, 2 for disapproved
        
        $stmt = $conn->prepare("UPDATE donations SET approved = ? WHERE id = ?");
        $result = $stmt->execute([$status, $id]);
        
        echo json_encode(['success' => $result]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
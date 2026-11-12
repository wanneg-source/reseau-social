<?php
declare(strict_types = 1);
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once 'db.php';
$id = $_GET['id'];
if(!isset($_SESSION['user_id'])){
    header("Location: connexion.php");
    exit;
}
    $stmt = $conn->prepare("DELETE FROM taches WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute(); 
    header("Location: dashboard.php");
    exit;
?>
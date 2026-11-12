<?php
declare(strict_types = 1);
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once 'db.php';
session_destroy();
header("Location: connexion.php");
exit;
?>




 
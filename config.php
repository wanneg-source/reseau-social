<?php
if (php_sapi_name() !== 'cli') {
    session_start();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

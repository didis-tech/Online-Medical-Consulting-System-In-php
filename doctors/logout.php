<?php
session_start();
unset($_SESSION['doc_login']);
unset($_SESSION['doc_id']);
header("location: ../doctors-signin.php")
?>

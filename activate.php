<?php
require 'resources/db_connect.php';
if (!isset($_GET["id"])) {
echo "<script>window.location='index.php';</script>";
}else {
  $cmrid=$_GET['id'];
  /* Form Required Field Validation */
  $sqlskns="UPDATE users set p_status='active' WHERE p_id='". $cmrid ."'";
  $result = $conn->query($sqlskns);
  if ($result) {
      echo "<script>alert('Your account has been activated successfully');window.location='index.php';</script>";
      }
}


 ?>

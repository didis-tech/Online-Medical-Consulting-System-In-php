<?php
session_start();
  require '../resources/db_connect.php';
  require '../resources/fetch.php';
if (isset($_GET['c_id'])) {
  $c_id=$_GET['c_id'];
$getCmpt=$conn ->query("SELECT * FROM `complaints` where c_id=$c_id");
  $cmpt=$getCmpt->fetch_assoc();
  $my_name=$firstname.' '.$lastname;
  $d_id=$cmpt['d_id'];

  $conn->query("INSERT INTO `activities`(`p_id`, `d_id`, `p_noti`, `d_noti`)
  VALUE('$id','$d_id','You updated your complaint','$my_name has responded to your questions')");
header("location: complaints.php");
} else {
  header("location: complaints.php");
}
 ?>

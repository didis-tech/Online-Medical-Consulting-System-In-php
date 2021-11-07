<?php
if (isset($_GET['user_id'])) {
	$id = $_GET['user_id'];
}else {
	$id = $_SESSION['user_id'];
}
$sql = "SELECT * FROM `users` where p_id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
  while($row = $result->fetch_assoc()) {
  $firstname = $row['p_firstname'];
  $lastname = $row['p_lastname'];
  $email = $row['p_email'];
  $phone = $row['p_tel'];
  $state = $row['p_state'];
  $lga = $row['p_lga'];
  $address = $row['p_address'];
  $adp = $row['p_dp'];
  $DoB = $row['p_dob'];
  $dp = "assets/img/$adp";
  $status = $row['p_status'];
$date = $row['p_time_created'];
$stored_password=$row['p_password'];
}}

$today = new DateTime();
$birthdate = new DateTime("$DoB");
$age = $today->diff($birthdate);


function trim_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function trimphoneno($data)
{
  $data= explode('-',$data);
  $data=$data[0].''.$data[1].''.$data[2];
  $data= explode('(',$data);
  $data=$data[0].''.$data[1];
  $data= explode(')',$data);
  $data=$data[0].''.$data[1];
  $data= explode(' ',$data);
  $data=$data[0].''.$data[1];
  return $data;
}
$parentDir=explode('/',$_SERVER['REQUEST_URI'])[1];
$actual_link = "http://$_SERVER[HTTP_HOST]/$parentDir/";
 ?>

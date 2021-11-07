<?php

$id = $_SESSION['doc_id'];
$sql = "SELECT * FROM doctors where doc_id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
  while($row = $result->fetch_assoc()) {
  $doc_id = $_SESSION['doc_id'];
  $doc_name = $row['doc_name'];
  $doc_email = $row['doc_email'];
  $doc_phone = $row['doc_tel'];
  $doc_address = $row['doc_address'];
  $doc_state = $row['doc_state'];
  $doc_dpt = $row['doc_dept'];
  $doc_role = $row['doc_role'];
  $doc_adp = $row['doc_dp'];
  $doc_dp = "assets/img/$doc_adp";
$doc_date = $row['doc_created_at'];
$doc_stored_password=$row['doc_password'];
}}
$DeptQry = $conn->query("SELECT * FROM departments where dept_id = '$doc_dpt'");
$dept = $DeptQry->fetch_assoc();
$doc_dept = $dept['dept_name'];

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

function getAge( $DoB)
{
  $today = new DateTime();
  $birthdate = new DateTime("$DoB");
  $age = $today->diff($birthdate);
  return $age;
}

$parentDir=explode('/',$_SERVER['REQUEST_URI'])[1];
$actual_link = "http://$_SERVER[HTTP_HOST]/$parentDir/";

<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

require 'fetch-doctor.php';

$newname = isset($_POST['name']) ? $_POST['name'] : "";
$newstate = isset($_POST['state']) ? $_POST['state'] : "";
$newemail = isset($_POST['email']) ? $_POST['email'] : "";
$newphone = isset($_POST['tel']) ? $_POST['tel'] : "";
$newaddress = isset($_POST['address']) ? $_POST['address'] : "";

/* Email Validation */
	if(!isset($message)) {
	if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
	$responses = array(
    'message' => 'Invalid Email, Please put a valid E-mail address',
    'type' => 'warning',
    'icon' => 'fa-bell',
    'title' => 'Sorry'
  );
	$message = "danger";
	}
	}
	if($newemail!==$doc_email) {
	if(!isset($message)) {
    $query = $conn->query("SELECT DISTINCT * FROM `doctors` WHERE doc_email = '" . $newemail . "'");
    $count = $query->num_rows;
    if($count!=0) {
		$message = "User Email is already in use.";
		$responses = array(
		'message' => 'User Email is already in use.',
		'type' => 'warning',
		'icon' => 'fa-bell',
		'title' => 'Sorry'
  );
		}
	}}
	if($newphone!==$doc_phone) {
	if(!isset($message)) {
    $query = $conn->query("SELECT DISTINCT * FROM `doctors` WHERE doc_tel = '" . $newphone . "'");
    $count = $query->num_rows;
    if($count!=0) {
		$message = "phone number is already in use.";
		$responses = array(
		'message' => 'Phone number is already in use.',
		'type' => 'warning',
		'icon' => 'fa-bell',
		'title' => 'Sorry'
  );
		}
	}}

 if(!isset($message)) {
	$query = "UPDATE doctors
        	SET
        	doc_name 	= '$newname',
        	doc_tel = '$newphone',
        	doc_email 	= '$newemail',
        	doc_state = '$newstate',
        	doc_address 	= '$newaddress'
        	WHERE doc_id = '$id'";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
  }else {
    $responses = array(
      'message' => 'Profile updated successfully.',
      'type' => 'success',
      'icon' => 'fa-check-circle',
      'title' => 'Thank you'
    );

  }
}
mysqli_close($conn);

echo json_encode($responses);
?>

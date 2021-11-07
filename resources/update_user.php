<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

require 'fetch.php';

$newfirstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
$newlastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
$newstate = isset($_POST['state']) ? $_POST['state'] : "";
$newlga = isset($_POST['lga']) ? $_POST['lga'] : "";
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
	if($newemail!==$email) {
	if(!isset($message)) {
    $query = $conn->query("SELECT DISTINCT * FROM `users` WHERE p_email = '" . $newemail . "'");
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
	if($newphone!==$phone) {
	if(!isset($message)) {
    $query = $conn->query("SELECT DISTINCT * FROM `users` WHERE p_tel = '" . $newphone . "'");
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
	$query = "UPDATE users
        	SET
        	p_firstname 	= '$newfirstname',
        	p_lastname 	= '$newlastname',
        	p_email 	= '$newemail',
        	p_tel = '$newphone',
        	p_address 	= '$newaddress',
        	p_state = '$newstate',
					p_lga = '$newlga'
        	WHERE p_id = '$id'";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
			$responses = array(
	      'message' => $result,
	      'type' => 'error',
	      'icon' => 'fa-check-circle',
	      'title' => 'Thank you'
	    );
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

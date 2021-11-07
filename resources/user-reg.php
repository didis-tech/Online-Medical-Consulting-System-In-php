<?php

use PHPMailer\PHPMailer\PHPMailer;

session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "ediagnosis");

$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
$DoB = isset($_POST['DoB']) ? $_POST['DoB'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$state = isset($_POST['state']) ? $_POST['state'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$lga = isset($_POST['lga']) ? $_POST['lga'] : "";
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
$address = isset($_POST['address']) ? $_POST['address'] : "";
$pass = password_hash($password, PASSWORD_BCRYPT);
/* Email Validation */
if (!isset($message)) {
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$responses = array(
			'message' => 'Invalid Email, Please put a valid E-mail address',
			'type' => 'warning',
			'icon' => 'fa-bell',
			'title' => 'Sorry'
		);
		$message = "danger";
	}

	if (!isset($message)) {
		$query = $conn->query("SELECT * FROM `users` WHERE	p_tel = '" . $phone . "'");
		if ($query->num_rows > 0) {
			$message = "Phone number is already in use.";
			$type = "warning";
		}
	}
}
if (!isset($message)) {
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$responses = array(
			'message' => 'Invalid Email, Please put a valid E-mail address',
			'type' => 'warning',
			'icon' => 'fa-bell',
			'title' => 'Sorry'
		);
		$message = "danger";
	}
}

if (!isset($message)) {
	$query = "SELECT * FROM `users` where p_email  = '$email'";
	$result = mysqli_query($conn, $query);

	if ($result->num_rows > 0) {
		$responses = array(
			'message' => 'User Email is already in use',
			'type' => 'danger',
			'icon' => 'fa-bell',
			'title' => 'Sorry'
		);
	} else {
		$query = "INSERT INTO users(p_firstname,	p_lastname,	p_email,	p_tel,	p_password, p_status, p_address,	p_state, p_lga,	p_dob)
	VALUES('$firstname', '$lastname', '$email', '$phone', '$pass', 'active', '$address', '$state', '$lga', '$DoB')";

		if ($conn->query($query) === TRUE) {
			$user_id = $conn->insert_id;

			$message = 'Registration was successfull.';
			$type = "success";
		} else {
			$message = "Customer Data Not Inserted. Try Again!";
			$type = "dark";
		}
	}
}
if (isset($message)) {
	$responses = array(
		'message' => $message,
		'type' => $type,
		'icon' => 'fa-bell-o',
		'title' => 'Hello'
	);
}
echo json_encode($responses);

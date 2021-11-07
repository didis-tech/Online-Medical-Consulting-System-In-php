<?php
use PHPMailer\PHPMailer\PHPMailer;
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");
$password=123456;
$email=$_POST['email'];
$pass=password_hash($password, PASSWORD_BCRYPT);
$name=ucwords($_POST['name']);
// $sql = "INSERT INTO `doctors`( `doc_name`, `doc_tel`, `doc_email`, `doc_password`, `doc_state`, `doc_dept`, `doc_address`, `doc_role`)
// VALUES ('".$name."','".$_POST['tel']."','".$_POST['email']."','".$pass."','".$_POST['state']."','".$_POST['dept']."','".$_POST['address']."','".$_POST['role']."')";

/* Email Validation */
	if(!isset($message)) {
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

 if(!isset($message)) {
	$query = "SELECT * FROM `doctors` where doc_email  = '$email'";
  $result = mysqli_query($conn, $query);

  if ($result->num_rows > 0) {
    $responses = array(
        'message' => 'User Email is already in use',
        'type' => 'danger',
        'icon' => 'fa-bell',
        'title' => 'Sorry'
      );
  }else {
			$query = "INSERT INTO `doctors`( `doc_name`, `doc_tel`, `doc_email`, `doc_password`, `doc_state`, `doc_dept`, `doc_address`, `doc_role`)
            VALUES ('".$name."','".$_POST['tel']."','".$_POST['email']."','".$pass."','".$_POST['state']."','".$_POST['dept']."','".$_POST['address']."','".$_POST['role']."')";
    
			if ($conn->query($query) === TRUE) {
    $user_id = $conn->insert_id;
require 'C:/xampp/composer/vendor/autoload.php';
$template_file = "../email_templates/template_message.php";
$email_message = file_get_contents($template_file);
// create a list of the variables to be swapped in the html template
$swap_var = array(
"{SITE_ADDR}" => "https://localhost/ediagnosis",
"{EMAIL_LOGO}" => "https://localhost/ediagnosis/images/logo.png",
"{EMAIL_TITLE}" => "Activation Message!",
"{CUSTOM_URL}" => "http://localhost/ediagnosis/doctors",
"{CUSTOM_IMG}" => "https://localhost/ediagnosis/images/logo.png",
"{TO_NAME}" => $name,
"{MESSAGE}" => "Your email was used to sign up as a doctor(admin) @ediagnosis.com <br/>
please if you wish to activate your account you should login with the password below and change your password <br/>
PASSWORD: $password",
"{TO_EMAIL}" => $email
);

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.hostinger.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'didi@didiscuisine.com';
$mail->Password = 'KachisiCho1';
$mail->setFrom('didi@didiscuisine.com', "E-Diagnosis");
$mail->addReplyTo('didi@didiscuisine.com', "E-Diagnosis");
$mail->addAddress($email, $name);
$mail->Subject = "Welcome To E-Diagnosis";
// search and replace for predefined variables, like SITE_ADDR, {NAME}, {lOGO}, {CUSTOM_URL} etc
	foreach (array_keys($swap_var) as $key){
		if (strlen($key) > 2 && trim($swap_var[$key]) != '')
			$email_message = str_replace($key, $swap_var[$key], $email_message);
	}
$mail->msgHTML($email_message, __DIR__);

$mail->IsHTML(true);
;
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
$message = 'Sorry! - An error occured';
$type = "error";
} else {
$message = 'Welcome! - An activation message was sent to your email address. Please visit you email to complete your registration.';
$type = "info";
}
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

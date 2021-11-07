<?php
use PHPMailer\PHPMailer\PHPMailer;
session_start();
header('Content-Type: application/json');


require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';
$name = isset($_POST['name']) ? $_POST['name'] : "";
$dept = isset($_POST['dept']) ? $_POST['dept'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$tel = isset($_POST['tel']) ? $_POST['tel'] : "";
$address = isset($_POST['address']) ? $_POST['address'] : "";
$state = isset($_POST['state']) ? $_POST['state'] : "";
$lga = isset($_POST['lga']) ? $_POST['lga'] : "";
$c_id = isset($_POST['c_id']) ? $_POST['c_id'] : "";
$advice = isset($_POST['body']) ? $_POST['body'] : "";
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
if (isset($_POST['new-sickness'])) {
	$newSickness=$_POST['new-sickness'];
	$diagnosis=$newSickness;
	$conn->query("INSERT INTO `sicknesses`(`s_name`, `frequency`) VALUES ('$newSickness',1)");
}
elseif (isset($_POST['selected'])) {
	$selected=$_POST['selected'];
	$diagnosis=$selected;
	$conn->query("UPDATE `sicknesses` SET `frequency`= frequency+1 WHERE s_name='$selected'");
}else {
		$message = "error occured";
		$type = "warning";
}

 if(!isset($message)) {
			$query = "UPDATE `complaints` SET `diagnosis`='$diagnosis',`advice`='$advice',`c_status`='completed' WHERE `c_id`='$c_id'";
			$conn->query("INSERT INTO `activities`(`p_id`, `d_id`, `p_noti`, `d_noti`)
			VALUE('$user_id','$id','You have been diagnosed by $doc_name','You have diagnosed $name')");

			if ($conn->query($query) === TRUE) {
    $user_id = $conn->insert_id;
require 'C:/xampp/composer/vendor/autoload.php';
$template_file = "./diagnosis-file.php";
$email_message = file_get_contents($template_file);
// create a list of the variables to be swapped in the html template
$swap_var = array(
"{SITE_ADDR}" => "http://localhost/ediagnosis",
"{EMAIL_LOGO}" => "http://localhost/ediagnosis/images/logo.png",
"{EMAIL_TITLE}" => "Activation Message!",
"{CUSTOM_URL}" => "http://localhost/ediagnosis/users/view-diagnosis.php?c_id=$c_id&&user_id=".$_POST['user_id'],
"{CUSTOM_IMG}" => "http://localhost/ediagnosis/images/logo.png",
"{C_ID}" => $c_id,
"{DATE}" => date("M. d, Y"),
"{ADDRESS}" => $address,
"{LGA}" => $lga,
"{STATE}" => $state,
"{TEL}" => $tel,
"{DEPT}" => $dept,
"{DIAGNOSIS}" => $diagnosis,
"{ADVICE}" => htmlspecialchars_decode($advice),
"{TO_NAME}" => $name,
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
$mail->Subject = "Diagnosis From E-Diagnosis";
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
$message = 'Hello! - Diagnosis was sent successfully';
$type = "info";
}
			} else {
				$message = "Not updated. Try Again!";
				$type = "dark";
			}
	}
if (isset($message)) {
	$responses = array(
		'message' => $message,
		'type' => $type,
		'icon' => 'fa-bell-o',
		'title' => 'Hello'
	);
	header("location: complaints.php");
}



?>

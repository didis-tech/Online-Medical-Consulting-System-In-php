<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

require 'fetch-doctor.php';

$question = isset($_POST['question']) ? $_POST['question'] : "";
$type = isset($_POST['type']) ? $_POST['type'] : "";
$p_id = isset($_POST['p_id']) ? $_POST['p_id'] : "";
$p_name = isset($_POST['p_name']) ? $_POST['p_name'] : "";
$p_email = isset($_POST['p_email']) ? $_POST['p_email'] : "";

$complaint_id = isset($_POST['complaint_id']) ? $_POST['complaint_id'] : "";

	if(!isset($message)) {
    $query = $conn->query("SELECT DISTINCT * FROM `response` WHERE res_ques = '" . $question . "'");
    $count = $query->num_rows;
    if($count!=0) {
        $message = "warning";
		$responses = array(
		'message' => 'Response already exists.',
		'type' => 'warning',
		'icon' => 'fa-bell',
		'title' => 'Sorry'
  );
		}
	}

 if(!isset($message)) {
	$query = "INSERT into response(res_ques,type,c_id)
        	 VALUE('$question','$type','$complaint_id')";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
  }else {
		$conn->query("INSERT INTO `activities`(`p_id`, `d_id`, `p_noti`, `d_noti`,`act_type`,`c_id`)
    VALUE('$p_id','$id','$doc_name asked for more Information','You requested for more Information from $p_name','response','$complaint_id')");
    require 'C:/xampp/composer/vendor/autoload.php';
    $template_file = "../email_templates/template_message.php";
    $email_message = file_get_contents($template_file);
    // create a list of the variables to be swapped in the html template
    $swap_var = array(
    "{SITE_ADDR}" => "https://localhost/ediagnosis",
    "{EMAIL_LOGO}" => "https://localhost/ediagnosis/images/logo.png",
    "{EMAIL_TITLE}" => "Activation Message!",
    "{CUSTOM_URL}" => "http://localhost/ediagnosis/activate.php?id=$user_id",
    "{CUSTOM_IMG}" => "https://localhost/ediagnosis/images/logo.png",
    "{TO_NAME}" => $p_name,
    "{MESSAGE}" => "$doc_name asked for more Information",
    "{TO_EMAIL}" => $p_email
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
    $mail->addAddress($p_email, $p_name);
    $mail->Subject = "Response from E-diagnosis";
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
    $responses = array(
      'message' => $message,
      'type' => $type,
      'icon' => 'fa-check-circle',
      'title' => 'Ok!'
    );

  }
}
mysqli_close($conn);

echo json_encode($responses);
?>

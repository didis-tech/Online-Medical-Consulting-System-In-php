<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";

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

  if (!$result) {
    $result = mysqli_error($conn);
  }else {
    if ($result->num_rows > 0) {
    $value = $result->fetch_assoc();
    $stored_password = $value['doc_password'];
    if (password_verify($password,$stored_password)) {
    if ($value['doc_status']== 'inactive') {
        $_SESSION['doc_login'] = true;
        $_SESSION['doc_id'] = $value['doc_id'];
        $responses = array(
            'message' => 'Change Password',
            'type' => 'success',
            'icon' => 'fa-check-circle',
            'title' => 'inactive'
          );
    }elseif ($value['doc_status'] == 'active'){
        $_SESSION['doc_login'] = true;
        $_SESSION['doc_id'] = $value['doc_id'];
        $responses = array(
            'message' => 'Login',
            'type' => 'success',
            'icon' => 'fa-check-circle',
            'title' => 'active'
          );
    }else{
        $responses = array(
            'message' => 'Account have been deactivated, Please contact management.',
            'type' => 'error',
            'icon' => 'fa-bell',
            'title' => 'Sorry'
          );
    }
}else{
  $responses = array(
      'message' => 'Password is Incorrect.',
      'type' => 'warning',
      'icon' => 'fa-bell',
      'title' => 'Sorry'
    );
  }

  }else{
    $responses = array(
        'message' => 'Email is invalid please check your credentials.',
        'type' => 'error',
        'icon' => 'fa-bell',
        'title' => 'Sorry'
      );
}
}
 }
echo json_encode($responses);
?>

<?php
session_start();
require_once "db_connect.php";

$id = $_SESSION['doc_id'];
$password = isset($_POST['password']) ? $_POST['password'] : "";
$newPassword=password_hash($password, PASSWORD_BCRYPT);

 if(!isset($message)) {
	$query = "UPDATE doctors
        	SET
        	doc_password 	= '$newPassword',
          doc_status = 'active'
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
echo json_encode($responses);
?>

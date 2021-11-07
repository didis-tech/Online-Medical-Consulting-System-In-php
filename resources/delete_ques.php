<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$que_id = isset($_POST['que_id']) ? $_POST['que_id'] : "";


 if(!isset($message)) {
	$query = "DELETE FROM `questions`
        	WHERE que_id = '$que_id'";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
  }else {
    $responses = array(
      'message' => 'Question was Deleted.',
      'type' => 'error',
      'icon' => 'fa-check-circle',
      'title' => 'Hello!'
    );

  }
}
mysqli_close($conn);

echo json_encode($responses);
?>

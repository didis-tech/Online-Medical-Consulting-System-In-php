<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

require 'fetch-doctor.php';

$question = isset($_POST['question']) ? $_POST['question'] : "";
$type = isset($_POST['type']) ? $_POST['type'] : "";



	if(!isset($message)) {
    $query = $conn->query("SELECT DISTINCT * FROM `questions` WHERE que_desc = '" . $question . "'");
    $count = $query->num_rows;
    if($count!=0) {
        $message = "warning";
		$responses = array(
		'message' => 'Question already exists.',
		'type' => 'warning',
		'icon' => 'fa-bell',
		'title' => 'Sorry'
  );
		}
	}

 if(!isset($message)) {
	$query = "INSERT into questions(que_dept,que_desc,que_type)
        	 VALUE('$doc_dpt','$question','$type')";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
  }else {
    $query2 = "UPDATE departments
    SET
    dept_status 	= 'active'
    WHERE dept_id = '$doc_dpt'";
    mysqli_query($conn, $query2);
    $responses = array(
      'message' => 'Question added successfully.',
      'type' => 'success',
      'icon' => 'fa-check-circle',
      'title' => 'Ok!'
    );

  }
}
mysqli_close($conn);

echo json_encode($responses);
?>

<?php

session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$dept = isset($_POST['dept']) ? $_POST['dept'] : "";
$answer = isset($_POST['answer']) ? $_POST['answer'] : "";
$question = isset($_POST['question']) ? $_POST['question'] : "";
$sess_id = isset($_POST['sess_id']) ? $_POST['sess_id'] : "";
$userid = isset($_POST['userid']) ? $_POST['userid'] : "";
$count = isset($_POST['count']) ? $_POST['count'] : "";
$c_id = isset($_POST['c_id']) ? $_POST['c_id'] : "";
$count=intval($count);

$query = "INSERT INTO `patient_answers`(`c_id`,`sess_id`, `dept`, `user`, `que`, `ans`, `time_created`)
VALUES ('$c_id','$sess_id','$dept','$userid','$question','$answer',now())";
$qryresult = $conn->query($query);
if ($qryresult) {
    $responses = array(
      'message' => 'Inserted successfully..',
      'type' => 'success',
      'icon' => 'fa-info',
      'title' => 'Thank you',
      'count' => $count + 1
    );
}else {
  $responses = array(
    'message' => 'An Error occured..',
    'type' => 'error',
    'icon' => 'fa-info',
    'title' => 'Sorry'
  );
}
echo json_encode($responses);
?>

<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "ediagnosis");
require '../resources/calc_time.php';

$c_id = isset($_POST['c_id']) ? $_POST['c_id'] : "";

$query = "SELECT * FROM `patient_answers`,`questions` where patient_answers.que=questions.que_id and  patient_answers.c_id='$c_id'";
$qryresult = mysqli_query($conn, $query);
if ($qryresult->num_rows > 0) {
  foreach ($qryresult as $row) {

    $row += ["count" => $qryresult->num_rows, 'time' => relative_date(strtotime($row['time_created']))];
    $responses[] = $row;
  }
} else {
  $responses = array(
    'message' => 'Pending',
    'type' => 'info',
    'icon' => 'fa-info',
    'title' => 'Sorry',
    'count' => $qryresult->num_rows
  );
}
echo json_encode($responses);

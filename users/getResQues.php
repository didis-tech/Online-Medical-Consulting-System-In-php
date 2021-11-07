<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$c_id = isset($_POST['c_id']) ? $_POST['c_id'] : "";
$responses = array();
$query = "SELECT * FROM `response` where c_id='$c_id' and res_status='pending'";
$qryresult = mysqli_query($conn, $query);
if ($qryresult->num_rows > 0) {
  foreach ($qryresult as $row) {

    $row += [ "type" => 'success' ];
  	$responses[] = $row;
  }
}
echo json_encode($responses);
?>

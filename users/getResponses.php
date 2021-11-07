<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$c_id = isset($_POST['c_id']) ? $_POST['c_id'] : "";

$query = "SELECT * FROM `response` where c_id='$c_id' and res_status='answered'";
$qryresult = mysqli_query($conn, $query);
if ($qryresult->num_rows > 0) {
  foreach ($qryresult as $row) {

    $row += [ "count" => $qryresult->num_rows ];
  	$responses[] = $row;
  }
}else {
  $responses = array(
    'message' => 'Pending',
    'type' => 'info',
    'icon' => 'fa-info',
    'title' => 'Sorry',
    'count' => $qryresult->num_rows
  );
}
echo json_encode($responses);
?>

<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$dept = isset($_POST['dept']) ? $_POST['dept'] : "";

$query = "SELECT * FROM questions where que_dept=$dept";
$qryresult = mysqli_query($conn, $query);
if ($qryresult->num_rows > 0) {
  foreach ($qryresult as $row) {

    $row += [ "type" => 'success' ];
  	$responses[] = $row;
  }
}else {
  $responses = array(
    'message' => 'No Doctor available now try again later..',
    'type' => 'info',
    'icon' => 'fa-info',
    'title' => 'Sorry'
  );
}
echo json_encode($responses);
?>

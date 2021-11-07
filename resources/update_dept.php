<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$newname = isset($_POST['name']) ? $_POST['name'] : "";
$old_name = isset($_POST['old_name']) ? $_POST['old_name'] : "";
$dept_id = isset($_POST['dept_id']) ? $_POST['dept_id'] : "";


	if($newname!==$old_name) {
	if(!isset($message)) {
    $query = $conn->query("SELECT DISTINCT * FROM `departments` WHERE dept_name = '" . $newname . "'");
    $count = $query->num_rows;
    if($count!=0) {
        $message = "warning";
		$responses = array(
		'message' => 'Department already exists.',
		'type' => 'warning',
		'icon' => 'fa-bell',
		'title' => 'Sorry'
  );
		}
	}}

 if(!isset($message)) {
	$query = "UPDATE departments
        	SET
        	dept_name 	= '$newname'
        	WHERE dept_id = '$dept_id'";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
  }else {
    $responses = array(
      'message' => 'Department updated successfully.',
      'type' => 'success',
      'icon' => 'fa-check-circle',
      'title' => 'Hello!'
    );

  }
}
mysqli_close($conn);

echo json_encode($responses);
?>

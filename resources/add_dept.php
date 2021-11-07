<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$newname = isset($_POST['name']) ? $_POST['name'] : "";



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
	}

 if(!isset($message)) {
	$query = "INSERT into departments(dept_name)
        	 VALUE( '$newname' )";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
  }else {
    $responses = array(
      'message' => 'Department added successfully.',
      'type' => 'success',
      'icon' => 'fa-check-circle',
      'title' => 'Hello!'
    );

  }
}
mysqli_close($conn);

echo json_encode($responses);
?>

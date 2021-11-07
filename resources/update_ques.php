<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

$que_desc = isset($_POST['que_desc']) ? $_POST['que_desc'] : "";
$que_id = isset($_POST['que_id']) ? $_POST['que_id'] : "";
$question = isset($_POST['question']) ? $_POST['question'] : "";
$type = isset($_POST['type']) ? $_POST['type'] : "";


	if($question!==$que_desc) {
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
	}

 if(!isset($message)) {
	$query = "UPDATE questions
        	SET
        	que_desc 	= '$question',
					que_type 	= '$type'
        	WHERE que_id = '$que_id'";
  $result = mysqli_query($conn, $query);

  if (!$result) {
      $result = mysqli_error($conn);
  }else {
    $responses = array(
      'message' => 'Question updated successfully.',
      'type' => 'success',
      'icon' => 'fa-check-circle',
      'title' => 'Hello!'
    );

  }
}
mysqli_close($conn);

echo json_encode($responses);
?>

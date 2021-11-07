<?php
session_start();
header('Content-Type: application/json');
$conn = mysqli_connect("localhost", "root", "", "ediagnosis");
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

$sqlQuery = "SELECT * FROM `doctors` where doc_id='$user_id'";

$resultQ = mysqli_query($conn, $sqlQuery);
$newCount = $resultQ->num_rows;
$data = array();
foreach ($resultQ as $row) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);

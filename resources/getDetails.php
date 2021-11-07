<?php
session_start();
header('Content-Type: application/json');
$conn = mysqli_connect("localhost", "root", "", "ediagnosis");
require '../resources/fetch-doctor.php';
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

$sqlQuery = "SELECT * FROM `users` where p_id='$user_id'";

$resultQ = mysqli_query($conn, $sqlQuery);
$newCount = $resultQ->num_rows;
$data = array();
foreach ($resultQ as $row) {
    $row += ['age' => getAge($row['p_dob'])->format('%y years')];
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);

<?php
header('Content-Type: application/json');
include "../resources/calc_time.php";
$conn = mysqli_connect("localhost","root","","ediagnosis");
$sqlQuery = "SELECT SUM(frequency) as count FROM sicknesses";
$result = mysqli_query($conn,$sqlQuery);
$row=$result->fetch_assoc();
$newCount=$row['count'];

echo json_encode($newCount);
?>
<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","ediagnosis");

require 'fetch.php';
if(isset($_POST["image"]))
{
	$imgData = $_POST["image"];


	$image_array_1 = explode(";", $imgData);
	$image_array_2 = explode(",", $image_array_1[1]);



	$imgData = base64_decode($image_array_2[1]);
$imageName = time().'.png';
file_put_contents('../users/assets/img/'.$imageName, $imgData);

$img_sql = "UPDATE users set p_dp='$imageName' where p_id = '$id' ";
$img_res = $conn->query($img_sql);

$responses = array(
	'message' => 'Profile updated successfully.',
	'type' => 'success',
	'icon' => 'fa-check-circle',
	'title' => 'Thank you'
  );
  echo json_encode($responses);
}
 ?>

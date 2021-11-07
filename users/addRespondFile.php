<?php
session_start();
$active="home";
if(!isset($_SESSION['user_id'])  || !isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true ){
    echo "<script>alert('You have to login first.'); window.location='../'; </script>";
}
  require '../resources/db_connect.php';
  require '../resources/fetch.php';


?>
<?php
if (! empty($_FILES)) {
    $imagePath = isset($_FILES["file"]["name"]) ? $_FILES["file"]["name"] : "Undefined";
    $targetPath = "../images/user-files/";
    $imagePath = $targetPath . $imagePath;
    $tempFile = $_FILES['file']['tmp_name'];
    $File = $_FILES['file']['name'];
    // Valid extension
    $valid_ext = array('png','jpeg','jpg');
    // thumbnail Location
    $location = "images/user-files/".$File;
    $thumbnail_location = "../images/user-files/".$File;

    // file extension
    $file_extension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);

// Check extension
if(in_array($file_extension,$valid_ext)){

    // Upload file
    if(move_uploaded_file($_FILES['file']['tmp_name'],$imagePath)){


    }

}
}
// Compress image
function compressImage($type,$source, $destination, $quality) {

    $info = getimagesize($source);

    if ($type == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($type == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($type == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

}
if (! empty($_GET["action"]) && $_GET["action"] == "save") {
    $resp_id=$_POST['fileQuestion'];
     $query = "UPDATE response SET
    `res_ans`='$location',
    `res_status`='answered'
    WHERE `resp_id`='$resp_id'
    ";
    mysqli_query($conn, $query);
    $current_id = mysqli_insert_id($conn);
}
?>

<?php
session_start();
$active = "profile";
if (!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true) {
    echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';
$getDocs = $conn->query("SELECT * FROM doctors")->num_rows;
$getPatients = $conn->query("SELECT * FROM users")->num_rows;
?>
<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <!-- Site Icons -->
    <link rel="shortcut icon" href="../images/fevicon.ico.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
    <title>E-Diagnosis - Online Medical Consulting System</title>
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./../css/croppie.css">
    <script src="./../js/croppie.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/animate.css">
    <link rel="stylesheet" type="text/css" href="../css/Lobibox.min.css">
</head>

<body>
    <div class="main-wrapper">
        <?php require 'header.php'; ?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-7 col-6">
                        <h4 class="page-title">My Profile</h4>
                    </div>

                    <div class="col-sm-5 col-6 text-right m-b-30">
                        <a href="edit-profile.php" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Edit Profile</a>
                    </div>
                </div>
                <div class="card-box profile-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#!" data-toggle="modal" data-target="#myModal" id="upload-demo-i"><img class="avatar" src="<?php echo $doc_dp ?>" alt=""></a>
                                    </div>
                                </div>
                                <!-- The Modal -->
                                <div class="modal" id="myModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Update Profile Image</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Image Upload</div>
                                                    <div class="panel-body">


                                                        <div class="row">
                                                            <div class="col-md-12 text-center">
                                                                <div id="upload-demo" style="width:350px"></div>
                                                            </div>
                                                            <div class="col-md-12" style="padding-top:30px;">
                                                                <strong>Select Image:</strong>
                                                                <br />
                                                                <input type="file" id="upload">
                                                                <br />
                                                                <button class="btn btn-success upload-result">Upload Image</button>
                                                            </div>
                                                            <div class="col-md-12" class="user-profile-img">
                                                                <div id="upload-demo-i"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>


                                                <script type="text/javascript">
                                                    $uploadCrop = $('#upload-demo').croppie({
                                                        enableExif: true,
                                                        viewport: {
                                                            width: 200,
                                                            height: 200,
                                                            type: 'square'
                                                        },
                                                        boundary: {
                                                            width: 300,
                                                            height: 300
                                                        }
                                                    });


                                                    $('#upload').on('change', function() {
                                                        var reader = new FileReader();
                                                        reader.onload = function(e) {
                                                            $uploadCrop.croppie('bind', {
                                                                url: e.target.result
                                                            }).then(function() {
                                                                console.log('jQuery bind complete');
                                                            });

                                                        }
                                                        reader.readAsDataURL(this.files[0]);
                                                    });


                                                    $('.upload-result').on('click', function(ev) {
                                                        var vidFileLength = $("#upload")[0].files.length;
                                                        if (vidFileLength === 0) {
                                                            alert("No file selected.");
                                                        } else {
                                                            $('#upload-result').addClass("disabled");
                                                            $uploadCrop.croppie('result', {
                                                                type: 'canvas',
                                                                size: 'viewport'
                                                            }).then(function(resp) {


                                                                $.ajax({
                                                                    url: "../resources/doc_upload_dp.php",
                                                                    type: "POST",
                                                                    data: {
                                                                        "image": resp
                                                                    },
                                                                    success: function(data) {
                                                                        $('#myModal').modal('hide');
                                                                        html = '<img src="' + resp + '"  class="avatar"/>';
                                                                        $("#upload-demo-i").html(html);
                                                                        $("#user-img").html('<img src="' + resp + '" width="24" alt="Admin"  class="rounded-circle"/><span class="status online"></span>');
                                                                        Lobibox.notify('default', {
                                                                            position: 'top center',
                                                                            img: resp,
                                                                            msg: 'Image was uploaded successfully'
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        }
                                                    });
                                                </script>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?php echo $doc_name ?></h3>
                                                <small class="text-muted"><?php echo $doc_dept ?></small>
                                                <div class="staff-id">Employee ID : DR-0<?php echo $doc_id ?></div>

                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><a href="tel:<?php echo $doc_phone ?>"><?php echo $doc_phone ?></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Email:</span>
                                                    <span class="text"><a href="mailto:<?php echo $doc_email ?>"><?php echo $doc_email ?></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Department:</span>
                                                    <span class="text"><?php echo $doc_dept ?></span>
                                                </li>
                                                <li>
                                                    <span class="title">State:</span>
                                                    <span class="text"><?php echo $doc_state ?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Role:</span>
                                                    <span class="text"><?php echo $doc_role ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">About</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="about-cont">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-box">
                                        <h3 class="card-title">Additional Informations</h3>
                                        <div class="experience-box">
                                            <ul class="experience-list">
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <a href="#!" class="name"><?php echo $doc_address ?></a>
                                                            <div><?php echo $doc_dept ?></div>
                                                            <span class="time"><?php echo $doc_date ?></span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/app.js"></script>

    <!-- notification -->
    <script type="text/javascript" src="../js/Lobibox.js"></script>
    <script type="text/javascript" src="../js/notification-active.js"></script>
</body>


<!-- profile23:03-->

</html>
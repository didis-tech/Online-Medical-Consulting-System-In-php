<?php
session_start();
$active="dept";
if(!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true ){
    echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';
?>
<!DOCTYPE html>
<html lang="en">


<!-- add-department24:07-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <!-- Site Icons -->
   <link rel="shortcut icon" href="../images/fevicon.ico.png" type="image/x-icon" />
   <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
   <title>E-Diagnosis - Online Medical Consulting System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
    
    <link rel="stylesheet" type="text/css" href="../css/animate.css">
    <link rel="stylesheet" type="text/css" href="../css/Lobibox.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="main-wrapper">
    <?php require 'header.php'; ?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Department</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <form id="add">
							<div class="form-group">
								<label>Department Name</label>
								<input class="form-control" type="text" name="name" required>
							</div>
                            
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn">Create Department</button>
                            </div>
                        </form>
                        <script type="text/javascript">

										$('#add').submit(function(event) {

															// stop the form refreshing the page
															event.preventDefault();

															$('.form-group').removeClass('has-error'); // remove the error class
															$('.help-block').remove(); // remove the error text

													$.ajax({
															url: '../resources/add_dept.php',
															data: $(this).serialize(),
															type: "POST",
															dataType: "json",
															success: function (data) {
                                                                    Lobibox.notify(data.type, {
																	position: 'top right',
																	title: data.title,
																	msg: data.message
																});
                                                                
                                                                
															}
													});
										});
								</script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- notification -->
<script type="text/javascript" src="../js/Lobibox.js"></script>
<script type="text/javascript" src="../js/notification-active.js"></script>
</body>


<!-- add-department24:07-->
</html>

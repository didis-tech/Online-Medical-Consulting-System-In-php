<?php
session_start();
$active = "activities";
if (!isset($_SESSION['user_id'])  || !isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true) {
    echo "<script>alert('You have to login first.'); window.location='../'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch.php';
$getActs = $conn->query("SELECT * FROM `activities`,`users`,`doctors` WHERE activities.p_id=users.p_id AND activities.d_id=doctors.doc_id AND activities.p_id=$id order by activities.act_id desc");
$conn->query("UPDATE `activities` SET p_stat='seen' WHERE p_id=$id");
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
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <?php require 'header.php'; ?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Activities</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="activity">
                            <div class="activity-box">
                                <ul class="activity-list">
                                    <?php foreach ($getActs as $key => $activity) : ?>
                                        <?php $activity_time = strtotime($activity['noti_time']); ?>
                                        <li>
                                            <div class="activity-user">
                                                <a href="#!" onclick="viewDoctor(<?php echo $activity['doc_id'] ?>)" title="<?php echo $activity['doc_name'] ?>" data-toggle="tooltip" class="avatar">
                                                    <img alt="<?php echo $activity['doc_name'] ?>" src="../doctors/assets/img/<?php echo $activity['doc_dp'] ?>" class="img-fluid rounded-circle">
                                                </a>
                                            </div>
                                            <div class="activity-content">
                                                <div class="timeline-content">
                                                    <?php echo $activity['p_noti'] ?>
                                                    <span class="time"><?php echo get_time_ago($activity_time) ?></span>
                                                </div>
                                            </div>
                                            <a class="activity-delete" href="#" title="Delete">&times;</a>
                                        </li>
                                    <?php endforeach; ?>

                                </ul>
                                <!-- Modal -->
                                <div class="modal fade" id="view-doctor" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Doctor's Details.</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        function viewDoctor(params) {
            const doc_id = params;
            $.ajax({
                url: '../resources/getDocDetails.php',
                data: {
                    user_id: doc_id
                },
                type: "POST",
                dataType: "json",
                success: function(data) {
                    var content = `<ul class="list-group">`;
                    for (const key in data) {
                        content += `
                                    <li class="list-group-item text-center"><img src='../doctors/assets/img/${data[key].doc_dp}'</li>
                                    <li class="list-group-item"><span class="float-left text-secondary">Name:</span><span class="float-right text-primary">   ${data[key].doc_name}</span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">Email:</span><span class="float-right text-primary">  <a href='mailto:${data[key].doc_email}'> ${data[key].doc_email}</a></span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">Phone number:</span><span class="float-right text-primary">   ${data[key].doc_tel} <br> <small>its advisable not to call <br/> the doctor but you can send an email</small></span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">State:</span><span class="float-right text-primary">   ${data[key].doc_state}</span></li>`
                    }
                    content += `</ul>`
                    $("#view-doctor .modal-body").html(content);

                }
            });
            $("#view-doctor").modal();
        }
    </script>
</body>


<!-- activities22:59-->

</html>
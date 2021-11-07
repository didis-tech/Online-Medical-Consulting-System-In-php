<?php
session_start();
$active = "complaints";
if (!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true) {
    echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';
$getQues = $conn->query("SELECT * FROM questions where que_dept = '" . $doc_dpt . "' order by que_time_created desc");

$count = 0;
$types = array(
    "text",
    "file"
);
if (isset($_GET['complaint_id']) && isset($_GET['patient_id']) && isset($_GET['patient_name'])) {
    $cmptID = $_GET['complaint_id'];
    $p_id = $_GET['patient_id'];
    $p_name = $_GET['patient_name'];
    $respond = $conn->query("UPDATE complaints SET d_id=$id,c_status='in progress' where c_id=$cmptID");
    if ($respond) {
        $conn->query("INSERT INTO `activities`(`p_id`, `d_id`, `p_noti`, `d_noti`)
    VALUE('$p_id','$id','$doc_name accepted your request and is reviewing your complaint','You accepted $p_name`s request')");
        header("location: patient-complaint.php?complaint_id=$cmptID");
    }
}
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
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="./../css/animate.css">
    <link rel="stylesheet" type="text/css" href="../css/animate.css">
    <link rel="stylesheet" type="text/css" href="../css/Lobibox.min.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="main-wrapper">

        <?php require 'header.php'; ?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Complaints</h4>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card-box">
                            <ul class="nav nav-tabs nav-tabs-top nav-justified">
                                <li class="nav-item"><a class="nav-link active" href="#top-justified-tab1" data-toggle="tab">Expected Questions</a></li>
                                <li class="nav-item"><a class="nav-link" href="#top-justified-tab2" data-toggle="tab">Patients</a></li>
                                <li class="nav-item"><a class="nav-link" href="#top-justified-tab3" data-toggle="tab">Accepted Requests</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="top-justified-tab1">
                                    <?php require 'questions.php'; ?>
                                </div>
                                <div class="tab-pane" id="top-justified-tab2">
                                    <?php require 'deptComplaints.php'; ?>
                                </div>

                                <div class="tab-pane" id="top-justified-tab3">
                                    <?php require 'AcceptedComplaints.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- The Modal -->
    <div class="modal animated slideInDown" id="addQue">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Question</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="addQues">
                        <div class="form-group form-focus">
                            <label class="focus-label">Question</label>
                            <textarea type="text" class="form-control floating" name="question" required></textarea>
                        </div>
                        <div class="form-group form-focus">
                            <label class="focus-label">Type</label>
                            <select name="type" class="select form-control floating" required>
                                <option value="" selected disabled>Select type...</option>
                                <?php foreach ($types as $key => $type) : ?>
                                    <option value="<?php echo $type ?>"><?php echo $type ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn">Add</button>
                        </div>
                    </form>
                    <script type="text/javascript">
                        $('#addQues').submit(function(event) {

                            // stop the form refreshing the page
                            event.preventDefault();

                            $('.form-group').removeClass('has-error'); // remove the error class
                            $('.help-block').remove(); // remove the error text

                            $.ajax({
                                url: '../resources/add_ques.php',
                                data: $(this).serialize(),
                                type: "POST",
                                dataType: "json",
                                success: function(data) {
                                    $("#table").load(window.location.href + " #table");
                                    $('#addQue').modal('hide');
                                    Lobibox.notify(data.type, {
                                        position: 'top right',
                                        title: data.title,
                                        msg: data.message
                                    });
                                    setTimeout(
                                        location.reload(),
                                        3000);

                                }
                            });
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
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- notification -->
    <script type="text/javascript" src="../js/Lobibox.js"></script>
    <script type="text/javascript" src="../js/notification-active.js"></script>
</body>


<!-- tabs23:59-->

</html>
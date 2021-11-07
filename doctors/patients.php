<?php
session_start();
$active = "patients";
if (!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true) {
    echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';
$getPatients = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">


<!-- patients23:17-->

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
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
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
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Patients</h4>
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-patient.html" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Patient</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-border table-striped custom-table datatable mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($getPatients as $key => $user) : ?>
                                        <tr>
                                            <td><img width="28" height="28" src="<?php echo "../users/assets/img/" . $user['p_dp']; ?>" class="rounded-circle m-r-5" alt=""> <?php echo $user['p_firstname'] . " " . $user['p_lastname']; ?></td>
                                            <td><?php echo getAge($user['p_dob'])->format('%y years'); ?></td>
                                            <td><?php echo $user['p_address']; ?></td>
                                            <td><?php echo $user['p_tel']; ?></td>
                                            <td><?php echo $user['p_email']; ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="getDetails(<?php echo $user['p_id']; ?>)"><i class="fa fa-eye m-r-5"></i> View</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_patient"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="view_patient" class="modal fade delete-modal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center ">

                    </div>
                </div>
            </div>

        </div>
        <div id="delete_patient" class="modal fade delete-modal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="assets/img/sent.png" alt="" width="50" height="46">
                        <h3>Are you sure want to delete this Patient?</h3>
                        <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-danger">Delete</button>
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
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        function getDetails(params) {
            $.ajax({
                url: '../resources/getDetails.php',
                data: {
                    user_id: params
                },
                type: "POST",
                dataType: "json",
                success: function(data) {
                    var content = `<ul class="list-group">`;
                    for (const key in data) {
                        content += `<li class="list-group-item"><span class="float-left text-secondary">Firstname:</span><span class="float-right text-primary">   ${data[key].p_firstname}</span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">Lastname:</span><span class="float-right text-primary">   ${data[key].p_lastname}</span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">Email:</span><span class="float-right text-primary">   ${data[key].p_email}</span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">Phone number:</span><span class="float-right text-primary">   ${data[key].p_tel}</span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">State:</span><span class="float-right text-primary">   ${data[key].p_state}</span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">LGA:</span><span class="float-right text-primary">   ${data[key].p_lga}</span></li>
                                    <li class="list-group-item"><span class="float-left text-secondary">Age:</span><span class="float-right text-primary">   ${data[key].age}</span></li>`
                    }
                    content += `</ul>`
                    $("#view_patient .modal-body").html(content);

                }
            });
            $("#view_patient").modal();
        }
    </script>
</body>


<!-- patients23:19-->

</html>
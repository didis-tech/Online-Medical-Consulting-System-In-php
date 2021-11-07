<?php
session_start();
$active="dept";
if(!isset($_SESSION['user_id'])  || !isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true ){
    echo "<script>alert('You have to login first.'); window.location='../'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch.php';
$getDepts=$conn->query("SELECT * FROM departments order by dept_name");
$count=0;
?>
<!DOCTYPE html>
<html lang="en">


<!-- departments23:21-->
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
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">Departments</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Department Name</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($getDepts as $key => $dept): ?>
                                   <?php
                                   $dept_id=$dept['dept_id'];
                                   $checkCmpt=$conn ->query("SELECT * FROM `complaints` where dept='$dept_id' and user_id='$id' and c_status='pending' or c_status='in progress'");
                                   $cmptCnt=$checkCmpt->num_rows;
                                   $count=$count+1;
                                     if($dept['dept_status'] == 'active'){
                                         $status = 'status-green';
                                     }else{
                                      $status = 'status-grey';
                                     }

                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $dept['dept_name']; ?></td>
										<td><span class="custom-badge <?php echo $status; ?>"><?php echo $dept['dept_status']; ?></span></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item <?php if($dept['dept_status'] !== 'active' || $cmptCnt > 0) echo "disabled"; ?>" href="complain.php?dept=<?php echo $dept['dept_id']; ?>"><i class="fa fa-pencil m-r-5"></i> Complain</a>
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

    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/app.js"></script>
</body>


<!-- departments23:21-->
</html>

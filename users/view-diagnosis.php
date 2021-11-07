<?php
session_start();
$active = "complaints";
if (!isset($_SESSION['user_id'])  || !isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true) {
    echo "<script>alert('You have to login first.'); window.location='../'; </script>";
}
if (!isset($_GET['c_id'])) {
    header("location: complaints.php");
}
$c_id = $_GET['c_id'];
require '../resources/db_connect.php';
require '../resources/fetch.php';
$getCompt = $conn->query("SELECT * FROM `departments`,`doctors`,`complaints` WHERE departments.dept_id=complaints.dept and doctors.doc_id=complaints.d_id and complaints.c_id=$c_id");
$compt = $getCompt->fetch_assoc();

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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                    <div class="col-sm-5 col-4">
                        <h4 class="page-title">Invoice</h4>
                    </div>
                    <div class="col-sm-7 col-8 text-right m-b-30">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-white" href="print-diagnosis.php?c_id=<?php echo $c_id ?>">PDF</a>
                            <a class="btn btn-white" href="print-diagnosis.php?c_id=<?php echo $c_id ?>"><i class="fa fa-print fa-lg"></i> Print</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row custom-invoice">
                                    <div class="col-6 col-sm-6 m-b-20">
                                        <img src="../images/icon-logo.png" class="inv-logo" alt="">
                                        <ul class="list-unstyled">
                                            <li>E-Diagnosis</li>
                                            <li>GST No: 08143307959</li>
                                        </ul>
                                    </div>
                                    <div class="col-6 col-sm-6 m-b-20">
                                        <div class="invoice-details">
                                            <h3 class="text-uppercase">DIAGNOSIS #DIAG-0<?php echo $c_id ?></h3>
                                            <ul class="list-unstyled">
                                                <li>Date: <span><?php echo date("M. d, Y", strtotime($compt['c_time_sent'])) ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-6 m-b-20">

                                        <h5>Diagnosis to:</h5>
                                        <ul class="list-unstyled">
                                            <li>
                                                <h5><strong><?php echo $firstname . ' ' . $lastname ?></strong></h5>
                                            </li>
                                            <li><?php echo $address ?></li>
                                            <li><?php echo $lga ?>, <?php echo $state ?></li>
                                            <li>Nigeria</li>
                                            <li><?php echo $phone ?></li>
                                            <li><a href="#"><?php echo $email ?></a></li>
                                        </ul>

                                    </div>
                                    <div class="col-sm-6 col-lg-6 m-b-20">
                                        <div class="invoices-view">
                                            <span class="text-muted">OTher Details:</span>
                                            <ul class="list-unstyled invoice-payment-details">

                                                <li>Department: <span><?php echo $compt['dept_name'] ?></span></li>
                                                <li>Country: <span>Nigeria</span></li>
                                                <li>State: <span><?php echo $state ?></span></li>
                                                <li>Address: <span><?php echo $address ?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="row invoice-payment">
                                        <div class="col-sm-7">
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="m-b-20">
                                                <h6>Total due</h6>
                                                <div class="table-responsive no-border">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th>Diagnosis:</th>
                                                                <td class="text-right"><?php echo $compt['diagnosis'] ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-info">
                                        <h5>Advice</h5>
                                        <?php echo $compt['advice'] ?>
                                        <span class="float-right">Signed by</span> <br>
                                        <span class="float-right"> <i><?php echo $compt['doc_name'] ?></i> </span>
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
</body>


<!-- invoice-view24:07-->

</html>
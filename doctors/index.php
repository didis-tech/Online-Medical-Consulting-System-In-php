<?php
session_start();
$active = "home";
if (!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true) {
	echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';
$getDocs = $conn->query("SELECT * FROM doctors")->num_rows;
$getPatients = $conn->query("SELECT * FROM users")->num_rows;
$getPending = $conn->query("SELECT * FROM `users`,`complaints` WHERE users.p_id=complaints.user_id and complaints.dept =$doc_dpt and complaints.d_id=0");
$cntPending = $getPending->num_rows;
$getCompleted = $conn->query("SELECT * FROM `users`,`complaints` WHERE users.p_id=complaints.user_id and complaints.d_id=$id and complaints.c_status='completed'");
$cntCompleted = $getCompleted->num_rows;
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
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget">
							<span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
							<div class="dash-widget-info text-right">
								<h3><?php echo $getDocs ?></h3>
								<span class="widget-title1">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget">
							<span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
							<div class="dash-widget-info text-right">
								<h3><?php echo $getPatients ?></h3>
								<span class="widget-title2">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget">
							<span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
							<div class="dash-widget-info text-right">
								<h3><?php echo $cntCompleted ?></h3>
								<span class="widget-title3">Attend <i class="fa fa-check" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="dash-widget">
							<span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
							<div class="dash-widget-info text-right">
								<h3><?php echo $cntPending  ?></h3>
								<span class="widget-title4">Pending <i class="fa fa-check" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-6 col-xl-6">
						<div class="card">
							<div class="card-body">
								<div class="chart-title">
									<h4>Patient Total</h4>
									<span class="float-right"><i class="fa fa-caret-up" aria-hidden="true"></i> 15% Higher than Last Month</span>
								</div>
								<canvas id="linegraph"></canvas>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-6 col-xl-6">
						<div class="card">
							<div class="card-body">
								<div class="chart-title">
									<h4>Patients In</h4>
									<div class="float-right">
										<ul class="chat-user-total">
											<li><i class="fa fa-circle current-users" aria-hidden="true"></i>ICU</li>
											<li><i class="fa fa-circle old-users" aria-hidden="true"></i> OPD</li>
										</ul>
									</div>
								</div>
								<canvas id="bargraph"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12 col-xl-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">Pending Complaints</h4> <a href="complaints.php" class="btn btn-primary float-right">View all</a>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table mb-0">
										<thead class="d-none">
											<tr>
												<th>Patient Name</th>
												<th>Doctor Name</th>
												<th>Timing</th>
												<th class="text-right">Status</th>
											</tr>
										</thead>
										<tbody>
											<?php if ($cntPending === 0) : ?>
												<div class="card">
													<div class="alert alert-info alert-dismissible fade show" role="alert">
														There is no pending complants
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
												</div>
											<?php endif; ?>
											<?php foreach ($getPending as $key => $pend) : ?>
												<?php $patientName = $pend['p_firstname'] . " " . $pend['p_lastname']; ?>
												<tr>
													<td style="min-width: 200px;">
														<a class="avatar" href="profile.php"><?php echo $patientName[0] ?></a>
														<h2><a href="#!"><?php echo $patientName ?> <span><?php echo $pend['p_state'] ?>, Nigeria</span></a></h2>
													</td>
													<td>
														<h5 class="time-title p-0">Complaints For</h5>
														<p><?php echo $doc_dept ?></p>
													</td>
													<td>
														<h5 class="time-title p-0">Timing</h5>
														<p><?php echo relative_date(strtotime($pend['c_time_sent'])) ?></p>
													</td>
													<td class="text-right">
														<a href="complaints.php?complaint_id=<?php echo $pend['c_id'] ?>&&patient_id=<?php echo $pend['p_id'] ?>&&patient_name=<?php echo $patientName; ?>" class="btn btn-outline-primary take-btn">Take up</a>
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
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12 col-xl-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">Diagnosed Patients </h4> <a href="complaints.php" class="btn btn-primary float-right">View all</a>
							</div>
							<div class="card-block">
								<div class="table-responsive">
									<table class="table mb-0 new-patient-table">
										<tbody>
											<?php
											$btnColors = array("btn-primary-one", "btn-primary-two", "btn-primary-three", "btn-primary-four");
											$rand_colors = array_rand($btnColors, 2);
											?>
											<?php foreach ($getCompleted as $key => $value) : ?>
												<tr>
													<td>
														<img width="28" height="28" class="rounded-circle" src="../users/assets/img/<?php echo $value['p_dp'] ?>" alt="">
														<h2><?php echo $value['p_firstname'] . ' ' . $value['p_lastname']; ?></h2>
													</td>
													<td><?php echo $value['p_email'] ?></td>
													<td><?php echo $value['p_tel'] ?></td>
													<td><button class="btn btn-primary <?php echo $btnColors[$rand_colors[0]] ?> float-right"><?php echo $value['diagnosis'] ?></button></td>
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
		</div>
	</div>
	<div class="sidebar-overlay" data-reff=""></div>
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.slimscroll.js"></script>
	<script src="assets/js/Chart.bundle.js"></script>
	<script src="assets/js/chart.js"></script>
	<script src="assets/js/app.js"></script>

</body>



</html>
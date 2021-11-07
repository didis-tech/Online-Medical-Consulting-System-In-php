<?php
session_start();
$active="home";
if(isset($_SESSION['doc_id'])  && isset($_SESSION['doc_login'])  && $_SESSION['doc_login'] == true ){
    echo "<script> window.location='./doctors'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- login23:11-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <!-- Site Icons -->
   <link rel="shortcut icon" href="./images/fevicon.ico.png" type="image/x-icon" />
   <link rel="apple-touch-icon" href="./images/apple-touch-icon.png">
   <title>E-Diagnosis - Online Medical Consulting System</title>
    <link rel="stylesheet" type="text/css" href="doctors/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="doctors/assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="doctors/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/animate.css">
    <link rel="stylesheet" type="text/css" href="./css/Lobibox.min.css">
    <style>
        .account-box:hover{
            
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
    <script src="doctors/assets/js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="main-wrapper account-wrapper" style="background: url('./images/price-bg.png')">
        <div class="account-page">
			<div class="account-center">
				<div class="account-box">
                    <form id="docLogin" class="form-signin" method="post">
						<div class="account-logo">
                            <a href="index.php"><img src="images/icon-logo.png" alt=""></a>
                        </div>
                        <div class="form-group">
                            <label>Username or Email</label>
                            <input type="email" name="email" autofocus="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group text-right">
                            <a href="forgot-password.php">Forgot your password?</a>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="login_doctor" class="btn btn-primary account-btn">Login</button>
                        </div>
                    </form>
                    <script type="text/javascript">

										$('#docLogin').submit(function(event) {

															// stop the form refreshing the page
															event.preventDefault();

															$('.form-group').removeClass('has-error'); // remove the error class
															$('.help-block').remove(); // remove the error text

													$.ajax({
															url: 'resources/login-doctor.php',
															data: $(this).serialize(),
															type: "POST",
															dataType: "json",
															success: function (data) {
                                                                if(data.title == 'Sorry'){
                                                                
                                                                    Lobibox.notify(data.type, {
																	position: 'top right',
																	title: data.title,
																	msg: data.message
																});
                                                                }else if (data.title ==='inactive'){
                                                                    window.location = 'doctors/change-password2.php'
                                                                }else if (data.title ==='active'){
                                                                    window.location = 'doctors/'
                                                                }
																
															}
													});
										});
								</script>
                </div>
			</div>
        </div>
    </div>
    
	<script src="doctors/assets/js/popper.min.js"></script>
    <script src="doctors/assets/js/bootstrap.min.js"></script>
    <script src="doctors/assets/js/app.js"></script>
<!-- notification -->
<script type="text/javascript" src="js/Lobibox.js"></script>
<script type="text/javascript" src="js/notification-active.js"></script>
</body>


<!-- login23:12-->
</html>
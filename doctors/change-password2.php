<!DOCTYPE html>
<html lang="en">


<!-- change-password224:03-->
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
    <link rel="stylesheet" type="text/css" href="../css/animate.css">
    <link rel="stylesheet" type="text/css" href="../css/Lobibox.min.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script>
    $( document ).ready(function() {
        var check1 = false;
        var check2 = false;
    $('#password, #confirm_password').on('keyup', function () {
        if ($('#password').val().length > 6) {
            $( "#check1" ).prop( "checked", true );
            check1 = true;
        } else {
            $( "#check1" ).prop( "checked", false );
            check1 = false;
        }
        if ($('#password').val() == $('#confirm_password').val()) {
            $( "#check2" ).prop( "checked", true );
            check2 = true;
        } else {
            $( "#check2" ).prop( "checked", false );
            check2 = false;
        }
        if(check1 == true && check2 == true){
            $('#submit').removeClass("disabled");
        }else{
            $('#submit').addClass("disabled");
        }
        });
        console.log( "ready!" );
        Lobibox.notify('info', {
			position: 'top right',
			title: 'Welcome',
			msg: 'Please change your password!'
		});
});
</script>
</head>

<body>
    <div class="main-wrapper account-wrapper" style="background: url('../images/price-bg.png')">
        <div class="account-page">
			<div class="account-center">
                <div class="account-box">
                    <form class="form-signin" id="changePassword">
						<div class="account-logo">
                            <a href="index-2.html"><img src="../images/icon-logo.png" alt=""></a>
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" id="password" name="password" class="form-control" autofocus required/>
                        </div>
                        <div id="message"></div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" autofocus required/>
                        </div>
                        <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <!-- Default checked -->
      <div class="custom-control custom-checkbox">
        <input type="checkbox" style="background: green" class="custom-control-input" id="check1" disabled />
        <label class="custom-control-label" for="check1">Password up to 6 characters</label>
      </div>
    </li>
    <li class="list-group-item">
      <!-- Default checked -->
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="check2" disabled />
        <label class="custom-control-label" for="check2">Password Matching.</label>
      </div>
    </li>
  </ul>
  <hr>
                        <div class="form-group text-center">
                            <button id="submit" class="btn btn-primary account-btn disabled" type="submit">Reset Password</button>
                        </div>
                    </form>
                    <script type="text/javascript">

										$('#changePassword').submit(function(event) {

															// stop the form refreshing the page
															event.preventDefault();

															$('.form-group').removeClass('has-error'); // remove the error class
															$('.help-block').remove(); // remove the error text

													$.ajax({
															url: '../resources/changePassword.php',
															data: $(this).serialize(),
															type: "POST",
															dataType: "json",
															success: function (data) {
                                                                    Lobibox.notify(data.type, {
																	position: 'top right',
																	title: data.title,
																	msg: data.message
																});
                                                                setTimeout(
                                                                    window.location = './',
                                                                     3000);

															}
													});
										});
								</script>
                </div>
			</div>
        </div>
    </div>

	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- notification -->
<script type="text/javascript" src="../js/Lobibox.js"></script>
<script type="text/javascript" src="../js/notification-active.js"></script>
</body>


<!-- change-password224:03-->
</html>

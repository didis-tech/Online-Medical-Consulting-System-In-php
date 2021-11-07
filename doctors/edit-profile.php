<?php
session_start();
$active="profile";
if(!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true ){
    echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';

$states = array(
    "Abia",
"Adamawa",
"AkwaIbom",
"Anambra",
"Bauchi",
"Bayelsa",
"Benue",
"Borno",
"Cross River",
"Delta",
"Ebonyi",
"Edo",
"Ekiti",
"Enugu",
"FCT",
"Gombe",
"Imo",
"Jigawa",
"Kaduna",
"Kano",
"Katsina",
"Kebbi",
"Kogi",
"Kwara",
"Lagos",
"Nasarawa",
"Niger",
"Ogun",
"Ondo",
"Osun",
"Oyo",
"Plateau",
"Rivers",
"Sokoto",
"Taraba",
"Yobe",
"Zamafara")
?>
<!DOCTYPE html>
<html lang="en">


<!-- edit-profile23:03-->
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
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
    <link rel="stylesheet" type="text/css" href="../css/animate.css">
    <link rel="stylesheet" type="text/css" href="../css/Lobibox.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./../css/croppie.css">
    <script src="./../js/croppie.js" ></script>
</head>

<body>
    <div class="main-wrapper">
    <?php require 'header.php'; ?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Edit Profile</h4>
                    </div>
                </div>

                    <div class="card-box">
                        <h3 class="card-title">Basic Informations</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap" id="upload-demo-i"  data-toggle="modal" data-target="#myModal">
                                    <img class="inline-block" src="<?php echo $doc_dp ?>" alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <a href="#myModal" data-toggle="modal" data-target="#myModal" class="upload"></a>
                                    </div>
                                </div>

<form id="update">
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Name</label>
                                                <input type="text" name="name" value="<?php echo $doc_name ?>" class="form-control floating"  required/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Role</label>
                                                <input type="text" value="<?php echo $doc_role ?>" class="form-control floating" value="John" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-box">
                        <h3 class="card-title">Contact Informations</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-focus">
                                    <label class="focus-label">Address</label>
                                    <input type="text" name="address" class="form-control floating" value="<?php echo $doc_address ?>" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus">
                                    <label class="focus-label">States</label>
                                    <select name="state" class="select form-control floating" id="sel1" required>
                                    <?php foreach ($states as $key => $state): ?>
                                    <option value="<?php echo $state ?>" <?php if($state == $doc_state) echo "selected" ?>><?php echo $state ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus">
                                    <label class="focus-label">Country</label>
                                    <input type="text" class="form-control floating" value="Nigeria" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus">
                                    <label class="focus-label">Phone Number</label>
                                    <input name="tel" type="text" class="form-control floating" value="<?php echo $doc_phone ?>"  required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-focus">
                                    <label class="focus-label">Email Address</label>
                                    <input name="email" type="email" class="form-control floating" value="<?php echo $doc_email ?> " required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center m-t-20">
                        <button class="btn btn-primary submit-btn" type="submit">Save</button>
                    </div>
                </form>
                <script type="text/javascript">

										$('#update').submit(function(event) {

															// stop the form refreshing the page
															event.preventDefault();

															$('.form-group').removeClass('has-error'); // remove the error class
															$('.help-block').remove(); // remove the error text

													$.ajax({
															url: '../resources/update_doc.php',
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
    <!-- The Modal -->
<div id="myModal"  class="modal fade delete-modal" role="dialog">
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
                                    <br/>
                                    <input type="file" id="upload">
                                    <br/>
                                    <button class="btn btn-success upload-result">Upload Image</button>
                                    </div>
                                    <div class="col-md-12" class="user-profile-img">
                                    <div id="upload-demo-i" ></div>
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


                              $('#upload').on('change', function () {
                                var reader = new FileReader();
                                  reader.onload = function (e) {
                                    $uploadCrop.croppie('bind', {
                                      url: e.target.result
                                    }).then(function(){
                                      console.log('jQuery bind complete');
                                    });

                                  }
                                  reader.readAsDataURL(this.files[0]);
                              });


                              $('.upload-result').on('click', function (ev) {
                              var vidFileLength = $("#upload")[0].files.length;
                                                if(vidFileLength === 0){
                                                    alert("No file selected.");
                                                }else{
                                                    $('#upload-result').addClass("disabled");
                                          $uploadCrop.croppie('result', {
                                            type: 'canvas',
                                            size: 'viewport'
                                          }).then(function (resp) {


                                            $.ajax({
                                              url: "../resources/doc_upload_dp.php",
                                              type: "POST",
                                              data: {"image":resp},
                                              success: function (data) {
                                              $('#myModal').modal('hide');
                                                html = '<img src="' + resp + '"  class="inline-block"/><div class="fileupload btn"><span class="btn-text">edit</span><a class="upload" href="#!" data-toggle="modal" data-target="#myModal"></a></div>';
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
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/popper.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/jquery.slimscroll.js"></script>
      <script src="assets/js/select2.min.js"></script>
  	<script src="assets/js/moment.min.js"></script>
  	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
      <script src="assets/js/app.js"></script>
    <!-- notification -->
<script type="text/javascript" src="../js/Lobibox.js"></script>
<script type="text/javascript" src="../js/notification-active.js"></script>
</body>


<!-- edit-profile23:05-->
</html>

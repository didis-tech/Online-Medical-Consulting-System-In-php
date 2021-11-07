<?php
session_start();
$active="complaints";
if(!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true ){
    echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';

$count=0;
$types = array(
    "text",
"file");
if (!isset($_GET['complaint_id'])) {
    header("location: complaints.php");
}else {
  $c_id=$_GET['complaint_id'];
   $getAns=$conn -> query("SELECT * FROM `patient_answers`,`questions` where patient_answers.que=questions.que_id and patient_answers.c_id=$c_id");
   $getPnts=$conn->query("SELECT * FROM `users`,`complaints` WHERE users.p_id=complaints.user_id and complaints.c_id=$c_id");
   $getRes=$conn->query("SELECT * FROM `complaints`,`response` WHERE complaints.c_id=response.c_id and response.c_id=$c_id");
   $cntPnts=$getPnts->num_rows;
   $user=$getPnts->fetch_assoc();
   if ($user['c_status'] ==='completed') {
       header("location: complaints.php");
   }
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- tabs23:58-->
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
    <!-- Load TinyMCE -->
  <script src="../js/tinymce-dist-master/tinymce.min.js" type="text/javascript"></script>
  <script type="text/javascript">
  tinymce.init({
  selector:'.tinymce',

  plugins: 'lists link image code',
  toolbar: 'undo redo | styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link image | code',
  theme: 'silver',
  mobile: {
  theme: 'mobile',
  plugins: 'autosave lists autolink',
  toolbar: 'undo bold italic styleselect'
  },
  lists_indent_on_tab: false
  });
  </script>
</head>

<body>
    <div class="main-wrapper">

    <?php require 'header.php'; ?>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title"> <?php echo $user['p_firstname']." ".$user['p_lastname']; ?>'s Complaints</h4>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card-box">
                            <ul class="nav nav-tabs nav-tabs-top nav-justified">
                                <li class="nav-item"><a class="nav-link" href="#top-justified-tab1" data-toggle="tab">Patient's Complaints</a></li>
                                <?php
                                $checkForResponse=$conn->query("SELECT * FROM `response` WHERE c_id =$c_id");
                                 ?>
                                <?php if ($checkForResponse->num_rows !==0): ?>
                                  <li class="nav-item"><a class="nav-link" href="#top-justified-tab2" data-toggle="tab">Response</a></li>
                                <?php endif; ?>
                                <li class="nav-item"><a class="nav-link active" href="#top-justified-tab3" data-toggle="tab">Diagnose</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane " id="top-justified-tab1">

                                    <div class="accordion" id="accordionExample">
                                      <?php $ansCount=0; ?>
                                      <?php foreach ($getAns as $key => $value): ?>
                                        <?php $ansCount=$ansCount+1; ?>
                                        <div class="card">
                                          <div class="card-header" id="heading<?php echo $ansCount ?>">
                                            <h2 class="mb-0">
                                              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $ansCount ?>" aria-expanded="true" aria-controls="collapse<?php echo $ansCount ?>">
                                                #<?php echo $ansCount ?>: <?php echo $value['que_desc'] ?>
                                              </button>
                                            </h2>
                                          </div>

                                          <div id="collapse<?php echo $ansCount ?>" class="collapse <?php if ($ansCount === 1) echo "show"; ?>" aria-labelledby="heading<?php echo $ansCount ?>" data-parent="#accordionExample">
                                            <div class="card-body bg bg-secondary" style="color:#fff;border-style: inset;">
                                              <?php if ($value['que_type'] === "file"): ?>
                                                <img src="../<?php echo $value['ans'] ?>" alt="" width="100%" class="img-thumbnail">
                                              <?php else: ?>
                                                Ans: <?php echo $value['ans'] ?>
                                              <?php endif; ?>

                                            </div>
                                          </div>
                                        </div>
                                      <?php endforeach; ?>

                                    </div>
                                    <center>
                                    <a href="#!" class="btn btn-primary btn-rounded"  data-toggle="modal" data-target="#addQue"><i class="fa fa-plus"></i> Add</a>
                                  </center>
                                </div>
                                <div class="tab-pane" id="top-justified-tab2">
                                  <div class="accordion" id="accordionExample">
                                    <?php $resCount=0; ?>
                                    <?php foreach ($getRes as $key => $res): ?>
                                      <?php $resCount=$resCount+1; ?>
                                      <div class="card">
                                        <div class="card-header" id="heading<?php echo $resCount ?>">
                                          <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $resCount ?>" aria-expanded="true" aria-controls="collapse<?php echo $resCount ?>">
                                              #<?php echo $resCount ?>: <?php echo $res['res_ques'] ?>
                                            </button>
                                          </h2>
                                        </div>

                                        <div id="collapse<?php echo $resCount ?>" class="collapse <?php if ($resCount === 1) echo "show"; ?>" aria-labelledby="heading<?php echo $ansCount ?>" data-parent="#accordionExample">
                                          <div class="card-body bg bg-secondary" style="color:#fff;border-style: inset;">
                                            <?php if ($value['que_type'] === "file"): ?>
                                              <img src="../<?php echo $value['ans'] ?>" alt="" width="100%" class="img-thumbnail">
                                            <?php else: ?>
                                              Ans: <?php echo $value['ans'] ?>
                                            <?php endif; ?>
                                          </div>
                                        </div>
                                      </div>
                                    <?php endforeach; ?>

                                  </div>
                                </div>

                                <div class="tab-pane show active" id="top-justified-tab3">
                                    <?php require 'diagnose.php'; ?>
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
          <input type="hidden" name="p_id" value="<?php echo $user['p_id'] ?>">
          <input type="hidden" name="p_email" value="<?php echo $user['p_email'] ?>">
            <input type="hidden" name="complaint_id" value="<?php echo $user['c_id'] ?>">
          <input type="hidden" name="p_name" value="<?php echo $user['p_firstname'].' '.$user['p_lastname']; ?>">
                                      <label class="focus-label">Question</label>
                                      <textarea type="text" class="form-control floating" name="question" required></textarea>
                                  </div>
                              <div class="form-group form-focus">
                                      <label class="focus-label">Type</label>
                                      <select name="type" class="select form-control floating"  required>
                                          <option value="" selected disabled>Select type...</option>
                                      <?php foreach ($types as $key => $type): ?>
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
                    url: '../resources/add_response.php',
                    data: $(this).serialize(),
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $( "#table" ).load(window.location.href + " #table" );
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
    <script src="assets/js/tagsinput.js"></script>
    <!-- notification -->
<script type="text/javascript" src="../js/Lobibox.js"></script>
<script type="text/javascript" src="../js/notification-active.js"></script>
</body>


<!-- tabs23:59-->
</html>

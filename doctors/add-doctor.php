<?php
session_start();
$active = "doctors";
if (!isset($_SESSION['doc_id'])  || !isset($_SESSION['doc_login'])  || $_SESSION['doc_login'] !== true) {
  echo "<script>alert('You have to login first.'); window.location='../doctors-signin.php'; </script>";
}
require '../resources/db_connect.php';
require '../resources/fetch-doctor.php';

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
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
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
          <div class="col-lg-8 offset-lg-2">
            <h4 class="page-title">Add Doctor</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 offset-lg-2">
            <form method="post" id="add_doc">
              <div class="form-group">
                <label for="email">Name:</label>
                <input type="text" name="name" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="pwd">Phone:</label>
                <input type="text" name="tel" class="form-control" id="pwd">
              </div>
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" name="email" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label class="control-label">State of Origin</label>
                <select onchange="toggleLGA(this);" name="state" id="state" class="select form-control floating">
                  <option value="" selected="selected">- Select -</option>
                  <option value="Abia">Abia</option>
                  <option value="Adamawa">Adamawa</option>
                  <option value="AkwaIbom">AkwaIbom</option>
                  <option value="Anambra">Anambra</option>
                  <option value="Bauchi">Bauchi</option>
                  <option value="Bayelsa">Bayelsa</option>
                  <option value="Benue">Benue</option>
                  <option value="Borno">Borno</option>
                  <option value="Cross River">Cross River</option>
                  <option value="Delta">Delta</option>
                  <option value="Ebonyi">Ebonyi</option>
                  <option value="Edo">Edo</option>
                  <option value="Ekiti">Ekiti</option>
                  <option value="Enugu">Enugu</option>
                  <option value="FCT">FCT</option>
                  <option value="Gombe">Gombe</option>
                  <option value="Imo">Imo</option>
                  <option value="Jigawa">Jigawa</option>
                  <option value="Kaduna">Kaduna</option>
                  <option value="Kano">Kano</option>
                  <option value="Katsina">Katsina</option>
                  <option value="Kebbi">Kebbi</option>
                  <option value="Kogi">Kogi</option>
                  <option value="Kwara">Kwara</option>
                  <option value="Lagos">Lagos</option>
                  <option value="Nasarawa">Nasarawa</option>
                  <option value="Niger">Niger</option>
                  <option value="Ogun">Ogun</option>
                  <option value="Ondo">Ondo</option>
                  <option value="Osun">Osun</option>
                  <option value="Oyo">Oyo</option>
                  <option value="Plateau">Plateau</option>
                  <option value="Rivers">Rivers</option>
                  <option value="Sokoto">Sokoto</option>
                  <option value="Taraba">Taraba</option>
                  <option value="Yobe">Yobe</option>
                  <option value="Zamfara">Zamafara</option>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label">LGA of Origin</label>
                <select name="lga" id="lga" class="form-control select-lga" required>
                </select>
              </div>
              <div class="form-group">
                <label for="pwd">Dept:</label>
                <?php $getDept = $conn->query("SELECT * FROM `departments`  order by dept_name"); ?>
                <select class="form-control" id="sel1" name="dept">
                  <?php foreach ($getDept as $key => $dept) : ?>
                    <option value="<?php echo $dept['dept_id'] ?>"><?php echo $dept['dept_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="email">Address:</label>
                <input type="text" name='address' class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="email">Role:</label>
                <?php
                $enum_sql = "SHOW COLUMNS FROM doctors LIKE 'doc_role'";
                $result_id = $conn->query($enum_sql);
                while ($row = $result_id->fetch_assoc()) {
                  $type = $row["Type"];
                }

                // format the values
                // $type currently has the value of: enum('Equipment','Set','Show')

                // ouput will be: Equipment','Set','Show')
                $output = str_replace("enum('", "", $type);

                // $output will now be: Equipment','Set','Show
                $output = str_replace("')", "", $output);

                // array $results contains the ENUM values
                $results = explode("','", $output);

                // create HTML select object
                echo "<select class='select form-control floating' id='menuType' name='role' required>
                <option disabled selected>Select Role</option>
                ";
                foreach ($results as $key => $value) {
                  echo "<option value='$value'>$value</option>";
                  continue;
                }

                // close HTML select object
                echo "</select>";
                ?>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <script type="text/javascript">
              $('#add_doc').submit(function(event) {

                // stop the form refreshing the page
                event.preventDefault();

                $('.form-group').removeClass('has-error'); // remove the error class
                $('.help-block').remove(); // remove the error text

                $.ajax({
                  url: '../resources/add_doc.php',
                  data: $(this).serialize(),
                  type: "POST",
                  dataType: "json",
                  success: function(data) {
                    Lobibox.notify(data.type, {
                      position: 'top right',
                      title: data.title,
                      msg: data.message
                    });
                    $('#add_doc').reset();

                  }
                });
              });
            </script>
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
  <script src="assets/js/moment.min.js"></script>
  <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
  <script src="assets/js/app.js"></script>
  <script src="../js/lga.min.js"></script>
</body>


<!-- add-doctor24:06-->

</html>
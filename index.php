<?php $conn = mysqli_connect("localhost", "root", "", "ediagnosis"); ?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- Site Metas -->
<title>E-Diagnosis - Online Medical Consulting System</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<!-- Site Icons -->
<link rel="shortcut icon" href="images/icon-logo.png" type="image/x-icon" />
<link rel="apple-touch-icon" href="images/icon-logo.png">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Site CSS -->
<link rel="stylesheet" href="style.css">
<!-- Colors CSS -->
<link rel="stylesheet" href="css/colors.css">
<!-- ALL VERSION CSS -->
<link rel="stylesheet" href="css/versions.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="css/responsive.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>

<!-- Modernizer for Portfolio -->
<script src="js/modernizer.js"></script>
<!-- [if lt IE 9] -->
<script>
   $(document).ready(function() {
      var check1 = false;
      var check2 = false;
      $('#password, #confirm_password').on('keyup', function() {
         if ($('#password').val().length > 6) {
            $("#check1").prop("checked", true);
            check1 = true;
         } else {
            $("#check1").prop("checked", false);
            check1 = false;
         }
         if ($('#password').val() == $('#confirm_password').val()) {
            $("#check2").prop("checked", true);
            check2 = true;
         } else {
            $("#check2").prop("checked", false);
            check2 = false;
         }
         if (check1 == true && check2 == true) {
            $('#submit').removeClass("disabled");
            $('#submit').prop('disabled', false);
         } else {
            $('#submit').addClass("disabled");
            $('#submit').prop('disabled', true);
         }
      });
      console.log("ready!");

   });
</script>
<!-- notifications CSS
============================================ -->
<link rel="stylesheet" href="css/Lobibox.min.css">
<style media="screen">
   .disabled {
      opacity: 0.6;
      cursor: not-allowed;
   }
</style>
</head>

<body class="clinic_version">
   <!-- LOADER -->
   <div id="preloader">
      <img class="preloader" src="images/loaders/heart-loading2.gif" alt="">
   </div>
   <!-- END LOADER -->
   <header>
      <div class="header-top wow fadeIn">
         <div class="container">
            <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="image"></a>
            <div class="right-header">
               <div class="header-info">
                  <div class="info-inner">
                     <span class="icontop"><img src="images/phone-icon.png" alt="#"></span>
                     <span class="iconcont"><a href="tel:08143307959">08143307959</a></span>
                  </div>
                  <div class="info-inner">
                     <span class="icontop"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                     <span class="iconcont"><a data-scroll href="mailto:info@Ediagnosis.com">info@Ediagnosis.com</a></span>
                  </div>
                  <div class="info-inner">
                     <span class="icontop"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                     <span class="iconcont"><a data-scroll href="#">Daily: 7:00am - 8:00pm</a></span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="header-bottom wow fadeIn">
         <div class="container">
            <nav class="main-menu">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i class="fa fa-bars" aria-hidden="true"></i></button>
               </div>

               <div id="navbar" class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                     <li><a class="active" href="index.php">Home</a></li>
                     <li><a data-scroll href="#about">About us</a></li>
                     <li><a data-scroll href="#service">Services</a></li>
                     <li><a data-scroll href="#doctors">Doctors</a></li>
                     <li><a data-scroll href="#getintouch">Contact</a></li>
                     <li><a data-toggle="modal" href="#loginUser">Login</a></li>

                  </ul>
               </div>
            </nav>
            <div class="serch-bar">
               <div id="custom-search-input">
                  <div class="input-group col-md-12">
                     <input type="text" class="form-control input-lg" placeholder="Search" />
                     <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                           <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </header>
   <div id="home" class="parallax first-section wow fadeIn" data-stellar-background-ratio="0.4" style="background-image:url('images/doctor.jpg');">
      <div class="container">
         <div class="row">
            <div class="col-md-12 col-sm-12">
               <div class="text-contant">
                  <h2>
                     <span class="center"><span class="icon"><img src="images/icon-logo.png" alt="#" /></span></span>
                     <a href="" class="typewrite" data-period="2000" data-type='[ "Welcome to E-Diagnosis", "We Care About Your Health", "We are Expert!" ]'>
                        <span class="wrap"></span>
                     </a>
                  </h2>
               </div>
            </div>
         </div>
         <!-- end row -->
      </div>
      <!-- end container -->
   </div>
   <!-- end section -->
   <div id="loginUser" class="modal fade" role="dialog">
      <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
               <form id="login" class="form-login user">
                  <div class="form-group">
                     <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                  </div>
                  <div class="form-group">
                     <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                  </div>
                  <div class="form-group">
                     <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                     </div>
                  </div>
                  <button type="submit" href="index.html" name="login" class="btn btn-primary btn-user btn-block">
                     Login
                  </button>
                  <hr>
               </form>
               <script type="text/javascript">
                  $('#login').submit(function(event) {

                     // stop the form refreshing the page
                     event.preventDefault();

                     $('.form-group').removeClass('has-error'); // remove the error class
                     $('.help-block').remove(); // remove the error text

                     $.ajax({
                        url: 'resources/login.php',
                        data: $(this).serialize(),
                        type: "POST",
                        dataType: "json",
                        success: function(data) {
                           if (data.type === 'success') {
                              window.location = './users';
                           } else {
                              Lobibox.notify(data.type, {
                                 position: 'top right',
                                 title: data.title,
                                 msg: data.message
                              });
                           }




                        }
                     });
                  });
               </script>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>

      </div>
   </div>
   <div id="time-table" class="time-table-section">
      <div class="container">
         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="row">
               <div class="service-time one" style="background:#5e5ea7;">
                  <span class="info-icon"><i class="fa fa-ambulance" aria-hidden="true"></i></span>
                  <h3>Emergency Case</h3>
                  <p>For cases of emergency, please call our us for instructions.</p>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="row">
               <div class="service-time middle" style="background:#4c4c88;">
                  <span class="info-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                  <h3>Working Hours</h3>
                  <div class="time-table-section">
                     <ul>
                        <li><span class="left">Monday - Friday</span><span class="right">8.00 – 18.00</span></li>
                        <li><span class="left">Saturday</span><span class="right">8.00 – 16.00</span></li>
                        <li><span class="left">Sunday</span><span class="right">8.00 – 13.00</span></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="row">
               <div class="service-time three" style="background:#3c3c6c;">
                  <span class="info-icon"><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
                  <h3>Clinic Timetable</h3>
                  <p>Get help at any time.</p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="about" class="section wow fadeIn">
      <div class="container">
         <div class="heading">
            <span class="icon-logo"><img src="images/icon-logo.png" alt="#"></span>
            <h2>E-Diagnosis </h2>
         </div>
         <!-- end title -->
         <div class="row">
            <div class="col-md-6">
               <div class="message-box">
                  <h4>What We Do</h4>
                  <h2>Our Service</h2>
                  <p class="lead">Get medical tips and possible diagnosis</p>
                  <p> Get fast medical advices from experts without the stress of hospitals delays and booking appointments. </p>
                  <a href="#services" data-scroll class="btn btn-light btn-radius btn-brd grd1 effect-1">Learn More</a>
               </div>
               <!-- end messagebox -->
            </div>
            <!-- end col -->
            <div class="col-md-6">
               <div class="post-media wow fadeIn">
                  <img src="images/inline_image_preview.jpg" alt="" class="img-responsive">
                  <!--a href="http://www.youtube.com/watch?v=nrJtHemSPW4" data-rel="prettyPhoto[gal]" class="playbutton"><i class="flaticon-play-button"></i></a-->
               </div>
               <!-- end media -->
            </div>
            <!-- end col -->
         </div>
         <!-- end row -->
         <hr class="hr1">
         <div class="row">

            <div class="col-12">
               <div id="chart-container">
                  <canvas id="graphCanvas"></canvas>
               </div>
               <script>
                  var totalFrequency = 0;
                  $(document).ready(function() {
                     showGraph();
                     setInterval(() => {
                        checkSicknesses()
                     }, 1000);
                  });

                  function checkSicknesses() {
                     $.ajax({
                        url: './users/checkSicknesses.php',
                        data: $(this).serialize(),
                        type: "POST",
                        dataType: "json",
                        success: function(data) {
                           if (totalFrequency !== data) {
                              showGraph();
                              totalFrequency = data;
                           }

                        }
                     });
                  }

                  function showGraph() {
                     {
                        $.post("data.php",
                           function(data) {
                              console.log(data);
                              var name = [];
                              var marks = [];

                              for (var i in data) {
                                 name.push(data[i].s_name);
                                 marks.push(data[i].frequency);
                              }

                              var chartdata = {
                                 labels: name,
                                 datasets: [{
                                    label: 'Diagnosed',
                                    backgroundColor: '#3c3c6c',
                                    borderColor: '#46d5f1',
                                    hover: false,
                                    hoverBackgroundColor: '#36afa2',
                                    hoverBorderColor: '#666666',
                                    data: marks
                                 }]
                              };

                              var graphTarget = $("#graphCanvas");

                              var barGraph = new Chart(graphTarget, {
                                 type: 'bar',
                                 data: chartdata
                              });
                           });
                     }
                  }
               </script>
            </div>
         </div>
         <!-- end row -->
      </div>
      <!-- end container -->
   </div>
   <div id="service" class="services wow fadeIn">
      <div class="container">
         <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
               <div class="inner-services">
                  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                     <div class="serv">
                        <span class="icon-service"><img src="images/service-icon2.png" alt="#" /></span>
                        <h4>FIRST HAND HEALTH CARE</h4>
                        <p>Get medical care/advice at the comfort of your home.</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                     <div class="serv">
                        <span class="icon-service"><img src="images/service-icon2.png" alt="#" /></span>
                        <h4>QUALIFIED DOCTORS</h4>
                        <p>Authentic dataset of qualified doctors in Nigeria.</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                     <div class="serv">
                        <span class="icon-service"><img src="images/service-icon2.png" alt="#" /></span>
                        <h4>DETAILED SPECIALIST</h4>
                        <p>Get diagnosed now.</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
               <div class="appointment-form">
                  <h3><span>+</span> Sign Up</h3>
                  <div class="form">
                     <form id="register">
                        <fieldset>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <input type="text" id="name" placeholder="Your Firstname" name="firstname" required />
                                 </div>
                                 <div class="form-group">
                                    <input type="text" placeholder="Lastname" id="lastname" name="lastname" required />
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <input type="email" placeholder="Email Address" id="email" name="email" required />
                                 </div>
                              </div>
                           </div>

                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <input type="date" name="DoB" value="" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 select-section">
                              <div class="row">
                                 <div class="form-group">
                                    <select onchange="toggleLGA(this);" name="state" id="state" class="form-control" required>
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
                                    <select name="lga" id="lga" class="form-control select-lga" required>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <input type="text" placeholder="Address" name="address" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <input type="text" placeholder="Phone number" name="phone" required>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" autofocus required />
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="form-control" autofocus required />
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <hr>
                                 <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                       <!-- Default checked -->
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="check1" disabled />
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
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="form-group">
                                    <div class="center"><button type="submit" id="submit">Submit</button></div>
                                 </div>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                     <script type="text/javascript">
                        $('#register').submit(function(event) {

                           // stop the form refreshing the page
                           event.preventDefault();

                           $('.form-group').removeClass('has-error'); // remove the error class
                           $('.help-block').remove(); // remove the error text

                           $.ajax({
                              url: 'resources/user-reg.php',
                              data: $(this).serialize(),
                              type: "POST",
                              dataType: "json",
                              success: function(data) {
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
         </div>
      </div>
   </div>
   <!-- end section -->

   <!-- doctor -->

   <div id="doctors" class="parallax section db" data-stellar-background-ratio="0.4" style="background:#fff;" data-scroll-id="doctors" tabindex="-1">
      <div class="container">

         <div class="heading">
            <span class="icon-logo"><img src="images/icon-logo.png" alt="#"></span>
            <h2>E-Diagnosis</h2>
         </div>

         <div class="row dev-list text-center">
            <?php $getAdminRand = $conn->query("SELECT * FROM `doctors` order by rand() limit 3"); ?>
            <?php foreach ($getAdminRand as $key => $doc) : ?>
               <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
                  <div class="widget clearfix">
                     <img src="doctors/assets/img/<?php echo $doc['doc_dp']; ?>" alt="" class="img-responsive img-rounded">
                     <div class="widget-title">
                        <h3><?php echo $doc['doc_name']; ?></h3>
                        <small><?php echo $doc['doc_role']; ?></small>
                     </div>
                     <!-- end title -->
                     <p><?php echo $doc['doc_email']; ?></p>

                     <div class="footer-social">
                        <a href="#" class="btn grd1"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="btn grd1"><i class="fa fa-github"></i></a>
                        <a href="#" class="btn grd1"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="btn grd1"><i class="fa fa-linkedin"></i></a>
                     </div>
                  </div>
                  <!--widget -->
               </div><!-- end col -->
            <?php endforeach; ?>


         </div><!-- end row -->
      </div><!-- end container -->
   </div>


   <!-- end doctor section -->

   <div id="getintouch" class="section wb wow fadeIn" style="padding-bottom:0;">
      <div class="container">
         <div class="heading">
            <span class="icon-logo"><img src="images/icon-logo.png" alt="#"></span>
            <h2>Get in Touch</h2>
         </div>
      </div>
      <div class="contact-section">
         <div class="form-contant">
            <form id="ajax-contact" action="assets/mailer.php" method="post">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group in_name">
                        <input type="text" class="form-control" placeholder="Name" required="required">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group in_email">
                        <input type="email" class="form-control" placeholder="E-mail" required="required">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group in_email">
                        <input type="tel" class="form-control" id="phone" placeholder="Phone" required="required">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group in_email">
                        <input type="text" class="form-control" id="subject" placeholder="Subject" required="required">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group in_message">
                        <textarea class="form-control" id="message" rows="5" placeholder="Message" required="required"></textarea>
                     </div>
                     <div class="actions">
                        <input type="submit" value="Send Message" name="submit" id="submitButton" class="btn small" title="Submit Your Message!">
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div id="googleMap" style="width:100%;height:450px;"></div>
      </div>
   </div>
   <footer id="footer" class="footer-area wow fadeIn">
      <div class="container">
         <div class="row">
            <div class="col-md-4">
               <div class="logo padding">
                  <a href=""><img src="images/logo.png" alt=""></a>
                  <p>We care about your health.</p>
               </div>
            </div>
            <div class="col-md-4">
               <div class="footer-info padding">
                  <h3>CONTACT US</h3>
                  <p><i class="fa fa-map-marker" aria-hidden="true"></i> University of Nigeria, Nsukka.</p>
                  <p><i class="fa fa-paper-plane" aria-hidden="true"></i> info@ediagnosis.com</p>
                  <p><i class="fa fa-phone" aria-hidden="true"></i> (+234) 814 330 7959</p>
               </div>
            </div>
            <div class="col-md-4">
               <div class="subcriber-info">
                  <h3>SUBSCRIBE</h3>
                  <p>Get healthy news, tip and solutions to your problems from our experts.</p>
                  <div class="subcriber-box">
                     <form id="mc-form" class="mc-form">
                        <div class="newsletter-form">
                           <input type="email" autocomplete="off" id="mc-email" placeholder="Email address" class="form-control" name="EMAIL">
                           <button class="mc-submit" type="submit"><i class="fa fa-paper-plane"></i></button>
                           <div class="clearfix"></div>
                           <!-- mailchimp-alerts Start -->
                           <div class="mailchimp-alerts">
                              <div class="mailchimp-submitting"></div>
                              <!-- mailchimp-submitting end -->
                              <div class="mailchimp-success"></div>
                              <!-- mailchimp-success end -->
                              <div class="mailchimp-error"></div>
                              <!-- mailchimp-error end -->
                           </div>
                           <!-- mailchimp-alerts end -->
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </footer>
   <div class="copyright-area wow fadeIn">
      <div class="container">
         <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
               <div class="social">
                  <ul class="social-links">
                     <li><a href=""><i class="fa fa-rss"></i></a></li>
                     <li><a href=""><i class="fa fa-facebook"></i></a></li>
                     <li><a href=""><i class="fa fa-twitter"></i></a></li>
                     <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                     <li><a href=""><i class="fa fa-youtube"></i></a></li>
                     <li><a href=""><i class="fa fa-pinterest"></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end copyrights -->
   <a href="#home" data-scroll class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>
   <!-- all js files -->
   <script src="js/all.js"></script>

   <!-- notification -->
   <script type="text/javascript" src="js/Lobibox.js"></script>
   <!-- all plugins -->
   <script src="js/custom.js"></script>
   <script src="js/lga.min.js"></script>

</body>

</html>
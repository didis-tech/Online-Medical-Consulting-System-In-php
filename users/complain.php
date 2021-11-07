<?php
session_start();
$active = "home";
if (!isset($_SESSION['user_id'])  || !isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true) {
  echo "<script>alert('You have to login first.'); window.location='../'; </script>";
}
if (!isset($_GET['dept'])) {
  header('location: departments.php');
} else {
  require '../resources/db_connect.php';
  require '../resources/fetch.php';
  $dept_id = $_GET['dept'];
  $getDept = $conn->query("SELECT * FROM `departments` where dept_id = $dept_id");
  $dept = $getDept->fetch_assoc();
  $_SESSION['sess_id'] = session_id();
  $_SESSION['count'] = 0;
  $checkComplaint = $conn->query("SELECT * FROM `complaints` where user_id ='$id' and c_status='pending' or c_status='in progress'");
  if ($checkComplaint->num_rows > 0) {
    $cmpt = $checkComplaint->fetch_assoc();
    $cmptID = $cmpt['c_id'];
  } else {
    $sqlcomplaints = "INSERT INTO complaints (user_id,dept)
VALUES ('$id','$dept_id')";

    if ($conn->query($sqlcomplaints) === TRUE) {
      $cmptID = $conn->insert_id;
    }
  }
}

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

  <script src="assets/js/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/animate.css">
  <link rel="stylesheet" type="text/css" href="../css/Lobibox.min.css">
  <link rel="stylesheet" type="text/css" href="dropzone/dropzone.css" />
  <link rel="stylesheet" type="text/css" href="dropzone/css/styles.css" />
  <style media="screen">
    .disable-click {
      pointer-events: none;
    }
  </style>
  <script type="text/javascript">
    let count;
    let totalQues;

    function updateScroll() {
      var element = document.getElementById("chats");
      element.scrollTop = element.scrollHeight;
    }

    function getComplaints() {
      $.post("getComplaints.php", {
          c_id: "<?php echo $cmptID ?>"
        },
        function(data, status) {
          if (data.type === 'info') {
            $(".typing-text").html(" ");

            getQuestion(data.count);
          } else {
            var n = data.length - 1;
            var complants = data;
            var op = '';
            for (let i = 0; i <= n; i++) {
              if (data[i].que_type === "file") {
                op += `<div class="chat chat-left animated bounce">
      <div class="chat-avatar">
         <a href="profile.html" class="avatar">
         <img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">
         </a>
      </div>
     <div class="chat-body">
       <div class="chat-bubble">
       <div class="chat-content">
       <p> ${data[i].que_desc} </p>
         <span class="chat-time">${data[i].time}</span>
         </div>
         </div>
     </div>
  </div>
  <div class="chat chat-right">
      <div class="chat-body">
       <div class="chat-bubble">
        <div class="chat-content img-content">
       <a class="chat-img-attach" href="#">
           <img width="182" height="137" alt="img" src="../${data[i].ans}">
           <div class="chat-placeholder">
               <div class="chat-img-name">file</div>
           </div>
       </a>
              </div>
          </div>
      </div>
  </div>`;
              } else {
                op += `<div class="chat chat-left animated bounce">
      <div class="chat-avatar">
          <a href="profile.html" class="avatar">
             <img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">
          </a>
      </div>
      <div class="chat-body">
       <div class="chat-bubble">
        <div class="chat-content">
        <p> ${data[i].que_desc} </p>
                  <span class="chat-time">${data[i].time}</span>
              </div>
          </div>
      </div>
  </div>
  <div class="chat chat-right">
      <div class="chat-body">
       <div class="chat-bubble">
        <div class="chat-content">
        <p> ${data[i].ans} </p>
                  <span class="chat-time">${data[i].time}</span>
              </div>
          </div>
      </div>
  </div>`;
              }

            }
            $(".answered").html(op);
            $(".typing-text").html(" ");
            getQuestion(data[n].count);
          }

          console.log(data);
          updateScroll();
        });
    }

    function getQuestion(cnt) {
      var newCount = cnt;
      console.log('newCount: ' + newCount);
      $.post("getQues.php", {
          dept: "<?php echo $dept_id ?>"
        },
        function(data, status) {
          if (data.type === 'info') {
            Lobibox.notify(data.type, {
              position: 'top right',
              title: data.title,
              msg: data.message
            });
            $(".typing-text").html(" ");
          } else {
            var n = data.length;
            console.log('length: ' + n);
            var questions = data;

            var op = '';
            if (newCount >= n) {
              op += `<div class="chat chat-left animated fadeInLeft">
                 <div class="chat-avatar">
                     <a href="profile.html" class="avatar">
                        <img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">
                     </a>
                 </div>
                 <div class="chat-body">
                  <div class="chat-bubble">
                   <div class="chat-content">
                             <span class="btn btn-success" onclick="window.history.back();return false;">End Session</span>
                         </div>
                     </div>
                 </div>
             </div>`;
              $('#answerArea').html('');
            } else {
              op += `<div class="chat chat-left animated fadeInLeft">
                 <div class="chat-avatar">
                     <a href="profile.html" class="avatar">
                        <img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">
                     </a>
                 </div>
                 <div class="chat-body">
                  <div class="chat-bubble">
                   <div class="chat-content">
                   <p> ${data[newCount].que_desc} </p>
                             <span class="chat-time">...</span>
                         </div>
                     </div>
                 </div>
             </div>`;
              $("#question").val(data[newCount].que_id);

              $("#fileQuestion").val(data[newCount].que_id);
              if (data[newCount].que_type === "file") {
                $("#answer").prop("disabled", true);
                if ($(".attach-icon").hasClass("disable-click")) {
                  $(".attach-icon").removeClass("disable-click");
                }

              } else {
                $(".attach-icon").addClass("disable-click");
              }
            }


            $("#count").val(newCount);
            $(".question").html(op);
            updateScroll();
            $(".typing-text").html(" ");
          }

          console.log(data);
        });
    }

    function submitAns() {
      var answer = $('#answer').val();
      var question = $('#question').val();
      var count = $('#count').val();
      var sess_id = "<?php echo $_SESSION['sess_id']; ?>";
      var dept = "<?php echo $dept_id ?>";
      var userid = "<?php echo $_SESSION['user_id'] ?>";
      if (answer === "") {
        Lobibox.notify('warning', {
          position: 'top right',
          title: 'Sorry',
          msg: 'Provide an answer before sending'
        });
      } else {
        $.post("submitAns.php", {
            answer: answer,
            question: question,
            sess_id: sess_id,
            dept: dept,
            userid: userid,
            count: count,
            c_id: "<?php echo $cmptID ?>"
          },
          function(data, status) {
            if (data.type !== 'success') {
              Lobibox.notify(data.type, {
                position: 'top right',
                title: data.title,
                msg: data.message
              });
              $(".typing-text").html(" ");
            } else {
              getComplaints();
              $("#answer").val("");
            }
          });
      }
      updateScroll();
    }
    $(document).ready(function() {
      getComplaints();
      getQuestion(0);
      $(".typing-text").html("typing...");

    })
  </script>
</head>

<body>
  <div class="main-wrapper">
    <div class="header">
      <div class="header-left">
        <a href="index.php" class="logo">
          <img src="../images/icon-logo.png" width="35" height="35" alt=""> <span>E-Diagnosis</span>
        </a>
      </div>
      <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
      <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
      <ul class="nav user-menu float-right">

        <li class="nav-item dropdown has-arrow">
          <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
            <span class="user-img" id="user-img">
              <img class="rounded-circle" src="<?php echo $dp ?>" width="24" alt="User">
              <span class="status online"></span>
            </span>
            <span><?php echo $firstname ?></span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="edit-profile.php">Edit Profile</a>
            <a class="dropdown-item" href="settings.php">Settings</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
      <div class="dropdown mobile-user-menu float-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="profile.php">My Profile</a>
          <a class="dropdown-item" href="edit-profile.php">Edit Profile</a>
          <a class="dropdown-item" href="settings.php">Settings</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
    <div class="sidebar" id="sidebar">
      <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu">
          <ul>
            <li>
              <a href="#!" onclick="window.history.back();return false;"><i class="fa fa-home back-icon"></i> <span>Go Back</span></a>
            </li>
            <li class="menu-title">Doctors <a href="#" class="add-user-icon" data-toggle="modal" data-target="#add_chat_user"><i class="fa fa-plus"></i></a></li>
            <?php $getDeptDocs = $conn->query("SELECT * FROM `doctors` WHERE doc_dept=$dept_id"); ?>
            <?php foreach ($getDeptDocs as $key => $doc) : ?>
              <li>
                <a href="#!"><span class="chat-avatar-sm user-img"><img src="../doctors/assets/img/<?php echo $doc['doc_dp'] ?>" alt="" class="rounded-circle">
                    <?php if ($doc['doc_status'] === 'active') : ?>
                      <span class="status online"></span>
                    <?php else : ?>
                      <span class="status offline"></span>
                    <?php endif; ?>
                  </span> <?php echo $doc['doc_name'] ?> </a>
              </li>

            <?php endforeach; ?>

          </ul>
        </div>
      </div>
    </div>
    <div class="page-wrapper">
      <div class="chat-main-row">
        <div class="chat-main-wrapper">
          <div class="col-lg-9 message-view chat-view">
            <div class="chat-window">
              <div class="fixed-header">
                <div class="navbar">
                  <div class="user-details mr-auto">
                    <div class="float-left user-img m-r-10">
                      <a href="#!" title="<?php echo $dept['dept_name'] ?>"><img src="assets/img/dept.png" alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                    </div>
                    <div class="user-info">
                      <a href="#!"><span class="font-bold"><?php echo $dept['dept_name'] ?></span> <i class="typing-text"></i></a>
                    </div>
                  </div>

                </div>
              </div>
              <div class="chat-contents">
                <div class="chat-content-wrap">
                  <div class="chat-wrap-inner">
                    <div class="chat-box">
                      <div class="chats" id="chats">
                        <div class="answered">

                        </div>
                        <div class="question">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="chat-footer" id="answerArea">
                <div class="message-bar">
                  <div class="message-inner">
                    <a class="link attach-icon" href="#" data-toggle="modal" data-target="#drag_files" data-backdrop="static" data-keyboard="false"><img src="assets/img/attachment.png" alt=""></a>
                    <div class="message-area">
                      <div class="input-group">
                        <input type="hidden" id="question">

                        <input type="hidden" id="count">
                        <textarea class="form-control" id="answer" placeholder="Type message..."></textarea>
                        <span class="input-group-append">
                          <button class="btn btn-primary" onClick="submitAns()" type="button"><i class="fa fa-send"></i></button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div id="drag_files" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Drag and drop files upload</h3>
              <button type="button" class="close" data-dismiss="modal" onclick="location.reload()">&times;</button>
            </div>
            <div class="modal-body">
              <div id="dropzone1">
                <form name="frmImage" method="post" action="addComplaintFile.php?c_id=<?php echo $cmptID ?>&&action=save" class="dropzone">
                  <input type="hidden" id="fileQuestion" name="fileQuestion" />
                  <input type="hidden" id="sess_id2" name="sess_id2" value="<?php echo $_SESSION['sess_id'] ?>" />
                  <input type="hidden" id="userid2" name="userid2" value="<?php echo $id ?>" />
                  <input type="hidden" id="c_id2" name="c_id2" value="<?php echo $cmptID ?>" />
                  <input type="hidden" id="dept2" name="dept2" value="<?php echo $dept_id ?>" />
                </form>

              </div>
              <div class="m-t-30 text-center">
                <button class="btn btn-primary submit-btn" onclick="location.reload()">Add to upload</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="sidebar-overlay" data-reff=""></div>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.slimscroll.js"></script>
  <script src="assets/js/app.js"></script>
  <!-- notification -->
  <script type="text/javascript" src="../js/Lobibox.js"></script>
  <script type="text/javascript" src="../js/notification-active.js"></script>
  <!--  dropzone JS
============================================ -->
  <script type="text/javascript" src="dropzone/dropzone.js"></script>
</body>

<!-- chat23:29-->

</html>
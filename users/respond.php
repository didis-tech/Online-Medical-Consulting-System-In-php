<?php
session_start();
$active="home";
if(!isset($_SESSION['user_id'])  || !isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true ){
    echo "<script>alert('You have to login first.'); window.location='../'; </script>";
}
if (!isset($_GET['c_id'])) {
  header('location: complaints.php');
}else {
  require '../resources/db_connect.php';
  require '../resources/fetch.php';
  $c_id=$_GET['c_id'];
  $getDept= $conn ->query("SELECT * FROM `departments`,`complaints` where departments.dept_id = complaints.dept and complaints.c_id=$c_id");
  $dept=$getDept->fetch_assoc();
  $_SESSION['sess_id']=session_id();
  $_SESSION['count']=0;

}

?>
<?php
if (! empty($_FILES)) {
    $imagePath = isset($_FILES["file"]["name"]) ? $_FILES["file"]["name"] : "Undefined";
    $targetPath = "../../../img/gallery/";
    $imagePath = $targetPath . $imagePath;
    $tempFile = $_FILES['file']['tmp_name'];
    $File = $_FILES['file']['name'];
    // Valid extension
    $valid_ext = array('png','jpeg','jpg');
    // thumbnail Location
    $location = "img/thumbnail/".$File;
    $thumbnail_location = "../../../img/thumbnail/".$File;

    // file extension
    $file_extension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);

// Check extension
if(in_array($file_extension,$valid_ext)){

    // Upload file
    if(move_uploaded_file($_FILES['file']['tmp_name'],$imagePath)){

        // Compress Image
        compressImage($_FILES['file']['type'],$imagePath,$thumbnail_location,60);

      echo "true";
    }

}
}
// Compress image
function compressImage($type,$source, $destination, $quality) {

    $info = getimagesize($source);

    if ($type == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($type == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($type == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

}
if (! empty($_GET["action"]) && $_GET["action"] == "save") {
    $resp_id=$_GET['fileQuestion'];
    print $query = "UPDATE response SET
    `response`='$File',
    `res_status`='answered'
    WHERE `resp_id`='$resp_id'
    ";
    mysqli_query($conn, $query);
    $current_id = mysqli_insert_id($conn);
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
    <script type="text/javascript">
    let count;
    let totalQues;

    function getComplaints() {
      $.post("getResponses.php",
       {
           c_id: "<?php echo $c_id ?>"
       },
       function(data, status){
           if (data.type === 'info') {
             $( ".typing-text" ).html( " " );

             getQuestion(data.count);
           } else {
           var n=data.length-1;
           var complants = data;
           var op='';
           for(let i = 0; i <= n; i++){
             if (data[i].type ==="file" ) {
               op +='<div class="chat chat-left animated bounce">'
                   +'<div class="chat-avatar">'
                      + '<a href="profile.html" class="avatar">'
                      +    '<img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">'
                      + '</a>'
                   +'</div>'
                  + '<div class="chat-body">'
                    +'<div class="chat-bubble">'
                    + '<div class="chat-content">'
                    + '<p>'+ data[i].res_ques +'</p>'
                      +         '<span class="chat-time">8:35 am</span>'
                      +     '</div>'
                      + '</div>'
                  + '</div>'
               +'</div>'
               +'<div class="chat chat-right">'
                  + '<div class="chat-body">'
                    +'<div class="chat-bubble">'
                    + '<div class="chat-content img-content">'
                    +'<a class="chat-img-attach" href="#">'
                        +'<img width="182" height="137" alt="img" src="../'+data[i].res_ans+'">'
                        +'<div class="chat-placeholder">'
                            +'<div class="chat-img-name">file</div>'
                        +'</div>'
                    +'</a>'
                      +     '</div>'
                      + '</div>'
                  + '</div>'
               +'</div>';
             }else {
               op +='<div class="chat chat-left animated bounce">'
                   +'<div class="chat-avatar">'
                      + '<a href="profile.html" class="avatar">'
                      +    '<img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">'
                      + '</a>'
                   +'</div>'
                  + '<div class="chat-body">'
                    +'<div class="chat-bubble">'
                    + '<div class="chat-content">'
                    + '<p>'+ data[i].res_ques +'</p>'
                      +         '<span class="chat-time">8:35 am</span>'
                      +     '</div>'
                      + '</div>'
                  + '</div>'
               +'</div>'
               +'<div class="chat chat-right">'
                  + '<div class="chat-body">'
                    +'<div class="chat-bubble">'
                    + '<div class="chat-content">'
                    + '<p>'+ data[i].res_ans +'</p>'
                      +         '<span class="chat-time">8:35 am</span>'
                      +     '</div>'
                      + '</div>'
                  + '</div>'
               +'</div>';
             }

          }
           $(".answered").html(op);
             $( ".typing-text" ).html( " " );
             getQuestion(data[n].count);
           }

           console.log(data);
       });
    }
    function getQuestion(cnt) {
      var newCount=cnt;
      console.log('newCount: '+newCount);
      $.post("getResQues.php",
       {
           c_id: "<?php echo $c_id ?>"
       },
       function(data, status){
           if (data.type === 'info') {
             Lobibox.notify(data.type, {
               position: 'top right',
               title: data.title,
               msg: data.message
             });
             $( ".typing-text" ).html( " " );
           } else {
           var n=data.length;
           console.log('length: '+n);
           var questions = data;

           var op='';
           if (newCount >= 1) {
             op +='<div class="chat chat-left animated fadeInLeft">'
                 +'<div class="chat-avatar">'
                    + '<a href="profile.html" class="avatar">'
                    +    '<img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">'
                    + '</a>'
                 +'</div>'
                + '<div class="chat-body">'
                  +'<div class="chat-bubble">'
                  + '<div class="chat-content">'
                    +         '<span><a class="btn btn-success" href="endResponseSession.php?c_id=<?php echo $c_id ?>">End Session</a></span>'
                    +     '</div>'
                    + '</div>'
                + '</div>'
             +'</div>';
             $('#answerArea').html('');
           } else {
             op +='<div class="chat chat-left animated fadeInLeft">'
                 +'<div class="chat-avatar">'
                    + '<a href="profile.html" class="avatar">'
                    +    '<img alt="Dept" src="assets/img/dept.png" class="img-fluid rounded-circle">'
                    + '</a>'
                 +'</div>'
                + '<div class="chat-body">'
                  +'<div class="chat-bubble">'
                  + '<div class="chat-content">'
                  + '<p>'+ data[newCount].res_ques +'</p>'
                    +         '<span class="chat-time">8:35 am</span>'
                    +     '</div>'
                    + '</div>'
                + '</div>'
             +'</div>';
             $("#question").val(data[newCount].resp_id );
             $("#fileQuestion").val(data[newCount].resp_id );

             if (data[newCount].type ==="file" ) {
                $( "#answer" ).prop( "disabled", true )
             }else {
               $(".attach-icon").addClass("disable-click");
             }
           }



             $("#count").val(newCount);
           $(".question").html(op);
             $( ".typing-text" ).html( " " );
           }

           console.log(data);
       });
    }
    function submitAns() {
      var answer = $('#answer').val();
      var question = $('#question').val();
      var count = $('#count').val();
      var responseFile = $('#responseFile').val();
      var sess_id = "<?php echo $_SESSION['sess_id']; ?>";
      var dept = "<?php echo $dept['dept'] ?>";
      var userid = "<?php echo $_SESSION['user_id'] ?>";
      if (answer === "" && responseFile=== "") {
        Lobibox.notify('warning', {
          position: 'top right',
          title: 'Sorry',
          msg: 'Provide an answer before sending'
        });
      } else {
        $.post("submitAns.php",
      {
          answer: answer,
          question: question,
          sess_id: sess_id,
          dept: dept,
          userid: userid,
          count: count,
          c_id: "<?php echo $c_id ?>"
      },
      function(data, status){
        if (data.type !== 'success') {
          Lobibox.notify(data.type, {
            position: 'top right',
            title: data.title,
            msg: data.message
          });
          $( ".typing-text" ).html( " " );
        } else {
          getComplaints();
            $("#answer").val("");
        }
      });
      }
    }
      $( document ).ready(function() {
getComplaints();
getQuestion(0);
        $( ".typing-text" ).html( "typing..." );

      })
    </script>
    <style media="screen">
    .disable-click{
  pointer-events:none;
}
    </style>
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
<?php $getDeptDocs= $conn->query("SELECT * FROM `doctors` WHERE doc_dept='".$dept['dept']."'"); ?>
<?php foreach ($getDeptDocs as $key => $doc): ?>
  <li>
      <a href="#!"><span class="chat-avatar-sm user-img"><img src="../doctors/assets/img/<?php echo $doc['doc_dp'] ?>" alt="" class="rounded-circle">
        <?php if ($doc['doc_status'] ==='active'): ?>
        <span class="status online"></span>
      <?php else: ?>
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
                            <div class="chat-footer"  id="answerArea">
                                <div class="message-bar">
                                    <div class="message-inner">
                                        <a class="link attach-icon" href="#" data-toggle="modal" data-target="#drag_files" data-backdrop="static" data-keyboard="false" ><img src="assets/img/attachment.png" alt=""></a>
                                        <div class="message-area">
                                            <div class="input-group">
                                              <input type="hidden" id="question" >

                                                <input type="hidden" id="count" >
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
                    <div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
                        <div class="chat-window video-window">
                            <div class="fixed-header">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a class="nav-link" href="#calls_tab" data-toggle="tab">Calls</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="#profile_tab" data-toggle="tab">Profile</a></li>
                                </ul>
                            </div>
                            <div class="tab-content chat-contents">
                                <div class="content-full tab-pane" id="calls_tab">
                                    <div class="chat-wrap-inner">
                                        <div class="chat-box">
                                            <div class="chats">
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <a href="profile.html" class="avatar">
                                                            <img alt="Cristina Groves" src="assets/img/doctor-thumb-03.jpg" class="img-fluid rounded-circle">
                                                        </a>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-bubble">
                                                            <div class="chat-content">
                                                                <span class="chat-user">You</span> <span class="chat-time">8:35 am</span>
                                                                <div class="call-details">
                                                                    <i class="material-icons">phone_missed</i>
                                                                    <div class="call-info">
                                                                        <div class="call-user-details">
                                                                            <span class="call-description">Jeffrey Warden missed the call</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <a href="profile.html" class="avatar">
                                                            <img alt="Jennifer Robinson" src="assets/img/patient-thumb-02.jpg" class="img-fluid rounded-circle">
                                                        </a>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-bubble">
                                                            <div class="chat-content">
                                                                <span class="chat-user">Jennifer Robinson</span> <span class="chat-time">8:35 am</span>
                                                                <div class="call-details">
                                                                    <i class="material-icons">call_end</i>
                                                                    <div class="call-info">
                                                                        <div class="call-user-details"><span class="call-description">This call has ended</span></div>
                                                                        <div class="call-timing">Duration: <strong>5 min 57 sec</strong></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="chat-line">
                                                    <span class="chat-date">January 29th, 2015</span>
                                                </div>
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <a href="profile.html" class="avatar">
                                                            <img alt="Cristina Groves" src="assets/img/doctor-thumb-03.jpg" class="img-fluid rounded-circle">
                                                        </a>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-bubble">
                                                            <div class="chat-content">
                                                                <span class="chat-user">You</span> <span class="chat-time">8:35 am</span>
                                                                <div class="call-details">
                                                                    <i class="material-icons">ring_volume</i>
                                                                    <div class="call-info">
                                                                        <div class="call-user-details">
                                                                            <a href="#" class="call-description call-description--linked" data-qa="call_attachment_link">Calling Jennifer ...</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-full tab-pane show active" id="profile_tab">
                                    <div class="display-table">
                                        <div class="table-row">
                                            <div class="table-body">
                                                <div class="table-content">
                                                    <div class="chat-profile-img">
                                                        <div class="edit-profile-img">
                                                            <img src="assets/img/doctor-03.jpg" alt="">
                                                            <span class="change-img">Change Image</span>
                                                        </div>
                                                        <h3 class="user-name m-t-10 mb-0">Cristina Groves</h3>
                                                        <small class="text-muted">Gynecologist</small>
                                                        <a href="edit-profile.html" class="btn btn-primary edit-btn"><i class="fa fa-pencil"></i></a>
                                                    </div>
                                                    <div class="chat-profile-info">
                                                        <ul class="user-det-list">
                                                            <li>
                                                                <span>Username:</span>
                                                                <span class="float-right text-muted">@cristina_groves</span>
                                                            </li>
                                                            <li>
                                                                <span>DOB:</span>
                                                                <span class="float-right text-muted">3rd March</span>
                                                            </li>
                                                            <li>
                                                                <span>Email:</span>
                                                                <span class="float-right text-muted">cristinagroves@example.com</span>
                                                            </li>
                                                            <li>
                                                                <span>Phone:</span>
                                                                <span class="float-right text-muted"> 770-889-6484</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="transfer-files">
                                                        <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-0">
                                                            <li class="nav-item"><a class="nav-link active" href="#all_files" data-toggle="tab">All Files</a></li>
                                                            <li class="nav-item"><a class="nav-link" href="#my_files" data-toggle="tab">My Files</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane show active" id="all_files">
                                                                <ul class="files-list">
                                                                    <li>
                                                                        <div class="files-cont">
                                                                            <div class="file-type">
                                                                                <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                            </div>
                                                                            <div class="files-info">
                                                                                <span class="file-name text-ellipsis">AHA Selfcare Mobile Application Test-Cases.xls</span>
                                                                                <span class="file-author"><a href="#">Loren Gatlin</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                                                            </div>
                                                                            <ul class="files-action">
                                                                                <li class="dropdown dropdown-action">
                                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                                                    <div class="dropdown-menu">
                                                                                        <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="tab-pane" id="my_files">
                                                                <ul class="files-list">
                                                                    <li>
                                                                        <div class="files-cont">
                                                                            <div class="file-type">
                                                                                <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                            </div>
                                                                            <div class="files-info">
                                                                                <span class="file-name text-ellipsis">AHA Selfcare Mobile Application Test-Cases.xls</span>
                                                                                <span class="file-author"><a href="#">John Doe</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                                                            </div>
                                                                            <ul class="files-action">
                                                                                <li class="dropdown dropdown-action">
                                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                                                                    <div class="dropdown-menu">
                                                                                        <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="drag_files" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Drag and drop files upload</h3>
							<button type="button" class="close" data-dismiss="modal" onclick="location.reload()">&times;</button>
                        </div>
                        <div class="modal-body">
                                <div  id="dropzone1">
                                  <form name="frmImage" method="post" action="addRespondFile.php?c_id=<?php echo $c_id ?>&&action=save"

                                      class="dropzone">
                                      <input type="hidden" id="fileQuestion" name="fileQuestion"/>
</form>

                                </div>

                            <div class="m-t-30 text-center">
                                <button class="btn btn-primary submit-btn" data-dismiss="modal">Add to upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="add_group" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Create a group</h3>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Groups are where your team communicates. They’re best when organized around a topic — #leads, for example.</p>
                            <form>
                                <div class="form-group">
                                    <label>Group Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Send invites to: <span class="text-muted-light">(optional)</span></label>
                                    <input class="form-control" type="text">
                                </div>
                                <div class="m-t-50 text-center">
                                    <button class="btn btn-primary submit-btn">Create Group</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="add_chat_user" class="modal fade " role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Create Chat Group</h3>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group m-b-30">
                                <input placeholder="Search to start a chat" class="form-control search-input" id="btn-input" type="text">
                                <span class="input-group-append">
									<button class="btn btn-primary">Search</button>
								</span>
                            </div>
                            <div>
                                <h5>Recent Conversations</h5>
                                <ul class="chat-user-list">
                                    <li>
                                        <a href="#">
                                            <div class="media">
												<span class="avatar align-self-center">J</span>
                                            <div class="media-body align-self-center text-nowrap">
                                                <div class="user-name">Jeffery Lalor</div>
                                                <span class="designation">Team Leader</span>
                                            </div>
                                            <div class="text-nowrap align-self-center">
                                                <div class="online-date">1 day ago</div>
                                            </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="media ">
												<span class="avatar align-self-center">B</span>
												<div class="media-body align-self-center text-nowrap">
													<div class="user-name">Bernardo Galaviz</div>
													<span class="designation">Web Developer</span>
												</div>
												<div class="align-self-center text-nowrap">
													<div class="online-date">3 days ago</div>
												</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="media">
												<span class="avatar align-self-center">
													<img src="assets/img/user.jpg" alt="John Doe">
												</span>
												<div class="media-body text-nowrap align-self-center">
													<div class="user-name">John Doe</div>
													<span class="designation">Web Designer</span>
												</div>
												<div class="align-self-center text-nowrap">
													<div class="online-date">7 months ago</div>
												</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="m-t-50 text-center">
                                <button class="btn btn-primary submit-btn">Create Group</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="share_files" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Share File</h3>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="files-share-list">
                                <div class="files-cont">
                                    <div class="file-type">
                                        <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                    </div>
                                    <div class="files-info">
                                        <span class="file-name text-ellipsis">AHA Selfcare Mobile Application Test-Cases.xls</span>
                                        <span class="file-author"><a href="#">Bernardo Galaviz</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Share With</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="m-t-50 text-center">
                                <button class="btn btn-primary submit-btn">Share</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="notification-box">
                <div class="msg-sidebar notifications msg-noti">
                    <div class="topnav-dropdown-header">
                        <span>Messages</span>
                    </div>
                    <div class="drop-scroll msg-list-scroll" id="msg_list">
                        <ul class="list-box">
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">R</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Richard Miles </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item new-message">
                                        <div class="list-left">
                                            <span class="avatar">J</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">John Doe</span>
                                            <span class="message-time">1 Aug</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">T</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Tarah Shropshire </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">M</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Mike Litorus</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">C</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Catherine Manseau </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">D</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Domenic Houston </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">B</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Buster Wigton </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">R</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Rolland Webber </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">C</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author"> Claire Mapes </span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">M</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Melita Faucher</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">J</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Jeffery Lalor</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">L</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Loren Gatlin</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="chat.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar">T</span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">Tarah Shropshire</span>
                                            <span class="message-time">12:28 AM</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="chat.html">See all messages</a>
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

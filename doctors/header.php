<?php require_once '../resources/calc_time.php'; ?>
<div class="header">
    <div class="header-left">
        <a href="index.php" class="logo">
            <img src="../images/icon-logo.png" width="35" height="35" alt=""> <span>E-Diagnosis</span>
        </a>
    </div>
    <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
    <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
    <ul class="nav user-menu float-right">
      <?php
      $notiQuery=$conn->query("SELECT * FROM `activities`,`users`,`doctors` WHERE activities.p_id=users.p_id AND activities.d_id=doctors.doc_id AND activities.d_id=$id AND activities.d_stat='not seen'");
      $noti_count=$notiQuery->num_rows > 0 ? $notiQuery->num_rows:""; ?>
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-danger float-right"><?php echo "$noti_count";?></span></a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span>Notifications</span>
                </div>
                <div class="drop-scroll">
                    <ul class="notification-list">
                      <?php foreach ($notiQuery as $key => $noti): ?>
                        <?php $noti_time=strtotime($noti['noti_time']); ?>
                        <li class="notification-message">
                            <a href="activities.php">
                                <div class="media">
                                    <span class="avatar">
                                        <img alt="<?php echo $noti['p_firstname'].' '.$noti['p_lastname'] ?>" src="../users/assets/img/<?php echo $noti['p_dp'] ?>" class="img-fluid">
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title"> <?php echo $noti['d_noti'] ?></p>
                                        <p class="noti-time"><span class="notification-time"><?php echo get_time_ago( $noti_time ) ?></span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                      <?php endforeach; ?>

                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="activities.php">View all Notifications</a>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img" id="user-img">
                    <img class="rounded-circle" src="<?php echo $doc_dp ?>" width="24" alt="Admin">
                    <span class="status online"></span>
                </span>
                <span>Admin</span>
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
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                <li class="<?php if(isset($active) && $active=='home') echo 'active'; ?>">
                    <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <?php if($doc_role !== "member" ): ?>
                <li class="<?php if(isset($active) && $active=='doctors') echo 'active'; ?>">
                    <a href="doctors.php"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                </li>
                <?php endif; ?>
                <li class="<?php if(isset($active) && $active=='patients') echo 'active'; ?>">
                    <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                </li>
                <li class="<?php if(isset($active) && $active=='dept') echo 'active'; ?>">
                    <a href="departments.php"><i class="fa fa-hospital-o"></i> <span>Departments</span></a>
                </li>
                <li class="<?php if(isset($active) && $active=='complaints') echo 'active'; ?>">
                    <a href="complaints.php"><i class="fa fa-pencil"></i> <span>Complaints</span></a>
                </li>
                <li class="<?php if(isset($active) && $active=='activities') echo 'active'; ?>">
                    <a href="activities.php"><i class="fa fa-list"></i> <span>Activities</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>

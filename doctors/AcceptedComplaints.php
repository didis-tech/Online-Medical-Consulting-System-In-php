<?php
$getAcptPnts = $conn->query("SELECT * FROM `users`,`complaints` WHERE users.p_id=complaints.user_id and complaints.dept =$doc_dpt and complaints.d_id=$id order by complaints.c_id desc");
$cntAcptPnts = $getAcptPnts->num_rows;
?>
<div class="row">

  <div class="col-md-12">

    <div class="table-responsive">
      <table id="table" class="table table-striped custom-table mb-0 datatable">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Age</th>
            <th>Date</th>
            <th class="text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $Acptcnt = 0; ?>
          <?php if ($cntAcptPnts > 0) : ?>

            <?php foreach ($getAcptPnts as $key => $p_row) : ?>
              <?php $Acptcnt = $Acptcnt + 1;
              $p_dob = $p_row['p_dob'];
              $today = new DateTime();
              $birthdate = new DateTime("$p_dob");
              $age = $today->diff($birthdate);

              ?>
              <tr>
                <td><?php echo $Acptcnt; ?></td>
                <td>
                  <img width="28" height="28" src="<?php echo "../users/assets/img/" . $p_row['p_dp']; ?>" class="rounded-circle m-r-5" alt="">
                  <?php echo $p_row['p_firstname'] . " " . $p_row['p_lastname']; ?>
                </td>
                <td><?php echo $age->format('%y years'); ?></td>
                <td><?php echo date("M. d, Y", strtotime($p_row['c_time_sent'])) ?></td>
                <td class="text-right">
                  <?php if ($p_row['c_status'] === 'completed') : ?>
                    <a class="btn btn-info" href="view-diagnosis.php?c_id=<?php echo $p_row['c_id']; ?>"><i class="fa fa-eye m-r-5"></i> View</a>
                  <?php else : ?>
                    <a class="btn btn-dark" href="patient-complaint.php?complaint_id=<?php echo $p_row['c_id']; ?>"><i class="fa fa-eye m-r-5"></i> View</a>
                  <?php endif; ?>
                </td>
              </tr>

            <?php endforeach; ?>

          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
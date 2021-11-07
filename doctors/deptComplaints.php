<?php
$getPnts = $conn->query("SELECT * FROM `users`,`complaints` WHERE users.p_id=complaints.user_id and complaints.dept =$doc_dpt and complaints.d_id=0 order by complaints.c_id desc");
$cntPnts = $getPnts->num_rows;
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
          <?php $cnt = 0; ?>
          <?php if ($cntPnts > 0) : ?>

            <?php foreach ($getPnts as $key => $user) : ?>
              <?php $cnt = $cnt + 1;
              $p_dob = $user['p_dob'];
              $today = new DateTime();
              $birthdate = new DateTime("$p_dob");
              $age = $today->diff($birthdate);

              ?>
              <tr>
                <td><?php echo $cnt; ?></td>
                <td>
                  <img width="28" height="28" src="<?php echo "../users/assets/img/" . $user['p_dp']; ?>" class="rounded-circle m-r-5" alt="">
                  <?php echo $user['p_firstname'] . " " . $user['p_lastname']; ?>
                </td>
                <td><?php echo $age->format('%y years'); ?></td>
                <td><?php echo date("M. d, Y", strtotime($user['c_time_sent'])) ?></td>
                <td class="text-right">
                  <div class="dropdown dropdown-action">
                    <a class="btn btn-info btn-sm" href="#!" data-toggle="modal" data-target="#view_ques<?php echo $user['c_id']; ?>"><i class="fa fa-eye m-r-5"></i> View</a>
                </td>
              </tr>
              <!-- Modal -->
              <div class="modal fade" id="view_ques<?php echo $user['c_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $user['p_firstname'] . " " . $user['p_lastname']; ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php
                      $c_id = $user['c_id'];
                      $getAns = $conn->query("SELECT * FROM `patient_answers`,`questions` where patient_answers.que=questions.que_id and patient_answers.c_id=$c_id"); ?>
                      <div class="row">
                        <div class="accordion" id="accordionExample">
                          <?php $ansCount = 0; ?>
                          <?php foreach ($getAns as $key => $value) : ?>
                            <?php $ansCount = $ansCount + 1; ?>
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
                                  <?php if ($value['que_type'] === "file") : ?>
                                    <img src="../<?php echo $value['ans'] ?>" alt="" width="100%" class="img-thumbnail">
                                  <?php else : ?>
                                    Ans: <?php echo $value['ans'] ?>
                                  <?php endif; ?>

                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>

                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a type="button" class="btn btn-primary" href="?complaint_id=<?php echo $c_id ?>&&patient_id=<?php echo $user['p_id'] ?>&&patient_name=<?php echo $user['p_firstname'] . ' ' . $user['p_lastname']; ?>">Respond</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>

          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
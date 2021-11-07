<script type="text/javascript">
  function selectSickness() {
    var selected=$("#diagnosis").val();
    if (selected === '0') {
      $(".selected-sickness").html('<input type="text" class="form-control" placeholder="Please, add a new possible diagnosis" name="new-sickness" required="">');
    } else {
$(".selected-sickness").html('<input type="text" class="form-control" name="selected" value="'+selected+'" readonly>');
    }
    console.log(selected);
  }
</script>
<div class="row">
    <div class="col-md-12">
        <form method="post" action="diagnose-patient.php">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Client <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name" value="<?php echo $user['p_firstname']." ".$user['p_lastname']; ?>" readonly>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Department <span class="text-danger">*</span></label>
                        <input class="form-control" name="dept" type="text" value="<?php echo $doc_dept ?>" class="select" readOnly>

                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="<?php echo $user['p_email'] ?>" readOnly>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input class="form-control" type="text" name="tel" value="<?php echo $user['p_tel'] ?>" readOnly>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Patient's Address</label>
                        <textarea class="form-control" name="address" rows="3" readonly><?php echo $user['p_address'] ?></textarea>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>State</label>
                        <input class="form-control" type="text" name="state" value="<?php echo $user['p_state'] ?>" readOnly>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                      <label>Local Government Area</label>
                      <input class="form-control" type="text" name="lga" value="<?php echo $user['p_lga'] ?>" readOnly>
                    </div>
                </div>
                <input type="hidden" name="c_id" value="<?php echo $c_id ?>">
                <input type="hidden" name="user_id" value="<?php echo $user['p_id'] ?>">
                <?php $getSicknesses=$conn->query("SELECT * FROM sicknesses"); ?>
                <div class="col-sm-6 col-md-3">
                  <div class="form-group">
                      <label>Possible diagnosis <span class="text-danger">*</span></label>
                      <select class="select form-control floating" name="diagnosis" id="diagnosis" onChange="selectSickness()">
                        <option selected disabled> select possible diagnosis</option>
                        <?php foreach ($getSicknesses as $key => $sickness): ?>
                          <option value="<?php echo $sickness['s_name'] ?>"><?php echo $sickness['s_name'] ?></option>
                        <?php endforeach; ?>
                          <option value="0">Add new possible sickness</option>
                      </select>
                      <div class="selected-sickness">

                      </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Other Information</label>
                                <textarea name="body" class="form-control tinymce" id="body"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center m-t-20">
                <button class="btn btn-primary submit-btn" type="submit">Save Invoice</button>
            </div>
        </form>
    </div>
</div>

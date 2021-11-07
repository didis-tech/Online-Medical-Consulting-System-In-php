<div class="row">
<div class="col-sm-5 col-6 text-right m-b-30">
<a href="#!" class="btn btn-primary btn-rounded"  data-toggle="modal" data-target="#addQue"><i class="fa fa-plus"></i> Add</a>
</div>
<div class="col-md-12">

<div class="table-responsive">
<table id="table" class="table table-striped custom-table mb-0 datatable">
<thead>
    <tr>
        <th>#</th>
        <th>Questions</th>
        <th>Type</th>
        <th class="text-right">Action</th>
    </tr>
</thead>
<tbody>
<?php foreach($getQues as $key => $que): ?>
   <?php $count=$count+1;
   if($que['que_type'] == 'text'){
       $status = 'status-green';
   }else{
    $status = 'status-purple';
   }
    ?>
    <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo $que['que_desc']; ?></td>
<td><span class="custom-badge <?php echo $status; ?>"><?php echo $que['que_type']; ?></span></td>
        <td class="text-right">
            <div class="dropdown dropdown-action">
                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#edit_ques<?php echo $que['que_id']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#delete_ques<?php echo $que['que_id']; ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                </div>
            </div>
        </td>
    </tr>
    <div id="edit_ques<?php echo $que['que_id']; ?>" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Update Question</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
                <div class="modal-body text-center">
                  <form id="editQues<?php echo $que['que_id']; ?>">
                    <input type="hidden" name="que_id" value="<?php echo $que['que_id']; ?>" required>
                      <input type="hidden" name="que_desc" value="<?php echo $que['que_desc']; ?>" required>
                  <div class="form-group form-focus">
                                                <label class="focus-label">Question</label>
                                                <textarea type="text" class="form-control floating" name="question" required><?php echo $que['que_desc']; ?></textarea>
                                            </div>
                                        <div class="form-group form-focus">
                                                <label class="focus-label">Type</label>
                                                <select name="type" class="select form-control floating" required>
                                                    <option value="" selected disabled>Select type...</option>
                                                <?php foreach ($types as $key => $type): ?>
                                                <option value="<?php echo $type ?>" <?php if ($type === $que['que_type']) echo "selected"; ?>><?php echo $type ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                        <div class="m-t-20 text-center">
                                            <button class="btn btn-primary submit-btn">Update</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">

            $('#editQues<?php echo $que['que_id']; ?>').submit(function(event) {

                                // stop the form refreshing the page
                                event.preventDefault();

                                $('.form-group').removeClass('has-error'); // remove the error class
                                $('.help-block').remove(); // remove the error text

                        $.ajax({
                                url: '../resources/update_ques.php',
                                data: $(this).serialize(),
                                type: "POST",
                                dataType: "json",
                                success: function (data) {
                                    $( "#table" ).load(window.location.href + " #table" );
                                $('#edit_ques<?php echo $que['que_id']; ?>').modal('hide');
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
            </div>
        </div>
    </div>
    <div id="delete_ques<?php echo $que['que_id']; ?>" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form id="delete<?php echo $que['que_id']; ?>">
                <input type="hidden" name="que_id" value="<?php echo $que['que_id']; ?>">

                <div class="modal-body text-center">
                    <img src="assets/img/sent.png" alt="" width="50" height="46">
                    <h3>Are you sure want to delete this Question?</h3>
                    <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
                </form>
                <script type="text/javascript">

$('#delete<?php echo $que['que_id']; ?>').submit(function(event) {

            // stop the form refreshing the page
            event.preventDefault();

            $('.form-group').removeClass('has-error'); // remove the error class
            $('.help-block').remove(); // remove the error text

    $.ajax({
            url: '../resources/delete_ques.php',
            data: $(this).serialize(),
            type: "POST",
            dataType: "json",
            success: function (data) {
                $( "#table" ).load(window.location.href + " #table" );
            $('#edit_ques<?php echo $que['que_id']; ?>').modal('hide');
                    Lobibox.notify(data.type, {
                    position: 'top right',
                    title: data.title,
                    msg: data.message
                });
                setTimeout(
                    location.reload(),
                     8000);

            }
    });
});
</script>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>

<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Assigned Targets |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Dashboard</a>
                <a target="_blank" href="<?= base_url('careers'); ?>" class="btn btn-outline-light btn-lg btn-block">Careers</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mb-2">
        <div class="col-xl-lg-6 col-md-6">
            <h2 class="font-weight-lighter">
                <?php if(empty($results)){ echo 'Targets'; }else{ echo "Search Results"; } ?>
            </h2>
        </div>
        <div class="col-xl-lg-6 col-md-6 text-right pull-right">
            <form action="<?= base_url('admin/search_targets'); ?>" method="get" class="form-inline pl-5">
                <div class="form-group pr-3">
                    <select name="target_month" class="form-control" title="Search targets by month">
                        <option value="" disabled selected>--Select Month--</option>
                        <?php
                            foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $monthNumber => $month) {
                                echo "<option value='$month, ".date('Y')."'>{$month}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group pr-3">
                    <select name="city" class="form-control">
                        <option value="" disabled selected>--Select City--</option>
                        <?php if(!empty($locations)): foreach($locations as $loc): ?>
									<option value="<?= $loc->name; ?>"><?= $loc->name; ?></option>
								<?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-outline-secondary btn-block">Search</button>
                </div>
            </form>
        </div>
    </div>
    <?php if($success = $this->session->flashdata('success')): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success"><?= $success; ?></div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 col-sm-12">
            <div class="table table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Serial #</th>
                            <th>Added By</th>
                            <th>Month</th>
                            <th>Employee Code, Name</th>
                            <th>Location</th>
                            <th>Target</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php if(empty($results)): ?>
                        <tbody>
                            <?php if(!empty($targets)): $serial = $this->uri->segment(3) + 1; foreach($targets as $target): ?>
                                <tr>
                                    <td><?= $serial++; ?></td>
                                    <td><?= $target->fullname; ?></td>
                                    <td><?= $target->target_month; ?></td>
                                    <td><?= $target->emp_id.', '.$target->emp_name; ?></td>
                                    <td><?= $target->emp_city; ?></td>
                                    <td><?= number_format($target->revenue_target); ?></td>
                                    <td><?= date("M d, Y", strtotime($target->created_at)); ?></td>
                                    <td><a data-id="<?= $target->target_id; ?>" class="btn btn-outline-primary btn-sm targets">Edit</a></td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    <?php elseif(!empty($results)): ?>
                        <tbody>
                        <?php $serial = $this->uri->segment(3) + 1; $total_targets = 0; foreach($results as $result):
                                $total_targets += $result->revenue_target; ?>
                            <tr>
                                <td><?= $serial++; ?></td>
                                <td><?= $result->fullname; ?></td>
                                <td><?= $result->target_month; ?></td>
                                <td><?= $result->emp_id.', '.$result->emp_name; ?></td>
                                <td><?= $result->emp_city; ?></td>
                                <td><?= number_format($result->revenue_target); ?></td>
                                <td><?= date("M d, Y", strtotime($result->created_at)); ?></td>
                                <td><a data-id="<?= $result->target_id; ?>" class="btn btn-outline-primary btn-sm targets">Edit</a></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        <?php if(!empty($results)): ?>
                        <tr class="table-success font-weight-bold">
                            <td colspan="5">Total</td>
                            <td colspan="3"><?= number_format($total_targets); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if(empty($results) AND empty($targets)): ?>
    <!-- Grid row -->
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 text-center">
            <div class="alert alert-danger">
                <h3 class="font-weight-lighter"><span class="display-3">Oops!</span> No record was found for your search.</h3>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Grid row -->
    <div class="row mt-4">
        <div class="col-xl-lg-12 col-md-12 text-center">
            <?php if(empty($results) AND !empty($targets)){ echo $this->pagination->create_links(); } ?>
        </div>
    </div>
</div>
<div class="modal fade" id="target_detail" tabindex="-1" role="dialog" aria-labelledby="team_infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Target</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-12">
                    <form action="<?= base_url('admin/update_target'); ?>" method="post">
                        <input type="hidden" name="target_id" id="target_id" value="">
                        <label for="revenue_target">Revenue Target</label>
                        <input type="text" name="revenue_target" class="form-control mb-2" id="revenue_target" value="">
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $('.targets').click(function(){  
    var target_id = $(this).data('id');
    // alert(target_id);
    // AJAX request
    $.ajax({
    url: '<?= base_url('admin/edit_target/'); ?>' + target_id,
    method: 'POST',
    dataType: 'JSON',
    data: {target_id: target_id},
      success: function(response){
        console.log(response);
        $('#target_id').val(response.id);
        $('#revenue_target').val(response.revenue_target);
        $('#target_detail').modal('show');
      }
    });
  });
});
</script>

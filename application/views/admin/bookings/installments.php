<div class="jumbotron jumbotron-fluid text-white" style="background-color: crimson;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Installments &raquo; History | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Home</a>
                <a href="<?= base_url('bookings'); ?>" class="btn btn-outline-light btn-lg btn-block">Bookings' Home</a>
            </div>
        </div>
    </div>
</div>
<div class="container mb-3">
    <?php if($success = $this->session->flashdata('success')): ?>
        <div class="row">
            <div class="col">
                <div class="alert alert-success"><?php echo $success; ?></div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($failed = $this->session->flashdata('failed')): ?>
        <div class="row">
            <div class="col">
                <div class="alert alert-danger"><?php echo $failed; ?></div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Installment Hisotry</h2>
        </div>
        <div class="col-md-4 text-right">
            <form action="<?= base_url('bookings/search_installment_history'); ?>" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search installment history..." aria-label="Search installment history..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table table-condensed table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Booking ID</th>
                        <th>Trx Mode</th>
                        <th title="Cheque status...">Status</th>
                        <th>Trx Amount</th>
                        <th title="Cheque or transaction date...">Trx Date</th>
                        <th>Date Recorded</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php if(!empty($installments)): ?>
                    <tbody id="history">
                        <?php foreach($installments as $inst): ?>
                            <tr>
                                <td><?= $inst->id; ?></td>
                                <td><?= $inst->customer_name; ?></td>
                                <td><?= $inst->booking_id < 10 ? '0' : ''; ?><?= $inst->booking_id; ?></td>
                                <td><?= ucfirst($inst->payment_mode); ?></td>
                                <td><?= ucfirst($inst->cheque_status); ?></td>
                                <td title="Paid in Pakistani Rupee, pkr."><?= number_format($inst->amount_paid); ?></td>
                                <td><?= date('M d, Y', strtotime($inst->date_added)); ?></td>
                                <td><?= date('M d, Y', strtotime($inst->created_at)); ?></td>
                                <td title="view which booking the installment was paid against ?">
                                    <a href="<?= base_url('bookings/booking_detail/'.$inst->booking_id); ?>">more</a> |
                                    <a class="installment_id" data-id="<?= $inst->id; ?>" href="#0" title="update cheque status...">edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php elseif(!empty($results)): ?>
                    <tbody id="history">
                        <?php foreach($results as $res): ?>
                            <tr>
                                <td><?= $res->id; ?></td>
                                <td><?= $res->customer_name; ?></td>
                                <td><?= $inst->booking_id < 10 ? '0' : ''; ?><?= $res->booking_id; ?></td>
                                <td><?= ucfirst($res->payment_mode); ?></td>
                                <td><?= ucfirst($res->cheque_status); ?></td>
                                <td title="Paid in Pakistani Rupee, pkr."><?= number_format($res->amount_paid); ?></td>
                                <td><?= date('M d, Y', strtotime($res->date_added)); ?></td>
                                <td><?= date('M d, Y', strtotime($res->created_at)); ?></td>
                                <td title="view which booking the installment was paid against ?">
                                    <a href="<?= base_url('bookings/booking_detail/'.$res->booking_id); ?>">more</a> |
                                    <a class="installment_id" data-id="<?= $res->id; ?>" href="#0" title="update cheque status...">edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<!-- Modal >> edit unit -->
<div class="modal fade" id="editTrxDetail" tabindex="-1" role="dialog" aria-labelledby="editTrxDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('bookings/update_cheque_status'); ?>" method="post" id="unitEdit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Cheque Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="installment_id" class="installment_id">
                    <div class="form-group">
                        <select name="cheque_status" class="custom-select cheque_status">
                            <option value="" selected disabled>Choose Status</option>
                            <option value="cleared">Cleared</option>
                            <option value="pending">Pending</option>
                            <option value="bounced">Bounced</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="date" name="date_added" class="form-control date_added">
                        <small class="help-text text-muted">Transaction date, change if it's changed!</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Search filter for installments
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#history tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  // update cheque status
  $('.installment_id').click(function(){
    installmentId = $(this).data('id');
    $.ajax({
        url: '<?= base_url('bookings/installment_detail/') ?>' + installmentId,
        method: 'post',
        dataType: 'json',
        data: {installmentId: installmentId},
        success: function(res){
            $('.installment_id').val(res.id);
            $('.date_added').val(res.date_added);
            $('.cheque_status').val(res.cheque_status);
            $('#editTrxDetail').modal('show');
        }
    });
  });
});
</script>
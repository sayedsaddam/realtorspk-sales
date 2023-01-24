<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Sales Stats |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
    <div class="row">
        <div class="col-xl-lg-4 col-md-4">
            <div class="row">
                <div class="col-xl-lg-4">
                    <h4 class="text-info display-4 font-weight-light">Sale detail</h4>
                    <h4 class="font-weight-light bg-info text-light px-2 py-2 rounded"><?= $detail[0]->emp_name; ?></h4>
                    <h4 class="font-weight-light"><?= $detail[0]->office; ?></h4>
                    <h4 class="font-weight-light"><?= $detail[0]->emp_city; ?></h4>
                    <h5 class="text-info mb-0">More Info</h5>
                    <?php foreach($detail as $det): ?>
                        <small><?= $det->edit_reason; ?></small>
                    <?php endforeach; echo '. '; ?>
                </div>
            </div>
        </div>
        <div class="col-xl-lg-8 col-md-8 table-responsive table-sm">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Amount Recieved</th>
                        <th>Project</th>
                        <th>Date Received</th>
                        <th>Date Recorded</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $serial = 1; $total = 0; foreach($detail as $res): if($res->rec_amount > 0): // Check if amount > 0 ?>
                    <?php $total += ((int)$res->rec_amount); ?>
                        <tr>
                            <td><?= $serial++; ?></td>
                            <td><?php if(!empty($res->rec_amount)){ echo number_format($res->rec_amount); }elseif($res->rec_amount < 1){ echo '0'; }else{ echo 'Edited'; } ?></td>
                            <td class="<?php if($res->project == 'Florenza'){ echo 'bg-primary text-light'; }else{ echo 'bg-secondary text-light'; } ?>"><?= $res->project; ?></td>
                            <td><?php if($res->rec_date == ''){ echo '<span class="badge badge-danger badge-pill">Not Available</span>'; }else{ echo date('M d, Y', strtotime($res->rec_date)); } ?></td>
                            <td><?= date('M d, Y', strtotime($res->created_at)); ?></td>
                            <td>
                                <a data-toggle="modal" data-target="#edit_sale<?= $res->id; ?>" href="" class="btn btn-primary btn-sm" title="In case you missed the Receiving date, here's a link to edit it.">Edit</a>
                                <?php if($this->session->userdata('username') == 'realtors' OR $this->session->userdata('username') == 'shahana.farah'): ?>
                                    <!-- Modal starts -->
                                    <div class="modal fade" id="edit_sale<?= $res->id; ?>" tabindex="-1" role="dialog" aria-labelledby="edit_saleTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Daily Sale Record</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <form action="<?= base_url('admin/update_daily_sale'); ?>" method="post">
                                                                <input type="hidden" name="daily_sale_id" value="<?= $res->id; ?>">
                                                                <div class="form-group">
                                                                    <label for="agent_name">Agent Name</label>
                                                                    <input type="text" name="agent_name" class="form-control" value="<?= $res->emp_name; ?>" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="rec-date">Receving Date</label>
                                                                    <input type="date" name="rec_date" class="form-control" value="<?= $res->rec_date; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="amount">Amount</label>
                                                                    <input type="text" name="amount_received" class="form-control" value="<?= $res->rec_amount; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="reason">Edit Reason</label>
                                                                    <textarea name="edit_reason" class="form-control" rows="5" placeholder="Do you have a minute to write a few words about why are you editing this?" required></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-info"> Note</span>
                                                            <p class="font-weight-lighter">In case you missed the receiving date while entering the daily sales record. Here you can fix it alongwith providing a valid reason for editing that specific entry.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Model ends -->
                                <?php endif; // session check session. ?>
                            </td>
                        </tr>
                    <?php endif; endforeach; ?>
                    <tr class="table-success">
                        <td class="font-weight-bold">Total</td>
                        <td colspan="4"></td>
                        <td class="font-weight-bold"><?= number_format($total); ?></td>
                    </tr>
                </tbody>
            </table>
  
        </div>
    </div>
    <hr>
    <div class="row">
      <!-- Locations summary chart -->
    
        <div class="col-md-12"><h3>Monthly Agent summary for <span class="text-danger font-weight-bold"><?= date('Y'); ?></span>.</h3></div>
    
    <div class="col-md-12" id="agentSummary" class="mb-5" style="height: 500px;"></div>
    </div>


</div>
<script>
        // Monthly sales report > Locations
        console.log(<?= $agent_sales ?>);
        new Morris.Bar({
      element: 'agentSummary',
      data: <?php echo $agent_sales; ?>,
      xkey: 'recDate',
      ykeys: ['received_amount'],
      labels: ['Revenue'],
      stacked: false,
      hideHover: true,
      resize: true
   });
    </script>

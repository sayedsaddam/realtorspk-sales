<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Bookings &raquo; Booking Detail | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
<?php if(!empty($booking_detail)): ?>
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
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-8">
                        <legend>Booking Information</legend>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="<?= base_url('bookings/edit_booking/'.$booking_detail->booking_id); ?>" class="btn btn-outline-primary btn-sm">Edit Booking</a>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Booked by &raquo; Name / ID
                        <span class=""><?= $booking_detail->customer_name.' / '.$booking_detail->customer; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Amount Paid
                        <span class=""><?= number_format($booking_detail->amount_paid); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Sale Price /sqft
                        <span class=""><?=number_format($booking_detail->sale_price); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Current Price /sqft
                        <span class=""><?=number_format($booking_detail->total_price/$booking_detail->buying_area + $booking_detail->discount); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Price
                        <span class=""><?= number_format($booking_detail->total_price); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Payment Mode
                        <span class=""><?= ucfirst($booking_detail->payment_mode); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Booked Area in sqft
                        <span class=""><?= $booking_detail->buying_area; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Unit &raquo; Name
                        <span class=""><?= $booking_detail->unit_name; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Booking Date
                        <span class=""><?= date('M d, Y', strtotime($booking_detail->created_at)); ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-md-7">
                <legend>Add Installment | <small class="font-weight-light"><a class="btn btn-outline-primary btn-sm" target="_blank" href="<?= $booking_detail->qr_code; ?>">Click here</a> to view client's receipt.</small></legend>
                <fieldset <?= empty($booking_detail) ? 'disabled' : ''; ?>>
                    <form action="<?= base_url('bookings/add_installment'); ?>" method="post">
                        <input type="hidden" name="booking_id" value="<?= !empty($booking_detail) ? $booking_detail->booking_id : ''; ?>">
                        <div class="form-group">
                            <select name="payment_mode" class="custom-select payment_mode">
                                <option value="" disabled selected>Choose Payment Mode</option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                                <option value="bank transfer">Bank Transfer</option>
                                <option value="wire transfer">Wire Transfer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" name="amount_paid" class="form-control" placeholder="Amount paid, i.e. 100000...">
                        </div>
                        <div class="form-group reference_number">
                            <input type="number" name="reference_number" class="form-control" placeholder="Reference number, i.e. 1234567890...">
                        </div>
                        <div class="form-group cheque_status">
                            <select name="cheque_status" class="custom-select" id="cheque_status">
                                <option value="" disabled selected>Choose Cheque Status</option>
                                <option value="cleared">Cleared</option>
                                <option value="pending">Pending</option>
                                <option value="bounced">Bounced</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group date_added">
                            <input type="date" name="date_added" class="form-control">
                        </div>
                        <div class="form-group rejection_reason" style="display: none;">
                            <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Rejection or bounced reason..."></textarea>
                        </div>
                        <div class="form-group">
                            <textarea name="remarks" class="form-control" rows="5" placeholder="Remarks..."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="reset" class="btn btn-danger">Clear</button>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
        <hr>
        <div class="row mb-4">
            <div class="col-md-12">
                <legend>Installments History</legend>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Booking ID</th>
                                <th>Payment Mode</th>
                                <th>Amount Paid</th>
                                <th>Ref Number</th>
                                <th>Cheque Status</th>
                                <th>Rejection Reason</th>
                                <th>Date Added</th>
                                <th>Remarks</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; if(!empty($installments)): foreach($installments as $inst): ?>
                            <tr>
                                <td><?= $inst->id; ?></td>
                                <td><?= $inst->booking_id; ?></td>
                                <td><?= ucfirst($inst->payment_mode); ?></td>
                                <td><?= number_format($inst->amount_paid); ?></td>
                                <td><?= $inst->reference_number; ?></td>
                                <td><?= ucfirst($inst->cheque_status); ?></td>
                                <td title="<?= $inst->rejection_reason; ?>"><?= substr($inst->rejection_reason, 0, 15).' ...'; ?></td>
                                <td><?= date('M d, Y', strtotime($inst->date_added)); ?></td>
                                <td title="<?= $inst->remarks; ?>"><?= substr($inst->remarks, 0, 15).' ...'; ?></td>
                                <td><?= date('M d, Y', strtotime($inst->created_at)); ?></td>
                            </tr>
                            <?php $total += $inst->amount_paid; ?>
                            <?php endforeach; else: echo '<tr class="table-danger"><td colspan="10" align="center">No installment records were found!</td></tr>'; endif; ?>
                            <tr>
                                <th colspan="3">Total</th>
                                <th colspan="7"><?= number_format($booking_detail->amount_paid+$total).' <small>including the amount paid while booking!</small>'; ?></th>
                            </tr>
                            <tr>
                                <th colspan="3">Balance</th>
                                <th colspan="7"><?= number_format($booking_detail->total_price - $booking_detail->amount_paid - $total); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <h4>No booking found!</h4>
                    <p>The booking you are looking for does not exist or has been deleted.</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="container mb-2">
    <div class="row">
        <div class="col-md-12 text-right">
            <small>AH Group of Companies Pvt. Ltd.</small>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.payment_mode').on('change', function(){
            payment_mode = $(this).val();
            if(payment_mode == 'cash'){
                $('.reference_number').hide();
                $('.cheque_status').hide();
                $('.date_added').hide();
            }else if(payment_mode == 'cheque'){
                $('.reference_number').show();
                $('.cheque_status').show();
                $('.date_added').show(); 
            }else if(payment_mode == 'bank-transfer'){
                $('.date_added').show();
                $('.reference_number').hide();
                $('.cheque_status').hide();
            }
        });
        $('#cheque_status').on('change', function(){
            cheque_status = $(this).val();
            if(cheque_status == 'rejected' || cheque_status == 'bounced'){
                $('.rejection_reason').show();
            }else{
                $('.rejection_reason').hide();
            }
        });
    });
</script>

<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Bookings &raquo; Dashboard | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Home</a>
                <a href="javascript:history.go(-1)" class="btn btn-outline-light btn-lg btn-block">Bookings' Home</a>
            </div>
        </div>
    </div>
</div>
<div class="container mb-3 d-print-none">
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
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h3>Bookings &amp; Installments Dashboard</h3>
                </div>
                <div class="col-md-6">
                    <p>Advance Payments: <strong><?= number_format($bookings_amount->amount_paid); ?></strong>, Installments: <strong><?= number_format($installments_amount->amount_paid); ?></strong></p>
                </div>
            </div>
            <div class="card-deck">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <h5 class="card-title font-weight-light">Bookings <span class="badge badge-secondary badge-pill"><?= number_format($total_bookings); ?></span></h5>
                            </div>
                            <div class="col-md-7 text-right">
                                <a href="<?= base_url('inventory/units'); ?>" class="btn btn-outline-secondary btn-sm">New Booking</a>
                                <a href="<?= base_url('bookings/bookings_list'); ?>" class="btn btn-outline-danger btn-sm">Bookings List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-sm">
                            <caption>Bookings can now be edited.</caption>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Area</th>
                                    <th>Price</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($bookings)): foreach($bookings as $booking): ?>
                                <tr>
                                    <td><?= $booking->booking_id; ?></td>
                                    <td><?= $booking->customer_name; ?></td>
                                    <td><?= $booking->buying_area; ?></td>
                                    <td><?= number_format($booking->total_price); ?></td>
                                    <td title="Booking detail, installments etc...">
                                        <a href="<?= base_url('bookings/booking_detail/'.$booking->booking_id); ?>">detail</a> | 
                                        <a href="<?= base_url('bookings/edit_booking/'.$booking->booking_id); ?>" title="You can edit a booking by clicking the edit link, that'll lead you to another page where you can do your necessary editings and update it.">edit</a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="card-title font-weight-light">Installments <span class="badge badge-secondary badge-pill"><?= number_format($total_installments); ?></span></h5>
                            </div>
                            <div class="col-md-8 text-right">
                                <a href="<?= base_url('bookings/installment_history'); ?>" class="btn btn-outline-secondary btn-sm">View History</a>
                                <a href="<?= base_url('bookings/installment_calculator'); ?>" class="btn btn-outline-danger btn-sm">Installment Calculator</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-condensed table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($installments)): foreach($installments as $inst): ?>
                                    <tr>
                                        <td><?= $inst->id; ?></td>
                                        <td><?= $inst->customer_name; ?></td>
                                        <td><?= number_format($inst->amount_paid); ?></td>
                                        <td><?= ucfirst($inst->payment_mode); ?></td>
                                        <td><?= date('M d, Y', strtotime($inst->date_added)); ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mb-4 d-print-none">
    <div class="row">
        <div class="col-md-12 text-right">
            <small class="">Copyright &copy; <?= date('Y'); ?>, AH Group of Companies Pvt. Ltd.</small>                          
        </div>
    </div>
</div>

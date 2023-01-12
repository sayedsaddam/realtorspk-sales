<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">List of Bookings  | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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

<div class="container">
   <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">List of Bookings</h2>
            <small><?= !empty($results) ? 'About '. count($results). ' result(s)({elapsed_time} seconds).' : ''; ?></small>
        </div>
        <div class="col-md-4 text-right">
            <form action="<?= base_url('bookings/search_bookings'); ?>" action="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search bookings..." aria-label="Search bookings..." aria-describedby="basic-addon2" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
       <div class="col-md-12 table-responsive">
          <table class="table table-hover table-condensed table-sm">
             <caption>Bookings can now be edited, i.e, you can exchange apartments among clients.</caption>
             <thead>
                <tr>
                  <th>#</th>
                  <th>Customer</th>
                  <th>Unit</th>
                  <th>Area</th>
                  <th title="Total Booking price...">Total Price</th>
                  <th title="Total amount paid with installments...">Amount Paid</th>
                  <th>Discount</th>
                  <th>Balance</th>
                  <th>Booking Date</th>
                  <th>Action</th>
                </tr>
             </thead>
             <?php if(!empty($bookings)): ?>
               <tbody>
                  <?php foreach($bookings as $booking): ?>
                  <?php
                     $installments = $this->booking_model->sum_installments($booking->booking_id); 
                     $total_paid = $booking->amount_paid + $installments->amount_paid;
                  ?>
                     <tr>
                        <td><?= $booking->booking_id; ?></td>
                        <td><?= $booking->customer_name; ?></td>
                        <td><?= $booking->unit_name; ?></td>
                        <td><?= number_format($booking->buying_area); ?></td>
                        <td><?= number_format($booking->total_price); ?></td>
                        <td><?= number_format($total_paid); ?></td>
                        <td><?= number_format($booking->discount); ?></td>
                        <td><?= number_format($booking->total_price -  $total_paid); ?></td>
                        <td><?= date('M d, Y', strtotime($booking->created_at)); ?></td>
                        <td>
                           <a href="<?= base_url('bookings/booking_detail/'.$booking->booking_id); ?>">detail</a> | 
                           <a href="<?= base_url('bookings/edit_booking/'.$booking->booking_id) ?>">edit</a>
                        </td>
                     </tr>
                  <?php endforeach; ?>
               </tbody>
               <?php elseif(!empty($results)): ?>
                  <tbody>
                     <?php foreach($results as $booking): ?>
                     <?php 
                        $installments = $this->booking_model->sum_installments($booking->booking_id);
                        $total_paid = $booking->amount_paid + $installments->amount_paid;
                     ?>
                        <tr>
                           <td><?= $booking->booking_id; ?></td>
                           <td><?= $booking->customer_name; ?></td>
                           <td><?= $booking->unit_name; ?></td>
                           <td><?= number_format($booking->buying_area); ?></td>
                           <td><?= number_format($booking->total_price); ?></td>
                           <td><?= number_format($total_paid); ?></td>
                           <td><?= number_format($booking->discount); ?></td>
                           <td><?= number_format($booking->total_price -  $total_paid); ?></td>
                           <td><?= date('M d, Y', strtotime($booking->created_at)); ?></td>
                           <td>
                              <a href="<?= base_url('bookings/booking_detail/'.$booking->booking_id); ?>">detail</a> | 
                              <a href="<?= base_url('bookings/edit_booking/'.$booking->booking_id); ?>">edit</a>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               <?php endif; ?>
          </table>
          <?= $this->pagination->create_links(); ?>
       </div>
    </div>
</div>

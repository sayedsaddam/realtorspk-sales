<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Bookings &raquo; Edit Booking | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
<div class="container mb-5">
   <div class="row">
      <div class="col-md-12">
         <?php if($success = $this->session->flashdata('success')): ?>
            <div class="alert alert-success">
               <?= $success; ?>
            </div>
         <?php endif; ?>
         <legend>Unit number <strong><?= $edit_booking->unit_name; ?></strong>, booked by <strong><?= $edit_booking->customer_name; ?></strong>. You can update it now (if necessary).</legend>
         <form action="<?= base_url('bookings/update_booking'); ?>" method="post">
            <input type="hidden" name="booking_id" value="<?= $edit_booking->booking_id; ?>">
            <input type="hidden" name="old_unit_id" value="<?= $edit_booking->unit_id; ?>">
            <div class="row">
               <div class="col-md-6">
                  <label for="customer_name">Customer <small class="text-muted">ID, name, and CNIC</small></label>
                  <div class="form-group">
                     <input list="customer" class="form-control" name="customer" placeholder="Choose Customer..." value="<?= $edit_booking->customer_id.', '.$edit_booking->customer_name.', '.$edit_booking->customer_cnic; ?>">
                     <datalist id="customer">
                        <?php foreach($customers as $cst): ?>
                           <option value="<?php echo $cst->id.', '.$cst->customer_name.','.$cst->customer_cnic; ?>" <?= $cst->id == $edit_booking->customer_id ? 'selected' : ''; ?>></option>
                        <?php endforeach; ?>
                     </datalist>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="payment_mode">Payment Mode</label>
                     <select name="payment_mode" class="custom-select payment_mode">
                        <option value="" disabled selected>Choose Payment Mode</option>
                        <option value="cash" <?= $edit_booking->payment_mode == 'cash' ? 'selected' : ''; ?>>Cash</option>
                        <option value="cheque" <?= $edit_booking->payment_mode == 'cheque' ? 'selected' : ''; ?>>Cheque</option>
                        <option value="bank transfer" <?= $edit_booking->payment_mode == 'bank transfer' ? 'selected' : ''; ?>>Bank Transfer</option>
                        <option value="wire transfer" <?= $edit_booking->payment_mode == 'wire transfer' ? 'selected' : ''; ?>>Wire Transfer</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group reference_number">
                     <label for="reference_number">Reference Number</label>
                     <input type="number" name="reference_number" class="form-control" value="<?= $edit_booking->reference_number != null ? $edit_booking->reference_number : '0'; ?>">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="amount_paid">Amount Paid <small class="text-muted">Booking time</small></label>
                     <input type="number" name="amount_paid" class="form-control" value="<?= $edit_booking->amount_paid; ?>">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="discount">Discount <small class="text-muted">per ft<sup>2</sup></small></label>
                     <input type="number" name="discount" class="form-control" value="<?= $edit_booking->discount > 0 ? $edit_booking->discount : '0'; ?>">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="buying_area">Buying Area</label>
                     <input type="text" name="buying_area" id="buying_area" class="form-control" placeholder="Buying area in sqft i.e. 100..." pattern="[0-9]+" value="<?= $edit_booking->buying_area; ?>">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="buying_price">Buying Price <small class="text-muted">per ft<sup>2</sup></small></label>
                     <input type="text" name="price" id="price" class="form-control" pattern="[0-9.]+" value="<?= $edit_booking->sale_price; ?>">
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="project">Project</label>
                     <select name="project" id="project" class="custom-select">
                        <option value="" disabled selected>Choose Project</option>
                        <?php if(!empty($projects)): foreach($projects as $project): ?>
                           <option value="<?= $project->id; ?>"><?= $project->name; ?></option>
                        <?php endforeach; endif; ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="floor">Floor</label>
                     <select name="floor" id="floor" class="custom-select">
                        <option value="">Choose Floor</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="unit">Unit <small class="text-muted">Available units will be listed only.</small></label>
                     <select name="unit_id" id="unit" class="custom-select">
                        <option value="<?= $edit_booking->unit_id; ?>" selected><?= $edit_booking->unit_name; ?></option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label for="remarks">Remarks</label>
               <textarea name="remarks" class="form-control" rows="4"><?= $edit_booking->remarks; ?></textarea>
            </div>
            <div class="row">
               <div class="col-md-3 font-weight-bold">
                  <label for="type" title="Booking this unit completely or shared...">Booking Type</label>
               </div>
               <div class="col-md-3">
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="type" id="gridRadios1" value="complete" <?= $edit_booking->type == 'complete' ? 'checked' : ''; ?>>
                     <label class="form-check-label" for="gridRadios1">
                        Complete
                     </label>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="type" id="gridRadios2" value="shared" <?= $edit_booking->type == 'shared' ? 'checked' : ''; ?>>
                     <label class="form-check-label" for="gridRadios2">
                        Shared
                     </label>
                  </div>
               </div>
            </div>
            <div class="form-group mt-3">
               <button type="submit" class="btn btn-primary">Save Changes</button>
               <button type="reset" class="btn btn-danger">Clear</button>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
   $(document).ready(function(){
      $('.payment_mode').on('change', function(){
         payment_mode = $(this).val();
         if(payment_mode == 'cash'){
            $('.reference_number').hide();
         }else{
            $('.reference_number').show();
         }
      });
      // get floors of selected project
      $('#project').on('change', function(){
         project = $(this).val();
         $.ajax({
            url: '<?= base_url('inventory/get_floors_byProject/') ?>' + project,
            method: 'post',
            dataType: 'json',
            data: {project: project},
            success: function(res){
               console.log(res);
               $('#floor').find('option').not(':first').remove();
               // Add options
               $.each(res, function(index, data){
                  $('#floor').append('<option value="'+data['id']+'">'+data['name']+'</option>');
               });
            }
         });
      });
      // get units of selected floor
      $('#floor').on('change', function(){
         floor = $(this).val();
         $.ajax({
            url: '<?= base_url('inventory/get_units_byFloor/') ?>' + floor,
            method: 'post',
            dataType: 'json',
            data: {floor: floor},
            success: function(res){
               console.log(res);
               $('#unit').find('option').not(':first').remove();
               // Add options
               $.each(res, function(index, data){
                  $('#unit').append('<option value="'+data['id']+'">'+data['unit_name']+'</option>');
               });
            }
         });
      });
      // get unit detail for selected unit.
      $('#unit').on('change', function(){
         unit = $(this).val();
         $.ajax({
            url: '<?= base_url('inventory/unit_detail/') ?>' + unit,
            method: 'post',
            dataType: 'json',
            data: {unit: unit},
            success: function(res){
               console.log(res);
               $('#buying_area').val(parseInt(res.size_in_sqft));
               $('#price').val(res.price);
            }
         });
      });
   });
</script>

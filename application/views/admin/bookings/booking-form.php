<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Bookings &raquo; Booking Form | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
<div class="container mb-4">
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
    <?php if($unit_info->status == 0): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <strong>Warning!</strong> This unit is currently not available.
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-5">
            <legend>Unit Information</legend>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Unit ID
                    <span class=""><?= $unit_info->unit_id; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Unit Name
                    <span class=""><?= $unit_info->unit_name; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Unit Type
                    <span class=""><?= $unit_info->floor_type; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Size &raquo; sqft
                    <span class=""><?= round($unit_info->size_in_sqft); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= strpos($unit_info->no_of_beds, 'Bed') ? 'Number of Beds' : 'Size'; // check whether the string contains the word "Bed". ?>
                    <span class=""><?= $unit_info->no_of_beds; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Price /sqft
                    <span class=""><?= number_format($unit_info->price); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Floor
                    <span class=""><?= $unit_info->floor_name; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Date Added
                    <span class=""><?= date('M d, Y', strtotime($unit_info->created_at)); ?></span>
                </li>
            </ul>
        </div>
        <div class="col-md-7">
            <legend>Booking Information | <small class="font-weight-light">Customer does not exist ?</small> <a href="" data-toggle="modal" data-target="#add_customer">Add</a></legend>
            <form action="<?= base_url('bookings/store_booking_info'); ?>" method="post">
                <input type="hidden" name="unit_id" value="<?= $unit_info->unit_id; ?>">
                <div class="form-group">
                    <input list="customer" class="form-control" name="customer" placeholder="Choose Customer..." autocomplete="off">
                    <datalist id="customer">
                        <?php foreach($customers as $cst): ?>
                            <option value="<?php echo $cst->id.', '.$cst->customer_name.','.$cst->customer_cnic; ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group">
                    <select name="payment_mode" class="custom-select payment_mode">
                        <option value="" disabled selected>Choose Payment Mode</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="bank transfer">Bank Transfer</option>
                    </select>
                </div>
                <div class="form-group reference_number">
                    <input type="number" name="reference_number" class="form-control" placeholder="Reference number...">
                </div>
                <div class="form-group">
                    <input type="number" name="amount_paid" class="form-control" placeholder="Amount paid i.e. 1000000...">
                </div>
                <div class="form-group">
                    <input type="number" name="discount" class="form-control" placeholder="Discount (if any) i.e. 1000000..." value="0">
                    <small class="help-text text-muted mb-0">Discount per ft<sup>2</sup></small>
                </div>
                <div class="form-group">
                    <input type="text" name="buying_area" class="form-control" placeholder="Buying area in sqft i.e. 100..." pattern="[0-9]+" value="<?= $unit_info->floor_type == 'Residential' ? round($unit_info->size_in_sqft) : ''; ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="price" class="form-control" placeholder="Sale price i.e. 6000..." pattern="[0-9.]+" value="<?= $unit_info->price; ?>">
                    <small class="help-text text-muted mb-0">Sale price per ft<sup>2</sup></small>
                </div>
                <div class="form-group">
                    <textarea name="remarks" class="form-control" rows="4" placeholder="Remarks..."></textarea>
                </div>
                <div class="row">
                    <div class="col-md-3 font-weight-bold">
                        <label for="type" title="Booking this unit completely or shared...">Booking Type</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="gridRadios1" value="complete" <?= $unit_info->floor_type == 'Residential' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="gridRadios1">
                                Complete
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="gridRadios2" value="shared">
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

<div class="container-fluid mb-2">
    <div class="row">
        <div class="col-md-12 text-right">
            <small>AH Group of Companies Pvt. Ltd.</small>
        </div>
    </div>
</div>

<!-- Modal for adding new customer starts -->
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="add_teamLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_teamLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/add_customer'); ?>" method="post">
                    <div class="row">
						<div class="col-md-12">
							<legend class="text-muted">Customer Information</legend>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control" placeholder="Customer name..." required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cnic">CNIC</label>
								<input type="text" name="cnic" class="form-control cnic" placeholder="Customer CNIC..." required>
								<span class="exists_message text-danger"></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="phone">Phone</label>
								<input type="number" name="phone" class="form-control" placeholder="Phone...">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="agent">Agent</label>
								<select name="agent" class="custom-select">
									<option value="" disabled selected>Agent</option>
									<?php if(!empty($agents)): foreach($agents as $agent): ?>
										<option value="<?= $agent->emp_code; ?>"><?= $agent->emp_city.', '.$agent->emp_name; ?></option>
									<?php endforeach; endif; ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="project">Project</label>
								<select name="project" class="custom-select">
									<option value="" disabled selected>Porject</option>
									<?php $projects = array('091 Mall', 'Florenza', 'MoH', 'North Hills', 'AH Tower'); ?>
									<?php foreach($projects as $project): ?>
										<option value="<?= $project; ?>"><?= $project; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="address">Address</label>
								<textarea name="address" class="form-control" rows="2" placeholder="Address"></textarea>
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-12">
							<legend class="text-muted">Next of Kin Information</legend>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<label for="phone">Next of Kin Name</label>
							<input type="text" name="nok_name" class="form-control" placeholder="Next of Kin...">
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="cnic_nok">Next of Kin CNIC</label>
								<input type="number" name="nok_cnic" class="form-control" placeholder="Next of Kin CNIC...">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="relation">Relation with Next of Kin</label>
								<input type="text" name="nok_relation" class="form-control" placeholder="Relation with NoK...">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nok_contact">Next of Kin Contact</label>
								<input type="number" name="nok_contact" class="form-control" placeholder="Next of Kin contact...">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-12">
							<legend class="text-muted">Bank Information</legend>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="bank_name">Bank Name</label>
								<input type="text" name="bank_name" class="form-control" placeholder="Bank name...">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="branch_code">Branch Code</label>
								<input type="number" name="branch_code" class="form-control" placeholder="Branch code...">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="account_no">Account Number</label>
								<input type="number" name="account_no" class="form-control" placeholder="Account no...">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="tax_status">Tax Status</label>
								<select name="tax_status" class="custom-select">
									<option value="" disabled selected>Tax Status</option>
									<option value="filer">Filer</option>
									<option value="non filer">Non Filer</option>
								</select>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="reset" class="btn btn-danger">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for adding new customer ends -->

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
    });
</script>

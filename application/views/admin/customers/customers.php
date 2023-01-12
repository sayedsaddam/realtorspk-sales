<div class="jumbotron jumbotron-fluid text-white" style="background-color: crimson;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Customers | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Home</a><br>
                <a target="_blank" href="<?= base_url('careers'); ?>" class="btn btn-outline-light btn-lg btn-block">Careers</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
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
            <h2>Customers List &raquo; <button data-toggle="modal" data-target="#add_customer" class="btn btn-primary">Add New</button></h2>
        </div>
        <div class="col-md-4 text-right">
            <form action="<?= base_url('admin/search_customers'); ?>" action="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search customers..." aria-label="Search customers..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>CNIC</th>
                        <th>Agent</th>
                        <th>Contact</th>
                        <th>Project</th>
                        <th>Action</th>
                    </tr>
                </thead>
					 <?php if(!empty($customers)): ?>
					<tbody id="customers">
						<?php foreach($customers as $cust): ?>
							<tr class="<?php if($cust->status == 0){ echo 'table-danger'; } ?>">
									<td><?= $cust->id; ?></td>
									<td><?= $cust->customer_name; ?></td>
									<td><?= $cust->customer_cnic; ?></td>
									<td><?= $cust->emp_name; ?></td>
									<td><?= $cust->customer_contact; ?></td>
									<td><?= $cust->project; ?></td>
									<td>
										<a data-id="<?= $cust->id; ?>" href="#0" class="customer_id">edit</a> |
										<a href="<?=  base_url('admin/update_customer_status/'.$cust->id); ?>">
											<?= $cust->status == 0 ? 'enable' : 'disable'; ?>
										</a> | 
										<a href="">bookings</a>
									</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<?php elseif(!empty($result)): ?>
						<tbody id="customers">
                    	<?php foreach($result as $res): ?>
                        <tr class="<?php if($res->status == 0){ echo 'table-danger'; } ?>">
                            <td><?= $res->id; ?></td>
                            <td><?= $res->customer_name; ?></td>
                            <td><?= $res->customer_cnic; ?></td>
                            <td><?= $res->emp_name; ?></td>
                            <td><?= $res->customer_contact; ?></td>
                            <td><?= $res->project; ?></td>
                            <td>
                                <a data-id="<?= $res->id; ?>" href="#0" class="customer_id">edit</a> |
                                <a href="<?=  base_url('admin/update_customer_status/'.$res->id); ?>">
                                    <?= $res->status == 0 ? 'enable' : 'disable'; ?>
                                </a> | 
										  <a href="">bookings</a>
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

<!-- Modal for editing customer starts -->
<div class="modal fade" id="edit_customer" tabindex="-1" role="dialog" aria-labelledby="add_teamLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_teamLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/update_customer'); ?>" method="post">
                    <input type="hidden" name="customer_id" class="customer_id">
                    <div class="row">
						<div class="col-md-12">
							<legend class="text-muted">Customer Information</legend>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control name" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cnic">CNIC</label>
								<input type="text" name="cnic" class="form-control cnic" required>
								<span class="exists_message text-danger"></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="phone">Phone</label>
								<input type="text" name="phone" class="form-control phone">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="agent">Agent</label>
								<select name="agent" class="custom-select agent">
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
								<select name="project" class="custom-select project">
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
								<textarea name="address" class="form-control address" rows="2" placeholder="Address"></textarea>
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
							<input type="text" name="nok_name" class="form-control nok_name">
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="cnic_nok">Next of Kin CNIC</label>
								<input type="number" name="nok_cnic" class="form-control nok_cnic">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="relation">Relation with Next of Kin</label>
								<input type="text" name="nok_relation" class="form-control nol_relation">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="nok_contact">Next of Kin Contact</label>
								<input type="number" name="nok_contact" class="form-control nok_contact">
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
								<input type="text" name="bank_name" class="form-control bank_name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="branch_code">Branch Code</label>
								<input type="number" name="branch_code" class="form-control branch_code">
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="account_no">Account Number</label>
								<input type="number" name="account_no" class="form-control account_no">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="tax_status">Tax Status</label>
								<select name="tax_status" class="custom-select tax_status">
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
<!-- Modal for editing customer ends -->
<script>
$(document).ready(function(){
	$("#search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#customers tr").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
    $('.customer_id').click(function(){
        customer_id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/edit_customer/') ?>' + customer_id,
            method: 'post',
            dataType: 'json',
            data: {customer_id: customer_id},
            success: function(res){
                console.log(res);
                $('.customer_id').val(res.id);
                $('.name').val(res.customer_name);
                $('.cnic').val(res.customer_cnic);
                $('.phone').val(res.customer_contact);
                $('.agent').val(res.customer_agent);
                $('.project').val(res.project);
                $('.address').val(res.customer_address);
                $('.nok_name').val(res.nok_name);
                $('.nok_cnic').val(res.nok_cnic);
                $('.nok_relation').val(res.nok_relation);
                $('.nok_contact').val(res.nok_contact);
                $('.bank_name').val(res.bank_name);
                $('.branch_code').val(res.branch_code);
                $('.account_no').val(res.account_no);
                $('.tax_status').val(res.tax_status);
                $('#edit_customer').modal('show');
            }
        });
    });
});
</script>
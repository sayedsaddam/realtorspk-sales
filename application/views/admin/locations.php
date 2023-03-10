<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Locations |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
<div class="container-fluid">
    <?php if($success = $this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>
    <?php if($failed = $this->session->flashdata('failed')): ?>
        <div class="alert alert-danger"><?= $failed; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6 mb-2">
        <h2 class="font-weight-bold">
            List of Locations
        </h2>
        
        </div>
        <div class="col-md-6 mb-2 text-right">
        <button data-toggle="modal" data-target="#add_location" class="btn btn-outline-info btn-sm">Add New Location</button>
        
        </div>
    </div>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 col-sm-12 table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Active</th>
                        <th>Inactive</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php if(!empty($locations)): ?>
                    <tbody>
                        <?php  foreach($locations as $loc): ?>
                            <tr id="<?= $loc->id ?>" <?= $loc->status == 0 ?  'class="table-danger"': ''  ?>>
                                <td><?= $loc->name; ?></td>
                                <td title="<?= $loc->location_address; ?>"><?= substr($loc->location_address,0,25); ?></td>
                                <td><?= $this->admin_model->count_employees_with_status($loc->name,'1') ?></td>
                                <td><?= $this->admin_model->count_employees_with_status($loc->name,'0') ?></td>
                                <td><?php if($loc->status == 1){ echo "<span class='badge badge-success'>Active</span>"; }else{ echo '<span class="badge badge-danger">Inactive</span>'; } ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#edit_location<?= $loc->id; ?>" href="javascript:void(0)" data-id="1">Edit</a> |
                                    <!-- Modal starts -->
                                    <div class="modal fade" id="edit_location<?= $loc->id; ?>" tabindex="-1" role="dialog" aria-labelledby="edit_saleTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Location</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 offset-md-3">
															<h2 class="font-weight-bold text-center mb-5 text-secondary">Location Information</h2>
                                                            <form action="<?= base_url('admin/update_location'); ?>" method="post">
                                                                <input type="hidden" name="location_id" value="<?= $loc->id; ?>">
                                                                <div class="form-group">
                                                                    <input type="text" name="location_name" class="form-control" value="<?= $loc->name; ?>" >
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea name="address" class="form-control" placeholder="Address of location..."><?= $loc->location_address; ?></textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-block">Save changes</button>
																<button type="button" class="btn btn-warning btn-block" data-dismiss="modal">Cancel</button>
                                                            </form>
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
                                    <a href="<?= base_url('admin/update_location_status/'.$loc->id); ?>" title="Change the status whether resigned or terminated..." onclick="javascript:return confirm('Are you sure to change status ? Click OK to continue.');">
									<?= $loc->status == 1 ? 'Disable' : 'Enable' ?>
									</a>
                                </td>   
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php endif ?>
            </table>
        </div>
    </div>

    <!-- Grid row -->
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 text-center">
       <!-- links for pagination here -->
        </div>
    </div>
        <!-- Modal for adding new location starts -->
    <div class="modal fade" id="add_location" tabindex="-1" role="dialog" aria-labelledby="payment_statusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payment_statusLabel">Add New Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-md-6 offset-md-3">
							<h2 class="text-center font-weight-bold text-secondary mb-5">Location Information</h2>
							<form action="<?= base_url('admin/add_location'); ?>" method="post">
								<div class="form-group">
									<input type="text" name="location_name" class="form-control" placeholder="Location name" required>
								</div>
								<div class="form-group">
                                    <textarea name="address" class="form-control" placeholder="Address of location..."></textarea>
								</div>
								<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
								<input type="reset" class="btn btn-warning btn-block" value="Clear">
							</form>
						</div>
					</div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for adding new location ends -->
</div>

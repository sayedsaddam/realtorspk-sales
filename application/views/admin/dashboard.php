<?php $session = $this->session->userdata('department'); ?>
<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-10">
               <h1 class="display-4 font-weight-bold">Leads and Sales Stats Dashboard</h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p> 
            </div>
            <?php if($session == 5 || $session == 10): ?>
                <div class="col-2 mt-3">
                    <a href="<?= base_url('admin/sales_report'); ?>" class="btn btn-outline-light btn-block btn-sm">Sales Reports</a>
                    <a href="<?= base_url('reporting_panel'); ?>" class="btn btn-outline-light btn-block btn-sm">Reporting Panel</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="container">
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
        <div class="col-xl-lg-12 col-md-12">
            <div class="card-deck">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="font-weight-light">Stats - Sales Department</h5>
                        <div class="row">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>All Employees</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= $total_employees; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Islamabad</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= $isbd_employees; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Peshawar</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= $psh_employees; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Hangu</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= $hangu_employees; ?></small>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Kohat</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= $kohat_employees; ?></small>
                            </div>
                        </div>
                        <h5 class="card-title">Employees</h5>
                        <?php if($session == 2 OR $session == 10): ?>
                            <button data-toggle="modal" data-target="#add_employee" class="btn btn-outline-info btn-sm">Add New</button>
                            <a href="<?= base_url('admin/employees'); ?>" class="btn btn-outline-secondary btn-sm">Detail</a>
                        <?php else: echo 'No further action!'; endif; ?>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted" style="font-size: 10px;">Numbers based on Sales Department only.</small>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <?php if($session == 10 OR $session == 5): // Access level - role based. ?>
                        <h5 class="font-weight-light">Stats - Daily Basis</h5>
                        <div class="row mb-1">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Today</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= number_format($total_sales_today->total_today/1000000, 3).' M'; ?></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>This Month</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= number_format($total_sales_this_month->total_sales_this_month/1000000, 3).' M'; ?></small>
                            </div>
                        </div>
                        <!-- <div class="row mb-1">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Overall</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= number_format($overall_sales->overall_sale_amount/1000000, 3).' M'; ?></small>
                            </div>
                        </div> -->
                        <div class="row mb-4">
                            <div class="col-xl-lg-12 col-md-12 text-center">
                                <small class="text-secondary">The stats shown here are cumulative, not region based.</small>
                            </div>
                        </div>
                        <h5 class="card-title">Sales Stats</h5>
                            <button data-toggle="modal" data-target="#daily_sales" class="btn btn-outline-info btn-sm">Add New</button>
                            <a href="<?= base_url('admin/daily_sales'); ?>" class="btn btn-outline-secondary btn-sm">Detail</a>
                            <a href="<?= base_url('reporting_panel/agent_stats/Peshawar'); ?>" class="btn btn-outline-primary btn-sm" title="Agents in Green, Yellow, or Red Zone...">More &raquo;</a>
                        <?php else: echo "No further action!"; endif; // Access level - role based. ?>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted" style="font-size: 10px;">Al Hayyat Group</small>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <?php if($session == 10 OR $session == 5): ?>
                        <h5 class="font-weight-light"><?= 'Stats - '.date('F, Y'); ?></h5>
                        <div class="row">
                            <div class="col-xl-lg-5 col-md-5 text-left">
                                <small>Target</small>
                            </div>
                            <div class="col-xl-lg-7 col-md-7 text-right">
                                <small><?= number_format($total_this_month->total_this_month/1000000, 3).' M'; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-lg-5 col-md-5 text-left">
                                <small>Achieved</small>
                            </div>
                            <div class="col-xl-lg-7 col-md-7 text-right">
                                <small><?= number_format($total_sales_this_month->total_sales_this_month/1000000, 3).' M'; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-lg-5 col-md-5 text-left">
                                <small>To Goal</small>
                            </div>
                            <div class="col-xl-lg-7 col-md-7 text-right">
                                <small><?php $total_difference_this_month = ($total_this_month->total_this_month - $total_sales_this_month->total_sales_this_month); echo number_format($total_difference_this_month/1000000, 3).' M'; ?></small>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-xl-lg-5 col-md-5 text-left">
                                <small>Agents</small>
                            </div>
                            <div class="col-xl-lg-7 col-md-7 text-right">
                                <small><?= $total_agents_this_month; ?></small>
                            </div>
                        </div>
                        <h5 class="card-title">Targets</h5>
                            <button data-toggle="modal" data-target="#assign_target" class="btn btn-outline-info btn-sm">Add New</button>
                            <a href="<?= base_url('admin/assigned_targets'); ?>" class="btn btn-outline-secondary btn-sm">Detail</a>
                        <?php else: echo 'No further action!'; endif; ?>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted" style="font-size: 10px;">The stats are cumulative, not region based.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Grid row -->
    <div class="row mb-4">
        <div class="col-xl-lg-12 col-md-12">
            <div class="card-deck">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="font-weight-light">Rebate & Buyback</h5>
                        <div class="row">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Rebate %age</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small class="text-primary" title="Approx. rebate percentage...">2.5% or 3.5%</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-lg-7 col-md-7 text-left">
                                <small>This month</small>
                            </div>
                            <div class="col-xl-lg-5 col-md-5 text-right">
                                <small>0</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-lg-7 col-md-7 text-left">
                                <small>Overall Rebates</small>
                            </div>
                            <div class="col-xl-lg-5 col-md-5 text-right">
                                <small>0</small>
                            </div>
                        </div>
                        <div class="row mb-1 mt-1">
                            <div class="col-xl-lg-12 col-md-12 text-center">
                                [<small class="text-info">Will be available the next month</small>]
                            </div>
                        </div>
                        <h5 class="card-title pt-3">Rebate</h5>
                        <?php if($session == 10 OR $session == 5): ?>
                            <a href="<?= base_url('admin/buybacks'); ?>" class="btn btn-outline-info btn-sm" title="Click to view rebate calculations." title="Click to view the rebate calculation process...">Buyback</a>
                            <a href="<?= base_url('admin/rebate_calculations'); ?>" class="btn btn-outline-secondary btn-sm" title="Click to view report...">Rebate</a>
                        <?php else: echo 'No further action!'; endif; ?>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted" style="font-size: 10px;">The %age mentioned is approx., not fixed.</small>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="font-weight-light">Teams Stats - <?= date('M, Y'); ?></h5>
                        <div class="row">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Total Teams</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small><?= $total_teams; ?></small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xl-lg-6 col-md-6 text-left">
                                <small>Revenue</small>
                            </div>
                            <div class="col-xl-lg-6 col-md-6 text-right">
                                <small>
                                    <?php if(!empty($teams_revenue) && $session == 10 || $session == 5): $total_revenue = 0; foreach($teams_revenue as $tr): $tr->received_amount;
                                        $total_revenue += $tr->received_amount;$tr->received_amount; endforeach; endif;
                                        if(!empty($total_revenue)){ echo number_format($total_revenue/1000000, 2).' M'; }else{ echo '00'; } ?>
                                </small>
                            </div>
                        </div>
                        <h5 class="card-title pt-5">Teams</h5>
                        <?php if($session == 10): ?>
                            <button data-toggle="modal" data-target="#add_team" class="btn btn-outline-info btn-sm" title="Click to add a team...">Add New</button>
                            <a href="<?= base_url('admin/teams'); ?>" class="btn btn-outline-secondary btn-sm" title="Click to view teams...">View Teams</a>
                        <?php else: echo 'No further action!'; endif; ?>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted" style="font-size: 10px;">Cumulative sum, not region based.</small>
                    </div>
                </div>
				<!-- card -->
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="font-weight-light">Customers Information</h5>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small>Active Customers</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small><?= $active_customers; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small>Total Customers</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small><?= $total_customers; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small>Inactive Customers</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small><?= $inactive_customers; ?></small>
                            </div>
                        </div>
                        <div class="row mt-4 pt-4">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add_customer">Add New</button>
                                <a href="<?= base_url('admin/customers'); ?>" class="btn btn-outline-secondary btn-sm">Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right text-muted">
                        <small>AH Group of Companies</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Grid row -->
    <div class="row mb-4">
        <div class="col-xl-lg-12 col-md-12">
            <div class="card-deck">
                <!-- card -->
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="font-weight-light">Bookings & Inventory Information</h5>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small>Total Projects</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small><?= $total_projects; ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small>Total Floors</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small><?= number_format($total_floors); ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small>Total Units</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small><?= number_format($total_units); ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small>Available Units</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small><?= number_format($available_units); ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <small title="Total Area, Sel = Sellable, Cov = Covered">Area, Sell / Cov</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small>
                                    <?= number_format($sellable_area->sellable_area).' / '. number_format($covered_area->covered_area).' ft<sup>2</sup>'; ?>
                                </small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="<?= base_url('inventory'); ?>" class="btn btn-outline-info btn-sm">Inventory</a>
                                <a href="<?= base_url('bookings'); ?>" class="btn btn-outline-secondary btn-sm">Bookings</a>
                                <a target="_blank" href="<?= base_url('projects-inventory'); ?>" class="btn btn-outline-primary btn-sm">View Online</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right text-muted">
                        <small>AH Group of Companies</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for adding new employee starts -->
<div class="modal fade" id="add_employee" tabindex="-1" role="dialog" aria-labelledby="payment_statusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment_statusLabel">Add an Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/add_employee'); ?>" method="post">
					<div class="row">
						<div class="col-md-4">
							<label for="emp_code">Employee Code</label>
                    		<input type="text" name="emp_code" class="form-control mb-2" placeholder="Employee code i.e 40" required>
						</div>
						<div class="col-md-4">
							<label for="name">Employee Name</label>
                    		<input type="text" name="emp_name" class="form-control mb-2" placeholder="Employee name..." required>
						</div>
						<div class="col-md-4">
							<label for="gender">Gender</label>
							<select name="gender" class="custom-select">
								<option value="" disabled selected>-- Select One --</option>
								<option value="m">Male</option>
								<option value="f">Female</option>
							</select>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<label for="office">Office</label>
							<select name="office" class="custom-select mb-2">
								<option value="" disabled selected>-- Select One --</option>
								<option value="Head Office">Head Office</option>
								<option value="Regional Office">Regional Office</option>
								<option value="Site Office">Site Office</option>
								<option value="Branch Office">Branch Office</option>
								<option value="Realtors">Realtors</option>
							</select>
						</div>
						<div class="col-md-6">
							<label for="phone">Phone</label>
                    		<input type="text" name="emp_phone" class="form-control mb-2" placeholder="Mobile no. i.e. 03439343456" required>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<label for="department">Department</label>
							<select name="emp_department" class="custom-select mb-2" required>
								<option value="" disabled selected>-- Select One --</option>
								<?php if(!empty($departments)): foreach($departments as $dept): ?>
									<option value="<?= $dept->dept_id; ?>"><?= $dept->dept_name; ?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
						<div class="col-md-6">
							 <label for="city">City</label>
							<select name="emp_city" class="custom-select mb-2" required>
								<option value="" disabled selected>-- Select One --</option>
								<option value="Islamabad">Islamabad</option>
								<option value="Peshawar">Peshawar</option>
								<option value="Hangu">Hangu</option>
								<option value="Kohat">Kohat</option>
							</select>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-6">
							<label for="doj">Date of Joining</label>
                    		<input type="date" name="doj" class="form-control mb-2" required>
						</div>
						<div class="col-md-6">
							<label for="team">Team</label>
							<select name="emp_team" class="custom-select mb-4">
								<option value="" disabled selected>-- Select One --</option>
								<?php if(!empty($teams)): foreach($teams as $team): ?>
									<option value="<?= $team->team_id; ?>"><?= $team->team_name; ?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
						</div>
						<div class="col-md-6">
							<input type="reset" class="btn btn-warning btn-block" value="Clear">
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
<!-- Modal for adding new employee ends -->
<!-- Modal for assigning targets starts -->
<div class="modal fade" id="assign_target" tabindex="-1" role="dialog" aria-labelledby="payment_statusLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment_statusLabel">Assign Targets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-lg-6 col-md-6 col-sm-6">
                        <select name="city" id="city" class="form-control">
                            <option value="">-- Select City --</option>
                            <option value="islamabad">Islamabad</option>
                            <option value="peshawar">Peshawar</option>
                            <option value="hangu">Hangu</option>
                            <option value="kohat">Kohat</option>
                        </select>
                    </div>
                    <div class="col-xl-lg-6 col-md-6 col-sm-6">
                        <select name="month" id="month" class="form-control">
                            <option value="<?= date('F'); ?>" selected><?= date('F'); ?></option>
                            <option value="<?= date("F", strtotime('first day of +1 month')); ?>"><?= date("F", strtotime('first day of +1 month')); ?></option>
                        </select>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-xl-lg-12 col-md-12 table-responsive">
                        <form action="<?php echo base_url('admin/save_targets'); ?>" method="post">
                            <table class="table table-bordered table-sm">
                                <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Agent Name</th>
                                    <th>Previous Target</th>
                                    <th>Revenue Target</th>
                                    <th>Target Month</th>
                                </tr>
                                </thead>
                                <tbody id="sales_team">
                                    
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" id="btn-targets" class="btn btn-primary btn-sm" value="Assign Targets" disabled>
                                    <input type="reset" class="btn btn-warning btn-sm" value="Reset">
                                </div>
                            </div>
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
<!-- Modal for assigning targets ends -->
<!-- Modal for daily sales starts -->
<div class="modal fade" id="daily_sales" tabindex="-1" role="dialog" aria-labelledby="payment_statusLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dail_salesLabel">Add Daily Sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-lg-6 col-md-6 col-sm-6">
                        <select name="city" id="dailySalesCity" class="form-control">
                            <option value="">-- Select City --</option>
                            <option value="islamabad">Islamabad</option>
                            <option value="peshawar">Peshawar</option>
                            <option value="hangu">Hangu</option>
                            <option value="kohat">Kohat</option>
                        </select>
                    </div>
                    <div class="col-xl-lg-6 col-md-6 col-sm-6">
                        <input type="date" name="sales_date" id="sales_date" class="form-control" min="<?= date('Y-m-d', strtotime('-3 days')); ?>" max="<?= date('Y-m', strtotime('+25 days')); ?>">
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-xl-lg-12 col-md-12 table-responsive">
                        <form action="<?php echo base_url('admin/add_daily_sales'); ?>" method="post">
                            <table class="table table-bordered table-sm">
                                <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" id="dailySales"></th>
                                    <th>Agent Name</th>
                                    <th>Project</th>
                                    <th>Receiving Date</th>
                                    <th>Received Amount</th>
                                    <th>Rebate %age</th>
                                </tr>
                                </thead>
                                <tbody id="daily_sales_agents">
                                    
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" id="btn-daily_sales" class="btn btn-primary btn-sm" value="Save Changes" disabled>
                                    <input type="reset" class="btn btn-warning btn-sm" value="Reset">
                                </div>
                            </div>
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
<!-- Modal for daily sales ends -->
<!-- Modal for adding new team starts -->
<div class="modal fade" id="add_team" tabindex="-1" role="dialog" aria-labelledby="add_teamLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_teamLabel">Add Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/add_team'); ?>" method="post">
					<div class="row">
						<div class="col-md-6">
							<label for="team_name">Team Name</label>
                    		<input type="text" name="team_name" class="form-control mb-2" placeholder="Team name..." required>
						</div>
						<div class="col-md-6">
							<label for="team_lead">BCM Name</label>
                    		<input type="text" name="team_lead" class="form-control mb-2" placeholder="BCM name..." required>
						</div>
					</div>
                    <div class="row">
						<div class="col-md-12">
							<label for="bdm_name">BDM Name</label>
                    		<input type="text" name="bdm_name" class="form-control mb-2" placeholder="BDM name..." required>
						</div>
					</div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                        </div>
						<div class="col-md-6">
							<button type="reset" class="btn btn-warning btn-block">Reset</button>
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
								<input type="number" name="cnic" class="form-control cnic" placeholder="Customer CNIC..." required>
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
<div class="container"><hr>
    <div class="row mb-4 mt-4">
    <div class="col-md-12 text-right">
        <small>Copyright &copy; <?=date('Y');?>, AH Group of Companies (Pvt). Ltd.</small>
    </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // Check all
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        // Target month
        $("#month").change(function () {
            var target_month = $(this).val();
            $(".assignMonth").html("<option value='January' selected>"+target_month+"</option>");
        });
        // Assigning targets
        $('#city').on('change', function(){
            var filterByCity = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/get_sales_agents/' + filterByCity,
                method: 'POST',
                dataType: 'JSON',
                data: {filterByCity: filterByCity},
                success:function(data){
                    console.log(data);
                    if(data){
                        $('#sales_team').html('');
                        $.each(data, function(index, item){
                            $('#sales_team').append(`<tr>
                            <td><input type="checkbox" id="emp_id" name="emp_id[]" value="${item.emp_code}:${item.emp_team}"></td>
                            <td>${item.emp_name}</td>
                            <td><input type="text" class="form-control assign_month" value="${item.revenue_target}"></td>
                            <td><input type="text" name="revenue[]" class="form-control revenue_month" placeholder="Revenue Target..."></td>
                            <td><select name="month[]" class="form-control assignMonth" required><option value="<?= date('F'); ?>"><?= date('F'); ?></option></select></td></tr>`);
                            $('#btn-targets').removeAttr('disabled');
                        });
                    }
                }
            });
        });
    });
    $(document).ready(function(){
        // Adding daily sales records.
        $('#dailySalesCity').on('change', function(){
            var filterBydailySalesCity = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/get_daily_sales_agents/' + filterBydailySalesCity,
                method: 'POST',
                dataType: 'JSON',
                data: {filterBydailySalesCity: filterBydailySalesCity},
                success:function(data){
                    console.log(data);
                    if(data){
                        $('#daily_sales_agents').html('');
                        $.each(data, function(index, res){ // <input type="hidden" name="team[]" value="${res.emp_team}">
                            $('#daily_sales_agents').append(`<tr>
                            <td><input type="checkbox" name="emp_id[]" value="${res.emp_code}:${res.emp_team}"></td>
                            <td>${res.emp_name}, ${res.emp_code}</td>
                            <td><select name="project[]" class="form-control"><option value="" disabled selected>--Project--</option><option value="091 Mall">091 Mall</option><option value="Florenza">Florenza</option><option value="MoH">Mall of Hangu</option><option value="North Hills">North Hills</option><option value="AH Tower">AH Tower</option><option value="AH City">AH City</option></select></td>
                            <td><input type="date" name="receiving_date[]" class="form-control receiving_date" placeholder="Receiving date..."></td>
                            <td><input type="text" name="received_amount[]" class="form-control received_amount" placeholder="Received amount..."></td><td><input type="text" name="rebate[]" class="form-control rebate" placeholder="Rebate %age..."></td></tr>`);
                            $('#btn-daily_sales').removeAttr('disabled');
                        });
                    }
                }
            });
        });
        // Check all
        $("#dailySales").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        // Change input date and populate rest of the inputs in the form.
        $('#sales_date').on('change', function(){
            var sales_date = $(this).val();
            $('.receiving_date').val(sales_date);
        });
    });
</script>

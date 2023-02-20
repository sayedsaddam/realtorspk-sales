<?php $session = $this->session->userdata('username'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome-all.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <title>
        <?php if($session == 'realtors' || $session == 'yasir.ali' || $session == 'akbar.arbab' || $session == 'shahana.farah' || $session == 'nasir.jalil' || $session == 'obaid.rehman' || $session == 'isdaq.ahmed'){ echo 'Leader Board | Realtors PK'; }else{ echo 'Login | Realtors PK'; } ?>
    </title>
</head>
<body>
    <div class="container-fluid mt-2 pt-2" id="backToTop">
        <div class="row mb-2">
            <div class="col-md-7 col-sm-12">
                <h2 class="font-weight-bold">
                    <?php if($session == 'realtors' || $session == 'yasir.ali' || $session == 'akbar.arbab' || $session == 'shahana.farah' || $session == 'nasir.jalil' || $session == 'obaid.rehman' || $session == 'isdaq.ahmed'){ echo "Leader Board - Realtors PK <small style='font-size: 15px;'>(Welcome back, ".$this->session->userdata('fullname').")</small> <small style='font-size: 15px;'>Ending in <span id='endingIn'></span></small>"; }else{ echo "Login"; } ?>
                </h2>
            </div>
            <div class="col-md-5 col-sm-12 text-right">
					<?php if($session): ?>
						<a href="<?= base_url('reporting_panel/agent_stats/Peshawar'); ?>" class="btn btn-outline-info">Agent Stats</a>
						<a href="#teamsRevenue" class="btn btn-outline-primary">Teams &rightarrow;</a>
						<a href="#teamsRevenue" class="btn btn-outline-primary">BCMs &rightarrow;</a>
						<a href="#annualReport" class="btn btn-outline-primary">Annual Sales</a>
						<a class="btn btn-danger" href="<?= base_url('home/signout'); ?>">Sign Out</a>
					<?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Leaderboard - daily sales. -->
    <div class="container-fluid">
        <?php if($session == 'realtors' || $session == 'yasir.ali' || $session == 'akbar.arbab' || $session == 'shahana.farah' || $session == 'adil.hussain' || $session == 'nasir.jalil' || $session == 'obaid.rehman' || $session == 'isdaq.ahmed'): ?>
			<div class="row total-revenue rounded mb-2 py-2 justify-content-sm-between">
				<div class="col-md-2 col-sm-6 border-left border-success">
					<strong>Agent : <?= $daily_sales[0]->emp_name; ?></strong><br>
					Revenue <span><?= number_format($daily_sales[0]->received_amount/1000000, 2); ?> M</span>
				</div>
				<div class="col-md-2 col-sm-6 border-left border-success">
					<strong>Team : <?= $teams_report[0]->team_name; ?></strong><br>
					Revenue <span><?= number_format($teams_report[0]->received_amount/1000000, 2); ?> M</span>
				</div>
				<div class="col-md-2 col-sm-6 border-left border-success">
					<strong>Runner-up : <?= $teams_report[1]->team_name; ?></strong><br>
					Revenue <span><?= number_format($teams_report[1]->received_amount/1000000, 2); ?> M</span>
				</div>
                <div class="col-md-2 col-sm-6 border-left border-success">
					<strong>Champion : <?= $bcms[0]->team_lead; ?></strong><br>
					Revenue : <span><?= number_format($bcms[0]->total_revenue/1000000, 2); ?></span>
				</div>
                <div class="col-md-2 col-sm-6 border-left border-success">
					<strong>Region : -/-</strong><br>
					Revenue : <span>-/-</span>
				</div>
			</div>
            <div class="row no-gutters">
                <div class="col-xl-col-lg-6 col-md-6 col-sm-6">
                    <div class="card border-secondary">
                        <div class="card-header bg-transparent">
                            <h3 class="text-secondary font-weight-bold">Revenue by Peshawar</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-col-lg-12 col-md-12 col-sm-12 table-responsive" style="height: 455px;overflow: scroll;">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr class="text-secondary">
                                                <th>Agent</th>
                                                <th>Target</th>
                                                <th>Total</th>
                                                <th>%age</th>
																<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!empty($daily_sales)):
                                                $total_targets_psh = 0;
																$total_psh = 0;
                                                foreach($daily_sales as $sale):
                                                if($sale->emp_city == 'Peshawar'):
                                                    $total_targets_psh += $sale->revenue_target; ?>
                                                <tr class="">
                                                    <td>
														<?php if($sale->gender == 'm' && $sale->received_amount >= 10000000){ echo ' <span class="bg-warning p-1 rounded">&#128014;</span>'; }elseif($sale->gender == 'f' && $sale->received_amount >= 5000000){ echo ' <span class="bg-warning p-1 rounded">&#128052;</span>'; } ?>
														<?= $sale->emp_name; ?>
													</td>
													<td>
														<?= number_format($sale->revenue_target/1000000, 3); ?>
													</td>
													<td class="<?php if($sale->received_amount >= $sale->revenue_target){ echo 'text-success'; }else{ echo 'text-danger'; } ?> font-weight-bold"><?= number_format(($sale->received_amount)/1000000, 3); ?></td>
													<td><?= $sale->revenue_target > 0 ? number_format($sale->received_amount/$sale->revenue_target*100, 2) : '100'; ?></td>
													<td>
														<a data-id="<?= $sale->agent_id; ?>" class="sales_info" href="javascript:void(0)">detail</a>
													</td>
                                                </tr>
                                                <?php $total_psh += ($sale->received_amount); ?>
                                            <?php endif; endforeach; ?>
                                                <tr class="total-revenue">
                                                    <td class="font-weight-bold">Total</td>
                                                    <td class="font-weight-bold"><?= number_format($total_targets_psh/1000000, 3); ?></td>
                                                    <td class="font-weight-bold"><?= number_format($total_psh/1000000, 3); ?></td>
                                                    <td class="font-weight-bold" colspan="2"><?= number_format($total_psh/$total_targets_psh*100, 2).'%'; ?></td>
                                                </tr>
                                            <?php else: ?>
                                                <tr class="table-danger">
                                                    <td colspan="8" align="center">No record found!</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-col-lg-6 col-md-6 col-sm-6">
                    <div class="card border-secondary">
                        <div class="card-header bg-transparent">
                            <h3 class="text-secondary font-weight-bold">Revenue by Islamabad</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-col-lg-12 col-md-12 col-sm-12 table-responsive" style="height: 455px;overflow: scroll;">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr class="text-secondary">
                                                <th>Agent</th>
                                                <th>Target</th>
                                                <th>Total</th>
                                                <th>%age</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            	if(!empty($daily_sales)):
                                                $total_targets_isb = 0;
                                                $total_isb = 0;
                                                foreach($daily_sales as $sale):
                                                if($sale->emp_city == 'Islamabad'):
                                                    $total_targets_isb += $sale->revenue_target; ?>
                                                <tr class="">
                                                    <td>
																		<?php if($sale->gender == 'm' && $sale->received_amount >= 10000000){ echo ' <span class="bg-warning p-1 rounded">&#128014;</span>'; }elseif($sale->gender == 'f' && $sale->received_amount >= 5000000){ echo ' <span class="bg-warning p-1 rounded">&#128052;</span>'; } ?>
																		<?= $sale->emp_name; ?>
																	</td>
                                                    <td>
                                                        <?= number_format($sale->revenue_target/1000000, 3); ?>
                                                    </td>
                                                    <td class="<?php if($sale->received_amount >= $sale->revenue_target){ echo 'text-success'; }else{ echo 'text-danger'; } ?> font-weight-bold"><?= number_format(($sale->received_amount)/1000000, 3); ?></td>
                                                    <td><?= $sale->revenue_target > 0 ? number_format($sale->received_amount/$sale->revenue_target*100, 2) : '100'; ?></td>
																	<td>
																		<a data-id="<?= $sale->agent_id; ?>" class="sales_info" href="javascript:void(0)">detail</a>
																	</td>
                                                </tr>
                                                <?php $total_isb += ($sale->received_amount); ?>
                                           	<?php endif; endforeach; ?>
															<?php if($total_isb > 0): ?>
																<tr class="total-revenue">
																	<td class="font-weight-bold">Total</td>
																	<td class="font-weight-bold"><?= number_format($total_targets_isb/1000000, 3); ?></td>
																	<td class="font-weight-bold"><?= number_format($total_isb/1000000, 3); ?></td>
																	<td class="font-weight-bold" colspan="2"><?= number_format($total_psh/$total_targets_psh*100, 2).'%'; ?></td>
																</tr>
															<?php else: ?>
																<tr class="table-danger">
																	<td colspan="5" align="center">No record found.</td>
																</tr>
															<?php endif; ?>
                                            	<?php else: ?>
                                                <tr class="table-danger">
                                                   <td colspan="8" align="center">No record found!</td>
                                                </tr>
                                            	<?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-gutters mt-3" id="teamsRevenue">
                <div class="col-xl-lg-6 col-md-6">
                    <div class="card border-secondary">
                        <div class="card-header bg-transparent">
                           <h3 class="font-weight-bold text-secondary">Revenue by Teams</h3>
                        </div>
                        <div class="card-body">
									<div class="row">
										<div class="col-xl-col-lg-12 col-md-12 col-sm-12 table-responsive" style="height: 400px;overflow: scroll;">
											<table class="table table-sm">
													<thead>
														<tr class="text-secondary">
															<th>Sr #</th>
															<th>Team Name</th>
															<th>BCM Name</th>
															<th>Target</th>
															<th>Achieved</th>
															<th>Percentage</th>
														</tr>
													</thead>
													<tbody>
														<?php if(!empty($teams_report)): $serial = 1;
															$total_targets_assigned = 0;
															$total_targets_achieved = 0;
															$total_targets_teams = 0;
															foreach($teams_report as $tr): ?>
														<tr>
															<td><?= $serial++; ?></td>
															<td><a data-id="<?= $tr->team_id; ?>" class="team_info" href="javascript:void(0)"><?= $tr->team_name; ?></a></td>
															<td><?= $tr->team_lead; //echo number_format($tr->total_target/1000000, 2); ?></td>
															<td>
																	<?php $team_target =  $this->home_model->sum_targets($tr->team_id); echo number_format($team_target->total_targets/1000000, 3); ?>
															</td>
															<td><?= number_format($tr->received_amount/1000000, 3); ?></td>
															<td class="<?php if($tr->received_amount > 0){ echo 'text-success'; }else{ echo 'text-danger'; } ?> font-weight-bold">
																	<?php if($team_target->total_targets > 0){
																		$percentage_target = ($tr->received_amount/$team_target->total_targets*100);
																		echo round($percentage_target, 3).'%';
																	}else{ echo '00'; } ?>
															</td>
														</tr>
														<?php $total_targets_assigned += $tr->total_target;
															$total_targets_achieved += $tr->received_amount;
															$total_targets_teams += $team_target->total_targets; ?>
														<?php endforeach; endif; ?>
														<tr class="total-revenue">
															<td class="font-weight-bold">Total</td>
															<td></td>
															<td></td>
															<td class="font-weight-bold"><?php if(!empty($total_targets_teams)){ echo number_format($total_targets_teams/1000000, 3); } ?></td>
															<td class="font-weight-bold" title="Sales in 091 Mall and Florenza"><?php //if(!empty($total_targets_achieved)){ echo number_format($total_targets_achieved/1000000, 3); }
															echo number_format($total_targets_achieved/1000000, 3); // 091 mall and florenza sales. ?></td>
															<td class="font-weight-bold">
																	<?php if(!empty($total_targets_achieved) && !empty($total_targets_teams)){ $percentage = ($total_targets_achieved/$total_targets_teams*100); 
																		echo round($percentage, 3).'%'; } ?>
															</td>
														</tr>
													</tbody>
											</table>
										</div>
									</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-lg-6 col-md-6">
                    <div class="card border-secondary">
                        <div class="card-header bg-transparent">
									<h3 class="text-secondary font-weight-bold">Revenue by BCMs</h3>
                        </div>
                        <div class="card-body" style="height: 440px;overflow: scroll;">
									<table class="table table-sm">
										<caption>BCMs' targets included</caption>
										<thead>
											<tr class="text-secondary">
												<th>Name</th>
												<th>Target</th>
												<th>Revenue</th>
												<th>Percentage</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($bcms)):
													$total_targets_bcms = 0;
													$total_sales_bcms = 0;
													foreach($bcms as $bcm):
											?>
											<tr>
												<td><?= $bcm->team_lead ? $bcm->team_lead : '-/-'; ?></td>
												<td><?php $bcm_targets = $this->home_model->sum_bcms_targets($bcm->team_lead); echo number_format($bcm_targets->total_targets_bcm/1000000, 2); ?></td>
												<td><?= number_format($bcm->total_revenue/1000000, 2); ?></td>
												<td class="<?= $bcm->total_revenue > 0 ? 'text-success' : 'text-danger'; ?> font-weight-bold">
													<?= $bcm_targets->total_targets_bcm > 0 ? number_format($bcm->total_revenue/$bcm_targets->total_targets_bcm*100, 2) : '100'; ?>%
												</td>
												<?php
													$total_targets_bcms += $bcm_targets->total_targets_bcm;
													$total_sales_bcms += $bcm->total_revenue;
												?>
											</tr>
											<?php endforeach; endif; ?>
											<tr class="total-revenue">
												<th>Total</th>
												<th><?= number_format($total_targets_bcms/1000000, 2); ?></th>
												<th><?= number_format($total_sales_bcms/1000000, 2); ?></th>
												<th><?= number_format($total_sales_bcms/$total_targets_bcms*100, 2); ?>%</th>
											</tr>
										</tbody>
									</table>
                        </div>
                    </div>
                </div>
            </div>
				<div class="row mt-3" id="annualReport">
               <div class="col-lg-12 col-md-12">
						<div class="card border-secondary">
							<div class="card-header bg-transparent">
								<h3 class="font-weight-bold text-secondary">Annual Sales Report for the year <?= date('Y'); ?></h3>
							</div>
							<div class="card-body">
						<div class="row">
							<div class="col-md-4 table-responsive">
								<h2 class="text-secondary">King of the Year</h2>
								<table class="table table-sm">
									<thead>
										<tr class="text-secondary">
											<th>Agent</th>
											<th>Revenue</th>
										</tr>
									</thead>
									<tbody>
										<?php $limit = 0; foreach($annual_sales_agents as $sale): if($sale->gender == 'm'): $limit++; ?>
										<tr>
											<td><?= $sale->emp_name; ?></td>
											<td><?= number_format($sale->amount_received/1000000, 3); ?> M</td>
										</tr>
										<?php endif; if($limit == 10){ break; } endforeach; ?>
									</tbody>
								</table>
							</div>
							<div class="col-md-4 table-responsive border-left">
								<h2 class="text-secondary">Queen of the Year</h2>
								<table class="table table-sm">
									<thead>
										<tr class="text-secondary">
											<th>Agent</th>
											<th>Revenue</th>
										</tr>
									</thead>
									<tbody>
										<?php $limit = 0; foreach($annual_sales_agents as $sale): if($sale->gender == 'f'): $limit++; ?>
										<tr>
											<td><?= $sale->emp_name; ?></td>
											<td><?= number_format($sale->amount_received/1000000, 3); ?> M</td>
										</tr>
										<?php endif; if($limit == 10){ break; } endforeach; ?>
									</tbody>
								</table>
							</div>
							<div class="col-md-4 border-left">
								<h2 class="text-secondary">Top Agent, Team & BCM</h2>
								<table class="table table-sm">
									<thead>
										<tr class="text-secondary">
											<th>Name</th>
											<th>Revenue</th>
										</tr>
										<tr>
											<td><?= $annual_sales_agents[0]->emp_name; ?></td>
											<td><?= number_format($annual_sales_agents[0]->amount_received/1000000, 3); ?> M</td>
										</tr>
										<tr>
											<td><?= $annual_sales_teams[0]->team_name; ?></td>
											<td><?= number_format($annual_sales_teams[0]->received_amount/1000000, 3); ?> M</td>
										</tr>
										<tr>
											<td><?= $annual_sales_bcm->team_lead; ?></td>
											<td><?= number_format($annual_sales_bcm->total_revenue/1000000, 3); ?> M</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
							</div>
						</div>
                </div>
            </div>
			<?php // Projects revenue
				$zeroNineOne = 0;
				$florenza = 0;
				$moh = 0;
				$nh = 0;
				$aht = 0;
				$ahc = 0;
				$ahr = 0;
				foreach($daily_sales as $projectSales){
					$zeroNineOne += $projectSales->zero_nine_one;
					$florenza += $projectSales->florenza;
					$moh += $projectSales->moh;
					$nh += $projectSales->nh;
					$aht += $projectSales->aht;
					$ahc += $projectSales->ahc;
					$ahr += $projectSales->ahr;
				}
			?>
			<div class="row mt-3">
				<div class="col-md-12">
					<div class="card border-secondary">
						<div class="card-header bg-transparent">
							<h2 class="card-title font-weight-bold text-secondary">Others</h2>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6 border-right">
									<legend>Projects Revenue</legend>
									<table class="table table-sm">
										<thead>
											<tr class="text-secondary">
												<th>Project</th>
												<th>Revenue</th>
												<th>City</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<img src="<?= base_url('assets/images/091.png'); ?>" class="img-fluid" alt="091 Mall" width="25">
													091 Mall
												</td>
												<td><?= number_format($zeroNineOne/1000000, 2); ?> Million</td>
												<td>Peshawar</td>
											</tr>
											<tr>
												<td>
													<img src="<?= base_url('assets/images/fl.png'); ?>" class="img-fluid" alt="091 Mall" width="25">
													Florenza
												</td>
												<td><?= number_format($florenza/1000000, 2); ?> Million</td>
												<td>Peshawar</td>
											</tr>
											<tr>
												<td>
													<img src="<?= base_url('assets/images/moh.png'); ?>" class="img-fluid" alt="091 Mall" width="25">
													Mall of Hangu
												</td>
												<td><?= number_format($moh/1000000, 2); ?> Million</td>
												<td>Hangu</td>
											</tr>
											<tr>
												<td>
													<img src="<?= base_url('assets/images/nh.png'); ?>" class="img-fluid" alt="091 Mall" width="25">
													North Hills
												</td>
												<td><?= number_format($nh/1000000, 2); ?> Million</td>
												<td>Murree</td>
											</tr>
											<tr>
												<td>
													<img src="<?= base_url('assets/images/aht.png'); ?>" class="img-fluid" alt="091 Mall" width="25">
													AH Tower
												</td>
												<td><?= number_format($aht/1000000, 2); ?> Million</td>
												<td>Peshawar</td>
											</tr>
											<tr>
												<td>
													<img src="<?= base_url('assets/images/ahcity.png'); ?>" class="img-fluid" alt="091 Mall" width="25">
													AH City
												</td>
												<td><?= number_format($ahc/1000000, 2); ?> Million</td>
												<td>DI Khan</td>
											</tr>
											<tr>
												<td>
													<img src="<?= base_url('assets/images/ahr.png'); ?>" class="img-fluid" alt="091 Mall" width="25">
													AH Residencia
												</td>
												<td><?= number_format($ahr/1000000, 2); ?> Million</td>
												<td>Islamabad</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-6">
									<legend>Business Center Mangers</legend>
									<table class="table table-sm">
										<thead>
											<tr class="text-secondary">
												<th>Designation</th>
												<th>Name</th>
												<th>Location</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>BCM-I</td>
												<td>Muhammad Akbar Arbab</td>
												<td>Realtors, Ring road, Peshawar</td>
											</tr>
											<tr>
												<td>BCM-II</td>
												<td>Obaid ur Rehman</td>
												<td>Realtors, Ring road, Peshawar</td>
											</tr>
											<tr>
												<td>BCM-III</td>
												<td>Isdaq Ahmad</td>
												<td>Realtors, Ring road, Peshawar</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        <?php else: ?>
            <div class="row">
                <div class="col-xl-lg-6 col-md-6 offset-xl-lg-3 offset-md-3">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Looks like you're not logged in. Login to continue your activity.
                    </div>
                    <div class="card">
                        <div class="card-header bg-info">
                            <h2 class="card-title font-weight-bold text-light mb-0">Login</h2>
                            <small class="text-light">Enter your credentials either you're based in Islamabad, Peshawar or Hangu.</small>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('home/get_access'); ?>" method="post">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                                <input type="submit" class="btn btn-primary" value="Continue">
                                <input type="reset" class="btn btn-warning" value="Clear">
                            </form>
                            <?php if($failed = $this->session->flashdata('access_denied')): ?>
                                <div class="alert alert-danger mt-4">
                                    <?php echo $failed; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer text-right">
                            <small>&copy; Realtors PK, Peshawar <?= date('Y'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- Leaderboard - daily sales. -->
	<?php if($session): ?>
		<div class="container-fluid"><hr>
			<div class="row mb-4 mt-4">
				<div class="col-md-4">
					<small><a href="#backToTop">Back to top &uparrow;</a></small>
				</div>
				<div class="<?= $session ? 'col-md-8' : 'col-md-12'; ?> text-right">
					<small class="text-dark">Copyright &copy; <?= date('Y'); ?>, Realtors PK, Peshawar.</small>
				</div>
			</div> 
		</div>
	<?php endif; ?>
    <!-- Modal > Filter employees by team ID. -->
    <div class="modal fade" id="team_info" tabindex="-1" role="dialog" aria-labelledby="team_infoModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"></h5>
					<button type="button" class="close d-print-none" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row mb-3">
						<div class="col-md-12">
							<p class="lead alert alert-success">Overall team statistics. Revenue by agent in each project.</p>
						</div>
					</div>
					<div class="list table-responsive">
						<table class="table table-sm">
							<thead>
								<tr class="text-center">
									<th class="text-left">Agent</th>
									<th>TGT</th>
									<th><img src="<?= base_url('assets/images/091.png'); ?>" alt="091 Mall" width="25"></th>
									<th><img src="<?= base_url('assets/images/fl.png'); ?>" alt="Florenza" width="25"></th>
									<th><img src="<?= base_url('assets/images/moh.png'); ?>" alt="Mall of Hangu" width="25"></th>
									<th><img src="<?= base_url('assets/images/aht.png'); ?>" alt="AH Tower" width="25"></th>
									<th><img src="<?= base_url('assets/images/nh.png'); ?>" alt="North Hills" width="25"></th>
									<th><img src="<?= base_url('assets/images/ahcity.png'); ?>" alt="AH City" width="25"></th>
									<th><img src="<?= base_url('assets/images/ahr.png'); ?>" alt="AH Residencia" width="25"></th>
									<th>TTL</th>
								</tr>
							</thead>
							<tbody class="employees_list text-center">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer d-print-none">
					<button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
    </div>

	<!-- Modal > Filter sales by agent ID / employee code. -->
    <div class="modal fade" id="sales_info" tabindex="-1" role="dialog" aria-labelledby="agent_infoModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title-sales font-weight-bold" id="exampleModalLabel">Agent Name - Team Name</h2>
					<button type="button" class="close d-print-none" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="list table-responsive">
						<table class="table table-hover table-sm">
							<thead>
								<tr class="text-center">
									<th><img src="<?= base_url('assets/images/091.png'); ?>" alt="091 Mall" width="25"></th>
									<th><img src="<?= base_url('assets/images/fl.png'); ?>" alt="Florenza" width="25"></th>
									<th><img src="<?= base_url('assets/images/moh.png'); ?>" alt="Mall of Hangu" width="25"></th>
									<th><img src="<?= base_url('assets/images/aht.png'); ?>" alt="AH Tower" width="25"></th>
									<th><img src="<?= base_url('assets/images/nh.png'); ?>" alt="North Hills" width="25"></th>
									<th><img src="<?= base_url('assets/images/ahcity.png'); ?>" alt="AH City" width="25"></th>
									<th><img src="<?= base_url('assets/images/ahr.png'); ?>" alt="AH Residencia" width="25"></th>
								</tr>
							</thead>
							<tbody class="sales_list text-center">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer d-print-none">
					<button class="btn btn-outline-primary" onclick="window.print()">Print</button>	
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
    </div>
</body>
<script>
    window.location.hash = "no-back-button";
    // Again because Google Chrome doesn't insert
    // the first hash into the history
    window.location.hash = "Again-No-back-button"; 
    window.onhashchange = function(){
        window.location.hash = "no-back-button";
    }
</script>
<script>
$(document).ready(function(){
  $('.team_info').click(function(){  
    var team_id = $(this).data('id');
    // AJAX request
    $.ajax({
    url: '<?= base_url('home/get_team_info/'); ?>' + team_id,
    method: 'POST',
    dataType: 'JSON',
    data: {team_id: team_id},
      success: function(response){ 
        console.log(response);
        $('.employees_list').html('');
        $.each(response, function(index, res){
            $('.modal-title').html(res.team_name + ' &raquo; ' + res.bdm_name + ' &raquo; '+ res.team_lead);
            $('.employees_list').append(`<tr><td class='text-left'>${res.emp_name}</td><td>${Number(res.revenue_target).toLocaleString()}</td><td>${Number(res.zero_nine_one).toLocaleString()}</td><td>${Number(res.florenza).toLocaleString()}</td><td title='MoH for Hangu team...'>${Number(res.moh).toLocaleString()}</td><td>${Number(res.aht).toLocaleString()}</td><td>${Number(res.nh).toLocaleString()}</td><td>${Number(res.ahc).toLocaleString()}</td><td>${Number(res.ahr).toLocaleString()}</td><td>${Number(res.received_amount).toLocaleString()}</td></tr>`);
        });
        $('#team_info').modal('show');
      }
    });
  });
  // Agent sales information
  $('.sales_info').click(function(){
	var agent_id = $(this).data('id');
	$.ajax({
		url: '<?= base_url("home/sales_info/"); ?>' + agent_id,
		method: 'POST',
		dataType: 'JSON',
		data: {agent_id: agent_id},
		success: function(response){
			console.log(response);
			$('.sales_list').html('');
			$.each(response, function(index, res){
				$('.modal-title-sales').html(res.emp_name + ' &raquo; ' + res.team_name);
				$('.sales_list').append(`<tr><td>${Number(res.zero_nine_one).toLocaleString()}</td><td>${Number(res.florenza).toLocaleString()}</td><td>${Number(res.moh).toLocaleString()}</td><td title='MoH for Hangu team...'>${Number(res.aht).toLocaleString()}</td><td>${Number(res.nh).toLocaleString()}</td><td>${Number(res.ahc).toLocaleString()}</td><td>${Number(res.ahr).toLocaleString()}</td></tr>`);
			});
			$('#sales_info').modal('show');
		}
	})
  })
});
</script>
<!-- countdown timer -->
<script>
	var today = new Date();
   var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0, 23,59,59);
   var countDownDate = new Date(lastDayOfMonth).getTime();
   var x = setInterval(function(){
      var now = new Date().getTime();
      var distance = countDownDate - now;
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      document.getElementById('endingIn').innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
      if(distance < 0){
         clearInterval(x);
         document.getElementById('endingIn').innerHTML = 'EXPIRED';
      }
   }, 1000);
</script>
</html>

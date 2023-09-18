<?php 
$bcm1_commission = 0;
$bcm2_commission = 0;
$bcm3_commission = 0;
$total_amount_bcm1=0;
?>
<div class="container">
    <div class="row mt-3 d-print-none">
        <div class="col-md-7">
            <form action="<?= base_url('admin/filter_by_month/'); ?>" method="get">
                <div class="input-group">
                    <input type="hidden" name="city" value="<?= $city ?>">
                    <input type="month" name="month" class="form-control" required>
                    <div class="input-group-append">
                        <input type="submit" class="btn btn-primary" value="Generate Report">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-5 text-right">
            <a href="javascript:history.go(-1)" class="btn btn-primary">&laquo; Go Back</a>
            <a href="" class="btn btn-primary" onclick="javascript:window.print();">Get Print</a>
        </div>
    </div>
    <hr>
</div>
<?php if(empty($daily_sales) && empty($monthly_commissions)): ?>
<div class="container mt-5 pt-5 text-center">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">
                <h1 class="font-weight-light">Whoopsie! <small class="font-weight-lighter">We couldn't find any result
                        associated with the input provided.</small></h1>
            </div>
        </div>
    </div>
</div>
<?php exit; endif; ?>
<?php if(empty($monthly_commissions)): ?>
<div class="container">
    <div class="row no-gutters d-print-none d-none">
        <div class="row">
            <div class="col-xl-col-lg-12 col-md-12 col-sm-12 table-responsive" style="height: 455px;overflow: scroll;">
                <?php
					// BCM 1 >> Target & Revenue
                    
					if(!empty($daily_sales)){
						$total_amount_zn_bcm1=0;
						$total_amount_fl_bcm1=0;
						$total_amount_aht_bcm1=0;
						$total_amount_nh_bcm1=0;
						$total_amount_moh_bcm1=0;
						$total_amount_ahc_bcm1=0;
						$total_targets_bcm1 = 0;
						foreach($daily_sales as $sale){
							if($sale->emp_team == 1 || $sale->emp_team == 3 || $sale->emp_team == 4 || $sale->emp_team == 5 || $sale->emp_team == 9){
								$total_targets_bcm1 += $sale->revenue_target;
								$total_amount_zn_bcm1 +=$sale->zero_nine_one;
								$total_amount_fl_bcm1 +=$sale->fl;
								$total_amount_aht_bcm1 +=$sale->aht;
								$total_amount_nh_bcm1 +=$sale->nh;
								$total_amount_moh_bcm1 +=$sale->moh;
								$total_amount_ahc_bcm1 += $sale->ahc;
								$total_amount_bcm1 = ($total_amount_zn_bcm1 + $total_amount_fl_bcm1 + $total_amount_aht_bcm1 + $total_amount_nh_bcm1 + $total_amount_moh_bcm1 + $total_amount_ahc_bcm1); // 091 + florenza + aht + nh + moh + ahc.
							}
						}
					}
				?>
            </div>
        </div>
        <?php
			// BCM 2 >> Target & Revenue
			if(!empty($daily_sales)){
				$total_amount_zn_bcm2=0;
				$total_amount_fl_bcm2=0;
				$total_amount_aht_bcm2=0;
				$total_amount_nh_bcm2=0;
				$total_amount_moh_bcm2=0;
				$total_amount_ahc_bcm2=0;
				$total_targets_bcm2 = 0;
                $total_amount_bcm2 = 0;
                $total_amount_bcm3 = 0;
				foreach($daily_sales as $sale){
					if($sale->emp_team == 2 || $sale->emp_team == 6 || $sale->emp_team == 7 || $sale->emp_team == 8 || $sale->emp_team == 10){
						$total_targets_bcm2 += $sale->revenue_target;
						$total_amount_zn_bcm2 += $sale->zero_nine_one; 
						$total_amount_fl_bcm2 += $sale->florenza;
						$total_amount_aht_bcm2 += $sale->aht;
						$total_amount_nh_bcm2 += $sale->nh;
						$total_amount_moh_bcm2 += $sale->moh;
						$total_amount_ahc_bcm2 += $sale->ahc;
						$total_amount_bcm2 = ($total_amount_zn_bcm2 + $total_amount_fl_bcm2 + $total_amount_aht_bcm2 + $total_amount_nh_bcm2 + $total_amount_moh_bcm2 + $total_amount_ahc_bcm2); // florenza + 091 + aht + nh + moh + ahc.
					}
				}
			}
		?>
        <?php
			// BCM 3 >> Target & Revenue
			if(!empty($daily_sales)){
				$total_amount_zn_bcm3=0;
				$total_amount_fl_bcm3=0;
				$total_amount_aht_bcm3=0;
				$total_amount_nh_bcm3=0;
				$total_amount_moh_bcm3=0;
				$total_amount_ahc_bcm3=0;
				$total_targets_bcm3 = 0;
				foreach($daily_sales as $sale){
					if($sale->emp_team == 11 || $sale->emp_team == 12 || $sale->emp_team == 13 || $sale->emp_team == 14 || $sale->emp_team == 15){
						$total_targets_bcm3 += $sale->revenue_target;
						$total_amount_zn_bcm3 += $sale->zero_nine_one;
						$total_amount_fl_bcm3 += $sale->florenza;
						$total_amount_aht_bcm3 += $sale->aht;
						$total_amount_nh_bcm3 += $sale->nh;
						$total_amount_moh_bcm3 += $sale->moh;
						$total_amount_ahc_bcm3 += $sale->ahc;
						$total_amount_bcm3 = ($total_amount_zn_bcm3 + $total_amount_fl_bcm3 + $total_amount_aht_bcm3 + $total_amount_nh_bcm3 + $total_amount_moh_bcm3 + $total_amount_ahc_bcm3); // florenza + 091 + aht + nh + moh + ahc.
					}
				}
			}
		?>
    </div>
    <div class="row no-gutters mt-3">
        <div class="col-xl-lg-12 col-md-12">
            <h3 class="font-weight-light text-center">Realtors PK Office - <?= $city ?> | <small
                    class="font-weight-light">
                    <?= date('F, Y'); ?></small></h3>
            <div class="row">
                <div class="col-xl-col-lg-12 col-md-12 col-sm-12 table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Team Name</th>
                                <th>Target</th>
                                <th>Target Achieved</th>
                                <th>Percentage Achieved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($teams_report)):
                                $total_targets_assigned = 0;
                                $total_targets_achieved = 0;
                                $total_targets_teams = 0;
                                $total_targets_helpers = 0; // $tr->team_name != 'BCM-1' && $tr->team_name != 'BCM-2' && $tr->team_name != 'BCM-3' => BCM's team included again.
                                foreach($teams_report as $tr): if($tr->team_name != 'The Helpers' && $tr->team_name != 'BCM-1' && $tr->team_name != 'BCM-2' && $tr->team_name != 'BCM-3'): // BCM's excluded. ?>
                            <tr>
                                <td><?= $tr->team_name; ?></td>
                                <td>
                                    <?php $team_target =  $this->home_model->sum_targets($tr->team_id); echo number_format($team_target->total_targets/1000000, 2);?>
                                </td>
                                <td><?= number_format($tr->received_amount/1000000, 2); ?></td>
                                <td>
                                    <?php $percentage_target = ($tr->received_amount/$team_target->total_targets*100);
                                        echo round($percentage_target, 2).'%'; ?>
                                </td>
                            </tr>
                            <?php $total_targets_assigned += $tr->total_target;
                                $total_targets_achieved += $tr->received_amount;
                                $total_targets_teams += $team_target->total_targets; 
                                if($tr->emp_team == 11){ $total_targets_achieved_ts += $tr->received_amount; } ?>
                            <?php endif; endforeach; endif; ?>
                            <tr>
                                <td class="font-weight-bold">Total</td>
                                <td class="font-weight-bold">
                                    <?php if(!empty($total_targets_teams)){ echo number_format($total_targets_teams/1000000, 2); }else{ echo '00'; } ?>
                                </td>
                                <td class="font-weight-bold">
                                    <?php if(!empty($total_targets_achieved)){ echo number_format($total_targets_achieved/1000000, 2); }else{ echo '00'; } ?>
                                </td>
                                <td class="font-weight-bold">
                                    <?php if(!empty($total_targets_achieved) && !empty($total_targets_teams)){ $percentage = ($total_targets_achieved/$total_targets_teams*100); 
                                        echo round($percentage, 2).'%'; }else{ echo '00'; } ?>
                                </td>
                            </tr>
                            <?php
                            
                            if($total_targets_bcm1) 
                            $bcm1_commission = ($total_amount_bcm1/$total_targets_bcm1*100); 
                            ?>
                            <?php 
                            if($total_targets_bcm2)
                            $bcm2_commission = $total_amount_bcm2 > 0 ? ($total_amount_bcm2/$total_targets_bcm2*100):0; ?>
                            <?php 
                            if($total_targets_bcm3)
                            $bcm3_commission = (($total_amount_bcm3/$total_targets_bcm3)*100); ?>
                            <tr>
                                <td>
                                    <div>BCM-I (<strong>Muhammad Akbar Arbab</strong>)</div>
                                    <div><small>0.3% of total teams revenue goes to the BCM.</small></div>
                                </td>
                                <td>
                                    <div><?= number_format($bcm1_commission, 2).'%'; ?></div>
                                    <div><small>Current %age</small></div>
                                </td>
                                <td>
                                    <div>
                                        <?php if($bcm1_commission >= 50){ echo number_format(0.3 * $total_amount_bcm1/100); }else{ echo '00'; } ?>
                                    </div>
                                    <div><small>%age Amount</small></div>
                                </td>
                                <td>
                                    <div><small>Target: <?= number_format($total_targets_bcm1/1000000, 2); ?></small>
                                    </div>
                                    <div><small>Achived: <?= number_format($total_amount_bcm1/1000000, 2); ?></small>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>BCM-II (<strong>Shahbaz Khan</strong>) </div>
                                    <div><small>0.3% of total teams revenue goes to the BCM.</small></div>
                                </td>
                                <td>
                                    <div><?= number_format($bcm2_commission, 2).'%'; ?></div>
                                    <div><small>Current %age</small></div>
                                </td>
                                <td>
                                    <div>
                                        <?php if($bcm2_commission >= 50){ echo number_format(0.3 * $total_amount_bcm2/100); }else{ echo '00'; } ?>
                                    </div>
                                    <div><small>%age Amount</small></div>
                                </td>
                                <td>
                                    <div><small>Target: <?= number_format($total_targets_bcm2/1000000, 2); ?></small>
                                    </div>
                                    <div><small>Achived: <?= number_format($total_amount_bcm2/1000000, 2); ?></small>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>BCM-III (<strong>Isdaq Ahmad</strong>)</div>
                                    <div><small>0.3% of total teams revenue goes to the BCM.</small></div>
                                </td>
                                <td>
                                    <div><?= number_format($bcm3_commission, 2).'%'; ?></div>
                                    <div><small>Current %age</small></div>
                                </td>
                                <td>
                                    <div>
                                        <?php if($bcm3_commission >= 50){ echo number_format(0.3 * $total_amount_bcm3/100); }else{ echo '00'; } ?>
                                    </div>
                                    <div><small>%age Amount</small></div>
                                </td>
                                <td>
                                    <div><small>Target: <?= number_format($total_targets_bcm3/1000000, 2); ?></small>
                                    </div>
                                    <div><small>Achived: <?= number_format($total_amount_bcm3/1000000, 2); ?></small>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; // First if condition ends. ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h3 class="font-weight-light text-center">Teams Rebate (BDMs) -
                <?= $city ?> </h3>
            <table class="table table-striped table-sm">
                <thead>
                    <th>BDM & Team</th>
                    <th>Target</th>
                    <th>Revenue</th>
                    <th>%age</th>
                    <th title="Applicable rebate...">Applicable</th>
                </thead>
                <tbody>
                    <?php if(!empty($teams_report)):
                        $total_targets_assigned = 0;
                        $total_targets_achieved = 0;
                        $total_targets_achieved_ts = 0; // Telesales
                        $total_targets_teams = 0;
                        $total_targets_helpers = 0;
                        foreach($teams_report as $tr): if($tr->team_name != 'BCM-1' && $tr->team_name != 'BCM-2' && $tr->team_name != 'BCM-3' && $tr->team_name != 'The Helpers'): // BCM's excluded. ?>
                    <tr>
                        <td><?= $tr->bdm_name ? $tr->bdm_name.' <small>('.$tr->team_name.')</small>' : 'n/a'; ?></td>
                        <td>
                            <?php $team_target =  $this->home_model->sum_targets($tr->team_id); echo number_format($team_target->total_targets/1000000, 2).' mn';?>
                        </td>
                        <td><?= number_format($tr->received_amount/1000000, 2).' mn'; ?></td>
                        <td>
                            <?php $percentage_target = ($tr->received_amount/$team_target->total_targets*100);
                                echo round($percentage_target, 2).'%'; ?>
                        </td>
                        <td title="If %age is equal to or greater than 80, 0.3% will be given to BDM.">
                            <?php if($percentage_target >= 50){ echo number_format(0.3 * $tr->received_amount/100); }else{ echo '<small title="Not applicable on less than 50% of the team\'s target.">not applicable</small>'; } ?>
                        </td>
                    </tr>
                    <?php $total_targets_assigned += $tr->total_target;
                        $total_targets_achieved += $tr->received_amount;
                        $total_targets_teams += $team_target->total_targets; 
                        if($tr->emp_team == 11){ $total_targets_achieved_ts += $tr->received_amount; } ?>
                    <?php endif; endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container mt-5 mb-5">
    <h3 class="font-weight-light text-center">Rebate Structure</h3>
    <table class="table table-reponsive table-sm">
        <tbody>
            <tr>
                <th>Designation</th>
                <th>Criteria</th>
                <th>Rebate</th>
            </tr>
            <tr>
                <td>Business Development Managers (BDMs)</td>
                <td>Achievement of 50% Team Revenue Target</td>
                <td>0.3%</td>
            </tr>
            <tr>
                <td>Business Centre Manager (BCMs)</td>
                <td>Achievement of 50% Team Revenue Target</td>
                <td>0.3%</td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-12 text-right">
            <small>Copyright &copy; <?= date('Y'); ?>, Department of Technology, AH Group of Companies Pvt. Ltd.</small>
        </div>
    </div>
</div>
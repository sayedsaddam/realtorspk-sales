<?php if(empty($teams_report_kohat)): ?>
    <div class="container mt-5 pt-5 text-center">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <h1 class="font-weight-light">Whoopsie! <small class="font-weight-lighter">We couldn't find any result associated with the input provided.</small></h1>
                </div>
            </div>
        </div>
    </div>
<?php exit; endif; ?>
<!-- Kohat sales -->
<?php if(empty($monthly_commissions_kohat)): ?>
<div class="container">
    <div class="row mt-3 d-print-none">
        <div class="col-5 text-center">
            <form action="<?=base_url('admin/filter_by_month_kohat');?>" method="get">
                <div class="input-group">
                    <input type="month" name="month" class="form-control" required>
                    <div class="input-group-append">
                        <input type="submit" class="btn btn-primary" value="Generate Report">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-7 text-right">
            <a href="javascript:history.go(-1)" class="btn btn-primary">&laquo; Go Back</a>
            <a href="" class="btn btn-primary" onclick="javascript:window.print();">Get Print</a>
        </div>
    </div><hr>
    <div class="row no-gutters mt-3">
        <div class="col-xl-lg-12 col-md-12">
            <h3 class="font-weight-light text-center">S2S Office, Kohat | <small class="font-weight-light"><?= date('F, Y'); ?></small></h3>
            <div class="row">
                <div class="col-xl-col-lg-12 col-md-12 col-sm-12 table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Team Name</th>
                                <th>Target</th>
                                <th>Revenue</th>
                                <th>%age Achieved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($teams_report_kohat)): $serial = 1;
                                    $total_targets_assigned = 0;
                                    $total_targets_achieved = 0;
                                    $total_targets_teams = 0;
                                    foreach($teams_report_kohat as $tr): ?>
                                <tr>
                                    <td><?= $serial++; ?></td>
                                    <td><?= $tr->team_name; ?></td>
                                    <td>
                                        <?php $team_target =  $this->home_model->sum_targets($tr->team_id); echo number_format($team_target->total_targets/1000000, 2); ?>
                                    </td>
                                    <td><?= number_format($tr->received_amount/1000000, 2); ?></td>
                                    <td>
                                        <?php $percentage_target = ($tr->received_amount/$team_target->total_targets*100);
                                        echo round($percentage_target, 2).'%'; ?>
                                    </td>
                                    <!-- <td title="If %age is equal to or greater than 80, 0.3% will be given to BDM.">
                                        <?php //if($percentage_target >= 79){ echo number_format(0.3 * $tr->received_amount/100); }else{ echo '00'; } ?> -->
                                    </td>
                                </tr>
                                <?php $total_targets_assigned += $tr->total_target;
                                    $total_targets_achieved += $tr->received_amount;
                                    $total_targets_teams += $team_target->total_targets; ?>
                                <?php endforeach; endif; ?>
                            <tr>
                                <td class="font-weight-bold" colspan="2">Total</td>
                                <td class="font-weight-bold"><?php if(!empty($total_targets_teams)){ echo number_format($total_targets_teams/1000000, 2); } ?></td>
                                <td class="font-weight-bold"><?php if(!empty($total_targets_achieved)){ echo number_format($total_targets_achieved/1000000, 2); } ?></td>
                                <td class="font-weight-bold">
                                    <?php if(!empty($total_targets_achieved) && !empty($total_targets_teams)){ $percentage = ($total_targets_achieved/$total_targets_teams*100); 
                                        echo round($percentage).'%'; } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h3 class="font-weight-light text-center">Teams Rebate (BDMs) - Kohat</h3>
            <table class="table table-striped table-sm">
                <thead>
                    <th>Sr#</th>
                    <th>BDM & Team</th>
                    <th>Target</th>
                    <th>Revenue</th>
                    <th>%age</th>
                    <th>Applicable</th>
                </thead>
                <tbody>
                    <?php if(!empty($teams_report_kohat)): $serial = 1;
                    $total_targets_assigned = 0;
                    $total_targets_achieved = 0;
                    $total_targets_teams = 0;
                    foreach($teams_report_kohat as $tr): ?>
                    <tr>
                        <td><?= $serial < 10 ? '0' : ''; ?><?= $serial++; ?></td>
                        <td><?= $tr->bdm_name.' <small>('.$tr->team_name.')</small>'; ?></td>
                        <td>
                            <?php $team_target =  $this->home_model->sum_targets($tr->team_id); echo number_format($team_target->total_targets/1000000, 2).' mn'; ?>
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
                        $total_targets_teams += $team_target->total_targets; ?>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="row">
        <div class="col-12 text-center">
            <h3 class="font-weight-light">Rebate Structure</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-hover table-sm">
                <thead>
                    <th>Designation</th>
                    <th>Criteria</th>
                    <th>Rebate</th>
                </thead>
                <tbody>
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
        </div>
    </div>
</div>
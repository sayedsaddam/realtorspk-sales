<?php $session = $this->session->userdata('username'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome-all.min.css'); ?>">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <title>
        <?php if($session ){ echo 'Sales Summary > Sales Champs | Daily Sales'; } ?>
    </title>
</head>
    <body>
        <div class="container-fluid mt-2 pt-2">
            <div class="row mb-2">
                <div class="col-7">
                    <h2 class="font-weight-bold">
                        <?php if($session){ echo "Summary &raquo; Team of the Month & Sales Champs."; }else{ echo "Login"; } ?>
                    </h2>
                </div>
                <div class="col-5 text-right">
                    <?php if($session == 'daily_sales.islamabad' || $session == 'daily_sales.peshawar' || $session == 'daily_sales.hangu'): ?>
                        <a class="btn btn-primary" href="<?= base_url('home/sales_summary_psh'); ?>">Peshawar</a>
                        <a class="btn btn-info" href="<?= base_url('home/sales_summary_hangu'); ?>">Hangu</a>
                        <a class="btn btn-primary" href="<?= base_url('home/sales_summary_kohat'); ?>">Kohat</a>
                        <a class="btn btn-info" href="<?= base_url('home/daily_sales_peshawar'); ?>">Home</a>
                        <a class="btn btn-dark" href="<?= base_url('home/signout'); ?>">Sign Out</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if($session == 'daily_sales.hangu' || $session == 'daily_sales.peshawar'): ?>
        <div class="container-fluid">
            <div class="row no-gutters">
                <!-- BCM-I -->
                <div class="col-md-12">
                    <div class="card-group">
                        <div class="card">
                            <div class="card-header bg-info text-light">
                                <h5>Sales Summary - Team of the Month | <small class="font-weight-light">Amounts are displayed in Millions</small></h5>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Target</th>
                                                    <th>Revenue</th>
													<th>%age</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($teams_report)):
                                                $class = 0;
                                                $bcm1_target = 0; $bcm1_revenue = 0; // BCM-I in Psh
                                                $bcm2_target = 0; $bcm2_revenue = 0; // BCM-II in Psh
                                                $bcm3_target = 0; $bcm3_revenue = 0;
                                                $bcmh_target = 0; $bcmh_revenue = 0; // BCM in Hangu
                                                $bcmk_target = 0; $bcmk_revenue = 0; // BCM in Hangu
                                                $mgt_target = 0; $mgt_revenue = 0; // BCM in Management
                                                foreach($teams_report as $team_rep): $class++; ?>
                                                <tr class="<?php if($class == 1){ echo 'bg-success text-light'; } ?>">
                                                    <td><?= $team_rep->team_name; ?></td>
                                                    <td><?php $team_target =  $this->home_model->sum_targets($team_rep->team_id); 
                                                    if($team_target->team_lead == 'BCM-I'){ 
                                                        $bcm1_target += $team_target->total_targets; $bcm1_revenue += $team_rep->received_amount;  
                                                    }elseif($team_target->team_lead == 'BCM-II'){ 
                                                        $bcm2_target += $team_target->total_targets; $bcm2_revenue += $team_rep->received_amount;
                                                    }elseif($team_target->team_lead == 'BCM-III'){
                                                        $bcm3_target += $team_target->total_targets; $bcm3_revenue += $team_rep->received_amount;
                                                    }elseif($team_target->team_lead == 'BCMH-I'){ 
                                                        $bcmh_target += $team_target->total_targets; $bcmh_revenue += $team_rep->received_amount;
                                                    }elseif($team_target->team_lead == 'BCMK-I'){ 
                                                        $bcmk_target += $team_target->total_targets; $bcmk_revenue += $team_rep->received_amount;
                                                    }elseif($team_target->team_lead == 'Management'){ 
                                                        $mgt_target += $team_target->total_targets; $mgt_revenue += $team_rep->received_amount;
                                                    }
                                                    echo number_format($team_target->total_targets/1000000, 2); ?></td>
                                                    <td><?= number_format($team_rep->received_amount/1000000, 2); ?></td>
													<td>
														<?= number_format($team_rep->received_amount/$team_target->total_targets*100, 1).' %'; ?>
													</td>
                                                </tr>
                                                <?php endforeach; endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-danger text-light">
                                <h5>Sales Summary - Sales Champion | <small class="font-weight-light">Amounts are displayed in Millions</small></h5>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Lead Name</th>
                                                    <th>Target</th>
                                                    <th>Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $array = compact('bcm1_revenue', 'bcm2_revenue', 'bcmh_revenue', 'bcm3_revenue', 'bcmk_revenue', 'mgt_revenue');
                                                arsort($array);
                                                foreach($array as $key => $value){
                                                    if($key == 'bcm1_revenue'){
                                                        echo '<tr><td>BCM-I</td><td>'.number_format($bcm1_target/1000000, 2).'</td><td>'.number_format($value/1000000, 2).'</td></tr>';
                                                    }
                                                    if($key == 'bcm2_revenue'){
                                                        echo '<tr><td>BCM-II</td><td>'.number_format($bcm2_target/1000000, 2).'</td><td>'.number_format($value/1000000, 2).'</td></tr>';
                                                    }
                                                    if($key == 'bcm3_revenue'){
                                                        echo '<tr><td>BCM-III</td><td>'.number_format($bcm3_target/1000000, 2).'</td><td>'.number_format($value/1000000, 2).'</td></tr>';
                                                    }
                                                    if($key == 'bcmh_revenue'){
                                                        echo '<tr><td>BCMH-I</td><td>'.number_format($bcmh_target/1000000, 2).'</td><td>'.number_format($value/1000000, 2).'</td></tr>';
                                                    }
                                                    if($key == 'bcmk_revenue'){
                                                        echo '<tr><td>BCMK-I</td><td>'.number_format($bcmk_target/1000000, 2).'</td><td>'.number_format($value/1000000, 2).'</td></tr>';
                                                    }
                                                    if($key == 'mgt_revenue'){
                                                        echo '<tr><td>Management</td><td>'.number_format($mgt_target/1000000, 2).'</td><td>'.number_format($value/1000000, 2).'</td></tr>';
                                                    }
                                                } // endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php else: ?>
			<div class="container-fluid">
                <div class="row pt-5 mt-5">
                    <div class="col-md-12 text-center">
                        <div class="alert alert-danger">
                            <h1 class="display-4">Uh oh! Looks like you're not supposed to be here.</h1>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </body>
</html>

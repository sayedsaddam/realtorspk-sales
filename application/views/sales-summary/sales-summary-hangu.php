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
        <?php if($session ){ echo 'Sales Summary > Hangu | Daily Sales'; } ?>
    </title>
</head>
    <body>
        <div class="container-fluid mt-2 pt-2">
            <div class="row mb-2">
                <div class="col-7">
                    <h2 class="font-weight-bold">
                        <?php if($session){ echo "Sales Summary &raquo; Hangu"; }else{ echo "Login"; } ?>
                    </h2>
                </div>
                <div class="col-5 text-right">
                    <?php if($session == 'daily_sales.islamabad' || $session == 'daily_sales.peshawar' || $session == 'daily_sales.hangu' || $session == 'daily_sales.kohat'): ?>
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
                                <h5>Sales Summary - Hangu</h5>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($daily_sales_hangu)): $class = 0; foreach($daily_sales_hangu as $ds_hangu): $class++; ?>
                                                <tr class="<?php if($class == 1){ echo 'table-success'; } ?>">
                                                    <td><?= $ds_hangu->emp_name; ?></td>
                                                    <td><?= number_format($ds_hangu->revenue_target/1000000, 1).' mn'; ?></td>
                                                    <td><?= number_format($ds_hangu->amount_received/1000000, 2).' mn'; ?></td>
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
                                <h5>Sales Summary - Teams</h5>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Team Name</th>
                                                    <th>Target</th>
                                                    <th>Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($teams_report)): $class = 0; foreach($teams_report as $team_rep): $class++; ?>
                                                <tr class="<?php if($class == 1){ echo 'table-success'; } ?>">
                                                    <td><?= $team_rep->team_name; ?></td>
                                                    <td><?php $team_target =  $this->home_model->sum_targets($team_rep->team_id); echo number_format($team_target->total_targets/1000000, 1); ?></td>
                                                    <td><?= number_format($team_rep->received_amount/1000000, 2).' mn'; ?></td>
                                                </tr>
                                                <?php endforeach; endif; ?>
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

<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Sales Stats |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
    <?php elseif($failed = $this->session->flashdata('failed')): ?>
        <div class="alert alert-danger"><?= $failed; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xl-lg-8 col-md-8 col-sm-12">
            <h2 class="font-weight-bold">
                <?php if(empty($results)): ?>
                    Daily Stats for the month of <strong class="text-secondary"><?= date('F, Y'); ?></strong>
                <?php elseif(!empty($results)): ?>
                    Search Results
                <?php endif; ?>
            </h2>
        </div>
        <div class="col-xl-lg-4 col-md-4 col-sm-12">
            <small></small>
            <form action="<?= base_url('admin/search_by_date'); ?>" method="get">
                <div class="form-row">
                    <div class="col">
                        <input name="search" type="date" class="form-control" title="Filter all sales on a date...">
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-outline-secondary" value="Filter by Date">
                    </div>
                </div>
            </form>
        </div>
    </div><hr>
    <div class="row mb-3">
        <div class="col-xl-lg-2 col-md-2">
            <h5 class="text-info" title="Search between dates, by region, or by project ...">Monthly Sales Report</h5>
        </div>
        <div class="col-xl-lg-10 col-md-10">
            <form action="<?= base_url('admin/archives'); ?>" method="get" class="form-inline">
                <div class="form-group mx-2">
                    <!-- <input type="month" name="archive_month" class="form-control" required> -->
                    <input type="date" name="date_from" id="" class="form-control">
                </div>
                <div class="form-group mx-2">
                    <input type="date" name="date_to" id="" class="form-control">
                </div>
                <div class="form-group mx-2">
                    <select name="archive_city" class="form-control" required>
                        <option value="" disabled selected>--select city--</option>
                        <?php if(!empty($locations)): foreach($locations as $loc): ?>
									<option value="<?= $loc->name; ?>"><?= $loc->name; ?></option>
								<?php endforeach; endif; ?>
                    </select>
                </div>
                <!-- <div class="form-group mx-2">
                    <select name="project" class="form-control">
                        <option value="" disabled selected>--select project--</option>
                        <option value="091 Mall">091 Mall</option>
                        <option value="Florenza">Florenza</option>
                        <option value="MoH">Mall of Hangu</option>
                        <option value="North Hills">North Hills</option>
                    </select>
                </div> -->
                <div class="form-group mx-2">
                    <input type="submit" class="btn btn-outline-secondary" value="Go &raquo;">
                    <input type="reset" class="btn btn-outline-danger mx-2" value="Clear">
                </div>
            </form>
        </div>
    </div>
    <?php if(empty($results)): ?>
    <div class="row">
        <div class="col-xl-lg-4 col-md-4 col-sm-12">
            <small>
            <?php if(!empty($daily_sales_kohat)){ $last_udpated = ''; if($daily_sales_kohat == TRUE){ $last_udpated = $this->admin_model->last_updated_by($daily_sales_kohat[0]->emp_city);
                echo 'Last updated at '.date('M d, Y - H:i:s', strtotime($last_udpated->created_at)).' by <strong>'.$last_udpated->fullname.'</strong>'; } }
            ?>
            </small>
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3>Sales Stats - Kohat</h3>
                </div>
                <div class="card-body table-reponsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>Sr #</th>
                                <th>Agent</th>
                                <th>Target</th>
                                <th>Achieved</th>
                                <!-- <th>Rebate</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($daily_sales_kohat)): $serial = 1; $isbd_total = 0; $isbd_targets = 0;
                            foreach($daily_sales_kohat as $sale): ?>
                            <?php $isbd_total += ((int)$sale->amount_received);
                                    $isbd_targets += ((int)$sale->revenue_target); ?>
                                <tr class="">
                                    <td><?= $serial++; ?></td>
                                    <td><a href="<?= base_url('admin/sale_detail/'.$sale->emp_id); ?>"><?= $sale->emp_name; ?></a></td>
                                    <td><?= number_format($sale->revenue_target); ?></td>
                                    <td><?= number_format($sale->amount_received); ?></td>
                                    <!-- <td><?= number_format(($sale->amount_received * $sale->rebate) / 100); ?></td> -->
                                </tr>
                            <?php endforeach; ?>
                                <tr class="table-success">
                                    <td class="font-weight-bold">Total</td>
                                    <td colspan="2" class="font-weight-bold" align="center"><?= number_format($isbd_targets); ?></td>
                                    <td class="font-weight-bold"><?= number_format($isbd_total); ?></td>                                
                                </tr>
                            <?php else: ?>
                                <tr class="table-danger">
                                    <td colspan="5" align="center">
                                        No record found!
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-lg-4 col-md-4 col-sm-12">
            <small>
            <?php if(!empty($daily_sales_peshawar)){ $last_udpated = ''; if($daily_sales_peshawar == TRUE){ $last_udpated = $this->admin_model->last_updated_by($daily_sales_peshawar[0]->emp_city);
                echo 'Last updated at '.date('M d, Y - H:i:s', strtotime($last_udpated->created_at)).' by <strong>'.$last_udpated->fullname.'</strong>'; } }
            ?>
            </small>
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3>Sales Stats - Realtors PK</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm" id="sales_peshawar">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>Sr #</th>
                                <th>Agent</th>
                                <th>Target</th>
                                <th>Achieved</th>
                                <!-- <th>Rebate</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <input type="search" class="form-control mb-2" id="sales_peshawar_search" placeholder="Search for agent in Realtors PK ...">
                            <?php if(!empty($daily_sales_peshawar)): $serial = 1; $psh_total = 0; $psh_targets = 0;
                            foreach($daily_sales_peshawar as $sale): ?>
                            <?php $psh_total += ((int)$sale->amount_received);
                                    $psh_targets += ((int)$sale->revenue_target); ?>
                                <tr class="">
                                    <td><?= $serial++; ?></td>
                                    <td><a href="<?= base_url('admin/sale_detail/'.$sale->emp_id); ?>"><?= $sale->emp_name; ?></a></td>
                                    <td><?= number_format($sale->revenue_target); ?></td>
                                    <td><?= number_format($sale->amount_received); ?></td>
                                    <!-- <td><?= number_format(($sale->amount_received * $sale->rebate) / 100); ?></td> -->
                                </tr>
                            <?php endforeach;?>
                                <tr class="table-success">
                                    <td class="font-weight-bold">Total</td>
                                    <td colspan="2" class="font-weight-bold" align="center"><?= number_format($psh_targets) ?></td>
                                    <td class="font-weight-bold"><?= number_format($psh_total); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr class="table-danger">
                                    <td colspan="5" align="center">
                                        No record found!
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-lg-4 col-md-4 col-sm-12">
            <small>
            <?php if(!empty($daily_sales_hangu)){ $last_udpated = ''; if($daily_sales_hangu){ $last_udpated = $this->admin_model->last_updated_by($daily_sales_hangu[0]->emp_city); 
                echo 'Last updated at '.date('M d, Y - H:i:s', strtotime($last_udpated->created_at)).' by <strong>'.$last_udpated->fullname.'</strong>'; } }
            ?>
            </small>
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3>Sales Stats - Hangu</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>Sr #</th>
                                <th>Agent</th>
                                <th>Target</th>
                                <th>Achieved</th>
                                <!-- <th>Rebate</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($daily_sales_hangu)): $serial = 1; $hangu_total = 0; $hangu_targets = 0;
                            foreach($daily_sales_hangu as $sale): ?>
                            <?php $hangu_total += ((int)$sale->amount_received);
                                    $hangu_targets += ((int)$sale->revenue_target); ?>
                                <tr class="">
                                    <td><?= $serial++; ?></td>
                                    <td><a href="<?= base_url('admin/sale_detail/'.$sale->emp_id); ?>"><?= $sale->emp_name; ?></a></td>
                                    <td><?= number_format($sale->revenue_target); ?></td>
                                    <td><?= number_format($sale->amount_received); ?></td>
                                    <!-- <td><?= number_format(($sale->amount_received * $sale->rebate) / 100); ?></td> -->
                                </tr>
                            <?php endforeach;?>
                                <tr class="table-success">
                                    <td class="font-weight-bold">Total</td>
                                    <td colspan="2" class="font-weight-bold" align="center"><?= number_format($hangu_targets); ?></td>
                                    <td class="font-weight-bold"><?= number_format($hangu_total); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr class="table-danger">
                                    <td colspan="5" align="center">
                                        No record found!
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php elseif(!empty($results)): ?>
        <div class="row">
            <div class="col-xl-lg-12 col-md-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Added By</th>
                            <th>Employee Code</th>
                            <th>Employee Name</th>
                            <th>Project</th>
                            <th>Office</th>
                            <th>Location</th>
                            <th>Amount Recieved</th>
                            <th>Date Received</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serial = 1; $total_today = 0; foreach($results as $res): ?>
                        <?php $total_today += ((int)$res->rec_amount); ?>
                            <tr>
                                <td><?= $serial++; ?></td>
                                <td><?= $res->fullname; ?></td>
                                <td><?= $res->emp_code; ?></td>
                                <td><?= $res->emp_name; ?></td>
                                <td class="<?php if($res->project == 'Florenza'){ echo 'bg-primary text-light'; } ?>"><?= $res->project; ?></td>
                                <td><?= $res->office; ?></td>
                                <td><?= $res->emp_city; ?></td>
                                <td><?php if(!empty($res->rec_amount)){ echo number_format($res->rec_amount); }else{ echo '--'; } ?></td>
                                <td><?php if($res->rec_date == ''){ echo '<span class="badge badge-danger badge-pill">Not Available</span>'; }else{ echo date('M d, Y', strtotime($res->rec_date)); } ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#edit_sale<?= $res->id; ?>" href="" class="btn btn-primary btn-sm" title="In case you missed the Receiving date, here's a link to edit it.">Edit</a>
                                    <?php if($this->session->userdata('username') == 'ammad.naseem'): ?>
                                        <!-- Modal starts -->
                                        <div class="modal fade" id="edit_sale<?= $res->id; ?>" tabindex="-1" role="dialog" aria-labelledby="edit_saleTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Daily Sale Record</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <form action="<?= base_url('admin/update_daily_sale'); ?>" method="post">
                                                                    <input type="hidden" name="daily_sale_id" value="<?= $res->id; ?>">
                                                                    <div class="form-group">
                                                                        <label for="agent_name">Agent Name</label>
                                                                        <input type="text" name="agent_name" class="form-control" value="<?= $res->emp_name; ?>" readonly>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="rec-date">Receving Date</label>
                                                                        <input type="date" name="rec_date" class="form-control" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="amount">Amount</label>
                                                                        <input type="text" name="amount_received" class="form-control" value="<?= $res->rec_amount; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="reason">Edit Reason</label>
                                                                        <textarea name="edit_reason" class="form-control" rows="5" placeholder="Do you have a minute to write a few words about why are you editing this?" required></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="text-info"> Note</span>
                                                                <p class="font-weight-lighter">In case you missed the receiving date while entering the daily sales record. Here you can fix it alongwith providing a valid reason for editing that specific entry.</p>
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
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-success">
                            <td class="font-weight-bold" colspan="7">Today's Total</td>
                            <td class="font-weight-bold" colspan="3"><?= number_format($total_today); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<script>
    $(document).ready(function(){
   // peshawar sales search
        $("#sales_peshawar_search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#sales_peshawar tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    })
</script>

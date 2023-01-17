<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Sales Report |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block mb-2">Dashboard</a>
                <a href="<?= base_url('admin/commissions'); ?>" class="btn btn-outline-light">Peshawar</a>
                <a href="<?= base_url('admin/commissions_hangu') ?>" class="btn btn-outline-light">Hangu</a>
                <a href="<?= base_url('admin/commissions_kohat'); ?>" class="btn btn-outline-light">Kohat</a>
                <a href="<?= base_url('reporting_panel/region_summary') ?>" class="btn btn-outline-light">Summary</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-print-none">
        <div class="col-12">
            <form action="<?= base_url('admin/generate_sales_report'); ?>" method="get">
                <div class="row">
                    <div class="col-3">
                       <div class="form-group">
                            <label for="month">Month</label>
                            <input type="month" name="month" class="form-control">
                        </div> 
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="date_from">Date From</label>
                            <input type="date" name="date_from" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="date_to">Date To</label>
                            <input type="date" name="date_to" class="form-control">  
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="team">Team</label>
                            <select name="team" class="form-control">
                                <option value="" selected disabled>--team--</option>
                                <?php if(!empty($teams)): foreach($teams as $team): ?>
                                    <option value="<?= $team->team_id; ?>"><?= $team->team_name.' - '.$team->team_lead; ?></option>
                                <?php endforeach; endif; ?>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                        <label for="city">City</label>
                            <select name="city" id="city" class="form-control">
                                <option value="" selected disabled>--select city--</option>
                                <?php if(!empty($locations)): foreach($locations as $loc): ?>
									<option value="<?= $loc->name; ?>"><?= $loc->name; ?></option>
								<?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                        <label for="agent">Agent</label>
                            <select name="agent" id="agents" class="form-control">
                                <option value="" selected disabled>--select agent--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" class="form-control">
                                <option value="" selected disabled>--project--</option>
                                <option value="091 Mall">091 Mall</option>
                                <option value="MoH">Mall of Hangu</option>
                                <option value="Florenza">Florenza</option>
                                <option value="North Hills">North Hills</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary mr-2">Search</button>
                            <button type="reset" class="btn btn-outline-danger">Clear Filters</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 table-responsive">
            <?php if(!empty($results) && isset($_GET['agent'])): ?>
                <p class="text-center">Sales Report for agent having employee code <strong><?php echo $_GET['agent']; ?></strong>
                for dates <strong><?= date('M d, Y', strtotime($_GET['date_from'])).' - '.date('M d, Y', strtotime($_GET['date_to'])); ?></strong></p>
            <?php endif; ?>
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th class="font-weight-bold">Sr #</th>
                        <th class="font-weight-bold">Agent</th>
                        <th class="font-weight-bold">091 Mall</th>
                        <th class="font-weight-bold">Florenza</th>
                        <th class="font-weight-bold">MoH</th>
                        <th class="font-weight-bold">North Hills</th>
                        <th class="font-weight-bold">Team</th>
                        <th class="font-weight-bold">Rebate %</th>
                        <th class="font-weight-bold">Rebate Amt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($results)): $serial = 1; 
                    $total = 0;
                    $zn_total = 0;
                    $florenza_total = 0;
                    $moh_total = 0;
                    $nh_total = 0;
                    foreach($results as $res): ?>
                        <tr>
                            <td><?= $serial++; ?></td>
                            <td><?= $res->emp_name; ?></td>
                            <td>
                                <?= number_format((int)$res->zero_nine_one_mall); ?>
                            </td>
                            <td>
                                <?= number_format((int)$res->florenza); ?>
                            </td>
                            <td>
                                <?= number_format((int)$res->moh); ?>
                            </td>
                            <td>
                                <?= number_format((int)$res->northHills); ?>
                            </td>
                            <td><?= $res->team_name; ?></td>
                            <td><?= $res->rebate.'%'; ?></td>
                            <td><?php if($res->florenza > 0){ echo number_format((int)$res->florenza * $res->rebate/100); }elseif($res->zero_nine_one_mall > 0){ echo number_format((int)$res->zero_nine_one_mall * $res->rebate/100); }elseif($res->moh > 0){ echo number_format((int)$res->moh * $res->rebate/100); }elseif($res->northHills > 0){ echo number_format((int)$res->northHills * $res->rebate/100); } ?></td>
                        </tr>
                        <?php   $total += $res->total_amount_received;
                                $zn_total += $res->zero_nine_one_mall;
                                $florenza_total += $res->florenza;
                                $moh_total += $res->moh;
                                $nh_total += $res->northHills ?>
                    <?php endforeach; ?>
                    <tr class="table-success">
                        <td class="font-weight-bold" colspan="2">Total</td>
                        <td class="font-weight-bold"><?= number_format($zn_total); ?></td>
                        <td class="font-weight-bold"><?= number_format($florenza_total); ?></td>
                        <td class="font-weight-bold"><?= number_format($moh_total); ?></td>
                        <td class="font-weight-bold" colspan="3"><?= number_format($nh_total); ?></td>
                        <td></td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td colspan="8" align="center"><button class="btn btn-primary d-print-none" onclick="javascript:window.print();">Print Report</button></td>
                    </tr>
                    <?php else: echo '<tr class="table-danger"><td colspan="9" align="center">Either record was not found, or you have not searched for anything yet.</td></tr>'; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
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
                    $('#agents').html('');
                    $('#agents').append('<option value="" selected disabled>--select agent--</option>');
                    $.each(data, function(index, item){
                        $('#agents').append(`<option value="${item.emp_code}">${item.emp_name}</option>`);
                    });
                }
            }
        });
    });
});
</script>

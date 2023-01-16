<style>
    .indicator{
        font-size: 20px;
        font-weight: bold;
    }
</style>
<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Rebate Calculations |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
<div class="container">
    <div class="row mb-0 d-print-none">
        <div class="col-xl-lg-5 col-md-5 col-sm-12 mb-1 pb-4">
            <h3>
                <?php if(empty($results)): ?>
                    Rebate calculations &raquo;
                    <small class="indicator text-secondary">Hng</small>
                    <small class="indicator text-success">Psh</small>
                    <small class="indicator text-primary">Kht</small>
                    <small class="indicator text-info">Isd</small>
                <?php elseif(!empty($results)): ?>
                    Commissions Report, <?= ucfirst($_GET['region']); ?>
                <?php endif; ?>
            </h3>
        </div>
        <div class="col-xl-lg-7 col-md-7 col-sm-12 mt-1">
            <form action="<?= base_url('admin/filter_rebates_monthly'); ?>" method="get">
                <div class="row">
                    <div class="col-3">
                        <input name="date_from" type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-3">
                        <input name="date_to" type="date" class="form-control form-control-sm">
                    </div>
                    <div class="col-3">
                        <select name="region" class="browser-default custom-select form-control-sm">
                            <option value="" selected disabled>--Region--</option>
                            <?php if(!empty($locations)): foreach($locations as $loc): ?>
									<option value="<?= strtolower($loc->name); ?>"><?= $loc->name; ?></option>
							<?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="submit" class="btn btn-outline-secondary btn-sm" value="Search">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 table-responsive">
            <h4 class="d-none d-print-block mb-4">
                <?php if(!empty($results)){
                    if($_GET['region'] == 'peshawar'){
                        echo 'Rebate &raquo; S2S Office, JB Towers '.ucfirst($_GET['region'].' for the month of '. date('F Y', strtotime($_GET['date_from'])));
                    }elseif($_GET['region'] == 'hangu'){
                        echo 'Rebate &raquo; S2S Office, '.ucfirst($_GET['region'].' for the month of '. date('F Y', strtotime($_GET['date_from'])));
                    }elseif($_GET['region'] == 'kohat'){
                        echo 'Rebate &raquo; S2S Office, '.ucfirst($_GET['region'].' for the month of '. date('F Y', strtotime($_GET['date_from'])));
                    }
                } ?>
            </h4>
            <table class="table table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Sr#</th>
                        <th>Employee Name</th>
                        <th>Team</th>
                        <th>Rec Amt</th>
                        <?php if(empty($results)): ?>
                            <th>Rec Date</th>
                        <?php endif; ?>
                        <th>Rebate %</th>
                        <th>Rebate Amt</th>
                    </tr>
                </thead>
                <?php if(empty($results)): ?>
                    <tbody>
                        <?php if(!empty($rebates)): $serial = $this->uri->segment(3) + 1; foreach($rebates as $rebate): ?>
                            <tr class="<?php if($rebate->emp_city == 'Peshawar'){ echo 'bg-success'; }elseif($rebate->emp_city == 'Hangu'){ echo 'bg-secondary'; }elseif($rebate->emp_city == 'Kohat'){ echo 'bg-primary'; }elseif($rebate->emp_city == 'Islamabad'){ echo 'bg-info'; } ?> text-light">
                                <td><?= $serial < 10 ? '0' : ''; ?><?= $serial++; ?></td>
                                <td><a class="badge badge-light rebate_info text-dark" data-id="<?= $rebate->emp_code; ?>"><?= $rebate->emp_name; ?></a></td>
                                <td><?= $rebate->team_name; ?></td>
                                <td><?= number_format($rebate->total_amount); ?></td>
                                <td><?= date('M d, Y', strtotime($rebate->rec_date)); ?></td>
                                <td><?php if(!empty($rebate->rebate_percentage)){ echo $rebate->rebate_percentage.'%'; }else{ echo '0'; } //$rebate->rebate_percentage; ?></td>
                                <td><?= number_format($rebate->amount_received);  ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                <?php else: ?>
                    <tbody>
                        <?php if(!empty($results)): 
                            $total_rec_amount = 0;
                            $total_rebate = 0;
                            $serial = 1;
                            foreach($results as $res): 
                                $rebate = $res->total_amount; // get the received amount & assign it to a variable. ?>
                            <tr>
                                <td><?= $serial < 10 ? '0' : ''; ?><?= $serial++; ?></td>
                                <td><?= $res->emp_name; ?></td>
                                <td><?= $res->team_name; ?></td>
                                <td><?= number_format($res->total_amount); ?></td>
                                <td>
                                    <?php if($rebate >= 1 AND $rebate <= 3000000) echo '1.5%';
                                        elseif($rebate >= 3000001 AND $rebate <= 9999999) echo '2.5%';
                                        elseif($rebate >= 10000000) echo '4%';
                                        // elseif($rebate >= 5000001 AND $rebate <= 7500000) echo '3%';
                                        // elseif($rebate >= 7500001 AND $rebate <= 10000000) echo '3.5%';
                                        // elseif($rebate >= 10000001 AND $rebate <= 15000000) echo '4%';
                                        // elseif($rebate >= 15000001 AND $rebate <= 20000000) echo '4.5%';
                                        // elseif($rebate > 20000000) echo '5%';
                                        else echo '0';
                                    ?>
                                </td>
                                <td class="rebate_amount">
                                    <?php 
                                    $all_rebate = array();
                                    if($rebate >= 1 AND $rebate <= 3000000) echo number_format($res->total_amount*1.5/100);
                                    elseif($rebate >= 3000001 AND $rebate <= 9999999) echo number_format($res->total_amount*2.5/100);
                                    // elseif($rebate >= 3000001 AND $rebate <= 5000000) echo number_format($res->total_amount*2.75/100);
                                    // elseif($rebate >= 5000001 AND $rebate <= 7500000) echo number_format($res->total_amount*3/100);
                                    // elseif($rebate >= 7500001 AND $rebate <= 10000000) echo number_format($res->total_amount*3.5/100);
                                    // elseif($rebate >= 10000001 AND $rebate <= 15000000) echo number_format($res->total_amount*4/100);
                                    // elseif($rebate >= 15000001 AND $rebate <= 20000000)echo number_format($res->total_amount*4.5/100);
                                    elseif($rebate >= 10000000) echo $rb8 = number_format($res->total_amount*4/100);
                                    else echo '0';
                                    ?>
                                    <?php // number_format($res->total_amount * $res->rebate/100);  ?>
                                </td>
                                <?php $total_rec_amount += $res->total_amount; //$total_rebate += $res->total_amount * $res->rebate/100; ?>
                            </tr>
                        <?php endforeach; endif; ?>
                        <tr class="table-success font-weight-bold">
                            <td colspan="3">Total</td>
                            <td colspan="2"><?= number_format($total_rec_amount); ?></td>
                            <td class="final_rebate"><?php //echo number_format($total_rebate); ?></td>
                        </tr>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12">
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
<div class="modal fade" id="agent_sales" tabindex="-1" role="dialog" aria-labelledby="team_infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 class="font-weight-light text-info">Sales and rebate / commission detail.</h4>
                </div>
            </div>
            <div class="list table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Project</th>
                            <th>Rec Amount</th>
                            <th>Rebate %</th>
                            <th>Commission</th>
                        </tr>
                    </thead>
                    <tbody class="rebate_list">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $('.rebate_info').click(function(){  
    var agent_id = $(this).data('id');
    // alert(agent_id);
    // AJAX request
    $.ajax({
    url: '<?= base_url('admin/agent_rebate/'); ?>' + agent_id,
    method: 'POST',
    dataType: 'JSON',
    data: {agent_id: agent_id},
      success: function(response){ 
        console.log(response);
        $('.rebate_list').html('');
        var total_sales = 0;
        var total_rebate = 0;
        $.each(response, function(index, res){
            total_sales += Number(res.rec_amount);
            total_rebate += Number(res.rebate*res.rec_amount/100);
            $('.modal-title').html('Employee ID &raquo; ' + res.agent_id);
            $('.rebate_list').append(`<tr><td>${res.rec_date}</td><td>${res.project}</td><td>${Number(res.rec_amount).toLocaleString()}</td><td>${Number(res.rebate).toLocaleString()}</td><td>${Number(res.rebate*res.rec_amount/100).toLocaleString()}</td></tr>`);
        });
        $('.rebate_list').append(`<tr><td colspan="2">Total</td><td colspan="2">${Number(total_sales).toLocaleString()}</td><td>${Number(total_rebate).toLocaleString()}</td></tr>`);
        $('#agent_sales').modal('show');
      }
    });
  });
});
</script>
<script>
    $(document).ready(function(){
        var sum = 0;
        $('.rebate_amount').each(function(){
            sum += parseInt($(this).text().replace(/,/g, ''));
        });
        console.log(sum);
        $('.final_rebate').html(Number(sum).toLocaleString());
    });
</script>

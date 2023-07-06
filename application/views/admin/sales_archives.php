<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
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
<div class="container">
    <div class="row mb-4">
        <div class="col-xl-lg-10 col-md-10 col-sm-10 col-print-12">
            <h4 class="font-weight-bold">Sales Report of <span class="text-secondary text-success px-2 py-2 rounded"><?= $_GET['archive_city']; ?></span> from <span class="text-secondary text-success px-2 py-2 rounded"> <?= date('F d, Y', strtotime($_GET['date_from'])).' <span class="text-dark">to</span> '.date('F d, Y', strtotime($_GET['date_to'])); ?></span></h4>
        </div>
        <div class="col-xl-lg-2 col-md-2 col-sm-2 d-print-none">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search...">
        </div>
    </div>
    <?php if(!empty($archives)): ?>
        <div class="row">
            <div class="col-xl-lg-12 col-md-12 table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>S#</th>
                            <th>Team</th>
                            <th>Name</th>
                            <th>091</th>
                            <th>FL</th>
                            <th>MoH</th>
                            <th>NH</th>
							<th>AHT</th>
							<th>AHC</th>
							<th>AHR</th>
                            <th title="In all projects">Total</th>
                        </tr>
                    </thead>
                    <tbody id="archives">
                        <?php   $serial = 1; 
                                $total = 0;
                                $zero_nine = 0;
                                $florenza = 0;
                                $moh = 0;
                                $nh = 0;
								$aht = 0;
								$ahc = 0;
								$ahr = 0;
                                foreach($archives as $res): ?>
                        <?php $total += ((int)$res->total_amount_received);
                                $zero_nine += $res->zero_nine_one_mall;
                                $florenza += $res->florenza;
                                $moh += $res->moh;
                                $nh += $res->northHills;
								$aht += $res->ah_tower;
								$ahc += $res->ah_city;
								$ahr += $res->ah_res; ?>
                            <tr>
                                <td><?= $serial++; ?></td>
                                <td><?= $res->team_name ? $res->team_name : '-/-'; ?></td>
                                <td><?= $res->emp_name; ?></td>
                                <td><?= number_format($res->zero_nine_one_mall); ?></td>
                                <td><?= number_format($res->florenza); ?></td>
                                <td><?= number_format($res->moh); ?></td>
                                <td><?= number_format($res->northHills); ?></td>
								<td><?= number_format($res->ah_tower); ?></td>
								<td><?= number_format($res->ah_city); ?></td>
								<td><?= number_format($res->ah_res); ?></td>
                                <td><?php if(!empty($res->total_amount_received)){ echo number_format($res->total_amount_received); }else{ echo '--'; } ?></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr class="table-info">
                                <td class="font-weight-bold" colspan="3">Total</td>
                                <td class="font-weight-bold"><?= number_format($zero_nine); ?></td>
                                <td class="font-weight-bold"><?= number_format($florenza); ?></td>
                                <td class="font-weight-bold"><?= number_format($moh); ?></td>
                                <th class="font-weight-bold"><?= number_format($nh); ?></th>
								<th class="font-weight-bold"><?= number_format($aht); ?></th>
								<th class="font-weight-bold"><?= number_format($ahc); ?></th>
								<th class="font-weight-bold"><?= number_format($ahr); ?></th>
                                <td class="font-weight-bold"><?= number_format($total); ?></td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="row mt-4">
            <div class="col-xl-lg-12 col-md-12 text-center">
                <div class="alert alert-danger">
                    <h3 class="font-weight-lighter"><span class="display-2">Oops!</span> No record was found for your search.</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#archives tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

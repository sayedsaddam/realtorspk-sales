<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-10">
               <h1 class="font-weight-bold">Agents Stats - Green, Yellow, or Red Zone</h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p> 
            </div>
            <div class="col-md-2">
               <?php if($this->session->userdata('username') == 'admin-ah'): ?>
                  <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-block btn-lg">Dashboard</a>
               <?php endif; ?>
               <a href="javascript:history.go(-1)" class="btn btn-light btn-block btn-lg">&laquo; Back</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         <div class="row">
            <div class="col-md-7">
               <h2>Agent Stats, <?= $this->uri->segment(3); ?> - <span class="font-weight-bold text-danger"><?= date('M, Y'); ?></span>.</h2>
            </div>
            <div class="col-md-5 text-right d-print-none">
           
               <button onclick="window.print();" class="btn btn-outline-secondary">Print</button>
            </div>
         </div>
         <div class="card-group">
            <div class="card">
               <div class="card-header bg-success text-white"><h4 class="card-title">Green Zone, 75% or higher.</h4></div>
               <div class="card-body">
                  <table class="table table-sm" id="greenZone">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>TGT</th>
                           <th>Rev</th>
                        </tr>
                     </thead>
                     <tbody>
                        <input type="search" class="form-control mb-2" id="searchGreenZone" placeholder="Search for agent in the green zone...">
                        <?php if(!empty($sales)): foreach($sales as $sale): if($sale->target > 0 && $sale->revenue/$sale->target*100 >= 75): ?>
                           <tr title="<?= $sale->emp_code; ?>">
                              <td><?= $sale->emp_name; ?></td>
                              <td><?= number_format($sale->target/1000000, 2); ?></td>
                              <td><?= number_format($sale->revenue/1000000, 3); ?></td>
                              <tr class="d-print-none">
                                 <td colspan="3">
                                    <div class="progress">
                                       <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="100" style="width: <?= number_format($sale->revenue/$sale->target*100, 2) ?>%;"><?= number_format($sale->revenue/$sale->target*100, 2); ?>%</div>
                                    </div>
                                 </td>
                              </tr>
                           </tr>
                        <?php endif; endforeach; endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="card">
               <div class="card-header bg-warning"><h4 class="card-title">Yellow Zone, 25% to 75%.</h4></div>
               <div class="card-body">
                  <table class="table table-sm" id="yellowZone">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>Target</th>
                           <th>Revenue</th>
                        </tr>
                     </thead>
                     <tbody>
                     <input type="search" id="searchYellowZone" class="form-control mb-2" placeholder="Search for agent in Yellow zone...">
                     <?php if(!empty($sales)): foreach($sales as $sale): if($sale->target > 0 && $sale->revenue/$sale->target*100 > 25 && $sale->revenue/$sale->target*100 < 75): ?>
                        <tr title="<?= $sale->emp_code; ?>">
                           <td><?= $sale->emp_name; ?></td>
                           <td><?= number_format($sale->target/1000000, 2); ?></td>
                           <td><?= number_format($sale->revenue/1000000, 3); ?></td>
                           <tr class="d-print-none">
                              <td colspan="3">
                                 <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="" aria-valuemax="100" style="width: <?= number_format($sale->revenue/$sale->target*100, 2) ?>%;"><?= number_format($sale->revenue/$sale->target*100, 2); ?>%</div>
                                 </div>
                              </td>
                           </tr>
                        </tr>
                     <?php endif; endforeach; endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="card">
               <div class="card-header bg-danger text-white"><h4 class="card-title">Red Zone, below 25%.</h4></div>
               <div class="card-body">
                  <table class="table table-sm" id="redZone">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>Target</th>
                           <th>Revenue</th>
                        </tr>
                     </thead>
                     <tbody>
                        <input type="search" id="searchRedZone" class="form-control mb-2" placeholder="Search for agent in Red zone...">
                        <?php if(!empty($sales)): foreach($sales as $sale): if($sale->target > 0 && $sale->revenue/$sale->target*100 < 25): ?>
                           <tr title="<?= $sale->emp_code; ?>">
                              <td><?= $sale->emp_name; ?></td>
                              <td><?= number_format($sale->target/1000000, 2); ?></td>
                              <td><?= number_format($sale->revenue/1000000, 3); ?></td>
                              <tr class="d-print-none">
                                 <td colspan="3">
                                    <div class="progress">
                                       <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="100" style="width: <?= number_format($sale->revenue/$sale->target*100, 2) ?>%;"><?= number_format($sale->revenue/$sale->target*100, 2); ?>%</div>
                                    </div>
                                 </td>
                              </tr>
                           </tr>
                        <?php endif; endforeach; endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
$(document).ready(function(){
   // Green zone search
   $("#searchGreenZone").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#greenZone tr").filter(function() {
         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
   });
  // Yellow zone search
  $("#searchYellowZone").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#yellowZone tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  // Red zone search
  $("#searchRedZone").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#redZone tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
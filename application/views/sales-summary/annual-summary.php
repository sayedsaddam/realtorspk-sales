<div class="container mt-5 mb-5">
   <div class="row">
      <div class="col-md-12 text-center">
         <h3 class="text-uppercase mb-0">annual summary, <?= date('Y') ?>.</h3>
         <p class="font-weight-bold">Realtors PK, Peshawar.</p>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <div class="row mb-2">
                  <div class="col-md-6">
                     <h4 class="">Realtors PK, Peshawar</h4>
                  </div>
                  <div class="col-md-6 col-sm-12 text-right">
                     <button type="button" class="btn btn-outline-danger rounded-0 d-print-none" onclick="javascript:history.go(-1);">Go Back</button>
                     <!-- <a href="<?= base_url('reporting_panel/annual_summary/Kohat') ?>" class="btn btn-outline-danger rounded-0 d-print-none">Kohat</a> -->
                     <button type="button" class="btn btn-outline-secondary rounded-0 d-print-none" onclick="window.print();">Print</button>
                  </div>
               </div>
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="table-responsive">
                        <table class="table table-bordered">
                           <tbody>
                              <tr>
                                 <th>Month</th>
                                 <th>No. of Agents</th>
                                 <th>Total Target</th>
                              </tr>
                              <?php if(!empty($merged_targets_sales)): foreach($merged_targets_sales as $key => $target): ?>
                              <tr>
                                 <th><?= $target->target_month; ?></th>
                                 <td><?= $total_employees[$key] = $target->total_employees; ?></td>
                                 <td><?= number_format($target->total_revenue_target/1000000, 2).'M';  ?></td>
                              </tr>
                              <?php endforeach; endif; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="table-responsive">
                        <table class="table table-bordered">
                           <tbody>
                              <tr>
                                 <th>Month</th>
                                 <th>Achieved</th>
                                 <th>%age</th>
                                 <th>Average</th>
                              </tr>
                              <?php if(!empty($merged_targets_sales)): foreach($merged_targets_sales as $key => $sale): ?>
                              <tr>
                                 <th><?= date('F, Y', strtotime($sale->rec_date)); ?></th>
                                 <td><?= number_format($sale->total_amount/1000000, 2).'M'; ?></td>
                                 <td><?= $sale->total_amount > 0 ? round($sale->total_amount/$sale->total_revenue_target*100, 2) . '%' : '0'; ?></td>
                                 <td><?= number_format($sale->total_amount/$sale->total_employees); ?></td>
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

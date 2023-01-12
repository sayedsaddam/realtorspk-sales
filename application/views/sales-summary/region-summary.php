<?php
   // Target assigned to Peshawar and revenue generated against it.
   $target_psh = 0; // declare a var with 0 value.
   $revenue_psh = 0; // declare a var with 0 value.
   foreach($daily_sales_psh as $psh){
      $target_psh += $psh->revenue_target;
      $revenue_psh += $psh->amount_received;
   }
   // Target assigned to Hangu and revenue generated against it.
   $target_hangu = 0; // declare a var with 0 value.
   $revenue_hangu = 0; // declare a var with 0 value.
   foreach($daily_sales_hangu as $hangu){
      $target_hangu += $hangu->revenue_target;
      $revenue_hangu += $hangu->amount_received;
   }
   // Target assigned to Kohat and revenue generated against it.
   $target_kohat = 0; // declare a var with 0 value.
   $revenue_kohat = 0; // declare a var with 0 value.
   foreach($daily_sales_kohat as $kohat){
      $target_kohat += $kohat->revenue_target;
      $revenue_kohat += $kohat->amount_received;
   }
?>
<div class="container mt-5 mb-5">
   <div class="row">
      <div class="col-md-12 text-center">
         <h3 class="text-uppercase mb-0">summary</h3>
         <p class="mb-0">For the month of <strong><?= date('F, Y'); ?></strong>.</p>
         <p class="font-weight-bold">Realtors PK, Peshawar.</p>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <div class="row mb-2">
                  <div class="col-md-6">
                     <h3 class="panel-title">
                        <span>Region Assigned (Total)</span>
                     </h3>
                  </div>
                  <div class="col-md-6 text-right">
                     <button type="button" class="btn btn-outline-danger rounded-0 d-print-none" onclick="javascript:history.go(-1);">Go Back</button>
                     <button type="button" class="btn btn-outline-secondary rounded-0 d-print-none" onclick="window.print();">Print Report</button>
                  </div>
               </div>
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                           <tbody>
                              <tr>
                                 <th class="w-50">Assigned Target to Realtors PK Office, Peshawar</th>
                                 <td><?= number_format($target_psh/1000000, 2).'M'; ?></td>
                              </tr>
                              <!-- <tr>
                                 <th class="w-50">Assigned Target to S2S, Hangu</th>
                                 <td><?= number_format($target_hangu/1000000, 2).'M'; ?></td>
                              </tr> -->
                              <!-- <tr>
                                 <th class="w-50">Assigned Target to S2S, Kohat</th>
                                 <td><?= number_format($target_kohat/1000000, 2).'M'; ?></td>
                              </tr> -->
                              <tr>
                                 <th>Total Assigned Target</th>
                                 <th><?php $total_targets = ($target_psh + $target_hangu + $target_kohat); echo number_format($total_targets/1000000, 2).'M'; ?></th>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row mt-4">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">
                  <span>Region Achieved (Total)</span>
               </h3>
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                           <tbody>
                              <tr>
                                 <th class="w-50">Target Achieved by Realtors PK Office, Peshawar</th>
                                 <td><?= number_format($revenue_psh/1000000, 2).'M'; ?></td>
                                 <td><?= round($revenue_psh/$target_psh*100, 2).'%'; ?></td>
                              </tr>
                              <!-- <tr>
                                 <th class="w-50">Target Achieved by S2S, Hangu</th>
                                 <td><?= number_format($revenue_hangu/1000000, 2).'M'; ?></td>
                                 <td><?= $target_hangu > 0 ? round($revenue_hangu/$target_hangu*100, 2).'%' : '0'; ?></td>
                              </tr> -->
                              <!-- <tr>
                                 <th>Target Achieved by S2S, Kohat</th>
                                 <td><?= number_format($revenue_kohat/1000000, 2).'M'; ?></td>
                                 <td><?= $target_kohat > 0 ? round($revenue_kohat/$target_kohat*100, 2).'%' : '0'; ?></td>
                              </tr> -->
                              <tr>
                                 <th class="w-50">Total Revenue</th>
                                 <th><?php $total_revenue = ($revenue_psh + $revenue_hangu + $revenue_kohat); echo number_format($total_revenue/1000000, 2).'M'; ?></th>
                                 <th><?= round($total_revenue/$total_targets*100, 2).'%'; ?></th>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row mt-4">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">
                  <span>Commissions</span>
               </h3>
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                           <tbody>
                              <tr>
                                 <th class="w-50">Zonal Manager team commission</th>
                                 <td><?= number_format(0.4*$revenue_psh/100).' PKR (<small>0.4 % of the total revenue</small>)'; ?></td><!-- Zonal Manager will get from Peshawar office's revenue. -->
                              </tr>
                              <tr>
                                 <th class="w-50">Regional Head commission</th>
                                 <td><?= '<strong>ZERO</strong> for now. Will be changed based on the management\'s instructions.'; ?></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12 text-right">
         <small><?= date('Y'); ?>, &copy; RealtorsPK, Peshawar.</small>
      </div>
   </div>
</div>

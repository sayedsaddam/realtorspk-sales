<div class="container mt-5 mb-5">
   <div class="row">
      <div class="col-md-12 text-center">
         <h3 class="text-uppercase mb-0">summary</h3>
         <p class="mb-0">For the month of <strong><?= date('F, Y'); ?></strong>.</p>
         <p class="font-weight-bold">AH Group of Companies Pvt. Ltd., Islamabad, Pakistan.</p>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <div class="row mb-2">
                  <div class="col-md-4 col-sm-12">
                     <h3 class="panel-title">
                        <span>Projects Summary</span>
                     </h3>
                  </div>
                  <div class="col-md-8 col-sm-12 text-right">
                     <button type="button" class="btn btn-outline-danger rounded-0 d-print-none" onclick="javascript:history.go(-1);">Go Back</button>
                     <button type="button" class="btn btn-outline-secondary rounded-0 d-print-none" onclick="window.print();">Print</button>
                     <a href="<?= base_url('reporting_panel/projects_summary'); ?>" class="btn btn-outline-secondary rounded-0 d-print-none">View All</a>
                     <a href="<?= base_url("reporting_panel/projects_summary_city/Peshawar"); ?>" class="btn btn-outline-secondary rounded-0 d-print-none">Peshawar</a>
                     <a href="<?= base_url('reporting_panel/projects_summary_city/Hangu'); ?>" class="btn btn-outline-secondary rounded-0 d-print-none">Hangu</a>
                     <a href="<?= base_url('reporting_panel/projects_summary_city/Kohat'); ?>" class="btn btn-outline-secondary rounded-0 d-print-none">Kohat</a>
                  </div>
               </div>
            </div>
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-bordered">
                           <caption><?= !empty($this->uri->segment(3)) ? $this->uri->segment(3) : ''; ?></caption>
                           <thead>
                              <tr>
                                 <th>Agent</th>
                                 <th>091 Mall</th>
                                 <th>Florenza</th>
                                 <th>Mall of Hangu</th>
											<th>North Hills</th>
                                 <th>AH Tower</th>
											<th>AH City</th>
                                 <th>Total <small>(PKR)</small></th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if(!empty($projects)): foreach($projects as $project): ?>
                                 <tr>
                                    <td><?= ucfirst($project->emp_name).', '.ucfirst($project->emp_city); ?></td>
                                    <td><?= number_format($project->zero_nine_one_mall); ?></td>
                                    <td><?= number_format($project->florenza); ?></td>
                                    <td><?= number_format($project->moh); ?></td>
												<td><?= number_format($project->northHills); ?></td>
                                    <td><?= number_format($project->ah_tower); ?></td>
												<td><?= number_format($project->ah_city); ?></td>
                                    <td><?= number_format($project->total_amount_received); ?></td>
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

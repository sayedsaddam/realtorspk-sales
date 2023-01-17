<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Reporting Panel |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    You're logged in as: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-block btn-lg">Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-center">
   <!-- Projects summary chart -->
   <div class="row">
        <div class="col-md-12"><h3>Monthly Projects summary for <span class="text-danger font-weight-bold"><?= date('F, Y'); ?>.</span></h3></div>
    </div>
    <div id="projectsSummary" class="mb-5" style="height: 500px;"></div>
    <hr>
    <!-- Region summary chart -->
    <div class="row">
        <div class="col-md-12"><h3>Monthly Regions summary for <span class="text-danger font-weight-bold"><?= date('F, Y'); ?></span>.</h3></div>
    </div>
    <div id="regionSummary" class="mb-5" style="height: 500px;"></div>
    <hr>
    <!-- BCMs summary chart -->
    <div class="row">
        <div class="col-md-12"><h3>Monthly BCMs summary for <span class="text-danger font-weight-bold"><?= date('F, Y'); ?></span>.</h3></div>
    </div>
    <div id="bcmsSummary" class="mb-5" style="height: 500px;"></div>
    <hr>
    <!-- Locations summary chart -->
    <div class="row">
        <div class="col-md-12"><h3>Monthly Locations summary for <span class="text-danger font-weight-bold"><?= date('F, Y'); ?></span>.</h3></div>
    </div>
    <div id="locationSummary" class="mb-5" style="height: 500px;"></div>
</div>
<script>
   // Monthly sales report > Projects
   new Morris.Bar({
      element: 'projectsSummary',
      data: <?php echo $projects; ?>,
      xkey: 'project',
      ykeys: ['rec_amount'],
      labels: ['Amount'],
      hideHover: true,
      resize: true,
      grid: true
   });
   // Monthly sales report > Region
   <?php if ($regions) {?>
   new Morris.Bar({
      element: 'regionSummary',
      data: <?php echo $regions; ?>,
      xkey: 'emp_city',
      ykeys: ['zero_nine_one_mall', 'florenza', 'moh', 'northHills', 'ah_tower', 'ah_city'],
      labels: ['091 Mall', 'Florenza', 'Mall of Hangu', 'North Hills', 'AH Tower', 'AH City'],
      stacked: false,
      hideHover: true,
      resize: true
   });
   <?php } ?>

      // Monthly sales report > BCMs
      new Morris.Bar({
      element: 'bcmsSummary',
      data: <?php echo $bcms; ?>,
      xkey: 'team_lead',
      ykeys: ['zero_nine_one_mall', 'florenza', 'moh', 'northHills', 'ah_tower', 'ah_city'],
      labels: ['091 Mall', 'Florenza', 'Mall of Hangu', 'North Hills', 'AH Tower', 'AH City'],
      stacked: false,
      hideHover: true,
      resize: true
   });
      // Monthly sales report > Locations
      new Morris.Bar({
      element: 'locationSummary',
      data: <?php echo $locations; ?>,
      xkey: 'emp_city',
      ykeys: ['rec_amount'],
      labels: ['Revenue'],
      stacked: false,
      hideHover: true,
      resize: true
   });

</script>
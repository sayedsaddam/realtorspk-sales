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
                        <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-block btn-sm">Dashboard</a>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <a href="<?= base_url('reporting_panel/region_summary'); ?>" class="btn btn-outline-light btn-block btn-sm mb-2">Region Summary</a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= base_url('reporting_panel/projects_summary'); ?>" class="btn btn-outline-light btn-block btn-sm">Projects Summary</a>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <a href="<?= base_url('reporting_panel/annual_summary/Peshawar'); ?>" class="btn btn-outline-light btn-block btn-sm mb-2">Annual Summary Report</a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= base_url('reporting_panel/charts'); ?>" class="btn btn-outline-light btn-block btn-sm">Report Graphs</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card-deck">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Sales Report - Teams</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('reporting_panel/team_report'); ?>" method="get">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input type="date" name="date_from" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <label for="to">To</label>
                                        <input type="date" name="date_to" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="team" class="form-control form-control-sm">
                                            <option value="" selected disabled>--select team--</option>
                                            <?php if(!empty($teams)): foreach($teams as $team): ?>
                                                <option value="<?= $team->team_id; ?>"><?= $team->team_name.' - '.$team->team_lead; ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <button type="submit" class="btn btn-dark btn-sm btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Sales Report - Team Lead / BCM</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('reporting_panel/bcm_report'); ?>" method="get">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input type="date" name="date_from" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <label for="to">To</label>
                                        <input type="date" name="date_to" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="team_lead" class="form-control form-control-sm">
                                            <option value="" selected disabled>--select BCM--</option>
                                            <option value="BCM-I">BCM-I</option>
                                            <option value="BCM-II">BCM-II</option>
                                            <option value="BCM-III">BCM-III</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <button type="submit" class="btn btn-dark btn-sm btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Sales Report - Agent</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('reporting_panel/agent_report'); ?>" method="get">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input type="date" name="date_from" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <label for="to">To</label>
                                        <input type="date" name="date_to" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <select name="city" id="city" class="form-control form-control-sm">
                                            <option value="" selected disabled>--select city--</option>
                                            <?php if(!empty($locations)): foreach($locations as $loc): ?>
									            <option value="<?= $loc->name; ?>"><?= $loc->name; ?>
                                            </option>
							                <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mx-2">
                                        <select name="agent" id="agents" class="form-control form-control-sm">
                                            <option value="" selected disabled>--select agent--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-dark btn-block btn-sm">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="card-deck">
                <div class="card">
                    <div class="card-header">
                        <h5>Sales Report - Project</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('reporting_panel/project_report'); ?>" method="get">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input type="date" name="date_from" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <label for="to">To</label>
                                        <input type="date" name="date_to" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="project" class="form-control form-control-sm">
                                            <option value="" selected disabled>--select project--</option>
                                            <option value="091 Mall">091 Mall</option>
                                            <option value="Florenza">Florenza</option>
                                            <option value="MoH">Mall of Hangu</option>
                                            <option value="North Hills">North Hills</option>
											<option value="AH Tower">AH Tower</option>
											<option value="AH City">AH City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <button type="submit" class="btn btn-dark btn-sm btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
						<h5>Sales Report - Between two dates</h5>
					</div>
                    <div class="card-body">
						<form action="<?= base_url('reporting_panel/overall_report'); ?>" method="get">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input type="date" name="date_from" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mx-2">
                                        <label for="to">To</label>
                                        <input type="date" name="date_to" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-md-12">
                                    <div class="form-group mx-2">
                                        <button type="submit" class="btn btn-dark btn-sm btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
					</div>
                </div>
            </div>
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

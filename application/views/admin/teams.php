<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Teams - Sales |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
    <?php if($success = $this->session->flashdata('success')): ?>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12">
            <div class="alert alert-success alert-dismissible fade show">
                <?= $success; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row mb-0">
        <div class="col-xl-lg-8 col-md-8 col-sm-12 mb-1 pb-2">
            <h2 class="font-weight-bold">
                <?php if(empty($results)): ?>
                    Teams - Sales
                <?php elseif(!empty($results)): ?>
                    Search Results
                <?php endif; ?>
            </h2>
        </div>
        <div class="col-xl-lg-4 col-md-4 col-sm-12 mb-2 pb-2">
            <small></small>
            <form action="<?= base_url('admin/search_teams'); ?>" method="get">
                <div class="form-row">
                    <div class="col">
                        <input name="search" type="text" class="form-control" placeholder="Search in teams ...">
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-outline-secondary" value="Search">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 table-responsive table-sm">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Sr#</th>
                        <th>Team Name</th>
                        <th>Team Lead</th>
                        <th>BDM Name</th>
                        <th>Added By</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($teams)): $serial = $this->uri->segment(3) + 1; foreach($teams as $team): ?>
                        <tr>
                            <td><?= $serial++; ?></td>
                            <td>
                                <a data-id="<?= $team->team_id; ?>" class="team_info" href="#0"><?= $team->team_name; ?></a>
                            </td>
                            <td><?= $team->team_lead; ?></td>
                            <td><?= $team->bdm_name; ?></td>
                            <td><?= $team->fullname; ?></td>
                            <td><?= date('M d, Y', strtotime($team->created_at)); ?></td>
                            <td>
                                <a href="javascript:void(0)" data-id="<?= $team->team_id; ?>" class="edit_team btn btn-primary btn-sm" href="javascript:void(0)">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; else: echo "<tr class='table-danger text-center'><td colspan='6'>No record found.</td></tr>"; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12">
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
<!-- Modal >> Edit team -->
<div class="modal fade" id="edit_team" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Update Team - <span class="text-danger font-weight-light"><?= $team->team_name; ?></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('admin/update_team'); ?>" method="post">
					<div class="row">
						<div class="col-md-6">
							<input type="hidden" name="team_id" id="team_id" value="<?= $team->team_id; ?>">
							<label for="team_name">Team Name</label>
							<input type="text" name="team_name" id="team_name" class="form-control mb-2" value="<?= $team->team_name; ?>">
						</div>
						<div class="col-md-6">
							<label for="team_lead">BCM Name</label>
							<input type="text" name="team_lead" id="team_lead" class="form-control mb-2" value="<?= $team->team_lead; ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label for="bdm_name">BDM Name</label>
							<input type="text" name="bdm_name" id="bdm_name" class="form-control mb-2" value="<?= $team->bdm_name; ?>">
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
							
						</div>
						<div class="col-md-6">
							<button type="reset" class="btn btn-warning btn-block">Reset</button>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Agents in a team -->
<div class="modal fade" id="team_info" tabindex="-1" role="dialog" aria-labelledby="teamInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 id="exampleModalLabel">Team Information &raquo; <span class="text-primary font-weight-light modal-title"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Office</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody class="employees_list">

                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
  $('.team_info').click(function(){  
    var team_id = $(this).data('id');
    // AJAX request
    $.ajax({
    url: '<?= base_url('admin/agents_in_team/'); ?>' + team_id,
    method: 'POST',
    dataType: 'JSON',
    data: {team_id: team_id},
      success: function(response){ 
        console.log(response);
        $('.employees_list').html('');
        serial = 1;
        $.each(response, function(index, res){
            $('.modal-title').html(res.team_name + ', ' + res.team_lead);
            $('.employees_list').append(`<tr><td>${serial++}</td><td>${res.emp_name}</td><td>${res.emp_code}</td><td>${res.office}</td><td>${res.emp_number}</td></tr>`);
        });
        $('#team_info').modal('show');
      }
    });
  });
  // Edit team
  $('.edit_team').click(function(){
	var team = $(this).data('id');
	$.ajax({
		url: '<?= base_url("admin/team_info/") ?>' + team,
		method: 'POST',
		dataType: 'JSON',
		data: {team: team},
		success: function(response){
			console.log(response);
			$('#team_id').val(response.team_id);
			$('#team_name').val(response.team_name);
			$('#team_lead').val(response.team_lead);
			$('#bdm_name').val(response.bdm_name);
			$('#edit_team').modal('show');
		}
	})
  })
});
</script>

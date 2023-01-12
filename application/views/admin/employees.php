<div class="jumbotron jumbotron-fluid text-white" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Employees |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
<div class="container-fluid">
    <?php if($success = $this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>
    <?php if($failed = $this->session->flashdata('failed')): ?>
        <div class="alert alert-danger"><?= $failed; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xl-lg-7 col-md-7 col-sm-12 mb-2 pb-2">
            <h2 class="font-weight-bold">
                <?php if(empty($results)){ echo 'Employees List'; }else{ echo "Seach Results| <a href='javascript:history.go(-1)' class='btn btn-info btn-sm'>Back</a>"; } ?>
            </h2>
            <?php if(!empty($employees)){ echo 'No. of employees currently working in the Sales department: '.$this->db->select('*')->from('employees')->where(array('emp_department' => 6, 'emp_status' => 1))->count_all_results();
            echo '<br> No. of employees left the company (terminated or resigned): '.$this->db->select('*')->from('employees')->where(array('emp_department' => 6, 'emp_status' => 0))->count_all_results(); } ?> &raquo; <a href="<?= base_url('admin/inactive_employees'); ?>" class="text-primary">view</a>
        </div>
        <div class="col-xl-lg-5 col-md-5 col-sm-12 mb-2 pb-2">
            <form action="<?= base_url('admin/search_employees'); ?>" method="get">
                <div class="form-row">
                    <div class="col">
                        <select name="emp_search" class="form-control" title="Filter employees by city">
                            <option value="">--Select One--</option>
                            <option value="Islamabad">Islamabad</option>
                            <option value="Peshawar">Peshawar</option>
                            <option value="Hangu">Hangu</option>
                            <option value="Kohat">Kohat</option>
                        </select>
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-outline-secondary" value="Search">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 col-sm-12 table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th>Serial #</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>City</th>
                        <th>Team</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Assign Team</th>
                    </tr>
                </thead>
                <?php if(!empty($employees)): ?>
                    <tbody>
                        <?php $serial = $this->uri->segment(3) + 1; foreach($employees as $emp): ?>
                            <tr <?php if($emp->emp_status == 0){ echo 'class="table-danger"'; } ?>>
                                <td><?= $serial++; ?></td>
                                <td><?= $emp->emp_name; ?></td>
                                <td><?= $emp->emp_code; ?></td>
                                <td><?= $emp->emp_number; ?></td>
                                <td><?= $emp->dept_name; ?></td>
                                <td><?= $emp->emp_city; ?></td>
                                <td><?php if($emp->team_name){ echo '<span class="badge badge-info">'.$emp->team_name.'</span>'; }else{ echo '<small class="badge badge-danger">N/A</small>'; } ?></td>
                                <td><?php if($emp->emp_status == 1){ echo "<span class='badge badge-success'>Active</span>"; }else{ echo '<span class="badge badge-danger">Inactive</span>'; } ?></td>
                                <td>
                                    <a href="<?= base_url('admin/update_employee_status/'.$emp->id); ?>" class="btn btn-primary btn-sm" title="Change the status whether resigned or terminated..." onclick="javascript:return confirm('Are you sure to delete ? This operation can not be undone! Click OK to continue.');">Status Change</a>
                                </td>
                                <td>
                                    <form action="<?= base_url('admin/assign_team'); ?>" method="post" class="team_assign">
                                        <input type="hidden" name="employee_id" class="employee_id" value="<?= $emp->id; ?>">
                                        <select name="team_id" class="form-control form-control-sm assign_team" onchange="assign_team(this, '<?= $emp->id; ?>')">
                                            <option value="" disabled selected>Assign Team</option>
                                            <?php if(!empty($teams AND $emp->emp_status == 1)): foreach($teams as $team): ?>
                                                <option value="<?= $team->team_id; ?>"><?= $team->team_name; ?></option>
                                            <?php endforeach; endif; ?>  
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php elseif(!empty($results)): ?>
                    <tbody>
                        <?php $serial = $this->uri->segment(3) + 1; foreach($results as $res): ?>
                            <tr <?php if($res->emp_status == 0){ echo 'class="table-danger"'; } ?>>
                                <td><?= $serial++; ?></td>
                                <td><?= $res->emp_name; ?></td>
                                <td><?= $res->emp_code; ?></td>
                                <td><?= $res->emp_number; ?></td>
                                <td><?= $res->dept_name; ?></td>
                                <td><?= $res->emp_city; ?></td>
                                <td><?php if($res->team_name){ echo '<span class="badge badge-info">'.$res->team_name.'</span>'; }else{ echo '<small class="badge badge-danger">N/A</small>'; } ?></td>
                                <td><?php if($res->emp_status == 1){ echo "<span class='badge badge-success'>Active</span>"; }else{ echo '<span class="badge badge-danger">Inactive</span>'; } ?></td>
                                <td>
                                    <a href="<?= base_url('admin/update_employee_status/'.$res->id); ?>" class="btn btn-primary btn-sm" title="Change the status whether resigned or terminated..." onclick="javascript:return confirm('Are you sure to delete ? This operation can not be undone! Click OK to continue.');">Status Change</a>
                                </td>
                                <td>
                                    <form action="<?= base_url('admin/assign_team'); ?>" method="post" class="team_assign">
                                        <input type="hidden" name="employee_id" class="employee_id" value="<?= $res->id; ?>">
                                        <select name="team_id" class="form-control form-control-sm assign_team" onchange="assign_team(this, '<?= $res->id; ?>')">
                                            <option value="" disabled selected>Assign Team</option>
                                            <?php if(!empty($teams AND $res->emp_status == 1)): foreach($teams as $team): ?>
                                                <option value="<?= $team->team_id; ?>"><?= $team->team_name; ?></option>
                                            <?php endforeach; endif; ?>  
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <!-- Grid row -->
    <div class="row">
        <div class="col-xl-lg-12 col-md-12 text-center">
            <?php if(!empty($employees) AND empty($results)){ echo $this->pagination->create_links(); } ?>
        </div>
    </div>
</div>
<script>
    function assign_team(selectObject, emp_id) {
        var team_id = selectObject.value; // value = team_id
        var employee_id = emp_id;
        // alert(team_id+":"+ emp_id);
        $.ajax({
            url: '<?php echo base_url(); ?>admin/assign_team/' + employee_id,
            method: 'post',
            dataType: 'html',
            data: {team_id:team_id},
            success:function(res){
                alert('Assigning to team was successful.');
                location.reload(true); 
            }
        });
    }
</script>

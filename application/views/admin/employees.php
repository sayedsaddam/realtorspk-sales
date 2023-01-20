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
                            <?php if(!empty($locations)): foreach($locations as $loc): ?>
									<option value="<?= $loc->name; ?>"><?= $loc->name; ?></option>
							<?php endforeach; endif; ?>
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
                                <td><a class="empId" href="javascript:void(0)" data-id="<?= $emp->id; ?>"><?= $emp->emp_name; ?></a></td>
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
<!-- Modal for editing employee starts -->
<div class="modal fade" id="edit_employee" tabindex="-1" role="dialog" aria-labelledby="payment_statusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment_statusLabel">Edit Employee Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_employee_form" action="<?= base_url('admin/update_employee'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="emp_code">Employee Code</label>
                            <input type="number" name="emp_code" class="form-control emp_code mb-2" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Employee Name</label>
                            <input type="text" name="emp_name" class="form-control emp_name mb-2" placeholder="Employee name..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="designation">Designation</label>
                            <select name="designation" class="custom-select designation mb-2">
                                <option value="" disabled selected>-- Select One --</option>
                                <?php if(!empty($designations)): foreach($designations as $des): ?>
                                    <option value="<?= $des->id; ?>"><?= $des->designation_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="gender">Gender</label>
                            <select name="gender" class="custom-select gender mb-2">
                                <option value="" disabled selected>-- Select One --</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="office">Office</label>
                            <select name="office" class="custom-select office mb-2">
                                <option value="" disabled selected>-- Select One --</option>
                                <option value="Head Office">Head Office</option>
                                <option value="Regional Office">Regional Office</option>
                                <option value="Site Office">Site Office</option>
                                <option value="Branch Office">Branch Office</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" name="emp_phone" class="form-control phone mb-2" placeholder="Mobile no. i.e. 03439343456" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="department">Department</label>
                            <select name="emp_department" class="custom-select emp_department mb-2" required>
                                <option value="" disabled selected>-- Select One --</option>
                                <?php if(!empty($departments)): foreach($departments as $dept): ?>
                                    <option value="<?= $dept->dept_id; ?>"><?= $dept->dept_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="city">City</label>
                            <select name="emp_city" class="custom-select emp_city mb-2" required>
                                <option value="" disabled selected>-- Select One --</option>
                                <option value="Islamabad">Islamabad</option>
                                <option value="Peshawar">Peshawar</option>
                                <option value="Hangu">Hangu</option>
                                <option value="Kohat">Kohat</option>
                                <option value="Mardan">Mardan</option>
                                <option value="D.I Khan">D.I Khan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="doj">Date of Joining</label>
                            <input type="date" name="doj" class="form-control doj mb-2" required>
                        </div>
                        <div class="col-md-6">
                            <label for="team">Team</label>
                            <select name="emp_team" class="custom-select emp_team mb-4">
                                <option value="" disabled selected>-- Select One --</option>
                                <?php if(!empty($teams)): foreach($teams as $team): ?>
                                    <option value="<?= $team->team_id; ?>"><?= $team->team_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="report_to">Report To</label>
                            <select id="reportsTo" class="custom-select reportsTo mb-4">
                                <option value="" disabled selected>-- Select One --</option>
                                <?php if(!empty($designations)): foreach($designations as $des): if($des->id != 1): ?>
                                    <option value="<?= $des->id; ?>"><?= $des->designation_name; ?></option>
                                <?php endif; endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="manager_id">Manager Name</label>
                            <select name="manager_id" id="manager_id" class="custom-select manager_id mb-4">
                                <option value="" disabled selected>-- Select One --</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                    <input type="reset" class="btn btn-warning" value="Clear">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for adding new employee ends -->
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
    $(document).ready(function(){
        $('#edit_employee_form').submit(function() {
            $('.emp_code').removeAttr('disabled');
            return true; 
        });
        $('.empId').click(function(){
            var empId = $(this).data('id');
            $.ajax({
                url: '<?= base_url(); ?>admin/employee_detail/' + empId,
                method: 'post',
                dataType: 'json',
                data: {empId: empId},
                success: function(res){
                    console.log(res);
                    $('.emp_code').val(empId);
                    $('.emp_name').val(res.emp_name);
                    $('.designation').val(res.des_id);
                    $('.gender').val(res.gender);
                    $('.office').val(res.office);
                    $('.phone').val(res.emp_number);
                    $('.emp_department').val(res.emp_department);
                    $('.emp_city').val(res.emp_city);
                    $('.doj').val(res.doj);
                    $('.emp_team').val(res.emp_team);
                    $('.manager_id').html('<option value="'+ res.manager_id +'" selected="selected">'+ res.manager_id +'</option>');
                    $('#edit_employee').modal('show');
                }
            });
        });
        // get all employees against a designation
        $('#reportsTo').change(function(){
            var managers = $(this).val();
            $.ajax({
                url: '<?= base_url('admin/get_managers/') ?>' + managers,
                method: 'POST',
                dataType: 'JSON',
                data: {managers: managers},
                success: function(res){
                    console.log(res);
                    $('#manager_id').find('option').not(':first').remove();
                    // add options
                    $.each(res, function(index, data){
                        $('#manager_id').append('<option value="'+data['id']+'">'+data['emp_name']+'</option>');
                    });
                }
            });
        });
    });
</script>

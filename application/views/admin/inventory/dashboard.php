<div class="jumbotron jumbotron-fluid text-white" style="background-color: crimson;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Dashboard &raquo; Inventory | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Home</a>
                <a href="javascript:history.go(-1)" class="btn btn-outline-light btn-lg btn-block">Inventory's Home</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <?php if($success = $this->session->flashdata('success')): ?>
        <div class="row">
            <div class="col">
                <div class="alert alert-success"><?php echo $success; ?></div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($failed = $this->session->flashdata('failed')): ?>
        <div class="row">
            <div class="col">
                <div class="alert alert-danger"><?php echo $failed; ?></div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card-deck">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title font-weight-light">Projects <span class="badge badge-secondary badge-pill"><?= number_format($total_projects); ?></span></h5>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#addProject">Add New</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-sm">
                            <small><?= 'Total on this page &raquo; '.count($projects); ?></small>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($projects)): foreach($projects as $project): ?>
                                    <tr>
                                        <td><?= $project->id; ?></td>
                                        <td title="View detail and upload documents if any..."><a href="<?= base_url('inventory/project_detail/'.$project->slug); ?>"><?= $project->name; ?></a></td>
                                        <td><?= $project->location; ?></td>
                                        <td><?= $project->slug; ?></td>
                                        <td>
                                            <a class="projectId" href="#0" data-id="<?= $project->slug; ?>">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title font-weight-light">Floors <span class="badge badge-secondary badge-pill"><?= number_format($total_floors); ?></span></h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" data-toggle="modal" data-target="#addFloor" class="btn btn-outline-secondary btn-sm">Add New</button>
                                <a href="<?= base_url('inventory/floors'); ?>" class="btn btn-outline-danger btn-sm">Floors List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-sm">
                            <small><?= 'Total on this page &raquo; '.count($floors); ?></small>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Project</th>
                                    <th title="C = Covered, S = Sellable">Area - C / S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($floors)): foreach($floors as $floor): ?>
                                <tr class="<?= $floor->status == 0 ? 'table-danger' : ''; ?>">
                                    <td><?= $floor->floor_id; ?></td>
                                    <td title="Click to edit..."><a class="floorId" href="#0" data-id="<?= $floor->floor_id; ?>"><?= $floor->floor_name; ?></a></td>
                                    <td><?= $floor->project_name; ?></td>
                                    <td><?= number_format($floor->covered_area).' / '.number_format($floor->sellable_area); ?> ft<sup>2</sup></td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title font-weight-light" title="Shops, Offices or Apartments...">Units <span class="badge badge-secondary badge-pill"><?= number_format($total_units); ?></span></h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" data-toggle="modal" data-target="#addUnit" class="btn btn-outline-secondary btn-sm">Add New</button>
                                <a href="<?= base_url('inventory/units'); ?>" class="btn btn-outline-danger btn-sm">Units List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-sm">
                        <small><?= 'Total on this page &raquo; '.count($units); ?>. Color indicates the booking status.</small>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Unit Name</th>
                                    <th>Size</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($units)): foreach($units as $unit): ?>
                                <tr class="<?= $unit->status == 0 ? 'table-danger' : ''; ?>" title="The red color indicates the booking status of the unit.">
                                    <td><?= $unit->unit_id; ?></td>
                                    <td title="Click to edit..."><a href="#0" data-id="<?= $unit->unit_id; ?>" class="unitId"><?= $unit->unit_name; ?></a></td>
                                    <td><?= $unit->unit_size; ?></td>
                                    <td title="sell or view detail of the unit!">
                                        <?php if($unit->status == 1): ?>
                                            <a title="Initiate a purchase request..." href="<?= base_url('bookings/purchase_now/'.$unit->unit_id); ?>">sell</a>
                                        <?php else: ?>
                                            <a title="View booking detail..." href="<?= base_url('home/booking_detail/'.$unit->unit_id); ?>">sold</a>
                                        <?php endif; ?>
                                    </td>
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

<div class="container-fluid mb-3">
    <div class="row">
        <div class="col-md-12 text-right">
            <small>AH Group of Companies Pvt. Ltd.</small>
        </div>
    </div>
</div>
<!-- Modal >> add project -->
<div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('inventory/add_project'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?php $locations = array('Islamabad', 'Peshawar', 'Hangu', 'Kohat', 'Murree', 'Karachi'); ?>
                        <select name="location" class="custom-select">
                            <option value="" disabled selected>Project Location</option>
                            <?php foreach($locations as $location): ?>
                                <option value="<?= $location; ?>"><?= $location; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Project name i.e, 091 Mall...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="floors" class="form-control" placeholder="No. of floors i.e, 8...">
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" rows="5" placeholder="Project description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal >> edit project -->
<div class="modal fade" id="editProject" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('inventory/update_project'); ?>" method="post">
            <input type="hidden" name="project_id" class="project_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Project Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <?php $locations = array('Islamabad', 'Peshawar', 'Hangu', 'Kohat', 'Murree', 'Karachi'); ?>
                        <select name="location" class="custom-select location">
                            <option value="" disabled selected>Project Location</option>
                            <?php foreach($locations as $location): ?>
                                <option value="<?= $location; ?>"><?= $location; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control name" placeholder="Project name i.e, 091 Mall...">
                    </div>
                    <div class="form-group">
                        <input type="text" name="slug" class="form-control slug" placeholder="Project slug i.e, 091-mall...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="floors" class="form-control floors" placeholder="No. of floors i.e, 8...">
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control description" rows="5" placeholder="Project description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal >> add floor -->
<div class="modal fade" id="addFloor" tabindex="-1" role="dialog" aria-labelledby="addFloorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('inventory/add_floor'); ?>" method="post" id="floorAdd">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Floor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="project" class="custom-select">
                            <option value="" disabled selected>Choose Project</option>
                            <?php foreach($projects as $project): ?>
                                <option value="<?= $project->id; ?>"><?= $project->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="type" class="custom-select">
                            <option value="" disabled selected>Choose Type</option>
                            <?php $types = array('Residential', 'Commercial', 'Offices'); ?>
                            <?php foreach($types as $type): ?>
                                <option value="<?= $type; ?>"><?= $type; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Floor name i.e, LG...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="covered_area" class="form-control covered_area" placeholder="Covered area in sqft i.e, 1100...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="sellable_area" class="form-control sellable_area" placeholder="Sellable area in sqft i.e, 1000...">
                        <small class="message"></small>
                    </div>
                    <div class="form-group">
                        <input type="number" name="price" class="form-control" placeholder="Price /sqft i.e, 85000...">
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" rows="5" placeholder="Floor description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal >> edit floor -->
<div class="modal fade" id="editFloor" tabindex="-1" role="dialog" aria-labelledby="editFloorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('inventory/update_floor'); ?>" method="post" id="floorAdd">
            <input type="hidden" name="floor_id" class="floor_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Floor Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="project" class="custom-select project">
                            <option value="" disabled selected>Choose Project</option>
                            <?php foreach($projects as $project): ?>
                                <option value="<?= $project->id; ?>"><?= $project->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="type" class="custom-select type">
                            <option value="" disabled selected>Choose Type</option>
                            <?php $types = array('Residential', 'Commercial', 'Offices'); ?>
                            <?php foreach($types as $type): ?>
                                <option value="<?= $type; ?>"><?= $type; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control floor_name" placeholder="Floor name i.e, LG...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="covered_area" class="form-control covered_area" placeholder="Covered area in sqft i.e, 1100...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="sellable_area" class="form-control sellable_area" placeholder="Sellable area in sqft i.e, 1000...">
                        <small class="message"></small>
                    </div>
                    <div class="form-group">
                        <input type="number" name="price" class="form-control price" placeholder="Price /sqft i.e, 85000...">
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control description" rows="5" placeholder="Floor description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal >> add unit -->
<div class="modal fade" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('inventory/add_unit'); ?>" method="post" id="unitAdd">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="project" class="custom-select" id="project">
                            <option value="">Choose Project</option>
                            <?php foreach($projects as $project): ?>
                                <option value="<?= $project->id; ?>"><?= $project->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="floor" class="custom-select" id="floor">
                            <option value="">Choose Floor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="unit_name" class="form-control" placeholder="Unit name...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="size" class="form-control" placeholder="Unit size i.e, 700...">
                    </div>
                    <div class="form-group">
                        <input type="text" name="beds" class="form-control" placeholder="No. of beds i.e, 2...">
                    </div>
                    <div class="form-group">
                        <input type="number" name="price" class="form-control" placeholder="Unit price...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal >> edit unit -->
<div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="editUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('inventory/update_unit'); ?>" method="post" id="unitEdit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Unit Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="unit_id" class="unit_id">
                    <legend id="unitName"></legend>
                    <div class="form-group">
                        <label for="name">Unit Name</label>
                        <input type="text" name="unit_name" class="form-control unit_name">
                    </div>
                    <div class="form-group">
                        <label for="size">Unit Size</label>
                        <input type="number" name="size" class="form-control size">
                    </div>
                    <div class="form-group">
                        <label for="beds">No. of Beds</label>
                        <input type="text" name="beds" class="form-control beds">
                    </div>
                    <div class="form-group">
                        <label for="price">Unit Price</label>
                        <input type="number" name="price" class="form-control price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.projectId').click(function(){
            projectSlug = $(this).data('id');
            $.ajax({
                url: '<?= base_url('inventory/edit_project/'); ?>' + projectSlug,
                method: 'post',
                dataType: 'json',
                data: {projectSlug: projectSlug},
                success: function(res){
                    console.log(res);
                    $('.project_id').val(res.id);
                    $('.location').val(res.location);
                    $('.name').val(res.name);
                    $('.slug').val(res.slug);
                    $('.floors').val(res.no_of_floors);
                    $('.description').val(res.project_description);
                    $('#editProject').modal('show');
                }
            });
        });
        // check for covered and sellable area - sellable area can not be greater than covered area.
        $('.sellable_area').on('change', function(){
            sellable_area = $(this).val();
            sellable_area = parseInt(sellable_area);
            covered_area =$('.covered_area').val();
            covered_area = parseInt(covered_area);
            if(sellable_area > covered_area){
                $('.message').html("Sellable area can't be greater than covered area.");
                $('#floorAdd button').prop('disabled', true);
            }else{
                $('.message').html("Good to go now.");
                $('#floorAdd button').prop('disabled', false);
            }
        });
        // floor detail > edit floor
        $('.floorId').click(function(){
            floorId = $(this).data('id');
            $.ajax({
                url: '<?= base_url('inventory/floor_detail/') ?>' + floorId,
                method: 'post',
                dataType: 'json',
                data: {floorId: floorId},
                success: function(res){
                    console.log(res);
                    $('.floor_id').val(res.floor_id);
                    $('.project').val(res.project_id);
                    $('.type').val(res.floor_type);
                    $('.floor_name').val(res.floor_name);
                    $('.covered_area').val(res.covered_area);
                    $('.sellable_area').val(res.sellable_area);
                    $('.price').val(res.price);
                    $('.description').val(res.floor_description);
                    $('#editFloor').modal('show');
                }
            });
        });
        // dependent dropdown for floors > fetch floors based on project change
        $('#project').on('change', function(){
            project = $(this).val();
            $.ajax({
                url: '<?= base_url('inventory/get_floors_byProject/') ?>' + project,
                method: 'post',
                dataType: 'json',
                data: {project: project},
                success: function(res){
                    console.log(res);
                    $('#floor').find('option').not(':first').remove();
                    // Add options
                    $.each(res, function(index, data){
                        $('#floor').append('<option value="'+data['id']+'">'+data['name']+'</option>');
                        // $('.unit_name').val(data['project_code']);
                    });
                }
            });
            $('#project_name').val($('#project option:selected').text());
            $('#floor').on('change', function(){
                // floor_name = $(this).text();
                $('#floor_name').val($('#floor option:selected').text());
            });
        });
        // unit detail > edit unit
        $('.unitId').click(function(){
            unitId = $(this).data('id');
            $.ajax({
                url: '<?= base_url('inventory/unit_detail/') ?>' + unitId,
                method: 'post',
                dataType: 'json',
                data: {unitId: unitId},
                success: function(res){
                    console.log(res);
                    // unit_name = res.unit_name.split('-')[res.unit_name.split('-').length-1];
                    $('.unit_id').val(res.unit_id);
                    $('#unitName').html(res.unit_name);
                    $('.project_name').val(res.project_name);
                    $('.floor_name').val(res.floor_name);
                    $('.unit_name').val(res.unit_name);
                    $('.size').val(res.unit_size);
                    $('.beds').val(res.no_of_beds);
                    $('.price').val(res.price);
                    $('#editUnit').modal('show');
                }
            });
        });
    });
</script>
<div class="jumbotron jumbotron-fluid text-white" style="background-color: crimson;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Inventory &raquo; Units | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Home</a>
                <a target="_blank" href="<?= base_url('careers'); ?>" class="btn btn-outline-light btn-lg btn-block">Careers</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
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
    <div class="row mb-3">
        <div class="col-md-8">
            <h2 class="font-weight-light mb-0">List of Units &raquo; <button data-toggle="modal" data-target="#addUnit" class="btn btn-primary">Add New</button></h2>
            <p class="font-weight-light"><?= !empty($results) ? 'About '.count($results).' results ({elapsed_time} seconds)' : ''; ?></p>
        </div>
        <div class="col-md-4 text-right">
            <form action="<?= base_url('inventory/search_units'); ?>" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search units..." aria-label="Search units..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Project</th>
                        <th>Floor</th>
                        <th>Type</th>
                        <th>Size m<sup>2</sup> | ft<sup>2</sup></th>
                        <th title="Number of beds or size of the unit...">Description</th>
                        <th>Price</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php if(empty($results) && !empty($units)): ?>
                <tbody id="units">
                    <?php foreach($units as $unit): ?>
                        <tr class="<?= $unit->status == 0 ? 'table-danger' : ''; ?>" title="The red color indicates the booking status of the unit.">
                            <td><?= $unit->unit_id; ?></td>
                            <td><?= $unit->unit_name; ?></td>
                            <td><?= $unit->project_name; ?></td>
                            <td><?= $unit->floor_name; ?></td>
                            <td><?= $unit->floor_type; ?></td>
                            <td><?= number_format($unit->unit_size).' | '.number_format($unit->size_in_sqft); ?></td>
                            <td><?= $unit->no_of_beds; ?></td>
                            <td><?= number_format($unit->price); ?></td>
                            <td><?= date('M d, Y', strtotime($unit->created_at)); ?></td>
                            <td>
                                <a title="update unit information" class="unitId" data-id="<?= $unit->unit_id; ?>" href="#0">edit</a> |
                                <a title="activate or deactivate this unit" href="<?= base_url('inventory/change_unit_status/'.$unit->unit_id); ?>">
                                   <?= $unit->status == 1 ? 'disable' : 'enable'; ?>
                                </a> |
                                <?php if($unit->status == 1): ?>
                                    <a title="Initiate a purchase request..." href="<?= base_url('bookings/purchase_now/'.$unit->unit_id); ?>">sell</a>
                                <?php else: ?>
                                    <a title="View detail if it's sold..." href="<?= base_url('home/booking_detail/'.$unit->unit_id); ?>">sold</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php elseif(!empty($results)): ?>
                    <tbody id="units">
                    <?php foreach($results as $unit): ?>
                        <tr class="<?= $unit->status == 0 ? 'table-danger' : ''; ?>" title="The red color indicates the booking status of the unit.">
                            <td><?= $unit->unit_id; ?></td>
                            <td><?= $unit->unit_name; ?></td>
                            <td><?= $unit->project_name; ?></td>
                            <td><?= $unit->floor_name; ?></td>
                            <td><?= $unit->floor_type; ?></td>
                            <td><?= number_format($unit->unit_size).' | '.number_format($unit->size_in_sqft); ?></td>
                            <td><?= $unit->no_of_beds; ?></td>
                            <td><?= number_format($unit->price); ?></td>
                            <td><?= date('M d, Y', strtotime($unit->created_at)); ?></td>
                            <td>
                                <a title="update unit information" class="unitId" data-id="<?= $unit->unit_id; ?>" href="#0">edit</a> |
                                <a title="activate or deactivate this unit" href="<?= base_url('inventory/change_unit_status/'.$unit->unit_id); ?>">
                                   <?= $unit->status == 1 ? 'disable' : 'enable'; ?>
                                </a> |
                                <?php if($unit->status == 1): ?>
                                    <a title="Initiate a purchase request..." href="<?= base_url('bookings/purchase_now/'.$unit->unit_id); ?>">sell</a>
                                <?php else: ?>
                                    <a title="View detail if it's sold..." href="<?= base_url('home/booking_detail/'.$unit->unit_id); ?>">sold</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
            </table>
            <?= $this->pagination->create_links(); ?>
        </div>
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
// Search filter for units
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#units tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<script>
    $(document).ready(function(){
        // dependent dropdown for floors > fetch floors based on project ID.
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
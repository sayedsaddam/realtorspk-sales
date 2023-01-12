<div class="jumbotron jumbotron-fluid text-white" style="background-color: crimson;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Inventory &raquo; Floors | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
            <h2 class="font-weight-light">List of Floors &raquo; <button data-toggle="modal" data-target="#addFloor" class="btn btn-primary">Add New</button></h2>
        </div>
        <div class="col-md-4 text-right">
            <form action="<?= base_url('inventory/search_floors'); ?>" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search floors..." aria-label="Search floors..." aria-describedby="basic-addon2">
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
                        <th>Covered Area</th>
                        <th>Sellable Area</th>
                        <th>Price /ft<sup>2</sup></th>
                        <th>Description</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php if(empty($results) && !empty($floors)): ?>
                <tbody id="floors">
                    <?php foreach($floors as $floor): ?>
                        <tr class="<?= $floor->status == 0 ? 'table-danger' : ''; ?>">
                            <td><?= $floor->floor_id; ?></td>
                            <td><?= $floor->floor_name; ?></td>
                            <td><?= $floor->project_name; ?></td>
                            <td><?= number_format($floor->covered_area); ?></td>
                            <td><?= number_format($floor->sellable_area); ?></td>
                            <td><?= number_format($floor->price); ?></td>
                            <td title="<?= $floor->floor_description; ?>"><?= substr($floor->floor_description, 0, 15).' ...'; ?></td>
                            <td><?= date('M d, Y', strtotime($floor->created_at)); ?></td>
                            <td>
                                <a class="floorId" data-id="<?= $floor->floor_id; ?>" href="#0">edit</a> |
                                <a href="<?= base_url('inventory/change_floor_status/'.$floor->floor_id); ?>">
                                    <?= $floor->status == 0 ? 'enable' : 'disable'; ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php elseif(!empty($results)): ?>
                    <tbody id="floors">
                    <?php foreach($results as $floor): ?>
                        <tr class="<?= $floor->status == 0 ? 'table-danger' : ''; ?>">
                            <td><?= $floor->floor_id; ?></td>
                            <td><?= $floor->floor_name; ?></td>
                            <td><?= $floor->project_name; ?></td>
                            <td><?= number_format($floor->covered_area); ?></td>
                            <td><?= number_format($floor->sellable_area); ?></td>
                            <td><?= number_format($floor->price); ?></td>
                            <td title="<?= $floor->floor_description; ?>"><?= substr($floor->floor_description, 0, 15).' ...'; ?></td>
                            <td><?= date('M d, Y', strtotime($floor->created_at)); ?></td>
                            <td>
                                <a class="floorId" data-id="<?= $floor->floor_id; ?>" href="#0">edit</a> |
                                <a href="<?= base_url('inventory/change_floor_status/'.$floor->floor_id); ?>">
                                    <?= $floor->status == 0 ? 'enable' : 'disable'; ?>
                                </a>
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
<script>
$(document).ready(function(){
    // Search filter for floors.
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#floors tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
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
});
</script>
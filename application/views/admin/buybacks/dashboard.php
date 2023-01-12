<div class="jumbotron jumbotron-fluid text-white" style="background-color: crimson;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Dashboard &raquo; Buybacks |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Home</a><br>
                <a target="_blank" href="<?= base_url('careers'); ?>" class="btn btn-outline-light btn-lg btn-block">Careers</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mb-3">
    <?php if($success = $this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>
    <?php if($failed = $this->session->flashdata('failed')): ?>
        <div class="alert alert-danger"><?= $failed; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-4">
            <legend class="font-weight-light">Initiate a Request</legend>
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('admin/initiate_request'); ?>" method="post">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Customer name...">
                        </div>
                        <div class="form-group">
                            <input name="cnic" type="number" class="form-control" id="exampleInputCnic1" placeholder="Customer CNIC...">
                        </div>
                        <div class="form-group">
                            <select name="agent" class="form-control">
                                <option value="" disabled selected>Select Agent</option>
                                <?php if(!empty($agents)): foreach($agents as $agent): ?>
                                    <option value="<?= $agent->emp_code; ?>"><?= $agent->emp_city.', '.$agent->emp_name; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="project" class="form-control">
                                <option value="" disabled selected>Select Project</option>
                                <?php $projects = array('091 Mall', 'MoH', 'North Hills', 'Florenza', 'AH Towers'); ?>
                                <?php foreach($projects as $project): ?>
                                    <option value="<?= $project; ?>"><?= $project; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" name="investment_date" class="form-control" title="Investment Date...">
                            <small class="help-text text-muted">Date of Investment</small>
                        </div>
                        <div class="form-group">
                            <input type="number" name="investment_amount" class="form-control" placeholder="Investment Amount...">
                        </div>
                        <div class="form-group">
                            <input type="number" name="refund_amount" class="form-control" placeholder="Refund Amount...">
                        </div>
                        <div class="form-group">
                            <textarea name="buyback_reason" class="form-control" rows="3" placeholder="Reason for buyback..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit Request</button>
                        <button type="reset" class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <legend class="font-weight-light">Recently Requested</legend>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Invested</th>
                                <th>Refund</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($buybacks)): foreach($buybacks as $bb): ?>
                            <tr>
                                <td><?= $bb->id; ?></td>
                                <td><?= $bb->customer_name; ?></td>
                                <td><?= number_format($bb->investment_amount); ?></td>
                                <td><?= number_format($bb->refund_amount); ?></td>
                                <td><?= date('M d, Y', strtotime($bb->created_at)); ?></td>
                                <td>
                                    <a href="<?= base_url('admin/request_detail/'.$bb->id); ?>">detail</a> | <a href="">delete</a>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
                <?= $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-right">
            <small>Buybacks - AH Group of Companies Pvt. Ltd. <?= date('Y'); ?></small>
        </div>
    </div>
</div>
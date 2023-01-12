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
            <div class="row">
                <div class="col-md-7">
                    <legend class="font-weight-light">Request Detail</legend>
                </div>
                <div class="col-md-5 text-right">
                    <button data-toggle="modal" data-target="#upload_docs" class="btn btn-outline-secondary btn-sm">Upload Documents</button>
                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Request Status
                    <span class="<?= $request_detail->status == 0 ? 'badge badge-warning badge-pill' : 'badge badge-info badge-pill'; ?>"><?= $request_detail->status == 0 ? 'Pending' : 'Processed'; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Reqeusted By
                    <span class="font-weight-bold"><?= $request_detail->customer_name; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Requester CNIC
                    <span class="font-weight-bold"><?= $request_detail->customer_cnic; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Project
                    <span class="font-weight-bold"><?= $request_detail->project; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Agent Name
                    <span class="font-weight-bold"><?= $request_detail->emp_name; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Investment Amount
                    <span class="font-weight-bold"><?= number_format($request_detail->investment_amount); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Refund Amount
                    <span class="font-weight-bold"><?= number_format($request_detail->refund_amount); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Date Requested
                    <span class="font-weight-bold"><?= date('M d, Y', strtotime($request_detail->created_at)); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Refund Reason
                    <span class="font-weight-bold" title="<?= $request_detail->refund_reason; ?>"><?= substr($request_detail->refund_reason, 0, 70); ?></span>
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <legend class="font-weight-light">Recently Uploaded Documents</legend>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Document</th>
                                <th>Remarks</th>
                                <th>Processed By</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($buyback_logs)): foreach($buyback_logs as $bb_logs): ?>
                            <tr>
                                <td><?= $bb_logs->id; ?></td>
                                <td><a target="_blank" href="<?= base_url('uploads/buyback_docs/'.$bb_logs->document_name); ?>"><?= $bb_logs->document_name; ?></a></td>
                                <td title="<?= $bb_logs->remarks; ?>"><?= substr($bb_logs->remarks, 0, 25).'...'; ?></td>
                                <td><?= $bb_logs->fullname; ?></td>
                                <td><?= date('M d, Y', strtotime($bb_logs->created_at)); ?></td>
                                <td>
                                    <a href="<?= base_url('admin/request_detail/'.$bb_logs->id); ?>">detail</a> | <a href="">delete</a>
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

<!-- Modal -->
<div class="modal fade" id="upload_docs" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form action="<?= base_url('admin/upload_documents'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="request_id" value="<?= $request_detail->id; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Upload Documents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Document</label>
                        <input type="file" name="document_name" class="form-control-file" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Write something here..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status Flag</label>
                        <select name="status_flag" class="form-control">
                            <option value="" disabled selected>Select status</option>
                            <option value="1">Processed</option>
                            <option value="2">Approved</option>
                            <option value="3">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
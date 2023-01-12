<div class="jumbotron jumbotron-fluid text-white" style="background-color: crimson;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Inventory &raquo; <?= $project->name; ?> | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
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
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-md-4">
            <small class="help-text text-muted">Hover over the document name to find out the type of doucment.</small>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Name
                    <span class=""><?= $project->name; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Slug
                    <span class=""><?= $project->slug; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Location
                    <span class=""><?= $project->location; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    No. of Floors
                    <span class=""><?= $project->no_of_floors; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Date Added
                    <span class=""><?= date('M d, Y', strtotime($project->created_at)); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Documents</strong>
                    <span>Legal, General</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php if(!empty($docs)): foreach($docs as $doc): ?>
                        <a title="<?= $doc->doc_type; ?>" target="_blank" href="<?= base_url('uploads/project_docs/'.$doc->doc_name); ?>"><?= $doc->doc_name; ?></a>
                    <?php endforeach; else: echo 'N/A'; endif; ?>
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <form action="<?= base_url('inventory/upload_project_docs'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="project_id" value="<?= $project->id; ?>">
                <div class="form-group">
                    <legend>Project Description</legend>
                    <p><?= $project->project_description; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="document">Project Documents</label>
                    <input type="file" name="document_name" class="form-control-file form-control">
                    <small class="help-text text-muted">Files with the extension of .pdf or .docx are allowed only.</small>
                </div>
                <div class="form-group">
                    <label for="doc_type">Document Type</label>
                    <select name="doc_type" class="custom-select">
                        <option value="" disabled selected>Document Type</option>
                        <option value="Legal">Legal</option>
                        <option value="General">General</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="javascript:history.go(-1)" class="btn btn-danger">Cancel</a>
            </form>
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
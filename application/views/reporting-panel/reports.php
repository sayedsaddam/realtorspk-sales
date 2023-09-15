<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="display-4 font-weight-bold">Reporting Panel |<small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    You're logged in as: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign
                        Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Dashboard</a>
                <a href="#0" class="btn btn-outline-light btn-lg btn-block">Team Report</a>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($reports)) : ?>
    <div class="container">
        <div class="row">
            <div class="col-7 mb-4">
                <h3 class="mb-0">Revenue Detail</h3>
                <span class="text-secondary font-weight-light d-print-none">About
                    <?= count($reports) . ' results in {elapsed_time} seconds'; ?></span>
            </div>
            <div class="col-md-5">
                <h3 class="mb-0">Team Detail</h3>
                <a href="#0" onclick="window.print()" class="d-print-none text-secondary font-weight-light">Print</a>
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                <table class="table table-reponsive table-sm">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Agent Name</th>
                            <th>Revenue</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reports)) :
                            $total_agents = 0;
                            $total_revenue = 0;
                            foreach ($reports as $rep) : // @foreach
                                $total_revenue += $rep->received_amount;
                                $total_agents++; ?>
                                <tr>
                                    <td><?= $rep->emp_code; ?></td>
                                    <td><?= $rep->emp_name; ?></td>
                                    <td><?= number_format($rep->received_amount); ?></td>
                                    <td><?= $rep->gender == 'm' ? 'Male' : 'Female'; ?></td>
                                </tr>
                        <?php endforeach;
                            echo '<tr class="table-success"><th>Total</th><th><small>No. of agents, </small> ' . $total_agents . '.</th><th colspan="3">' . number_format($total_revenue) . '</th></tr>';
                        else : echo '<tr class="table-danger"><td colspan="5" align="center">No record found.</td></tr>';
                        endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th>Team</th>
                            <td><?= $reports[0]->team_name; ?></td>
                        </tr>
                        <tr>
                            <th>Manager</th>
                            <td><?= $reports[0]->bdm_name; ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?= $reports[0]->emp_city; ?></td>
                        </tr>
                        <tr>
                            <th>Date Range</th>
                            <td><?= date('M d, Y', strtotime($_GET['date_from'])) . ' to ' . date('M d, Y', strtotime($_GET['date_to'])); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php elseif (!empty($bcm_reports)) : ?>
    <div class="container">
        <div class="row">
            <div class="col-8 mb-4">
                <h3 class="mb-0">Revenue Detail</h3>
                <span class="text-secondary font-weight-light">About
                    <?= count($bcm_reports) . ' results in {elapsed_time} seconds'; ?></span>
            </div>
            <div class="col-4 mb-4">
                <h3 class="mb-0">Manager's Detail</h3>
                <a href="#0" onclick="window.print()" class="d-print-none text-secondary font-weight-light">Print</a>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <table class="table table-reponsive table-sm">
                    <thead>
                        <tr>
                            <th title="Employee code">Code</th>
                            <th>Team</th>
                            <th>Revenue</th>
                            <th>Project</th>
                            <th>Rec Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bcm_reports)) :
                            $total_revenue = 0;
                            foreach ($bcm_reports as $rep) : // @foreach
                                $total_revenue += $rep->rec_amount; ?>
                                <tr>
                                    <td><?= $rep->agent_id; ?></td>
                                    <td><?= $rep->team_name; ?></td>
                                    <td><?= number_format($rep->rec_amount); ?></td>
                                    <td><?= $rep->project; ?></td>
                                    <td><?= date('M d, Y', strtotime($rep->rec_date)); ?></td>
                                </tr>
                        <?php
                            endforeach;
                            echo '<tr class="table-success"><th colspan="3">Total</th><th colspan="3">' . number_format($total_revenue) . '</th></tr>';
                        else : echo '<tr class="table-danger"><td colspan="3" align="center">No record found.</td></tr>';
                        endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th>BCM</th>
                            <td><?= $bcm_reports[0]->team_lead; ?></td>
                        </tr>
                        <tr>
                            <th>No. of Sales</th>
                            <td><?= count($bcm_reports); ?></td>
                        </tr>
                        <tr>
                            <th>Lead</th>
                            <td>
                                <?php if ($bcm_reports[0]->team_lead == 'BCM-I') {
                                    echo 'Muhammad Akbar Arbab';
                                } elseif ($bcm_reports[0]->team_lead == 'BCM-II') {
                                    echo 'Obaid ur Rehman';
                                } elseif ($bcm_reports[0]->team_lead == 'BCM-III') {
                                    echo 'Aimal Khattak';
                                } else {
                                    echo '--';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Date Range</th>
                            <td><?= date('M d, Y', strtotime($_GET['date_from'])) . ' to ' . date('M d, Y', strtotime($_GET['date_to'])); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php elseif (!empty($agent_report)) : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 mb-4">
                <h3 class="mb-0">Revenue Detail</h3>
                <span class="text-secondary font-weight-light d-print-none">About
                    <?= count($agent_report) . ' results in {elapsed_time} seconds'; ?></span>
            </div>
            <div class="col-md-5">
                <h3 class="mb-0">Agent Detail</h3>
                <a href="#0" onclick="window.print()" class="d-print-none text-secondary font-weight-light">Print</a>
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                <table class="table table-reponsive table-sm">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Rec Date</th>
                            <th>Added By</th>
                            <th>Revenue</th>
                            <th>Rebate</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($agent_report)) :
                            $total_revenue = 0;
                            $total_rebate = 0;
                            foreach ($agent_report as $rep) : // @foreach 
                        ?>
                                <tr>
                                    <td><?= $rep->project; ?></td>
                                    <td><?= date('M d, Y', strtotime($rep->rec_date)); ?></td>
                                    <td><?= $rep->fullname; ?></td>
                                    <td><?= number_format($rep->rec_amount); ?></td>
                                    <td><?= $rep->rebate . '%'; ?></td>
                                    <td><?= number_format($rebate = $rep->rebate * $rep->rec_amount / 100); ?></td>
                                </tr>
                        <?php $total_revenue += $rep->rec_amount;
                                $total_rebate += $rebate;
                            endforeach;
                            echo '<tr class="table-success"><th colspan=3">Total</th<th>' . '</th><th colspan="2">' . number_format($total_revenue) . '</th><th>' . number_format($total_rebate) . '</th></tr>';
                        else : echo '<tr class="table-danger"><td colspan="5" align="center">No record found.</td></tr>';
                        endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th>Name & Code</th>
                            <td><?= $agent_report[0]->emp_name . ', ' . $agent_report[0]->emp_code; ?></td>
                        </tr>
                        <tr>
                            <th>Team</th>
                            <td><?= $agent_report[0]->team_name; ?></td>
                        </tr>
                        <tr>
                            <th>Monthly Target</th>
                            <td><?php if ($agent_report[0]->emp_name == $agent_report[0]->bdm_name) {
                                    echo '6,000,000';
                                } elseif ($agent_report[0]->emp_name == $agent_report[0]->team_lead) {
                                    echo '10,000,000';
                                } else {
                                    echo '3,000,000';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Office</th>
                            <td><?= $agent_report[0]->office; ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?= $agent_report[0]->emp_city; ?></td>
                        </tr>
                        <tr>
                            <th>Date Range</th>
                            <td><?= date('M d, Y', strtotime($_GET['date_from'])) . ' - ' . date('M d, Y', strtotime($_GET['date_to'])) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php elseif (!empty($project_report)) : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <h3 class="">Project Detail</h3>
            </div>
            <div class="col-md-5 text-right">
                <a href="#0" onclick="window.print()" class="d-print-none btn btn-outline-secondary">Print</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th>Project</th>
                            <td><?= $project_report[0]->project; ?></td>
                            <th>Location</th>
                            <td><?php if ($project_report[0]->project == '091 Mall' || $project_report[0]->project == 'AH Towers' || $project_report[0]->project == 'Florenza') {
                                    echo 'Peshawar';
                                } elseif ($project_report[0]->project == 'MoH') {
                                    echo 'Hangu';
                                } elseif ($project_report[0]->project == 'North Hills') {
                                    echo 'Murree';
                                } elseif ($project_report[0]->project == 'AH City') {
                                    echo 'D. I Khan';
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <th>No. of Sales</th>
                            <td><?= count($project_report); ?></td>
                            <th>Date Range</th>
                            <td><?= date('M d, Y', strtotime($_GET['date_from'])) . ' - ' . date('M d, Y', strtotime($_GET['date_to'])) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-0">Revenue Detail</h3>
                <span class="text-secondary font-weight-light d-print-none">About
                    <?= count($project_report) . ' results in {elapsed_time} seconds'; ?></span>
                <table class="table table-reponsive table-sm">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th title="Employee location">Location</th>
                            <th>Team</th>
                            <th>Rec Date</th>
                            <th>Revenue</th>
                            <th>Rebate %</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($project_report)) :
                            $total_revenue = 0;
                            $total_rebate = 0;
                            foreach ($project_report as $rep) : // @foreach 
                        ?>
                                <tr>
                                    <td><?= $rep->emp_code; ?></td>
                                    <td><?= $rep->emp_name; ?></td>
                                    <td><?= $rep->emp_city; ?></td>
                                    <td><?= $rep->team_name; ?></td>
                                    <td><?= date('M d, Y', strtotime($rep->rec_date)); ?></td>
                                    <td><?= number_format($rep->rec_amount); ?></td>
                                    <td><?= $rep->rebate . '%'; ?></td>
                                    <td><?= number_format($rep->rebate * $rep->rec_amount / 100); ?></td>
                                </tr>
                        <?php $total_revenue += $rep->rec_amount;
                                $total_rebate += $rep->rec_amount * $rep->rebate / 100;
                            endforeach;
                            echo '<tr class="table-success"><th colspan="5">Total</th<th>' . '</th><th colspan="2">' . number_format($total_revenue) . '</th><th>' . number_format($total_rebate) . '</th></tr>';
                        else : echo '<tr class="table-danger"><td colspan="5" align="center">No record found.</td></tr>';
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php elseif (!empty($overall_report)) : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mb-4">
                <h3 class="mb-0">Revenue Detail</h3>
                <span class="text-secondary font-weight-light d-print-none">About
                    <?= count($overall_report) . ' results in {elapsed_time} seconds'; ?></span>
            </div>
            <div class="col-md-4 text-right">
                <button onclick="window.print()" type="button" class="btn btn-outline-secondary d-print-none">Print</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-reponsive table-sm">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Office</th>
                            <th>Location</th>
                            <th>Team</th>
                            <th>Reveue</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($overall_report)) :
                            $total_revenue = 0;
                            $active_agents = 0;
                            $inactive_agents = 0;
                            $zeroNineOne = 0;
                            $florenza = 0;
                            $moh = 0;
                            $nh = 0;
                            $ahtower = 0;
                            $ahcity = 0;
                            foreach ($overall_report as $rep) : // @foreach 
                        ?>
                                <tr <?php if ($rep->emp_status == 0) {
                                        echo 'style="text-decoration: line-through;"';
                                    } ?>>
                                    <td><?= $rep->emp_code;; ?></td>
                                    <td><?= $rep->emp_name; ?></td>
                                    <td><?= $rep->office; ?></td>
                                    <td><?= $rep->emp_city; ?></td>
                                    <td><?= $rep->team_name; ?></td>
                                    <td><?= number_format($rep->received_amount); ?></td>
                                    <td><?= $rep->emp_status == 1 ? 'Active' : 'Inactive'; ?></td>
                                </tr>
                        <?php $total_revenue += $rep->received_amount;
                                $active_agents += $rep->emp_status == 1;
                                $inactive_agents += $rep->emp_status == 0;
                                $zeroNineOne += $rep->zero_nine_one_mall;
                                $florenza += $rep->florenza;
                                $moh += $rep->moh;
                                $nh += $rep->northHills;
                                $ahtower += $rep->ah_tower;
                                $ahcity += $rep->ah_city;
                            endforeach;
                            echo '<tr class="table-success"><th colspan="5">Total</th<th>' . '</th><th colspan="2">' . number_format($total_revenue) . '</th></tr>';
                        else : echo '<tr class="table-danger"><td colspan="6" align="center">No record found.</td></tr>';
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">Filter Detail</h3>
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th>Region</th>
                            <td><?= 'Peshawar'; ?></td>
                            <th>Total Agents</th>
                            <td><?= count($overall_report); ?></td>
                        </tr>
                        <tr>
                            <th>Active</th>
                            <td><?= $active_agents; ?></td>
                            <th>Inactive</th>
                            <td><?= $inactive_agents; ?></td>
                        </tr>
                        <tr>
                            <th>091 Mall</th>
                            <td><?= number_format($zeroNineOne); ?></td>
                            <th>Florenza</th>
                            <td><?= number_format($florenza); ?></td>
                        </tr>
                        <tr>
                            <th>Mall of Hangu</th>
                            <td><?= number_format($moh); ?></td>
                            <th>North Hills</th>
                            <td><?= number_format($nh); ?></td>
                        </tr>
                        <tr>
                            <th>AH Tower</th>
                            <td><?= number_format($ahtower); ?></td>
                            <th>AH City</th>
                            <td><?= number_format($ahcity); ?></td>
                        </tr>
                        <tr>
                            <th>Date Range</th>
                            <td colspan="3">
                                <?= date('M d, Y', strtotime($_GET['date_from'])) . ' to ' . date('M d, Y', strtotime($_GET['date_to'])) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h3 class="mb-2">Information</h3>
                <p>The rows with strike-through line indicate the resigned / terminated employees. Dates are not shown as
                    the amounts printed are summed, not individual.</p>
            </div>
        </div>
    </div>
<?php elseif (!empty($city_report)) : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h3 class="mb-0">
                    Sales report of
                    <?= strtoupper($_GET['city']) . ' from ' . date('M d, Y', strtotime($_GET['date_from'])) . ' to ' . date('M d, Y', strtotime($_GET['date_to'])); ?>
                </h3>
                <span class="text-secondary font-weight-light d-print-none">About
                    <?= count($city_report) . ' results in {elapsed_time} seconds'; ?></span>
            </div>
        </div>
        <div class="row" id="filtered_records" style="width: 100%; overflow-x: auto;">

            <table id="tableCityReport" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <!-- Add table headers here -->
                    <tr>
                        <?php foreach ($columns as $column) : ?>
                            <th><?= $column ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add table rows here -->
                    <?php foreach ($city_report as $row) : ?>
                        <tr>
                            <?php foreach ($columns as $column) : ?>
                                <td><?= $row[$column] ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total
                        </th>
                        <?php foreach ($columns as $column) : if ($column == end($columns)) break; ?>

                            <th></th>
                        <?php endforeach; ?>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
<?php elseif (!empty($zonal_report)) : ?>
    <div class="container">
        <div class="row">
            <div class="col-8 mb-4">
                <h3 class="mb-0">Revenue Detail</h3>
                <span class="text-secondary font-weight-light d-print-none">About
                    <?= count($zonal_report) . ' results in {elapsed_time} seconds'; ?></span>
            </div>
            <div class="col-4 mb-4">
                <h3 class="mb-0">Manager's Detail</h3>
                <a href="#0" onclick="window.print()" class="d-print-none text-secondary font-weight-light">Print</a>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <table class="table table-reponsive table-sm">
                    <thead>
                        <tr>
                            <th title="Employee code">Code</th>
                            <th>Team</th>
                            <th>Revenue</th>
                            <th>Project</th>
                            <th>Rec Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($zonal_report)) :
                            $total_revenue = 0;
                            foreach ($zonal_report as $rep) : // @foreach
                                $total_revenue += $rep->rec_amount; ?>
                                <tr>
                                    <td><?= $rep->agent_id; ?></td>
                                    <td><?= $rep->team_name; ?></td>
                                    <td><?= number_format($rep->rec_amount); ?></td>
                                    <td><?= $rep->project; ?></td>
                                    <td><?= date('M d, Y', strtotime($rep->rec_date)); ?></td>
                                </tr>
                        <?php
                            endforeach;
                            echo '<tr class="table-success"><th colspan="4">Total</th><th colspan="3">' . number_format($total_revenue) . '</th></tr>';
                        else : echo '<tr class="table-danger"><td colspan="3" align="center">No record found.</td></tr>';
                        endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th>Manager</th>
                            <td><?= $_GET['zonal'] == 'zm1' ? 'Nasir Jalil' : 'Obaid ur Rehman'; ?></td>
                        </tr>
                        <tr>
                            <th>No. of Sales</th>
                            <td><?= count($zonal_report); ?></td>
                        </tr>
                        <tr>
                            <th>Date Range</th>
                            <td><?= date('M d, Y', strtotime($_GET['date_from'])) . ' to ' . date('M d, Y', strtotime($_GET['date_to'])); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <h1><span class="display-1">Whoopsie!</span> Result was not found.</h1>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function() {
        var totalColumns = <?php echo $total_columns; ?>;
        console.log('Total columns: ' + totalColumns);
        var footers = <?php echo json_encode($footers); ?>;
        var cols = <?php echo json_encode($columns); ?>;
        for (var i = 2; i < cols.length; i++) {
            console.log("value of footer " + cols[i] + " is " + footers[cols[i]]);

        }

        // Define the intVal function to convert values to integers
        var intVal = function(j) {
            return typeof j === 'string' ?
                j.replace(/[\$,]/g, '') * 1 :
                typeof j === 'number' ?
                j : 0;
        };



        // Initialize DataTable
        var dataTable = $('#tableCityReport').DataTable({
            searching: true,
            paging: false,
            "autoWidth": false,
            "columnDefs": [{
                "width": "100px",
                "targets": "_all"
            }],
            dom: 'Bfrtip',
            buttons: ['pdf', 'excel', {
                extend: 'print',
                title: '',
                footer: 'ture',
                customize: function(win) {
                    // Check if the current page is the last page
    var totalPages = dataTable.page.info().pages;
    var currentPage = dataTable.page.info().page;
    $(win.document.body).find('tfoot').remove();

    if (currentPage === (totalPages - 1)) {
        // Create a custom row for the body with values from the footers variable
        var customRow = '<tr style="font-weight: bold;">';

        for (let i = 0; i < cols.length; i++) {
            if(i==0){
                customRow +=
                                '<th>Total</th>';
            }            
            else if (i == 1) {
                            console.log("footer[i] is " + footers[i]);
                            customRow +=
                                '<th></th>'; // Leave an empty cell for columns with footers
                        } else {
                            // Calculate the sum for the current page of each column
                            var columnSum = dataTable.column(i, {
                                page: 'all'
                            }).data().reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                            customRow +=
                                '<td>' + columnSum +
                                '</td>'; // Display the sum in the footer
                        }
                    }

        customRow += '</tr>';

        // Append the custom row to the table body
        $(win.document.body).find('table tbody').append(customRow);
    }
                },
                exportOptions: {
                    columns: ':visible'
                }
            }],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                console.log(totalColumns);
                for (let i = 2; i < totalColumns; i++) {
                    // Calculate the sum for the third column (index 2)
                    var columnSum = api
                        .column(i, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update the footer cell with the sum
                    $(api.column(i).footer()).html(columnSum);
                }
            }


        });

        // Assigning targets
        $('#city').on('change', function() {
            var filterByCity = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>admin / get_sales_agents / ' + filterByCity,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    filterByCity: filterByCity
                },
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $('#agents').html('');
                        $('#agents').append(
                            '<option value="" selected disabled>--select agent--</option>'
                        );
                        $.each(data, function(index, item) {
                            $('#agents').append(
                                `<option value="${item.emp_code}">${item.emp_name}</option>`
                            );
                        });
                    }
                }
            });
        });

    });
</script>
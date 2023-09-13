<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * className: Reporting_panel
 * filePath: controllers
 * Author: Saddam
 */
class Reporting_panel extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model(array('reporting_model', 'admin_model', 'home_model', 'booking_model'));
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
    }
    // Index method > responsible for loading the main page for navigation acorss different modules
    public function index(){
        $data['title'] = 'Reporting Home > AH Group';
        $data['content'] = 'reporting-panel/reporting-home';
        $data['locations'] = $this->reporting_model->get_locations();
        $data['teams'] = $this->admin_model->get_sales_teams();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Get team report
    public function team_report(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $team = $this->input->get('team'); // Team ID
        $data['title'] = 'Team Report > Reporting > AH Group';
        $data['content'] = 'reporting-panel/reports';
        $data['reports'] = $this->reporting_model->get_team_report($date_from, $date_to, $team);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Get team lead / BCM report
    public function bcm_report(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $team_lead = $this->input->get('team_lead'); // Team ID
        $data['title'] = 'BCM Report > Reporting > AH Group';
        $data['content'] = 'reporting-panel/reports';
        $data['bcm_reports'] = $this->reporting_model->get_bcm_report($date_from, $date_to, $team_lead);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Get agent report > single agent
    public function agent_report(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $agent = $this->input->get('agent'); // Agent ID
        $data['title'] = 'Agent Report > Reporting > AH Group';
        $data['content'] = 'reporting-panel/reports';
        $data['agent_report'] = $this->reporting_model->get_agent_report($date_from, $date_to, $agent);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Project report
    public function project_report(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $project = $this->input->get('project'); // Project ID
        $data['title'] = 'Project Report > Reporting > AH Group';
        $data['content'] = 'reporting-panel/reports';
        $data['project_report'] = $this->reporting_model->get_project_report($date_from, $date_to, $project);
        // header('Content-Type: application/json');
        // echo json_encode($data['project_report']);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Overall report
    public function overall_report(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $data['title'] = 'Overall Report > Reporting > AH Group';
        $data['content'] = 'reporting-panel/reports';
        $data['overall_report'] = $this->reporting_model->get_overall_report($date_from, $date_to);
        $this->load->view('admin/commons/admin_template', $data);
    }
	// City report
    public function city_report(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $city = $this->input->get('city');
        $data['title'] = 'City Report > Reporting > AH Group';
        $data['content'] = 'reporting-panel/reports';
        $val = $this->reporting_model->get_city_report($date_from, $date_to, $city);
        //$data['city_report'] = $this->reporting_model->get_city_report($date_from, $date_to, $city);

        $month_to = date('m', strtotime($date_to));
        $month_from = date('m', strtotime($date_from));
        $year_to = date('Y', strtotime($date_to)); // Use uppercase 'Y' for the full year (4 digits)
        $year_from = date('Y', strtotime($date_from)); // Use uppercase 'Y' for the full year (4 digits)


        $dat = array();

        // Initialize an empty array to store month-year combinations
        $monthYearColumns = array('Name','code');
        $footer = array('Total','');

        $startDate = new DateTime("$year_from-$month_from-01");
        $endDate = new DateTime("$year_to-$month_to-01");

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $columnLabel = $currentDate->format('M Y');
            array_push($monthYearColumns, $columnLabel);
            $currentDate->add(new DateInterval('P1M')); // Increment by one month
        }
        array_push($monthYearColumns,"Total");


        // Access employee data (assuming $val contains the data)
        foreach ($val as $employee) {
            // Initialize an associative array for this employee
            $employeeData = array();
            $emp_code = $employee['emp_code'];
            $total_sale=0;

            if (!isset($employeeData[$emp_code])) {

                // Access common employee information
                $employeeData['code'] = $employee['emp_code'];
                $employeeData['Name'] = $employee['emp_name'];
                }
            // Loop through the months array for each employee
            foreach ($employee['months'] as $monthData) {
                $columnLabel = $monthData['rec_month'] . ' ' . $monthData['rec_year'];
                if($monthData['received_amount']>0)
                {$employeeData[$columnLabel] = $monthData['received_amount'];
                    $total_sale+=$monthData['received_amount'];
                    if (!isset($footer[$columnLabel])) {
                        $footer[$columnLabel]=0;
                        }
                    $footer[$columnLabel] +=$monthData['received_amount'];
                }
            }
            

            // Fill missing months with zero
            foreach ($monthYearColumns as $columnLabel) {
                if (!isset($employeeData[$columnLabel])) {
                   $employeeData[$columnLabel] = 0;
                }
                if($columnLabel=="Total"){
                    $employeeData["Total"]=$total_sale;
                }
                if (!isset($footer[$columnLabel])&&$columnLabel!='Name'&&$columnLabel!='code'&&$columnLabel!='Total') {
                    $footer[$columnLabel]=0;
                    }   
            }

            $dat[$employee['emp_code']]=$employeeData;
            }
            //echo '<pre>'; print_r($dat); exit;
            $data['city_report']=$dat;
            $data['columns']=$monthYearColumns;
            $data['total_columns'] =count($monthYearColumns);
            $data['footers']=$footer;
            //echo '<pre>';print_r($footer);exit;
        //exit;
        $this->load->view('admin/commons/admin_template', $data);
    }
	// Zonal managers' report
    public function zonal_report(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $zonal = $this->input->get('zonal');
        $data['title'] = 'Zonal Report > Reporting > AH Group';
        $data['content'] = 'reporting-panel/reports';
        $data['zonal_report'] = $this->reporting_model->get_zonal_report($date_from, $date_to, $zonal);
        // echo '<pre>'; print_r($data['zonal_report']); exit;
        $this->load->view('admin/commons/admin_template', $data);
    }
    // region summary
    public function region_summary(){
        $data['title'] = 'Region Summary > Reporting > AH Group';
        $data['content'] = 'sales-summary/region-summary';
        $data['daily_sales_psh'] = $this->admin_model->get_daily_sales_peshawar();
        $data['daily_sales_hangu'] = $this->admin_model->get_daily_sales_hangu();
        $data['daily_sales_kohat'] = $this->admin_model->get_daily_sales_kohat();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // projects summary report
    public function projects_summary(){
        $data['title'] = 'Projects Summary > Reporting > AH Group';
        $data['content'] = 'sales-summary/projects-summary';
        $data['projects'] = $this->reporting_model->projects_summary();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // projects summary report > Peshawar
    public function projects_summary_city($city){
        $data['title'] = "Projects Summary, $city > Reporting > AH Group";
        $data['content'] = 'sales-summary/projects-summary';
        $data['projects'] = $this->reporting_model->projects_summary_city($city);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Annual summary report
    public function annual_summary($city){
        $data['title'] = 'Annual Summary > Reporting > AH Group';
        $data['content'] = 'sales-summary/annual-summary';
        $data['targets'] = $this->reporting_model->annual_summary_targets($city);
        $data['sales'] = $this->reporting_model->annual_summary_sales($city);
        $data['city'] = $data['targets'][0]->emp_city;
        $this->load->view('admin/commons/admin_template', $data);
    }
    // charts
    public function charts(){
        $data['title'] = 'Charts > Reporting Panel';
        $data['content'] = 'reporting-panel/charts';
        $projects = $this->reporting_model->projects_summary_chart();
        $data['projects'] = json_encode($projects);
        $regions = $this->reporting_model->region_summary_chart();
        $data['regions'] = json_encode($regions);
        $bcms = $this->reporting_model->bcms_summary_chart();
        $data['bcms'] = json_encode($bcms);
        $locations = $this->reporting_model->location_summary_chart();
        $data['locations'] = json_encode($locations);
        $this->load->view('admin/commons/admin_template', $data);
    }
        // agent stats
    public function agent_stats($city){
        $data['title'] = 'Agent Stats > Reporting Panel';
        $data['content'] = 'reporting-panel/agent-stats';
        $data['sales'] = $this->reporting_model->agent_stats($city);
        $this->load->view('admin/commons/admin_template', $data);
    }
}
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
}

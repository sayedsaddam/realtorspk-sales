<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * className: Reporting_model
 * filePath: models
 * author: Saddam
 */
class Reporting_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    // Filter records between two dates for a single sales agent.
    public function get_agent_report($date_from, $date_to, $agent){
        $this->db->select('daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.project,
                            daily_sales.rebate,
                            users.id as user_id,
                            users.fullname,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            employees.office,
                            teams.team_name,
                            teams.bdm_name,
                            teams.team_lead');
        $this->db->from('daily_sales');
        $this->db->join('users', 'daily_sales.added_by = users.id', 'inner');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'inner');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        // $this->db->like(array('daily_sales.rec_date' => date('Y-m', strtotime($date)), 'employees.emp_city' => $city));
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to, 'daily_sales.agent_id' => $agent, 'daily_sales.rec_amount >' => 0));
        $this->db->order_by('daily_sales.rec_date', 'DESC');
        return $this->db->get()->result();
    }
    // Get project report
    // Filter records by month and city.
    public function get_project_report($date_from, $date_to, $project){
        $this->db->select('daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            SUM(rec_amount) as received_amount,
                            daily_sales.project,
                            daily_sales.rebate,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            employees.office,
                            teams.team_name');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'inner');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        // $this->db->like(array('daily_sales.rec_date' => date('Y-m', strtotime($date)), 'employees.emp_city' => $city));
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to, 'daily_sales.project' => $project));
        $this->db->where('daily_sales.rec_amount >', 0);
        $this->db->group_by('daily_sales.agent_id');
        $this->db->order_by('received_amount', 'DESC');
        return $this->db->get()->result();
    }
    // Get teams report
    public function get_team_report($date_from, $date_to, $team){ // $team => Team ID in sales table.
        $this->db->select('teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name,
                            employees.emp_name,
                            employees.emp_code,
                            employees.emp_team,
                            employees.emp_city,
                            employees.gender,
                            SUM(rec_amount) as received_amount,
                            daily_sales.id');
        $this->db->from('teams');
        $this->db->join('daily_sales', 'teams.team_id = daily_sales.team');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code');
        // $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id');
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to, 'daily_sales.team' => $team));
        $this->db->group_by('daily_sales.agent_id');
        // $this->db->group_by('targets.target_month');
        // $this->db->like('targets.target_month', date('F, Y', strtotime($date_from)));
        $this->db->order_by('received_amount', 'DESC');
        // echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query(); exit;
        return $this->db->get()->result();
    }
    // Get BCM report > Team lead
    public function get_bcm_report($date_from, $date_to, $team_lead){ // $team_lead => team_id sales table.
        $this->db->select('teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name,
                            daily_sales.rec_amount,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.project');
        $this->db->from('teams');
        $this->db->join('daily_sales', 'teams.team_id = daily_sales.team', 'left');
        // $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id');
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to, 'teams.team_lead' => $team_lead));
        // $this->db->where('targets.target_month', date('F, Y', strtotime($date_from)));
        $this->db->group_by('daily_sales.id');
        $this->db->order_by('daily_sales.rec_date', 'DESC');
        // echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query(); exit;
        return $this->db->get()->result();
    }
    // Filter records between two dates.
    public function get_overall_report($date_from, $date_to){
        $this->db->select('daily_sales.agent_id,
                            SUM(if(project="091 Mall", rec_amount, 0)) as zero_nine_one_mall,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="North Hills", rec_amount, 0)) as northHills,
                            SUM(IF(project="AH Towers", rec_amount, 0)) as ah_tower,
                            SUM(IF(project="AH City", rec_amount, 0)) as ah_city,
                            SUM(rec_amount) as received_amount,
                            daily_sales.project,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            employees.office,
                            employees.emp_status,
                            teams.team_name');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'inner');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        // $this->db->like(array('daily_sales.rec_date' => date('Y-m', strtotime($date)), 'employees.emp_city' => $city));
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to));
        // $this->db->where('daily_sales.rec_amount >', 0);
        $this->db->group_by('daily_sales.agent_id');
        $this->db->order_by('received_amount', 'DESC');
        return $this->db->get()->result();
    }
    // Filter records by target
    public function get_city_report($date_from, $date_to, $city){
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));
        $this->db->select('SUM(daily_sales.rec_amount) as received_amount,
                            MONTHNAME(daily_sales.rec_date) as rec_month,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.doj,
                            employees.emp_status');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
        $this->db->where(array('daily_sales.rec_date >=' => $from, 'daily_sales.rec_date <=' => $to));
        $this->db->where('employees.emp_city', $city);
        $this->db->group_by('daily_sales.agent_id');
        $this->db->group_by('MONTH(daily_sales.rec_date)');
        // $this->db->order_by('received_amount');
        // $this->db->order_by('received_amount', 'DESC');
        $results = $this->db->get()->result();
        $formattedResults = array();
        foreach ($results as $result){
            $empCode = $result->emp_code;
            if (!isset($formattedResults[$empCode])) {
                $formattedResults[$empCode] = array(
                    'months' => array(),
                    'emp_code' => $result->emp_code,
                    'emp_name' => $result->emp_name,
                    'emp_city' => $result->emp_city,
                    'doj' => $result->doj,
                    'emp_status' => $result->emp_status
                );
            }
            $formattedResults[$empCode]['months'][] = array(
                'received_amount' => $result->received_amount,
                'rec_month' => $result->rec_month
            );
        }
        return array_values($formattedResults);
    }
	// get zonal managers' report
	public function get_zonal_report($date_from, $date_to, $zonal){
        $zonal = '';
        $zm1 = array('BCM-I', 'BCM-II');
        $zm2 = array('BCM-III', 'BCM-IV');
		$zm3 = array('BCM-V');
		$zm4 = array('BCM-VI');
        if($this->input->get('zonal') == 'zm1'){
            $zonal = $zm1;
        }elseif($this->input->get('zonal') == 'zm2'){
            $zonal = $zm2;
        }elseif($this->input->get('zonal') == 'zm3'){
			$zonal = $zm3;
		}else{
			$zonal = $zm4;
		}
        $this->db->select('teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name,
                            daily_sales.rec_amount,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.project');
        $this->db->from('teams');
        $this->db->join('daily_sales', 'teams.team_id = daily_sales.team', 'left');
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to, 'daily_sales.rec_amount >' => 0));
        $this->db->where_in('teams.team_lead', $zonal);
        $this->db->order_by('daily_sales.rec_date', 'DESC');
        // echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query(); exit;
        return $this->db->get()->result();
    }
    // Get all projects summary
    public function projects_summary(){
        $this->db->select('SUM(if(project="091 Mall", rec_amount, 0)) as zero_nine_one_mall,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="North Hills", rec_amount, 0)) as northHills,
                            SUM(IF(project="AH Tower", rec_amount, 0)) as ah_tower,
							SUM(IF(project="AH City", rec_amount, 0)) as ah_city,
                            SUM(rec_amount) as total_amount_received,
                            daily_sales.id,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.project,
                            daily_sales.rebate,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name,
                            targets.id as target_id,
                            targets.target_month,
                            targets.emp_id,
                            targets.created_at');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->join('targets', 'employees.emp_code = targets.emp_id', 'left');
        $this->db->where(array('targets.target_month' => date('F, Y'), 'daily_sales.rec_amount >' => 0));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('total_amount_received', 'DESC');
        $this->db->group_by('daily_sales.agent_id');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    // projects summary - Filter by City name
    public function projects_summary_city($city){
        $this->db->select('SUM(if(project="091 Mall", rec_amount, 0)) as zero_nine_one_mall,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="North Hills", rec_amount, 0)) as northHills,
                            SUM(IF(project="AH Tower", rec_amount, 0)) as ah_tower,
							SUM(IF(project="AH City", rec_amount, 0)) as ah_city,
                            SUM(rec_amount) as total_amount_received,
                            daily_sales.id,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.project,
                            daily_sales.rebate,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name,
                            targets.id as target_id,
                            targets.target_month,
                            targets.emp_id,
                            targets.created_at');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->join('targets', 'employees.emp_code = targets.emp_id', 'left');
        $this->db->where(array('targets.target_month' => date('F, Y'), 'daily_sales.rec_amount >' => 0, 'employees.emp_city' => $city));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('total_amount_received', 'DESC');
        $this->db->group_by('daily_sales.agent_id');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    // annual summary report > no. of agents and targets assigned.
    public function annual_summary_targets($city){
        $this->db->select('SUM(revenue_target) as total_revenue_target,
                            count(targets.emp_id) as total_employees,
                            employees.emp_city,
                            targets.target_month');
        $this->db->from('targets');
        $this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
        $this->db->where(array('employees.emp_city' => $city));
        $this->db->like('targets.target_month', date('Y'));
        $this->db->order_by('targets.created_at', 'ASC');
        $this->db->group_by('targets.target_month');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
	// annual summary report > sales made by agents
    public function annual_summary_sales($city){
        $this->db->select('SUM(daily_sales.rec_amount) as total_amount, daily_sales.rec_date');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
        $this->db->where(array('employees.emp_city' => $city));
        $this->db->like('daily_sales.rec_date', date('Y'));
        $this->db->group_by('MONTH(daily_sales.rec_date)');
        return $this->db->get()->result();
    }
    //charts start --> report graphs
    public function projects_summary_chart(){
        $this->db->select_sum('rec_amount');
        $this->db->select('rec_date, project');
        $this->db->from('daily_sales');
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->group_by('project');
        // exit;
        return $this->db->get()->result();
    }
    // region summary for chart
    public function region_summary_chart(){
        $this->db->select('SUM(if(project="091 Mall", rec_amount, 0)) as zero_nine_one_mall,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="North Hills", rec_amount, 0)) as northHills,
                            SUM(IF(project="AH Towers", rec_amount, 0)) as ah_tower,
                            SUM(IF(project="AH City", rec_amount, 0)) as ah_city,
                            employees.emp_city');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->group_by('employees.emp_city');
        return $this->db->get()->result();
    }
    // bcms summary for chart
    public function bcms_summary_chart(){
        $this->db->select('teams.team_lead,
                            SUM(if(project="091 Mall", rec_amount, 0)) as zero_nine_one_mall,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="North Hills", rec_amount, 0)) as northHills,
                            SUM(IF(project="AH Towers", rec_amount, 0)) as ah_tower,
                            SUM(IF(project="AH City", rec_amount, 0)) as ah_city');
        $this->db->from('teams');
        $this->db->join('daily_sales', 'teams.team_id = daily_sales.team', 'left');
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->group_by('teams.team_lead');
        return $this->db->get()->result();
    }   
     // locations summary for chart
    public function location_summary_chart(){
        $this->db->select('SUM(rec_amount) as rec_amount,
                            employees.emp_city');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->group_by('employees.emp_city');
        return $this->db->get()->result();
    }

    // locations summary for chart
    public function agent_summary_chart($agent_id){
        $this->db->select('daily_sales.id,
                    daily_sales.added_by,
                    MONTHNAME(daily_sales.rec_date) as recDate,
                    daily_sales.agent_id,
                    daily_sales.rec_amount,
                    daily_sales.rec_amount,
                    SUM(rec_amount) as received_amount,
                    daily_sales.rebate,
                    daily_sales.project,
                    daily_sales.edit_reason,
                    daily_sales.created_at,
                    employees.id as emp_id,
                    employees.emp_code,
                    employees.emp_name,
                    employees.emp_city,
                    employees.office');
            $this->db->from('daily_sales');
            $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
            $this->db->where('employees.id', $agent_id);
            $this->db->like('daily_sales.rec_date', date('Y'));
            $this->db->group_by('MONTH(daily_sales.rec_date)');
            return $this->db->get()->result();
    }
    // agent stats
    public function agent_stats($city){
        $this->db->select('SUM(rec_amount) as revenue,
                            daily_sales.id,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            employees.emp_code,
                            employees.emp_name,
                            targets.revenue_target as target');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id', 'left');
        $this->db->where(array('target_month' => date('F, Y'), 'employees.emp_city' => $city));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('revenue', 'DESC');
        $this->db->group_by('daily_sales.agent_id');
        return $this->db->get()->result();
    }
        //get locations
        public function get_locations(){
            return $this->db->select('id, name')->get('locations')->result();
        }
}

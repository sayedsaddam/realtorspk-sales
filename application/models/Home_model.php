<?php defined('BASEPATH') OR exit('No direct script access allowed!');
class Home_model extends CI_Model{
    //public $realtors; // inialize variable to load the database.
    function __construct(){
        parent::__construct();
        //$this->realtors = $this->load->database('realtors', TRUE); // load the database for public use.
    }
    // Daily sales login
    public function get_access($username, $password){
        $this->db->select('id, username, fullname, password, department');
        $this->db->from('users');
        $this->db->where(array('username' => $username, 'password' => $password));
        return $this->db->get()->row();
    }
    // Get daily sales and display them on the website's front - Peshawar.
    public function get_daily_sales(){
        $this->db->select('SUM(IF(project="091 Mall", rec_amount, 0)) as zero_nine_one,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="AH Tower", rec_amount, 0)) as aht,
							SUM(IF(project="North Hills", rec_amount, 0)) as nh,
							SUM(IF(project="MoH", rec_amount, 0)) as moh,
							SUM(IF(project="AH City", rec_amount, 0)) as ahc,
							SUM(IF(project="AH Residencia", rec_amount, 0)) as ahr,
                            SUM(rec_amount) as received_amount,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.project,
                            daily_sales.created_at,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
							employees.gender,
							employees.emp_city,
                            employees.emp_team,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target');
        $this->db->from('targets');
        $this->db->join('employees', 'employees.emp_code = targets.emp_id', 'left');
        $this->db->join('daily_sales', 'targets.emp_id = daily_sales.agent_id', 'left');
        $this->db->where(array('targets.target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('received_amount', 'DESC');
        $this->db->group_by('targets.emp_id');
        // echo "<pre>"; print_r($this->db->get()->result()); exit;
        return $this->db->get()->result();
    }
	// Get daily sales and display them on the website's front - Peshawar.
    public function agent_sales_info($agent_id){ // Senior management, Peshawar.
        $this->db->select('SUM(IF(project="091 Mall", rec_amount, 0)) as zero_nine_one,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="AH Tower", rec_amount, 0)) as aht,
							SUM(IF(project="North Hills", rec_amount, 0)) as nh,
							SUM(IF(project="MoH", rec_amount, 0)) as moh,
							SUM(IF(project="AH City", rec_amount, 0)) as ahc,
							SUM(IF(project="AH Residencia", rec_amount, 0)) as ahr,
                            SUM(rec_amount) as received_amount,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.project,
                            daily_sales.created_at,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target,
							teams.team_name');
        $this->db->from('targets');
        $this->db->join('employees', 'employees.emp_code = targets.emp_id', 'left');
        $this->db->join('daily_sales', 'targets.emp_id = daily_sales.agent_id', 'left');
		$this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->where(array('employees.emp_code' => $agent_id, 'targets.target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('received_amount', 'DESC');
        $this->db->group_by('targets.emp_id');
        return $this->db->get()->result();
    }
	// get teams based on BCM > no city filter
	public function get_bcms_report(){
		$this->db->select('daily_sales.id,
							 daily_sales.rec_date,
							 daily_sales.agent_id,
							 SUM(daily_sales.rec_amount) as total_revenue,
							 teams.team_id,
							 teams.team_lead,
							 SUM(revenue_target) as total_target');
		$this->db->from('daily_sales');
		$this->db->join('teams', 'daily_sales.team = teams.team_id', 'left');
		$this->db->join('targets', 'daily_sales.agent_id = targets.emp_id');
		$this->db->where(array('daily_sales.team !=' => 0, 'targets.target_month' => date('F, Y')));
		$this->db->like('daily_sales.rec_date', date('Y-m'));
		$this->db->group_by('teams.team_lead');
		$this->db->order_by('total_revenue', 'DESC');
		return $this->db->get()->result();
	 }
	 // sum targets for BCMs
	 public function sum_bcms_targets($team_lead){ // BCM name
		$this->db->select('SUM(revenue_target) as total_targets_bcm,
							  targets.emp_id,
							  targets.target_month,
							  employees.emp_team,
							  teams.team_id,
							  teams.team_name,
							  teams.team_lead,
							  teams.bdm_name');
		$this->db->from('targets');
		$this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
		$this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
		$this->db->where(array('employees.emp_team !=' => null, 'teams.team_lead' => $team_lead, 'targets.target_month' => date('F, Y')));
		$this->db->group_by('teams.team_lead');
		// echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query();
		return $this->db->get()->row();
	 }
    // Sum targets.
    public function sum_targets($team_id){
        $this->db->select('SUM(revenue_target) as total_targets,
                            targets.emp_id,
                            targets.target_month,
                            employees.emp_team,
                            teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name');
        $this->db->from('targets');
        $this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->where(array('teams.team_id' => $team_id, 'targets.target_month' => date('F, Y')));
        $this->db->group_by('teams.team_id');
        return $this->db->get()->row();
    }
    // Get teams report and display it on the leader board > Peshawar teams.
    public function get_teams_report(){
        $this->db->select('teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name,
                            employees.emp_code,
                            employees.emp_team,
                            employees.emp_city,
                            SUM(rec_amount) as received_amount,
                            daily_sales.id,
                            daily_sales.rec_date,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target,
                            SUM(revenue_target) as total_target');
        $this->db->from('teams');
        $this->db->join('employees', 'teams.team_id = employees.emp_team');
        $this->db->join('daily_sales', 'employees.emp_code = daily_sales.agent_id');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id');
        $this->db->where(array('targets.target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
		$this->db->where_not_in('teams.team_name', array('BCM-1', 'BCM-2', 'BCM-3'));
        $this->db->group_by('teams.team_id');
        $this->db->order_by('received_amount', 'DESC');
        // echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query(); exit;
        return $this->db->get()->result();
    }
    // Agents with zero sales.
    public function all_targets(){
        $this->db->select('targets.id,
                            targets.emp_id,
                            targets.revenue_target,
                            employees.id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_team');
        $this->db->from('targets');
        $this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
        $this->db->where(array('employees.emp_city' => 'Peshawar', 'targets.target_month' => date('F, Y')));
        $this->db->group_by('employees.emp_code');
        return $this->db->get()->result();
    }
    // List all teams.
    public function all_teams(){
        $this->db->select('team_id, team_name, team_lead, bdm_name');
        $this->db->from('teams');
        return $this->db->get()->result();
    }
    // Teams - get employees belonging to teams
    public function sales_teams(){
        // return $this->db->get('teams')->result();
        $this->db->select('teams.team_id,
                            teams.team_name,
                            employees.id,
                            employees.emp_name,
                            employees.emp_code,
                            employees.emp_team');
        $this->db->from('teams');
        $this->db->join('employees', 'teams.team_id = employees.emp_team', 'left');
        return $this->db->get()->result();
    }
    // Filter employees by team and revenue.
    public function get_teams_info($team_id){
        $this->db->select('SUM(IF(project="091 Mall", rec_amount, 0)) as zero_nine_one,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="AH Tower", rec_amount, 0)) as aht,
							SUM(IF(project="North Hills", rec_amount, 0)) as nh,
							SUM(IF(project="AH City", rec_amount, 0)) as ahc,
							SUM(IF(project="AH Residencia", rec_amount, 0)) as ahr,
                            SUM(rec_amount) as received_amount,
                            daily_sales.id, 
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            employees.emp_name,
                            targets.target_month,
                            targets.revenue_target,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name');
        $this->db->from('targets');
        $this->db->join('employees', 'employees.emp_code = targets.emp_id', 'left');
        $this->db->join('daily_sales', 'targets.emp_id = daily_sales.agent_id', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->where(array('employees.emp_team' => $team_id, 'employees.emp_status' => 1, 'targets.target_month' => date('F, Y'))); 
        // 'employees.emp_city' => 'Peshawar' > Removed this from where condition in query.
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('received_amount', 'DESC');
        $this->db->group_by('targets.emp_id');
        return $this->db->get()->result();
    }
	// Annual sales report > King & Queen of the year.
	public function annual_sales_agents(){
		$this->db->select('SUM(rec_amount) as amount_received, employees.emp_name, employees.gender');
		$this->db->from('daily_sales');
		$this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
		$this->db->where('employees.emp_status', 1);
		$this->db->like('daily_sales.rec_date', date('Y'));
		$this->db->order_by('amount_received', 'DESC');
		$this->db->group_by('daily_sales.agent_id');
		return $this->db->get()->result();
	}
	// Annual sales report > Team of the year
	public function annual_sales_teams(){
		$this->db->select('teams.team_name, SUM(rec_amount) as received_amount');
		$this->db->from('teams');
		$this->db->join('employees', 'teams.team_id = employees.emp_team');
		$this->db->join('daily_sales', 'employees.emp_code = daily_sales.agent_id');
		$this->db->where_not_in('teams.team_name', array('BCM-1', 'BCM-2', 'BCM-3')); // exclude the BCMs
		$this->db->like('daily_sales.rec_date', date('Y'));
		$this->db->group_by('teams.team_id');
		$this->db->order_by('received_amount', 'DESC');
		return $this->db->get()->result();
	}
	// Annual sales report > BCM of the year
	public function annual_sales_bcm(){
		$this->db->select('SUM(daily_sales.rec_amount) as total_revenue, teams.team_lead');
		$this->db->from('daily_sales');
		$this->db->join('teams', 'daily_sales.team = teams.team_id', 'left');
		$this->db->where_not_in('teams.team_name', array('BCM-1', 'BCM-2', 'BCM-3')); // exclude the BCMs
		$this->db->group_by('teams.team_lead');
		$this->db->order_by('total_revenue', 'DESC');
		return $this->db->get()->row();
	 }
}

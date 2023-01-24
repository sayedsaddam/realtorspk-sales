<?php defined('BASEPATH') OR exit('No direct script access allowed!');
class Admin_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    // Login.
    public function login($otp){
        $this->db->select('id, username, fullname, password, otp, department');
        $this->db->from('users');
        $this->db->where(array('otp' => $otp, 'email' => $this->session->userdata('email')));
        return $this->db->get()->row();
    }
    // Get departments
    public function get_departments(){
        return $this->db->select('dept_id, dept_name')->get('departments')->result();
    }
    // Add new employee
    public function add_employee($data){
        $this->db->insert('employees', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Count employees.
    public function count_employees(){
        return $this->db->from('employees')->count_all_results();
    }
    public function count_employees_isbd(){
        return $this->db->from('employees')->where(array('emp_city' => 'Islamabad', 'emp_status' => 1))->count_all_results();
    }
    public function count_employees_psh(){
        return $this->db->from('employees')->where(array('emp_city' => 'Peshawar', 'emp_status' => 1))->count_all_results();
    }
    public function count_employees_hangu(){
        return $this->db->from('employees')->where(array('emp_city' => 'Hangu', 'emp_status' => 1))->count_all_results();
    }
    public function count_employees_kohat(){
        return $this->db->from('employees')->where(array('emp_city' => 'Kohat', 'emp_status' => 1))->count_all_results();
    }
    // Get all employees from database and display them on the employees page.
    public function get_employees($limit, $offset){
        $this->db->select('employees.id,
                            employees.added_by,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_number,
                            employees.emp_city,
                            employees.emp_department,
                            employees.emp_team,
                            employees.emp_status,
                            employees.resign_date,
                            departments.dept_id,
                            departments.dept_name,
                            teams.team_id,
                            teams.team_name');
        $this->db->from('employees');
        $this->db->join('departments', 'employees.emp_department = departments.dept_id', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->order_by('employees.id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Get all employees from database and display them on the employees page > inactive employees.
    public function employees_left($limit, $offset){
        $this->db->select('employees.id,
                            employees.added_by,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_number,
                            employees.emp_city,
                            employees.emp_department,
                            employees.emp_team,
                            employees.emp_status,
                            employees.resign_date,
                            departments.dept_id,
                            departments.dept_name,
                            teams.team_id,
                            teams.team_name');
        $this->db->from('employees');
        $this->db->join('departments', 'employees.emp_department = departments.dept_id', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->where('emp_status', 0);
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Change employee status
    public function change_employee_status($id, $data){
        $this->db->where('id', $id);
        $this->db->update('employees', $data);
        return true;
    }
    // Search employees.
    public function search_employees($search){ // Search employees by city/regional office.
        $this->db->select('employees.id,
                            employees.added_by,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_number,
                            employees.emp_city,
                            employees.emp_department,
                            employees.emp_team,
                            employees.emp_status,
                            employees.resign_date,
                            departments.dept_id,
                            departments.dept_name,
                            teams.team_id,
                            teams.team_name');
        $this->db->from('employees');
        $this->db->join('departments', 'employees.emp_department = departments.dept_id', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->where(array('employees.emp_city' => $search));
        return $this->db->get()->result();
    }
    // Update payment status.
    public function update_payment_status($id, $data){
        $this->db->where('id', $id);
        $this->db->update('installments', $data);
        return true;
    }
    // Get daily sales and display them on the website's front - Islamabad.
    public function get_daily_sales_islamabad(){
        $this->db->select('SUM(rec_amount) as amount_received,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.rebate,
                            daily_sales.created_at,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id', 'left');
        $this->db->where(array('employees.emp_city' => 'Islamabad', 'target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('amount_received', 'DESC');
        $this->db->group_by('daily_sales.agent_id');
        return $this->db->get()->result();
    }
    // Get Instalments.
    public function get_daily_sales_hangu(){
        $this->db->select('SUM(rec_amount) as amount_received,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.rebate,
                            daily_sales.created_at,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id', 'left');
        $this->db->where(array('employees.emp_city' => 'Hangu', 'target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('amount_received', 'DESC');
        $this->db->group_by('daily_sales.agent_id');
        return $this->db->get()->result();
    }
    // Get daily sales and display them on the website's front - Peshawar.
    public function get_daily_sales_peshawar(){ // SUM(if(rec_date='.date('Y-m').', rec_amount, 0)) ...
        $this->db->select('SUM(rec_amount) as amount_received,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.rebate,
                            daily_sales.project,
                            daily_sales.created_at,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id', 'left');
        $this->db->where(array('employees.emp_city' => 'Peshawar', 'target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('amount_received', 'DESC');
        $this->db->group_by('daily_sales.agent_id');
        // echo $this->db->last_query();
        return $this->db->get()->result();
    }
    // Get daily sales and display them on the website's front - Kohat.
    public function get_daily_sales_kohat(){
        $this->db->select('SUM(rec_amount) as amount_received,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.rebate,
                            daily_sales.created_at,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id', 'left');
        $this->db->where(array('employees.emp_city' => 'Kohat', 'target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('amount_received', 'DESC');
        $this->db->group_by('daily_sales.agent_id');
        return $this->db->get()->result();
    }
    // Count rebates.
    public function count_rebates(){
        return $this->db->from('daily_sales')->where(array('rebate !=' => 0))->group_by('agent_id')->count_all_results();
    }
    // Rebate calculations.
    public function rebate_calculations($limit, $offset){ // amount_received = rebate_amount
        $this->db->select('SUM(rec_amount) as total_amount,
                            SUM(rec_amount * rebate / 100) as amount_received,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.rebate,
                            daily_sales.project,
                            daily_sales.rebate as rebate_percentage,
                            daily_sales.created_at,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            teams.team_id,
                            teams.team_name');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
        $this->db->join('teams', 'daily_sales.team = teams.team_id', 'left');
        // $this->db->where(array('employees.emp_city' => 'Hangu'));
        $this->db->where(array('daily_sales.rebate >' => '0', 'daily_sales.rec_amount >' => '0'));
        $this->db->order_by('created_at', 'DESC');
        $this->db->group_by('daily_sales.id');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Individual rebate report.
    public function agent_rebate($agent_id){ // amount_received = rebate_amount
        $this->db->select('id, added_by, rec_date, agent_id, rec_amount, rebate, project, rebate as rebate_percentage, created_at');
        $this->db->from('daily_sales'); // SUM(rec_amount) as total_amount, SUM(rec_amount * rebate / 100) as amount_received
        $this->db->where(array('agent_id' => $agent_id, 'rec_amount >' => 0, 'rebate !=' => 0));
        // $this->db->like('created_at', date('Y-m'));
        return $this->db->get()->result();
    }
    // Filter monthly rebates.
    public function filter_rebates_monthly($date_from, $date_to, $region){
        $this->db->select('daily_sales.id,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            SUM(rec_amount) as total_amount,
                            daily_sales.rebate,
                            daily_sales.project,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            teams.team_id,
                            teams.team_name');
        $this->db->from('daily_sales');
        $this->db->join('employees', 'employees.emp_code = daily_sales.agent_id', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to, 'daily_sales.rebate !=' => '0', 'employees.emp_city' => $region));
        $this->db->group_by('daily_sales.agent_id');
        $this->db->order_by('total_amount', 'DESC');
        return $this->db->get()->result();
    }
    // Get from two tables and add the third one as an array.
    public function get_as_array(){ // Sort it out later tonight.
        $this->db->select('targets.id,
                            targets.target_month,
                            targets.revenue_target,
                            targets.emp_id,
                            employees.id as empId,
                            employees.emp_name,
                            employees.emp_code,
                            employees.emp_city');
        $this->db->from('targets');
        $this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
        $this->db->where(array('targets.target_month' => date('F, Y'), 'employees.emp_city' => 'Peshawar'));
        return $this->db->get()->result();
    }
    // Get daily sales in current month based on agent / employee_id. 
    public function get_daily_sales_by_agent($agent_id){ // Sort it out later tonight.
        // $this->db->select_sum('rec_amount');
        $this->db->select('id, added_by, rec_date, agent_id, SUM(rec_amount) as received_amount');
        $this->db->from('daily_sales');
        $this->db->where(array('agent_id' => $agent_id, 'rec_date' => date('Y-m')));
        return $this->db->get()->result();
    }
    // Filter teams report by month.
    public function teams_report_by_month($month){
        $this->db->select('teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            teams.bdm_name,
                            employees.emp_code,
                            employees.emp_team,
                            employees.emp_city,
                            SUM(daily_sales.rec_amount) as received_amount,
                            daily_sales.id,
                            daily_sales.rec_date,
                            daily_sales.project,
                            daily_sales.rec_amount,
                            SUM(IF(project="091 Mall", rec_amount, 0)) as zero_nine_one,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target,
                            SUM(revenue_target) as total_target');
        $this->db->from('teams');
        $this->db->join('employees', 'teams.team_id = employees.emp_team');
        $this->db->join('daily_sales', 'employees.emp_code = daily_sales.agent_id');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id');
        $this->db->where(array('targets.target_month' => date('F, Y', strtotime($month))));
        $this->db->like('daily_sales.rec_date', date('Y-m', strtotime($month)));
        $this->db->group_by('teams.team_id');
        $this->db->order_by('received_amount', 'DESC');
        // echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query(); exit;
        return $this->db->get()->result();
    }
    // Filter teams report by month.
    public function teams_report_by_month_hangu($month){
        $this->db->select('teams.team_id,
                            teams.team_name,
                            teams.team_lead,
                            employees.emp_code,
                            employees.emp_team,
                            employees.emp_city,
                            SUM(daily_sales.rec_amount) as received_amount,
                            daily_sales.id,
                            daily_sales.rec_date,
                            daily_sales.project,
                            daily_sales.rec_amount,
                            SUM(IF(project="091 Mall", rec_amount, 0)) as zero_nine_one,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            targets.id,
                            targets.target_month,
                            targets.revenue_target,
                            SUM(revenue_target) as total_target');
        $this->db->from('teams');
        $this->db->join('employees', 'teams.team_id = employees.emp_team');
        $this->db->join('daily_sales', 'employees.emp_code = daily_sales.agent_id');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id');
        $this->db->where(array('targets.target_month' => date('F, Y', strtotime($month))));
        $this->db->like('daily_sales.rec_date', date('Y-m', strtotime($month)));
        $this->db->group_by('teams.team_id');
        $this->db->order_by('received_amount', 'DESC');
        // echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query(); exit;
        return $this->db->get()->result();
    }
    // Sale detail. Filter records agent-wise in the current month.
    public function sale_detail($agent_id){
        $this->db->select('daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
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
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->order_by('rec_date', 'DESC');
        return $this->db->get()->result();
    }
    // Last updated date and updated by (Username).
    public function last_updated_by($city){
        $this->db->select('daily_sales.added_by,
                            daily_sales.agent_id,
                            daily_sales.created_at,
                            users.id,
                            users.fullname,
                            users.username,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_city');
        $this->db->from('daily_sales');
        $this->db->join('users', 'daily_sales.added_by = users.id', 'left');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'left');
        $this->db->where('employees.emp_city', $city);
        $this->db->order_by('daily_sales.created_at', 'DESC');
        return $this->db->get()->row();
    }
    // Get sales agents to assign monthly revenue targets.
    public function get_sales_agents($city){
        $this->db->select('employees.emp_code, employees.emp_name, employees.emp_team, employees.designation,designations.id as designation_id,designations.target_amount,designations.designation_name,targets.id as target_id, targets.target_month, targets.emp_id, targets.revenue_target, targets.created_at');
        $this->db->from('employees');
        $this->db->join('designations', 'employees.designation = designations.id');
        $this->db->join('targets', 'employees.emp_code = targets.emp_id', 'left');
        $this->db->where(array('employees.emp_city' => $city, 'employees.emp_status' => 1)); // , 'target_month <=' => date('F, Y', strtotime('first day of -1 month'))
        $this->db->order_by('employees.emp_name', 'ASC');
        $this->db->group_by('employees.emp_code'); // Added by group_by statement to get all records from employees table.
        
        return $this->db->get()->result();
    }
    // Check whether targets assigned in the current month.
    public function check_for_targets(){
        $this->db->select('id, target_month');
        $this->db->from('targets');
        $this->db->where('target_month', date('F, Y'));
        return $this->db->get()->result();
    }

    // Assign targets .
    public function assign_targets($data){
        $this->db->insert('targets', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Search daily sales by date.
    public function get_by_date($date){
        $this->db->select('daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            daily_sales.rec_amount,
                            daily_sales.project,
                            users.id as user_id,
                            users.fullname,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.office');
        $this->db->from('daily_sales');
        $this->db->join('users', 'daily_sales.added_by = users.id', 'inner');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'inner');
        $this->db->like('daily_sales.created_at', date('Y-m-d', strtotime($date)));
        return $this->db->get()->result();
    }
    // Filter records by month and city.
    public function get_by_date_city($date_from, $date_to, $city){
        $this->db->select('SUM(if(project="091 Mall", rec_amount, 0)) as zero_nine_one_mall,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="North Hills", rec_amount, 0)) as northHills,
							SUM(IF(project="AH Tower", rec_amount, 0)) as ah_tower,
							SUM(IF(project="AH City", rec_amount, 0)) as ah_city,
                            daily_sales.id,
                            daily_sales.added_by,
                            daily_sales.rec_date,
                            daily_sales.agent_id,
                            SUM(daily_sales.rec_amount) as total_amount_received,
                            daily_sales.project,
                            users.id as user_id,
                            users.fullname,
                            employees.id as emp_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            employees.emp_team,
                            employees.office,
                            teams.team_name');
        $this->db->from('daily_sales');
        $this->db->join('users', 'daily_sales.added_by = users.id', 'inner');
        $this->db->join('employees', 'daily_sales.agent_id = employees.emp_code', 'inner');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        // $this->db->like(array('daily_sales.rec_date' => date('Y-m', strtotime($date)), 'employees.emp_city' => $city));
        $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to, 'employees.emp_city' => $city));
        $this->db->where('daily_sales.rec_amount >=', 0);
        $this->db->group_by('daily_sales.agent_id');
        $this->db->order_by('total_amount_received', 'DESC');
        return $this->db->get()->result();
    }
    // Editing / updating a sales record.
    public function update_daily_sale($id, $data){
        $this->db->where('id', $id); // The ID (primary key) column in the daily_sales table.
        $this->db->update('daily_sales', $data);
        return true;
    }
    // Sum today's sales.
    public function total_sales_today(){
        $this->db->select('SUM(rec_amount) total_today');
        $this->db->from('daily_sales');
        $this->db->where('rec_date', date('Y-m-d'));
        return $this->db->get()->row();
    }
    // Count targets.
    public function count_targets(){
        return $this->db->from('targets')->count_all_results();
    }
    // Sum current month's targets.
    public function total_this_month(){
        $this->db->select('SUM(revenue_target) total_this_month');
        $this->db->from('targets');
        $this->db->where('target_month', date('F, Y'));
        return $this->db->get()->row();
    }
    // Sum all daily sales in the current month.
    public function total_sales_this_month(){
        $this->db->select('SUM(rec_amount) total_sales_this_month');
        $this->db->from('daily_sales');
        $this->db->like('rec_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Total agents this month.
    public function total_agents_this_month(){
        return $this->db->from('targets')->where('target_month', date('F, Y'))->count_all_results();
    }
    // Overall sales.
    public function overall_sales(){
        $this->db->select('SUM(rec_amount) overall_sale_amount');
        $this->db->from('daily_sales');
        return $this->db->get()->row();
    }
    // Get and display targets.
    public function get_targets($limit, $offset){
        $this->db->select('targets.id as target_id,
                            targets.added_by,
                            targets.target_month,
                            targets.emp_id,
                            targets.revenue_target,
                            targets.created_at,
                            employees.id as employee_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            users.id as user_id,
                            users.fullname');
        $this->db->from('targets');
        $this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
        $this->db->join('users', 'targets.added_by = users.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('targets.id', 'DESC');
        return $this->db->get()->result();
    }
    // Search targets.
    public function search_targets($target_month, $city){
        $this->db->select('targets.id as target_id,
                            targets.added_by,
                            targets.target_month,
                            targets.emp_id,
                            targets.revenue_target,
                            targets.created_at,
                            employees.id as employee_id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.emp_city,
                            users.id as user_id,
                            users.fullname');
        $this->db->from('targets');
        $this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
        $this->db->join('users', 'targets.added_by = users.id', 'left');
        $this->db->where(array('targets.target_month' => $target_month, 'employees.emp_city' => $city));
        return $this->db->get()->result();
    }
    // Edit target => get target by id.
    public function edit_target($target_id){
        $this->db->select('id, revenue_target');
        $this->db->from('targets');
        $this->db->where('id', $target_id);
        return $this->db->get()->row();
    }
    // Update target => update target by ID.
    public function update_target($id, $data){
        $this->db->where('id', $id);
        $this->db->update('targets', $data);
        return true;
    }
    // Get sales agents for adding daily sales.
    public function get_daily_sales_agents($city){
        $this->db->select('targets.id as tgt_id, targets.emp_id, employees.id, employees.emp_name, employees.emp_code, employees.emp_city, employees.emp_team');
        $this->db->from('targets');
        $this->db->join('employees', 'targets.emp_id = employees.emp_code', 'left');
        $this->db->where(array('employees.emp_city' => $city, 'targets.target_month' => date('F, Y')));
        $this->db->group_by('targets.emp_id'); // Group by emp_id so that the record displays once.
        $this->db->order_by('employees.emp_name', 'asc');
        return $this->db->get()->result();
    }
    // Adding daily sales into the database.
    public function add_daily_sales($data){
        // print_r('add daily sales');exit;
        $this->db->insert_batch('daily_sales', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Teams - Add new team
    public function add_team($data){
        $this->db->insert('teams', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Agents in teams.
    public function agents_in_team($team_id){
        $this->db->select('employees.id,
                            employees.emp_code,
                            employees.emp_name,
                            employees.office,
                            employees.emp_number,
                            teams.team_id,
                            teams.team_name,
                            teams.team_lead');
        $this->db->from('employees');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->where(array('teams.team_id' => $team_id, 'employees.emp_status' => 1));
        return $this->db->get()->result();
    }
    // Get teams for listing in the dropdown.
    public function teams_for_selectbox(){
        $this->db->select('team_id, team_name');
        $this->db->from('teams');
        return $this->db->get()->result();
    }
    // Count teams
    public function count_teams(){
        return $this->db->from('teams')->count_all_results();
    }
    // Get teams - list teams
    public function get_teams($limit, $offset){
        $this->db->select('teams.team_id, teams.added_by, teams.team_name, teams.team_lead, teams.bdm_name, teams.created_at, users.id, users.fullname');
        $this->db->from('teams');
        $this->db->join('users', 'teams.added_by = users.id', 'left');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Assign employee to team $id = Employee id.
    public function assign_employee_to_team($id, $data){
        $this->db->where('id', $id);
        $this->db->update('employees', $data);
        return true;
    }
    // Update/modify teams
    public function update_team($id, $data){ // $id = team_id.
        $this->db->where('team_id', $id);
        $this->db->update('teams', $data);
        return true;
    }
    // Calculate teams' revenue.
    public function teams_revenue(){
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
                            targets.revenue_target');
        $this->db->from('teams');
        $this->db->join('employees', 'teams.team_id = employees.emp_team');
        $this->db->join('daily_sales', 'employees.emp_code = daily_sales.agent_id');
        $this->db->join('targets', 'daily_sales.agent_id = targets.emp_id');
        $this->db->where(array('targets.target_month' => date('F, Y')));
        $this->db->like('daily_sales.rec_date', date('Y-m'));
        $this->db->group_by('teams.team_id');
        $this->db->order_by('received_amount', 'DESC');
        // echo "<pre>"; print_r($this->db->get()->result()); echo $this->db->last_query(); exit;
        return $this->db->get()->result();
    }
    // Get teams for filtering sales report.
    public function get_sales_teams(){
        return $this->db->from('teams')->get()->result();
    }
	// Team info > edit team
	public function team_info($team_id){
		return $this->db->get_where('teams', array('team_id' => $team_id))->row();
	}
    // Sales report.
    public function get_sales_report($month, $date_from, $date_to, $team, $city, $agent, $project){
        $this->db->select('SUM(if(project="091 Mall", rec_amount, 0)) as zero_nine_one_mall,
                            SUM(IF(project="Florenza", rec_amount, 0)) as florenza,
                            SUM(IF(project="MoH", rec_amount, 0)) as moh,
                            SUM(IF(project="North Hills", rec_amount, 0)) as northHills,
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
        if($date_from != '' && $date_to != ''){
            $this->db->where(array('daily_sales.rec_date >=' => $date_from, 'daily_sales.rec_date <=' => $date_to));
        }
        if($month != ''){
            $this->db->where(array('targets.target_month' => date('F, Y', strtotime($month))));
        }
        if($team != ''){
            $this->db->where('employees.emp_team', $team);
        }
        if($city != '' && $agent !=''){
            $this->db->where(array('employees.emp_city' => $city, 'employees.emp_code' => $agent));
        }elseif($city != ''){
            $this->db->where('employees.emp_city', $city);
            $this->db->or_where('employees.emp_code', $agent);
        }
        if($project != ''){
            $this->db->where('daily_sales.project', $project);
        }
        $this->db->order_by('total_amount_received', 'DESC');
        $this->db->group_by('daily_sales.rec_amount');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }
    //== --------------------------------------------- Buybacks section -------------------------------------------------- ==//
    // Get employees / sales agents for buyback request initiation.
    public function get_agents(){
        $this->db->select('emp_code, emp_name, emp_department, emp_city');
        $this->db->from('employees');
        $this->db->where(array('emp_department' => 6, 'emp_status' => 1));
        $this->db->order_by('emp_city', 'ASC');
        return $this->db->get()->result();
    }
    // Initiating a buyback request.
    public function initiate_request($data){
        $this->db->insert('buyback_requests', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Count total buyback requests for pagination and per page display
    public function total_buyback_requests(){
        return $this->db->from('buyback_requests')->count_all_results();
    }
    // Count total no. of pending requests
    public function count_requests($status){ // trying to get via variable.
        return $this->db->from('buyback_requests')->where('status', $status)->count_all_results();
    }  
    // Get recent submitted requests
    public function get_buyback_requests($limit, $offset){
        $this->db->select('buyback_requests.id,
                            buyback_requests.customer_name,
                            buyback_requests.customer_cnic,
                            buyback_requests.agent,
                            buyback_requests.project,
                            buyback_requests.date_of_investment,
                            buyback_requests.investment_amount,
                            buyback_requests.refund_amount,
                            buyback_requests.refund_reason,
                            buyback_requests.status,
                            buyback_requests.created_at,
                            employees.emp_code,
                            employees.emp_name');
        $this->db->from('buyback_requests');
        $this->db->join('employees', 'buyback_requests.agent = employees.emp_code', 'left');
        $this->db->order_by('buyback_requests.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Get request detail for further actions
    public function get_request_detail($id){ // $id = Request ID.
        $this->db->select('buyback_requests.id,
                            buyback_requests.customer_name,
                            buyback_requests.customer_cnic,
                            buyback_requests.agent,
                            buyback_requests.project,
                            buyback_requests.date_of_investment,
                            buyback_requests.investment_amount,
                            buyback_requests.refund_amount,
                            buyback_requests.refund_reason,
                            buyback_requests.status,
                            buyback_requests.created_at,
                            employees.emp_code,
                            employees.emp_name');
        $this->db->from('buyback_requests');
        $this->db->join('employees', 'buyback_requests.agent = employees.emp_code', 'left');
        $this->db->where(array('buyback_requests.id' => $id));
        return $this->db->get()->row();
    }
    // Search in buyback requests
    public function search_buyback_requests($search){
        $this->db->select('buyback_requests.id,
                            buyback_requests.customer_name,
                            buyback_requests.customer_cnic,
                            buyback_requests.agent,
                            buyback_requests.project,
                            buyback_requests.date_of_investment,
                            buyback_requests.investment_amount,
                            buyback_requests.refund_amount,
                            buyback_requests.refund_reason,
                            buyback_requests.status,
                            buyback_requests.created_at,
                            employees.emp_code,
                            employees.emp_name');
        $this->db->from('buyback_requests');
        $this->db->join('employees', 'buyback_requests.agent = employees.emp_code', 'left');
        $this->db->like('buyback_requests.customer_name', $search);
        $this->db->or_like('buyback_requests.customer_cnic', $search);
        $this->db->or_like('employees.emp_name', $search);
        $this->db->or_like('buyback_requests.project', $search);
        return $this->db->get()->result();
    }
    // Perform actions on the buyback and send data to buyback_logs table.
    public function upload_documents($data){
        $this->db->insert('buyback_logs', $data);
        if($this->db->affected_rows() > 0){
           return true; 
        }else{
           return false; 
        } 
    }
    // Update request status based on document upload
    public function update_request_status($id, $data){ // $id => request_id
        $this->db->where('id', $id);
        $this->db->update('buyback_requests', $data);
        return true;
    }
    // Get buyback logs > actions performed by different departments.
    public function get_buyback_logs($id){
        $this->db->select('buyback_logs.id,
                            buyback_logs.request_id,
                            buyback_logs.document_name,
                            buyback_logs.added_by,
                            buyback_logs.remarks,
                            buyback_logs.processed_by,
                            buyback_logs.created_at,
                            buyback_requests.id,
                            users.id as user_id,
                            users.fullname');
        $this->db->from('buyback_logs');
        $this->db->join('buyback_requests', 'buyback_logs.request_id = buyback_requests.id', 'left');
        $this->db->join('users', 'buyback_logs.added_by = users.id', 'left');
        $this->db->where('buyback_logs.id', $id);
        $this->db->order_by('buyback_logs.created_at', 'DESC');
        return $this->db->get()->result();
    }
    //== ------------------------------------------- Customers ------------------------------------------------ ==//
    // count customers for pagination
    public function total_customers(){
        return $this->db->from('customers')->count_all_results();
    }
    // count active customers for pagination
    public function active_customers(){
        return $this->db->from('customers')->where('status', 1)->count_all_results();
    }
 
    // count inactive customers for pagination
    public function inactive_customers(){
        return $this->db->from('customers')->where('status', 0)->count_all_results();
    }
    // Get all customers
    public function get_customers($limit, $offset){
        $this->db->select('customers.id,
                            customers.customer_name,
                            customers.customer_cnic,
                            customers.customer_contact,
                            customers.customer_agent,
                            customers.customer_address,
                            customers.project,
                            customers.status,
                            customers.nok_name,
                            customers.nok_cnic,
                            customers.nok_relation,
                            customers.nok_contact,
                            customers.bank_name,
                            customers.branch_code,
                            customers.account_no,
                            customers.tax_status,
                            customers.created_at,
                            employees.emp_code,
                            employees.emp_name');
        $this->db->from('customers');
        $this->db->join('employees', 'customers.customer_agent = employees.emp_code', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('customers.created_at', 'DESC');
        return $this->db->get()->result();
    }
    // add customer
    public function add_customer($data){
        $this->db->insert('customers', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function edit_customer($id){
        $this->db->select('customers.id,
                            customers.customer_name,
                            customers.customer_cnic,
                            customers.customer_contact,
                            customers.customer_agent,
                            customers.customer_address,
                            customers.project,
                            customers.status,
                            customers.nok_name,
                            customers.nok_cnic,
                            customers.nok_relation,
                            customers.nok_contact,
                            customers.bank_name,
                            customers.branch_code,
                            customers.account_no,
                            customers.tax_status,
                            customers.created_at,
                            employees.emp_code,
                            employees.emp_name');
        $this->db->from('customers');
        $this->db->join('employees', 'customers.customer_agent = employees.emp_code', 'left');
        $this->db->where('customers.id', $id);
        return $this->db->get()->row();
    }
    // update customer information
    public function update_customer($id, $data){
        $this->db->where('id', $id);
        $this->db->update('customers', $data);
        return true;
    }
    // update customer status / enable or disable
    public function update_customer_status($id){
        $this->db->query("UPDATE customers SET `status` = NOT `status` WHERE id=$id");
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // search customers
    public function search_customers($search){
        $this->db->select('customers.id,
                            customers.customer_name,
                            customers.customer_cnic,
                            customers.customer_contact,
                            customers.customer_agent,
                            customers.customer_address,
                            customers.project,
                            customers.status,
                            customers.nok_name,
                            customers.nok_cnic,
                            customers.nok_relation,
                            customers.nok_contact,
                            customers.bank_name,
                            customers.branch_code,
                            customers.account_no,
                            customers.tax_status,
                            customers.created_at,
                            employees.emp_code,
                            employees.emp_name');
        $this->db->from('customers');
        $this->db->join('employees', 'customers.customer_agent = employees.emp_code', 'left');
        $this->db->like('customers.customer_name', $search);
        $this->db->or_like('employees.emp_name', $search);
        $this->db->or_like('customers.customer_cnic', $search);
        $this->db->or_like('customers.customer_contact', $search);
        $this->db->order_by('customers.created_at', 'DESC');
        return $this->db->get()->result();
    }
       // get designations
    public function get_designations(){
        return $this->db->select('id, designation_name,target_amount')->get('designations')->result();
    }
    public function get_managers($designation_id){
        $this->db->select('id, emp_code, emp_name');
        $this->db->from('employees');
        $this->db->where(array('designation' => $designation_id, 'emp_status' => 1));
        $this->db->order_by('emp_name', 'asc');
        return $this->db->get()->result();
    }
    //get locations
    public function get_locations(){
        $this->db->select('id, name,status');
        $this->db->from('locations');
        $this->db->where('status','1');
        return $this->db->get()->result();
    }
    //get locations
    public function get_all_locations(){
        return $this->db->select('id, name,location_address,status')->get('locations')->result();
        
    }
    // Editing / updating a sales record.
    public function update_location($id, $data){
        $this->db->where('id', $id); // The ID (primary key) column in the daily_sales table.
        $this->db->update('locations', $data);
        return true;
    }
    //deleting designation
    public function delete_location($id){
        $this->db->from('locations');
        $this->db->where('id', $id);
        $this->db->delete('locations');
        return true;
    }
    //deleting designation
    public function add_location($data){
    $this->db->insert('locations', $data);
    if($this->db->affected_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}
    // Change employee status
    public function change_location_status($id, $data){
        $this->db->where('id', $id);
        $this->db->update('locations', $data);
        return true;
    }
    // employee detail > get employee by ID
    public function employee_detail($id){
        $this->db->select('employees.id,
                            employees.added_by,
                            employees.emp_code,
                            employees.emp_name,
                            employees.manager_id,
                            employees.gender,
                            employees.office,
                            employees.emp_number,
                            employees.emp_city,
                            employees.emp_department,
                            employees.emp_team,
                            employees.doj,
                            departments.dept_id,
                            departments.dept_name,
                            teams.team_id,
                            teams.team_name,
                            designations.id as des_id,
                            designations.designation_name');
        $this->db->from('employees');
        $this->db->join('departments', 'employees.emp_department = departments.dept_id', 'left');
        $this->db->join('teams', 'employees.emp_team = teams.team_id', 'left');
        $this->db->join('designations', 'employees.designation = designations.id', 'left');
        $this->db->where('employees.id', $id);
        return $this->db->get()->row();
    }
    // update employee
    public function update_employee($id, $data){
        $this->db->where('id', $id);
        $this->db->update('employees', $data);
        return true;
    }
    //active/ inactive employees count
    public function count_employees_with_status($location_name,$status){
        print_r( $this->db->from('employees')->where(array('emp_status' => $status, 'emp_city' => $location_name))->count_all_results());

    }


}

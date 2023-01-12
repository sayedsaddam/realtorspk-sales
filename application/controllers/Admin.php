<?php defined('BASEPATH') OR exit('No direct script access allowed!');
class Admin extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model(array('admin_model', 'home_model', 'inventory_model'));
        $this->load->helper('paginate'); // Custom pagination helper.
    }
    // Load the login page.
    public function index(){
        if($this->session->userdata('email') == null){
            $this->session->sess_destroy();
            redirect('admin');
        }
        $data['title'] = 'Login | Realtors PK';
        $data['content'] = 'admin/admin_login';
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Validate user before going to the login page.
    public function who_are_you(){
        $data['title'] = 'Identification | Realtors PK';
        $data['content'] = 'admin/authentication';
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Authentication before proceeding to the login page.
    public function authenticate(){
        $otp = rand(100000, 999999);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|callback_check_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if($this->form_validation->run() == FALSE){
            $this->who_are_you();
        }else{
            $user_email = $this->input->post('email');
            $password = sha1($this->input->post('password'));
            $email = $this->db->select('email, password')->from('users')->where(array('email' => $user_email, 'password' => $password))->get()->row();
            if($email != NULL && $password != NULL){
                $data = array(
                	'otp' => $otp
                );
                $this->db->where('email', $user_email);
                $this->db->update('users', $data);
                $this->load->library('email'); // Loading the email library.
                $this->email->from('no-reply@realtorspk.com', 'Realtors PK');
                $this->email->to($email->email);
                // $this->email->cc('another@another-example.com');
                // $this->email->bcc('them@their-example.com');
                $this->email->subject('Security code');
                $this->email->message("Your verification code is " .$otp.". Share with none in order to stay secure. Realtors PK of Companies Pvt. Ltd.");
                $this->email->send();
                $this->session->set_flashdata('otp_sent', '<strong>Information! </strong>A 6 digit code has been sent to your email. Please check your email and return to login.');
                $this->session->set_userdata(array('email' => $email->email));
                redirect('admin/index');
            }else{
                $this->session->set_flashdata('not_found', '<strong>Uh oh! </strong>The email or username you entered does not exist on our database. Trying another one might help.');
                redirect($_SERVER['HTTP_REFERER']);
                exit;
            }
        } 
    }
    // Check email
    public function check_email($email){
        if(stristr($email, '@ahgroup-pk.com') !== false) return true;
        if(stristr($email, '@s2smark.com') !== false) return true;
        if(stristr($email, '@realtorspk.com') !== false) return true;
        $this->load->library('form_validation');
        $this->form_validation->set_message('check_email', 'Please enter your official email address.');
        return false;
    }
    // Check credentials and log the user in.
    public function login(){
        $otp = $this->input->post('otp');
        $login = $this->admin_model->login($otp);
        if($login > '0'){
            $id = $login->id;
            $username = $login->username;
            $name = $login->fullname;
            $department = $login->department;
            $this->session->set_userdata(array('id' => $id, 'username' => $username, 'fullname' => $name, 'department' => $department));
            redirect('admin/dashboard');
            // echo "Welcome aboard ". $this->session->userdata('fullname');
        }else{
            $this->session->set_flashdata('login_failed', "<strong>Oops! </strong>This isn't the OTP we sent you, try looking into your email for the correct one.");
            redirect('admin/index');
        }
    }
    // Redirect the user to dashboard after succssfull login attempt.
    public function dashboard(){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $data['title'] = 'Dashboard | Realtors PK';
        $data['content'] = 'admin/dashboard';
        $data['check_for_targets'] = $this->admin_model->check_for_targets(); //Check for targets and restrict duplicate.
        $data['departments'] = $this->admin_model->get_departments();
        $data['total_this_month'] = $this->admin_model->total_this_month();
        $data['total_sales_this_month'] = $this->admin_model->total_sales_this_month();
        $data['total_agents_this_month'] = $this->admin_model->total_agents_this_month();
        $data['total_employees'] = $this->admin_model->count_employees();
        $data['isbd_employees'] = $this->admin_model->count_employees_isbd();
        $data['psh_employees'] = $this->admin_model->count_employees_psh();
        $data['hangu_employees'] = $this->admin_model->count_employees_hangu();
        $data['kohat_employees'] = $this->admin_model->count_employees_kohat();
        $data['total_sales_today'] = $this->admin_model->total_sales_today();
        $data['overall_sales'] = $this->admin_model->overall_sales();
        $data['total_teams'] = $this->admin_model->count_teams();
        $data['teams'] = $this->admin_model->teams_for_selectbox();
        $data['teams_revenue'] = $this->admin_model->teams_revenue();
        $data['total_customers'] = $this->admin_model->active_customers();
        $data['active_customers'] = $this->admin_model->active_customers();
        $data['inactive_customers'] = $this->admin_model->inactive_customers();
        $data['agents'] = $this->admin_model->get_agents();
        $data['total_projects'] = $this->inventory_model->total_projects();
        $data['total_floors'] = $this->inventory_model->total_floors();
        $data['total_units'] = $this->inventory_model->total_units();
        $data['available_units'] = $this->inventory_model->available_units();
        $data['sellable_area'] = $this->inventory_model->total_sellable_area();
        $data['covered_area'] = $this->inventory_model->total_covered_area();
        $data['total_units_aht'] = $this->inventory_model->total_units();
        $data['available_units_aht'] = $this->inventory_model->total_available_units();
        $data['booked_units_aht'] = $this->inventory_model->total_booked_units();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Employees
    public function employees($offset = NULL){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/employees';
        $rowscount = $this->admin_model->count_employees();
        paginate($url, $rowscount, $limit); // Calling the paginate helper.
        $data['title'] = 'Employees | Realtors PK';
        $data['content'] = 'admin/employees';
        $data['employees'] = $this->admin_model->get_employees($limit, $offset);
        $data['teams'] = $this->admin_model->teams_for_selectbox();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // inactive employees.
    public function inactive_employees($offset = null){
        $limit = 100;
        $inactive = $this->admin_model->employees_left($limit, $offset);
        echo json_encode($inactive);
    }
    // Add new employee.
    public function add_employee(){
        $data = array(
            'emp_code' => $this->input->post('emp_code'),
            'emp_name' => $this->input->post('emp_name'),
			'gender' => $this->input->post('gender'),
            'office' => $this->input->post('office'),
            'doj' => $this->input->post('doj'),
            'emp_number' => $this->input->post('emp_phone'),
            'emp_city' => $this->input->post('emp_city'),
            'emp_department' => $this->input->post('emp_department'),
            'emp_team' => $this->input->post('emp_team'),
            'added_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d')
        );
        if($this->admin_model->add_employee($data)){
            $this->session->set_flashdata("success", "<strong>Success! </strong>Employee record has been added successfully.");
            redirect('admin/dashboard');
        }else{
            $this->session->set_flashdata("failed", "<strong>Failed! </strong>Something went wrong, but don't fret. Let's give it another shot.");
            redirect('admin/dashboard');
        }
    }
    // Change employee status whether s/he resigned.
    public function update_employee_status($id){
		$user =  $this->db->get_where('employees', array('id' => $id))->row();
		$status = '';
		if($user->emp_status == 1){
			$status .= 0;
		}else{
			$status .= 1;
		}
		$data = array(
			'emp_status' => $status,
			'resign_date' => date('Y-m-d H:i:s')
		);
		if($this->admin_model->change_employee_status($id, $data)){
			$this->session->set_flashdata('success', '<strong>Success! </strong>Employee status has been changed successfully.');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata("failed", "<strong>Failed! </strong>Something went wrong, but don't fret. Let's give it another shot.");
			redirect($_SERVER['HTTP_REFERER']);
		}
    }
    // Search employees by city / regional office.
    public function search_employees(){
        $search = $this->input->get('emp_search'); // form attribute name.
        $data['title'] = 'Search Results | Realtors PK';
        $data['content'] = 'admin/employees';
        $data['results'] = $this->admin_model->search_employees($search);
        $data['teams'] = $this->admin_model->teams_for_selectbox();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Get instalments.
    public function daily_sales(){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $data['title'] = 'Instalments | Realtors PK';
        $data['content'] = 'admin/daily_sales';
        $data['daily_sales_hangu'] = $this->admin_model->get_daily_sales_hangu();
        $data['daily_sales_peshawar'] = $this->admin_model->get_daily_sales_peshawar();
        $data['daily_sales_islamabad'] = $this->admin_model->get_daily_sales_islamabad();
        $data['daily_sales_kohat'] = $this->admin_model->get_daily_sales_kohat();
        // $data['last_updated_by'] = $this->admin_model->last_updated_by();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Get sales agents for assigning targets.
    public function get_sales_agents($city){
        $filter_data = $this->admin_model->get_sales_agents($city);
        echo json_encode($filter_data);
    }
    // Add monthly targets.
	public function assign_targets(){
		if(isset($_POST)){
			$data = array();
			$data2 = array();
			$data3 = array();
			foreach($_POST['month'] as $key2 => $value2){
				if($value2 != '' ){
					array_push($data2, $value2);
				}
			}
			foreach($_POST['revenue'] as $key3 => $value3){
				if($value3 != ''){
					array_push($data3, $value3);
				}
			}
			for($i = 0; $i < count($_POST['emp_id']); $i++){
				$data[$i] = array(
                    'added_by' => $this->session->userdata('id'),
					'emp_id' => $_POST['emp_id'][$i],
					'target_month' => $data2[$i].', '.date('Y'),
					'revenue_target' => $data3[$i],
                );
                $check_before_assign = $this->db->get_where('targets', array('target_month' => date('F, Y'), 'emp_id' => $_POST['emp_id'][$i]))->result();
            }
            if($check_before_assign == TRUE){
                $this->session->set_flashdata("failed", "<strong>Failed! </strong> You can't assign target twice in the same month."); // Failed to insert record. Targets can't be assigned twice in a month.
                redirect('admin/dashboard');
                return false;
            }
            // echo "<pre>"; print_r($data);
			if($this->admin_model->assign_targets($data)){
				$this->session->set_flashdata('success', '<strong>Success! </strong>Target added successfully.');
				redirect('admin/dashboard');
			}else{
				$this->session->set_flashdata('failed', '<strong>Failed! </strong>Failed to add target.');
				redirect('admin/dashboard');
			}
        }
    }
    // Show all targets.
    public function assigned_targets($offset = NULL){
        if(!$this->session->userdata('username')){
            redirect('');
        }
        $limit = 20;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/assigned_targets';
        $rowscount = $this->admin_model->count_targets();
        paginate($url, $rowscount, $limit); // Calling the paginate helper.
        $data['title'] = 'Assigned Targets | Realtors PK';
        $data['content'] = 'admin/targets';
        $data['targets'] = $this->admin_model->get_targets($limit, $offset);
        $data['total_this_month'] = $this->admin_model->total_this_month();
        // echo "<pre>"; print_r($data['targets']); exit;
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Targets search.
    public function search_targets(){
        $target_month = $this->input->get('target_month');
        $city = $this->input->get('city'); // Target city.
        $data['title'] = 'Search Results | Realtors PK';
        $data['content'] = 'admin/targets';
        $data['results'] = $this->admin_model->search_targets($target_month, $city);
        $data['total_this_month'] = $this->admin_model->total_this_month();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Editing target
    public function edit_target($target_id){
        $target = $this->admin_model->edit_target($target_id);
        echo json_encode($target);
    }
    // Updating a target
    public function update_target(){
        $id = $this->input->post('target_id');
        $data = array(
            'revenue_target' => $this->input->post('revenue_target')
        );
        if($this->admin_model->update_target($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Updating target was successful.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Updating target was failed.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // Get agents for adding daily sales records.
    public function get_daily_sales_agents($city){
        $daily_sales = $this->admin_model->get_daily_sales_agents($city);
        echo json_encode($daily_sales);
    }
    // Add daily sales
    public function add_daily_sales(){
        if(isset($_POST['emp_id'])){
			$data = array(); // Added by
			$data2 = array(); // Receiving date
            $data3 = array(); // Agent Id
            $data4 = array(); // Rebate
            $data5 = array(); // Project
            $data6 = array(); // Team ID
			foreach($_POST['receiving_date'] as $key2 => $value2){
				if($value2 != '' ){
					array_push($data2, $value2);
				}
			}
			foreach($_POST['received_amount'] as $key3 => $value3){
				if($value3 != ''){
					array_push($data3, $value3);
				}
            }
            foreach ($_POST['rebate'] as $key4 => $value4) {
                if($value4 != ''){
                    array_push($data4, $value4);
                }
            }
            foreach($_POST['project'] as $key5 => $value5){
                if($value5 != ''){
                    array_push($data5, $value5);
                }
            }
            foreach($_POST['team'] as $key6 => $value6){
                if($value6 != ''){
                    array_push($data6, $value6);
                }
            }
			for($i = 0; $i < count($_POST['emp_id']); $i++){
                $split = explode(':', $_POST['emp_id'][$i]); // Split the string and get the value for dumping into database.
				$data[$i] = array(
                    'added_by' => $this->session->userdata('id'),
					'agent_id' => $split[0], // first part > Employee ID
                    'team' => $split[1], // second part > Team ID
					'rec_date' => $data2[$i],
                    'rec_amount' => $data3[$i],
                    'rebate' => $data4[$i],
                    'project' => $data5[$i]
				);
            }
			if($this->admin_model->add_daily_sales($data)){
				$this->session->set_flashdata('success', '<strong>Success! </strong>Daily sale was added successfully.');
				redirect('admin/dashboard');
			}else{
				$this->session->set_flashdata('failed', '<strong>Failed! </strong>Failed to add target.');
				redirect('admin/dashboard');
			}
        }
    }
    // Editing / updating daily sales records in case of wrong entry.
    public function update_daily_sale(){
        $id = $this->input->post('daily_sale_id'); // Get the form input.
        $reason = ''; // Declare an empty variable to concatenate other vars later.
        $updated_by = $this->session->userdata('fullname');
        $updated_at = date('M d, Y');
        $reason .= 'Updated by '.$updated_by.' on '.$updated_at.'. '.$this->input->post('edit_reason'); // Concatenate all vars to the $reason.
        $data = array(
            'rec_date' => $this->input->post('rec_date'),
            'rec_amount' => $this->input->post('amount_received'),
            'edit_reason' => $reason
        );
        if($this->admin_model->update_daily_sale($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Updating a daily sale record was successful.');
            redirect('admin/daily_sales');
        }else{
            $this->session->set_flashdata('failed', "<strong>Failed! </strong>Something went wrong, but don't fret. Let's give it another shot!");
            redirect('admin/daily_sales');
        }
    }
    // Sale detail. -- Filter record by agent ID.
    public function sale_detail($agent_id){
        $data['title'] = 'Sales Detail | Realtors PK';
        $data['content'] = 'admin/sales_detail';
        $data['detail'] = $this->admin_model->sale_detail($agent_id);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Filter records by month(date) and city.
    public function archives(){
        // $date = $this->input->get('archive_month');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $city = $this->input->get('archive_city');
        // $project = $this->input->get('project');
        $data['title'] = 'Sales Archives | Realtors PK';
        $data['content'] = 'admin/sales_archives';
        $data['archives'] = $this->admin_model->get_by_date_city($date_from, $date_to, $city);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Rebate calculation and view page.
    public function rebate_calculations($offset = NULL){
        $limit = 30;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/rebate_calculations';
        $rowscount = $this->admin_model->count_rebates();
        paginate($url, $rowscount, $limit); // Calling the paginate helper.
        $data['title'] = 'Rebate Calculations | Realtors PK';
        $data['content'] = 'admin/rebate';
        $data['rebates'] = $this->admin_model->rebate_calculations($limit, $offset);
        // echo '<pre>'; print_r($data['rebates']);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Individual agent rebate report.
    public function agent_rebate($agent_id){
        $agent_rebate = $this->admin_model->agent_rebate($agent_id);
        echo json_encode($agent_rebate);
    }
    // Filter by month.
    public function filter_rebates_monthly(){
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $region = $this->input->get('region');
        $data['title'] = 'Individual Rebate > Rebates > Realtors PK';
        $data['content'] = 'admin/rebate';
        $data['results'] = $this->admin_model->filter_rebates_monthly($date_from, $date_to, $region);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Search daily sales by date.
    public function search_by_date(){
        $date = date('Y-m-d', strtotime($this->input->get('search')));
        $data['title'] = 'Search Results | Realtors PK';
        $data['content'] = 'admin/daily_sales';
        $data['results'] = $this->admin_model->get_by_date($date);
        // echo json_encode($data['results']); exit;
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Teams - Add new team
    public function add_team(){
        $data = array(
            'added_by' => $this->session->userdata('id'),
            'team_name' => $this->input->post('team_name'),
            'team_lead' => $this->input->post('team_lead'),
            'bdm_name' => $this->input->post('bdm_name')
        );
        if($this->admin_model->add_team($data)){
            $this->session->set_flashdata('success', 'Team has been added successfully.');
            redirect('admin/dashboard');
        }else{
            $this->session->set_flashdata('failed', 'Something went wrong, please try again.');
            redirect('admin/dashboard');
        }
    }
    // List teams
    public function teams($offset = NULL){
        if(!$this->session->userdata('username')){
            redirect('');
        }
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/teams';
        $rowscount = $this->admin_model->count_teams();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Teams | Realtors PK';
        $data['content'] = 'admin/teams';
        $data['teams'] = $this->admin_model->get_teams($limit, $offset);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Get agents in teams
    public function agents_in_team($team_id){
        $agents = $this->admin_model->agents_in_team($team_id);
        echo json_encode($agents);
    }
    // Assign employee to a team.
    public function assign_team($id){
        $data = array(
            'emp_team' => $this->input->post('team_id')
        );
        $this->admin_model->assign_employee_to_team($id, $data);
    }
	// Team info > edit team
	public function team_info($team_id){
		$team_info = $this->admin_model->team_info($team_id);
		echo json_encode($team_info);
	}
    // Update team information.
    public function update_team(){
        $id = $this->input->post('team_id');
        $data = array(
            'team_name' => $this->input->post('team_name'),
            'team_lead' => $this->input->post('team_lead'),
            'bdm_name' => $this->input->post('bdm_name')
        );
        if($this->admin_model->update_team($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Updating team information was successful.');
            redirect('admin/teams');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Updating team information was not successful. Please try again.');
            redirect('admin/teams');
        }
    }
    // Sales report
    public function sales_report(){
        $data['title'] = 'Sales Reporting > Daily Sales';
        $data['content'] = 'admin/sales_report';
        $data['teams'] = $this->admin_model->get_sales_teams();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Get daily sales report.
    public function generate_sales_report(){
        $month = $this->input->get('month');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $team = $this->input->get('team');
        $city = $this->input->get('city');
        $agent = $this->input->get('agent');
        $project = $this->input->get('project');
        $data['title'] = 'Search Results > Sales Reporting > Daily Sales';
        $data['content'] = 'admin/sales_report';
        $data['teams'] = $this->admin_model->get_sales_teams();
        $data['results'] = $this->admin_model->get_sales_report($month, $date_from, $date_to, $team, $city, $agent, $project);
        // echo json_encode($data['results']);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Managers' commissions > Peshawar.
    public function commissions(){
        $data['title'] = 'Commissions > Sales Reporting > Daily Sales';
        $data['content'] = 'admin/commissions';
        $data['daily_sales'] = $this->home_model->get_daily_sales();
        $data['teams_report'] = $this->home_model->get_teams_report();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Filter mangagers' commissions by month.
    public function filter_by_month(){
        $month = date('F, Y', strtotime($this->input->get('month')));
        $data['title'] = 'Monthly Commissions > Sales Reporting > Daily Sales';
        $data['content'] = 'admin/commissions';
        $data['monthly_commissions'] = $this->admin_model->teams_report_by_month($month);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Filter mangagers' commissions by month.
    public function filter_by_month_hangu(){
        $month = date('F, Y', strtotime($this->input->get('month')));
        $data['title'] = 'Monthly Commissions > Sales Reporting > Daily Sales';
        $data['content'] = 'admin/commissions_hangu';
        $data['monthly_commissions_hangu'] = $this->admin_model->teams_report_by_month_hangu($month);
        $this->load->view('admin/commons/admin_template', $data);
    }
    //== ------------------------------------------------- Buybacks section ---------------------------------------------- ==//
    // Buybacks -> dashboard.
    public function buybacks($offset = NULL){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/buybacks';
        $rowscount = $this->admin_model->total_buyback_requests();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Buybacks > Realtors PK';
        $data['content'] = 'admin/buybacks/dashboard';
        $data['agents'] = $this->admin_model->get_agents();
        $data['buybacks'] = $this->admin_model->get_buyback_requests($limit, $offset);
        $data['pending'] = $this->admin_model->count_requests(0); // Status = Pending
        $data['processed'] = $this->admin_model->count_requests(1); // Status = Processed
        $data['initially_approved'] = $this->admin_model->count_requests(2); // Status = Initially Approved
        $data['signed'] = $this->admin_model->count_requests(3); // Status = Signed
        $data['approved'] = $this->admin_model->count_requests(4); // Status = Approved
        $data['rejected'] = $this->admin_model->count_requests(5); // Status = rejected
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Initiate request
    public function initiate_request(){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $data = array(
            'customer_name' => $this->input->post('name'),
            'customer_cnic' => $this->input->post('cnic'),
            'agent' => $this->input->post('agent'),
            'project' => $this->input->post('project'),
            'date_of_investment' => $this->input->post('investment_date'),
            'investment_amount' => $this->input->post('investment_amount'),
            'refund_amount' => $this->input->post('refund_amount'),
            'refund_reason' => $this->input->post('buyback_reason')
        );
        if($this->admin_model->initiate_request($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Request initiation was successful.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong while initiating a request.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // Buyback requests
    public function request_detail($id){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $data['title'] = 'Request Detail > Buybacks > Realtors PK';
        $data['content'] = 'admin/buybacks/buyback-detail';
        $data['request_detail'] = $this->admin_model->get_request_detail($id);
        $data['buyback_logs'] = $this->admin_model->get_buyback_logs($data['request_detail']->id);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // List all buyback requests
    public function list_buyback_requests($offset = NULL){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/list_buyback_requests';
        $rowscount = $this->admin_model->total_buyback_requests();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'List Buyback Requests > Buyback Portal > Realtors PK';
        $data['content'] = 'admin/buybacks/buyback-list';
        $data['buybacks'] = $this->admin_model->get_buyback_requests($limit, $offset);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Search in buyback requests > for specific request.
    public function search_buyback_requests(){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Buyback Requests > Realtors PK';
        $data['content'] = 'admin/buybacks/buyback-list';
        $data['results'] = $this->admin_model->search_buyback_requests($search);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Upload document
    public function upload_documents(){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $session = $this->session->userdata('department'); // declare a variable and pass session's dept ID.
        $config['upload_path'] = './uploads/buyback_docs/';
		$config['allowed_types'] = 'pdf|docx';
        $config['encrypt_name'] = false;
        $config['max_size'] = '2048000';
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('document_name')){
            echo $this->upload->display_errors();
        }else{
            $fileData = $this->upload->data();
            $document_name = $fileData['file_name'];
        }
        $processed_by = ''; // declare an empty variable for assgning value lo it later.
        if($session == 10){ $processed_by .= 'admin'; }elseif($session == 5){ $processed_by .= 'finance'; }elseif($session == 11){ $processed_by .= 'ccd'; } // Assign value to $processed_by based on the dept id in session.
        $data = array(
            'request_id' => $this->input->post('request_id'),
            'document_name' => $document_name, // document name.
            'added_by' => $this->session->userdata('id'),
            'remarks' => $this->input->post('remarks'),
            'processed_by' => $processed_by
        );
        if($this->admin_model->upload_documents($data)){
            $request_status_update = array(
                'status' => $this->input->post('status_flag') // processed, initially approved, signed, approved or rejected.
            );
            $this->admin_model->update_request_status($_POST['request_id'], $request_status_update);
            $this->session->set_flashdata('success', '<strong>Success! </strong>File attachment was successful.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Uh oh! something went wrong, please try again!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //== ------------------------------------------------ Customers ------------------------------------------- ==//
    // Customers - list customers
    public function customers($offset = null){
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/customers';
        $rowscount = $this->admin_model->total_customers();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Customers | Realtors PK';
        $data['content'] = 'admin/customers/customers';
        $data['customers'] = $this->admin_model->get_customers($limit, $offset);
        $data['agents'] = $this->admin_model->get_agents();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // add new customer
    public function add_customer(){
        $data = array(
			'added_by' => $this->session->userdata('id'),
			'customer_name' => $_POST['name'],
			'customer_cnic' => $_POST['cnic'],
			'customer_contact' => $_POST['phone'],
			'customer_agent' => $_POST['agent'],
			'project' => $_POST['project'],
			'customer_address' => $_POST['address'],
			'customer_pass' => sha1($_POST['phone']),
			'nok_name' => $_POST['nok_name'],
			'nok_cnic' => $_POST['nok_cnic'],
			'nok_relation' => $_POST['nok_relation'],
			'nok_contact' => $_POST['nok_contact'],
			'bank_name' => $_POST['bank_name'],
			'branch_code' => $_POST['branch_code'],
			'account_no' => $_POST['account_no'],
			'tax_status' => $_POST['tax_status'],
		);
        if($this->admin_model->add_customer($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Customer was added successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Customer was not added successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // public function edit customer - get customer by ID
    public function edit_customer($id){
        $customer = $this->admin_model->edit_customer($id);
        echo json_encode($customer);
    }
    // update customer information by ID
    public function update_customer(){
        $id = $this->input->post('customer_id');
        $data = array(
			'added_by' => $this->session->userdata('id'),
			'customer_name' => $_POST['name'],
			'customer_cnic' => $_POST['cnic'],
			'customer_contact' => $_POST['phone'],
			'customer_agent' => $_POST['agent'],
			'project' => $_POST['project'],
			'customer_address' => $_POST['address'],
			'customer_pass' => sha1($_POST['phone']),
			'nok_name' => $_POST['nok_name'],
			'nok_cnic' => $_POST['nok_cnic'],
			'nok_relation' => $_POST['nok_relation'],
			'nok_contact' => $_POST['nok_contact'],
			'bank_name' => $_POST['bank_name'],
			'branch_code' => $_POST['branch_code'],
			'account_no' => $_POST['account_no'],
			'tax_status' => $_POST['tax_status'],
		);
        if($this->admin_model->update_customer($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Customer information was updated successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Customer information was not updated successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // update customer status / enable or disable by ID
    public function update_customer_status($id){
        if($this->admin_model->update_customer_status($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Customer status was updated successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Customer status was not updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // search customers
    public function search_customers(){
        $search = $this->input->get('search');
        $data['title'] = 'Customers | Realtors PK';
        $data['content'] = 'admin/customers/customers';
        $data['result'] = $this->admin_model->search_customers($search);
        // $data['agents'] = $this->admin_model->get_agents();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // Terminate session and log the user out.
    public function logout(){
        $this->session->sess_destroy();
        redirect('admin');
    }
}

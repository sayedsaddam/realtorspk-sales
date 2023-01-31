<?php defined('BASEPATH') OR exit('No direct script access allowed!');

class Home extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('home_model', 'admin_model'));
    }
    // Check credentials and give access to view daily sales - Region based
    public function get_access(){ // Login
        $username = $this->input->post('username');
        $password = sha1($this->input->post('password'));
        $login = $this->home_model->get_access($username, $password);
        if($login > '0'){
            $id = $login->id;
            $username = $login->username;
            $name = $login->fullname;
            $this->session->set_userdata(array('id' => $id, 'username' => $username, 'fullname' => $name));
			$session = $this->session->userdata('username');
            if($session == 'realtors' || $session == 'yasir.ali' || $session == 'akbar.arbab' || $session == 'obaid.rehman' || $session == 'shahana.farah' || $session == 'adil.hussain' || $session == 'nasir.jalil' || $session == 'isdaq.ahmed'){
                redirect('home/daily_sales');
            }
        }else{
            $this->session->set_flashdata('access_denied', "<strong>Oops! </strong>Something went wrong, but don't fret. Let's give it another shot.");
            redirect('home/daily_sales');
        }
    }
    // Get daily sales > all cities, filter by city name when displaying on the leaderboard.
    public function daily_sales(){
		$data['daily_sales'] = $this->home_model->get_daily_sales();
        // $data['daily_sales_mgt'] = $this->home_model->get_daily_sales_management();
        // $data['daily_sales_mgt_isbd'] = $this->home_model->get_daily_sales_management_isbd();
        $data['teams_report'] = $this->home_model->get_teams_report();
        // $data['all_targets'] = $this->home_model->all_targets();
        // $data['teams'] = $this->home_model->all_teams();
		$data['bcms'] = $this->home_model->get_bcms_report();
		$data['annual_sales_agents'] = $this->home_model->annual_sales_agents();
		$data['annual_sales_teams'] = $this->home_model->annual_sales_teams();
		$data['annual_sales_bcm'] = $this->home_model->annual_sales_bcm();
        $this->load->view('daily_sales', $data);
    }
    // Page not found. 404 override.
    public function page_not_found(){
        $this->load->view('page-not-found');
    }
    // Destroy session and log the user out.
    public function signout(){
        $this->session->sess_destroy();
        redirect('home/daily_sales');
    }
    // Sales teams
    public function sales_teams(){
        $data = $this->home_model->sales_teams();
        echo json_encode($data);
    }
	// agent sales info > get by agent ID
	public function sales_info($agent_id){
		$sales_info = $this->home_model->agent_sales_info($agent_id);
		echo json_encode($sales_info);
	}
    // Filter employees by team > Team info.
    public function get_team_info($team_id){
        $team_info = $this->home_model->get_teams_info($team_id);
        echo json_encode($team_info);
    }
    // Check email whether it's official or not.
    public function check_email($email){
        if(stristr($email, '@ahgroup-pk.com') !== false) return true;
        if(stristr($email, '@s2smark.com') !== false) return true;
		if(stristr($email, '@realtorspk.com') !== false) return true;
        $this->load->library('form_validation');
        $this->form_validation->set_message('check_email', 'Please enter your official email address.');
        return false;
    }
}

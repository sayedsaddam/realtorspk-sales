<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Bookings extends CI_Controller{
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $this->load->model(array('booking_model', 'inventory_model', 'admin_model'));
        $this->load->helper('paginate');
    }
    // index method
    public function index($offset = null){
        $limit = 10;
        $data['title'] = 'Bookings | AH Group';
        $data['content'] = 'admin/bookings/dashboard';
        $data['bookings'] = $this->booking_model->get_bookings($limit, $offset);
        $data['installments'] = $this->booking_model->installments_history($limit, $offset);
        $data['total_bookings'] = $this->booking_model->total_bookings();
        $data['total_installments'] = $this->booking_model->total_installments();
        $data['bookings_amount'] = $this->booking_model->total_booking_amount();
        $data['installments_amount'] = $this->booking_model->total_installments_amount();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // book now
    public function purchase_now($unit_id, $offset = null){
        $limit = 1000;
        $data['title'] = 'Booking Unit | AH Group';
        $data['content'] = 'admin/bookings/booking-form';
        $data['unit_info'] = $this->inventory_model->get_unit_detail($unit_id);
        $data['customers'] = $this->admin_model->get_customers($limit, $offset);
        $data['agents'] = $this->admin_model->get_agents();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // send form data into database
    public function store_booking_info(){
        $unit_id = $this->input->post('unit_id'); // hidden field
        $customer = explode(',', $this->input->post('customer'));
        $customer_id = $customer[0];
        $price = $this->input->post('price');
        $discount = $this->input->post('discount');
        $buying_area = $this->input->post('buying_area');
        $total_price = ($price - $discount) * $buying_area; // total price after subtracting discount.
        $discounted_price = ($price - $discount);
        $data = array(
            'customer' => $customer_id,
            'unit_id' => $unit_id,
            'payment_mode' => $this->input->post('payment_mode'),
            'reference_number' => $this->input->post('reference_number'),
            'amount_paid' => $this->input->post('amount_paid'),
            'discount' => $this->input->post('discount'),
            'buying_area' => $buying_area,
            'price' => $total_price,
            'sale_price' => $discounted_price,
            'remarks' => $this->input->post('remarks'),
            'type' => $this->input->post('type'),
            'qr_code' => base_url('home/booking_detail/'.$unit_id),
            'added_by' => $this->session->userdata('id')
        );
        $verify_customer = $this->db->select('id')->from('customers')->where('id', $customer_id)->get()->row();
        if($verify_customer == 0){
            $this->session->set_flashdata('failed', 'The Customer field is required.');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if($this->booking_model->add_booking_info($data)){ 
            $this->inventory_model->change_unit_status($unit_id); // update unit status to sold
            $this->session->set_flashdata('success', '<strong>Success! </strong>Booking information saved sucessfully & the inventory status updated to booked.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
    }
    // bookings list >> all bookings
    public function bookings_list($offset = null){
        $limit = 15;
        $url = 'bookings/bookings_list';
        $rowscount = $this->booking_model->total_bookings();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Bookings List | AH Group';
        $data['content'] = 'admin/bookings/bookings-list';
        $data['bookings'] = $this->booking_model->get_bookings($limit, $offset);
        $data['total_bookings'] = $this->booking_model->total_bookings();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // booking detail by booking ID
    public function booking_detail($booking_id){
        $data['title'] = 'Booking Detail | AH Group';
        $data['content'] = 'admin/bookings/booking-detail';
        $data['booking_detail'] = $this->booking_model->get_booking_detail($booking_id);
        $data['installments'] = $this->booking_model->get_installments($booking_id); // installments against a booking.
        $this->load->view('admin/commons/admin_template', $data);
    }
    // search bookings
    public function search_bookings(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results | AH Group';
        $data['content'] = 'admin/bookings/bookings-list';
        $data['results'] = $this->booking_model->search_bookings($search); // search results
        $data['total_bookings'] = $this->booking_model->total_bookings();
        $this->load->view('admin/commons/admin_template', $data);

    }
    // edit booking > get booking by ID
    public function edit_booking($booking_id, $offset = null){
        $limit = 10000;
        $data['title'] = 'Edit Booking | AH Group';
        $data['content'] = 'admin/bookings/edit-booking';
        $data['customers'] = $this->admin_model->get_customers($limit, $offset);
        $data['agents'] = $this->admin_model->get_agents();
        $data['projects'] = $this->inventory_model->get_projects();
        $data['edit_booking'] = $this->booking_model->get_booking_detail($booking_id);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // update booking
    public function update_booking(){
        $booking_id = $this->input->post('booking_id'); // hidden field
        $unit_id = $this->input->post('unit_id'); // hidden field
        $old_unit_id = $this->input->post('old_unit_id'); // hidden field
        $customer = explode(',', $this->input->post('customer'));
        $customer_id = $customer[0];
        $price = $this->input->post('price');
        $discount = $this->input->post('discount');
        $buying_area = $this->input->post('buying_area');
        $total_price = ($price - $discount) * $buying_area; // total price after subtracting discount.
        $discounted_price = ($price - $discount);
        $data = array(
            'customer' => $customer_id,
            'unit_id' => $unit_id,
            'payment_mode' => $this->input->post('payment_mode'),
            'reference_number' => $this->input->post('reference_number'),
            'amount_paid' => $this->input->post('amount_paid'),
            'discount' => $this->input->post('discount'),
            'buying_area' => $buying_area,
            'price' => $total_price,
            'sale_price' => $discounted_price,
            'remarks' => $this->input->post('remarks'),
            'type' => $this->input->post('type'),
            'qr_code' => base_url('home/booking_detail/'.$this->input->post('unit_id')),
            'updated_by' => $this->session->userdata('id'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $verify_customer = $this->db->select('id')->from('customers')->where('id', $customer_id)->get()->row();
        if($verify_customer == 0){
            $this->session->set_flashdata('failed', 'The Customer field is required.');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if($this->booking_model->update_booking_info($booking_id, $data)){
            $this->inventory_model->change_unit_status($unit_id); // update new unit status to sold
            $this->inventory_model->change_unit_status($old_unit_id); // set old unit status to available
            $this->session->set_flashdata('success', '<strong>Success! </strong>Booking information updated sucessfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
    }
    //== ------------------------------------------------- Installments ------------------------------------------------- ==//
    // add new installment
    public function add_installment(){
        $date_added = '';
        $cheque_status = '';
        if($this->input->post('payment_mode') == 'cash'){
            $date_added = date('Y-m-d');
            $cheque_status = 'cleared';
        }else{
            $cheque_status = $this->input->post('cheque_status');
            $date_added = $this->input->post('date_added');
        }
        $data = array(
            'booking_id' => $this->input->post('booking_id'),
            'payment_mode' => $this->input->post('payment_mode'),
            'amount_paid' => $this->input->post('amount_paid'),
            'reference_number' => $this->input->post('reference_number'),
            'cheque_status' => $cheque_status,
            'rejection_reason' => $this->input->post('rejection_reason'),
            'date_added' => $date_added,
            'remarks' => $this->input->post('remarks'),
            'added_by' => $this->session->userdata('id')
        );
        if($this->booking_model->add_installment($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Installment was added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Installment was not added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // list of installments >> installment history
    public function installment_history($offset = null){
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $data['title'] = 'Installment History | AH Group';
        $data['content'] = 'admin/bookings/installments'; // view
        $data['installments'] = $this->booking_model->installments_history($limit, $offset);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // installment detail for updating cheque status
    public function installment_detail($installment_id){
        $detail = $this->booking_model->installment_detail($installment_id);
        echo json_encode($detail);
    }
    // update cheque status
    public function update_cheque_status(){
        $installment_id = $this->input->post('installment_id');
        $data = array(
            'cheque_status' => $this->input->post('cheque_status'),
            'date_added' => $this->input->post('date_added')
        );
        if($this->booking_model->update_cheque_status($installment_id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Cheque status was updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Cheque status was not updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // search installments history
    public function search_installment_history(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Resutls &raquo; Installment History | AH Group';
        $data['content'] = 'admin/bookings/installments'; // view
        $data['results'] = $this->booking_model->search_installment_history($search);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // installment calculator
    public function installment_calculator(){
        $data['title'] = 'Installment Calculator | AH Group';
        $data['content'] = 'admin/bookings/installment-calculator'; // view
        $this->load->view('admin/commons/admin_template', $data);
    }
}

<?php

use function PHPSTORM_META\map;

 defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Inventory extends CI_Controller{
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('username')){
            redirect('admin');
        }
        $this->load->model(array('inventory_model', 'home_model'));
        $this->load->helper('paginate');
    }
    // calling the index method
    public function index($offset = null){
        $limit = 15;
        $data['title'] = 'Inventory | AH Group';
        $data['content'] = 'admin/inventory/dashboard';
        $data['projects'] = $this->inventory_model->get_projects();
        $data['floors'] = $this->inventory_model->get_floors($limit, $offset);
        $data['units'] = $this->inventory_model->get_units($limit, $offset);
        $data['total_projects'] = $this->inventory_model->total_projects();
        $data['total_floors'] = $this->inventory_model->total_floors();
        $data['total_units'] = $this->inventory_model->total_units();
        $data['locations'] = $this->inventory_model->get_locations();

        $this->load->view('admin/commons/admin_template', $data);
    }
    // add project
    public function add_project(){
        $name = $this->input->post('name');
        $slug = url_title($name, 'dash', true);
        $data = array(
            'location' => $this->input->post('location'),
            'name' => $name,
            'slug' => $slug,
            'no_of_floors' => $this->input->post('floors'),
            'project_description' => $this->input->post('description'),
            'added_by' => $this->session->userdata('id')
        );
        if($this->inventory_model->add_project($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Project was added successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Project was not added successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // project detail -> get project by slug
    public function project_detail($slug){
        $data['content'] = 'admin/inventory/project_detail';
        $data['project'] = $this->inventory_model->project_detail($slug);
        $data['title'] = $data['project']->name.' &raquo; Projects | AH Group';
        $data['docs'] = $this->inventory_model->get_project_docs($data['project']->id);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // edit project - get project by ID
    public function edit_project($slug){
        $project = $this->inventory_model->project_detail($slug);
        echo json_encode($project);
    }
    // update project > by ID
    public function update_project(){
        $id = $this->input->post('project_id');
        $name = $this->input->post('name');
        $slug = url_title($name, 'dash', true);
        $data = array(
            'location' => $this->input->post('location'),
            'name' => $name,
            'slug' => $slug,
            'no_of_floors' => $this->input->post('floors'),
            'project_description' => $this->input->post('description'),
        );
        if($this->inventory_model->update_project($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Project was added successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Project was not added successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // upload project documents
    public function upload_project_docs(){
        $config['upload_path'] = './uploads/project_docs/';
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
        $data = array(
            'project_id' => $this->input->post('project_id'),
            'doc_name' => $document_name,
            'doc_type' => $this->input->post('doc_type'),
            'added_by' => $this->session->userdata('id')
        );
        if($this->inventory_model->upload_documents($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Project docs were uploaded successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        }else
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Project docs were not uploaded successfully!');
            redirect($_SERVER['HTTP_REFERER']);
    }
    // add floor information
    public function add_floor(){
        $exits = $this->inventory_model->added_floor($_POST['project'], strtolower($_POST['name']));
        if($exits != null){
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Floor with the name provided already exists in this project.');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $data = array(
            'project_id' => $this->input->post('project'),
            'floor_type' => $this->input->post('type'),
            'name' => $this->input->post('name'),
            'covered_area' => $this->input->post('covered_area'),
            'sellable_area' => $this->input->post('sellable_area'),
            'price' => $this->input->post('price'),
            'floor_description' => $this->input->post('description'),
            'added_by' => $this->session->userdata('id')
        );
        if($this->inventory_model->add_floor($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Floor info was added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Floor info was not added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // floor detail > get floor information by floor id
    public function floor_detail($floor_id){
        $floor_detail = $this->inventory_model->floor_detail($floor_id);
        echo json_encode($floor_detail);
    }
    // update floor informaiton
    public function update_floor(){
        $floor_id = $this->input->post('floor_id');
        $data = array(
            'project_id' => $this->input->post('project'),
            'floor_type' => $this->input->post('type'),
            'name' => $this->input->post('name'),
            'covered_area' => $this->input->post('covered_area'),
            'sellable_area' => $this->input->post('sellable_area'),
            'price' => $this->input->post('price'),
            'floor_description' => $this->input->post('description'),
            'added_by' => $this->session->userdata('id')
        );
        if($this->inventory_model->update_floor($floor_id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Floor info was updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Floor info was not updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // floors list
    public function floors($offset = null){
        $limit = 15;
        $url = 'inventory/floors';
        $rowscount = $this->inventory_model->total_floors();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Inventory &raquo; Floors | AH Group';
        $data['content'] = 'admin/inventory/floors';
        $data['projects'] = $this->inventory_model->get_projects();
        $data['floors'] = $this->inventory_model->get_floors($limit, $offset);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // search floors
    public function search_floors(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results &raquo; Floors | AH Group';
        $data['content'] = 'admin/inventory/floors';
        $data['projects'] = $this->inventory_model->get_projects();
        $data['results'] = $this->inventory_model->search_floors($search);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // update floor status > change it to either 1 or 0
    public function change_floor_status($id){
        if($this->inventory_model->change_floor_status($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Floor status was updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Floor status was not updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // get floors by project id for units adding form
    public function get_floors_byProject($project_id){
        $floors = $this->inventory_model->get_floors_byProject($project_id);
        echo json_encode($floors);
    }
    // get units by floor id for editing a booking
    public function get_units_byFloor($floor_id){
        $units = $this->inventory_model->get_units_byFloor($floor_id);
        echo json_encode($units);
    }
    // add a unit
    public function add_unit(){
        $data = array(
            'project_id' => $this->input->post('project'),
            'floor_id' => $this->input->post('floor'),
            'unit_name' => $this->input->post('unit_name'),
            'unit_size' => $this->input->post('size'),
            'no_of_beds' => $this->input->post('beds'),
            'price' => $this->input->post('price'),
            'added_by' => $this->session->userdata('id')
        );
        if($this->inventory_model->add_unit($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Unit was added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Unit was not added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // get all units
    public function units($offset = null){
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'inventory/units';
        $rowscount = $this->inventory_model->total_units();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Units List | AH Group';
        $data['content'] = 'admin/inventory/units';
        $data['units'] = $this->inventory_model->get_units($limit, $offset);
        $data['projects'] = $this->inventory_model->get_projects();
        $this->load->view('admin/commons/admin_template', $data);
    }
    // get unit detail by unit id
    public function unit_detail($unit_id){
        $detail = $this->inventory_model->get_unit_detail($unit_id);
        echo json_encode($detail);
    }
    // update unit
    public function update_unit(){
        $unit_id = $this->input->post('unit_id');
        $data = array(
            'unit_name' => $this->input->post('unit_name'),
            'unit_size' => $this->input->post('size'),
            'no_of_beds' => $this->input->post('beds'),
            'price' => $this->input->post('price')
        );
        if($this->inventory_model->update_unit($unit_id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Unit was updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Unit was not updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // change unit status
    public function change_unit_status($unit_id){
        if($this->inventory_model->change_unit_status($unit_id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Unit status was updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Unit status was not updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // search units
    public function search_units(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results &raquo; Units | AH Group';
        $data['content'] = 'admin/inventory/units';
        $data['projects'] = $this->inventory_model->get_projects();
        $data['results'] = $this->inventory_model->search_units($search);
        $this->load->view('admin/commons/admin_template', $data);
    }
    //== -------------------------------------------- AH Towers inventory -------------------------------------------------- ==//
    // add new inventory in AH Towers
    public function add_inventory_ah_towers(){
        $unit_size = $this->input->post('unit_size');
        $unit_price = $this->input->post('price');
        $total_value = ($unit_size * $unit_price);
        $data = array(
            'floor_name' => $this->input->post('floor_name'),
            'unit_no' => $this->input->post('unit_number'),
            'unit_description' => $this->input->post('unit_description'),
            'unit_size' =>$unit_size, // in sqft
            'price' => $unit_price,
            'total_value' => $total_value,
            'added_by' => $this->session->userdata('fullname')
        );
        if($this->inventory_model->add_inventory_ah_towers($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Inventory was added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Inventory was not added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // list inventory in AH Towers
    public function inventory_ah_towers($offset = null){
        $limit = 30;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'inventory/inventory_ah_towers';
        $rowscount = $this->home_model->total_inventory();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'AH Towers Inventory List | AH Group';
        $data['content'] = 'admin/inventory/aht_inventory';
        $data['aht_inventory'] = $this->inventory_model->get_inventory_ah_towers($limit, $offset);
        $this->load->view('admin/commons/admin_template', $data);
    }
    // get inventory detail by inventory id >> AH Towers
    public function inventory_detail_ah_towers($id){
        $detail = $this->inventory_model->get_inventory_ah_towers_detail($id);
        echo json_encode($detail);
    }
}

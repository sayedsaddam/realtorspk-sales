<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Inventory_model extends CI_Model{
    function __construct(){
        
    }
    // add new project
    public function add_project($data){
        $this->db->insert('projects', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // count total number of projects
    public function total_projects(){
        return $this->db->count_all('projects');
    }
    // get all projects
    public function get_projects(){
        return $this->db->select('id, location, name, slug, no_of_floors, project_description, status, created_at')->get('projects')->result();
    }
    // get project detail >> single project by slug
    public function project_detail($slug){
        return $this->db->get_where('projects', array('slug' => $slug))->row();
    }
    // update project > by ID
    public function update_project($id, $data){
        $this->db->where('id', $id);
        $this->db->update('projects', $data);
        return true;
    }
    // upload project documents
    public function upload_documents($data){
        $this->db->insert('project_docs', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // get project docs by project ID
    public function get_project_docs($project_id){
        $this->db->select('id, doc_name, doc_type, status, created_at');
        $this->db->from('project_docs');
        $this->db->where('project_id', $project_id);
        return $this->db->get()->result();
    }
    // count number of floors
    public function total_floors(){
        return $this->db->from('floors')->count_all_results();
    }
    // add floor information
    public function add_floor($data){
        $this->db->insert('floors', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // get all floor information
    public function get_floors($limit, $offset){
        $this->db->select('floors.id as floor_id,
                            floors.floor_type,
                            floors.name as floor_name,
                            floors.price,
                            floors.covered_area,
                            floors.sellable_area,
                            floors.floor_description,
                            floors.status,
                            floors.created_at,
                            projects.name as project_name');
        $this->db->from('floors');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('floors.created_at', 'DESC');
        return $this->db->get()->result();
    }
    // floor detail > get floor information by floor id
    public function floor_detail($floor_id){
        $this->db->select('floors.id as floor_id,
                            floors.floor_type,
                            floors.name as floor_name,
                            floors.covered_area,
                            floors.sellable_area,
                            floors.price,
                            floors.floor_description,
                            floors.status,
                            projects.id as project_id,
                            projects.name as project_name');
        $this->db->from('floors');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->where('floors.id', $floor_id);
        return $this->db->get()->row();
    }
    // check before adding floor > avoid duplicate floor entries
    public function added_floor($project, $name){
        return $this->db->get_where('floors', array('project_id' => $project, 'name' => strtolower($name)))->row();
    }
    // update floor information > by ID
    public function update_floor($floor_id, $data){
        $this->db->where('id', $floor_id);
        $this->db->update('floors', $data);
        return true;
    }
    // update floor status > change it to 1 or 0
    public function change_floor_status($id){
        $this->db->query("UPDATE floors SET `status` = NOT `status` WHERE id=$id");
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // search floors
    public function search_floors($search){
        $this->db->select('floors.id as floor_id,
                            floors.floor_type,
                            floors.name as floor_name,
                            floors.price,
                            floors.covered_area,
                            floors.sellable_area,
                            floors.floor_description,
                            floors.status,
                            floors.created_at,
                            projects.name as project_name');
        $this->db->from('floors');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->like('floors.name', $search);
        $this->db->or_like('floors.floor_type', $search);
        $this->db->or_like('floors.price', $search);
        $this->db->order_by('floors.created_at', 'DESC');
        return $this->db->get()->result();
    }
    // get floors by project id
    public function get_floors_byProject($project_id){
        return $this->db->select('id, name')->where('project_id', $project_id)->get('floors')->result();
    }
    // get units by floor id
    public function get_units_byFloor($floor_id){
        return $this->db->select('id, unit_name')->where(array('floor_id' => $floor_id, 'status' => 1))->get('units')->result(); // fetch available units only.
    }
    // add a unit
    public function add_unit($data){
        $this->db->insert('units', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // count total no. of units
    public function total_units(){
        return $this->db->from('units')->count_all_results();
    }
    // total available inventory
    public function total_available_units(){
        return $this->db->from('units')->where('status', 1)->count_all_results();
    }
    // total booked inventory
    public function total_booked_units(){
        return $this->db->from('units')->where('status', 0)->count_all_results();
    }
    // units not booked yet >> Completely available units
    public function available_units(){
        $this->db->select('*');
        $this->db->from('units');
        $this->db->where('id NOT IN (SELECT unit_id FROM bookings)');
        return $this->db->get()->num_rows();
    }
    // total sellable area of all floors
    public function total_sellable_area(){
        $this->db->select_sum('sellable_area');
        $this->db->from('floors');
        return $this->db->get()->row();
    }
    // total covered area of all floors
    public function total_covered_area(){
        $this->db->select_sum('covered_area');
        $this->db->from('floors');
        return $this->db->get()->row();
    }
    // get all units
    public function get_units($limit, $offset){
        $this->db->select('units.id as unit_id,
                            units.floor_id,
                            units.unit_name,
                            units.unit_size,
                            units.size_in_sqft,
                            units.no_of_beds,
                            units.price,
                            units.total_value,
                            units.status,
                            units.added_by,
                            units.created_at,
                            floors.id as floor,
                            floors.floor_type,
                            floors.name as floor_name,
                            projects.name as project_name');
        $this->db->from('units');
        $this->db->join('floors', 'units.floor_id = floors.id', 'left');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('units.id', 'DESC');
        return $this->db->get()->result();
    }
    // get booked units
    public function booked_units($limit, $offset){
        $this->db->select('units.id as unit_id,
                            units.floor_id,
                            units.unit_name,
                            units.unit_size,
                            units.size_in_sqft,
                            units.no_of_beds,
                            units.price,
                            units.total_value,
                            units.status,
                            units.added_by,
                            units.created_at,
                            floors.id as floor,
                            floors.floor_type,
                            floors.name as floor_name,
                            projects.name as project_name');
        $this->db->from('units');
        $this->db->join('floors', 'units.floor_id = floors.id', 'left');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->where('units.status', 0);
        $this->db->order_by('units.id', 'DESC');
        return $this->db->get()->result();
    }
    // get availale units
    public function available_inventory($limit, $offset){
        $this->db->select('units.id as unit_id,
                            units.floor_id,
                            units.unit_name,
                            units.unit_size,
                            units.size_in_sqft,
                            units.no_of_beds,
                            units.price,
                            units.total_value,
                            units.added_by,
                            units.status,
                            units.created_at,
                            floors.id as floor,
                            floors.floor_type,
                            floors.name as floor_name,
                            projects.name as project_name');
        $this->db->from('units');
        $this->db->join('floors', 'units.floor_id = floors.id', 'left');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->where('units.status', 1);
        $this->db->order_by('units.id', 'DESC');
        return $this->db->get()->result();
    }
    // get unit detail by unit_id
    public function get_unit_detail($unit_id){
        $this->db->select('units.id as unit_id,
                            units.floor_id,
                            units.unit_name,
                            units.unit_size,
                            units.size_in_sqft,
                            units.no_of_beds,
                            units.price,
                            units.total_value,
                            units.status,
                            units.added_by,
                            units.created_at,
                            floors.name as floor_name,
                            floors.floor_type,
                            floors.sellable_area,
                            floors.price as floor_price,
                            projects.name as project_name');
        $this->db->from('units');
        $this->db->join('floors', 'units.floor_id = floors.id', 'left');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->where('units.id', $unit_id);
        $this->db->order_by('units.created_at', 'DESC');
        return $this->db->get()->row();
    }
    // update unit detail
    public function update_unit($unit_id, $data){
        $this->db->where('id', $unit_id);
        $this->db->update('units', $data);
        return true;
    }
    // update unit status
    public function change_unit_status($id){
        $result = $this->db->query("UPDATE units SET `status` = NOT `status` WHERE id=$id");
        return $result ? true : false;
    }
    // search units
    public function search_units($search){
        $this->db->select('units.id as unit_id,
                            units.floor_id,
                            units.unit_name,
                            units.unit_size,
                            units.size_in_sqft,
                            units.no_of_beds,
                            units.price,
                            units.total_value,
                            units.status,
                            units.added_by,
                            units.created_at,
                            floors.id as floor,
                            floors.floor_type,
                            floors.name as floor_name,
                            projects.name as project_name');
        $this->db->from('units');
        $this->db->join('floors', 'units.floor_id = floors.id', 'left');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->like('units.unit_name', $search);
        $this->db->or_like('floors.floor_type', $search);
        $this->db->or_like('floors.name', $search);
        $this->db->or_like('projects.name', $search);
        $this->db->or_like('units.no_of_beds', $search);
        $this->db->order_by('units.id', 'DESC');
        return $this->db->get()->result();
    }
    // filter inventory by project
    public function projects($project, $limit, $offset){
        $this->db->select('units.id as unit_id,
                            units.floor_id,
                            units.unit_name,
                            units.unit_size,
                            units.size_in_sqft,
                            units.no_of_beds,
                            units.price,
                            units.total_value,
                            units.added_by,
                            units.status,
                            units.created_at,
                            floors.id as floor,
                            floors.floor_type,
                            floors.name as floor_name,
                            projects.name as project_name,
                            projects.slug as project_slug');
        $this->db->from('units');
        $this->db->join('floors', 'units.floor_id = floors.id', 'left');
        $this->db->join('projects', 'floors.project_id = projects.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->where('projects.slug', $project);
        $this->db->order_by('units.id', 'DESC');
        return $this->db->get()->result();
    }
}

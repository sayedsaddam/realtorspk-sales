<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Booking_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    // store booking information
    public function add_booking_info($data){
        $this->db->insert('bookings', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // update booking information
    public function update_booking_info($booking_id, $data){
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', $data);
        return true;
    }
    // cout all bookings
    public function total_bookings(){
        return $this->db->count_all('bookings');
    }
    // total amount paid for bookings
    public function total_booking_amount(){
        $this->db->select_sum('amount_paid');
        $query = $this->db->get('bookings');
        return $query->row();
    }
    // total amount paid via installments
    public function total_installments_amount(){
        $this->db->select_sum('amount_paid');
        $query = $this->db->get('installments');
        return $query->row();
    }
    // get bookings
    public function get_bookings($limit, $offset){
        $this->db->select('bookings.id as booking_id,
                            bookings.customer,
                            bookings.unit_id,
                            bookings.payment_mode,
                            bookings.reference_number,
                            bookings.amount_paid,
                            bookings.discount,
                            bookings.buying_area,
                            bookings.price as total_price,
                            bookings.sale_price,
                            bookings.status,
                            bookings.type,
                            bookings.qr_code,
                            bookings.created_at,
                            customers.id as customer_id,
                            customers.customer_name,
                            units.unit_name,
                            units.unit_size');
        $this->db->from('bookings');
        $this->db->join('customers', 'bookings.customer = customers.id', 'left');
        $this->db->join('units', 'bookings.unit_id = units.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('bookings.created_at', 'DESC');
        return $this->db->get()->result();
    }
    // get booking detail by booking_id
    public function get_booking_detail($booking_id){
        $this->db->select('bookings.id as booking_id,
                            bookings.customer,
                            bookings.unit_id,
                            bookings.payment_mode,
                            bookings.reference_number,
                            bookings.amount_paid,
                            bookings.discount,
                            bookings.buying_area,
                            bookings.price as total_price,
                            bookings.sale_price,
                            bookings.status,
                            bookings.remarks,
                            bookings.type,
                            bookings.qr_code,
                            bookings.created_at,
                            customers.id as customer_id,
                            customers.customer_name,
                            customers.customer_cnic,
                            units.unit_name,
                            units.unit_size');
        $this->db->from('bookings');
        $this->db->join('customers', 'bookings.customer = customers.id', 'left');
        $this->db->join('units', 'bookings.unit_id = units.id', 'left');
        $this->db->where('bookings.id', $booking_id);
        return $this->db->get()->row();
    }
    // booking detail by QR code
    public function booking_detail_qr($unit_id){
        $this->db->select('bookings.id as booking_id,
                            bookings.customer,
                            bookings.unit_id,
                            bookings.payment_mode,
                            bookings.reference_number,
                            bookings.amount_paid,
                            bookings.discount,
                            bookings.buying_area,
                            bookings.price as total_price,
                            bookings.sale_price,
                            bookings.status,
                            bookings.remarks,
                            bookings.type,
                            bookings.qr_code,
                            bookings.created_at,
                            customers.id as customer_id,
                            customers.customer_name,
                            customers.customer_cnic,
                            units.unit_name,
                            units.unit_size,
                            units.size_in_sqft,
                            units.no_of_beds');
        $this->db->from('bookings');
        $this->db->join('customers', 'bookings.customer = customers.id', 'left');
        $this->db->join('units', 'bookings.unit_id = units.id', 'left');
        $this->db->where('bookings.unit_id', $unit_id);
        return $this->db->get()->row();
    }
    // search bookings
    public function search_bookings($search){
        $this->db->select('bookings.id as booking_id,
                            bookings.customer,
                            bookings.unit_id,
                            bookings.payment_mode,
                            bookings.reference_number,
                            bookings.amount_paid,
                            bookings.discount,
                            bookings.buying_area,
                            bookings.price as total_price,
                            bookings.sale_price,
                            bookings.status,
                            bookings.type,
                            bookings.qr_code,
                            bookings.created_at,
                            customers.id as customer_id,
                            customers.customer_name,
                            units.unit_name,
                            units.unit_size');
        $this->db->from('bookings');
        $this->db->join('customers', 'bookings.customer = customers.id', 'left');
        $this->db->join('units', 'bookings.unit_id = units.id', 'left');
        $this->db->like('customers.customer_name', $search);
        $this->db->or_like('units.unit_name', $search);
        $this->db->or_like('bookings.reference_number', $search);
        $this->db->or_like('bookings.buying_area', $search);
        $this->db->order_by('bookings.created_at', 'DESC');
        return $this->db->get()->result();
    }
    //== ------------------------------------------------- Installments ------------------------------------------ ==//
    // total installments
    public function total_installments(){
        return $this->db->count_all('installments');
    }
    // add installment
    public function add_installment($data){
        $this->db->insert('installments', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // get installments
    public function get_installments($booking_id){
        $this->db->select('id, booking_id, payment_mode, amount_paid, reference_number, cheque_status, rejection_reason, date_added, remarks, added_by, created_at');
        $this->db->from('installments');
        $this->db->where('booking_id', $booking_id);
        // $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // sum installments against a booking
    public function sum_installments($booking_id){
        $this->db->select_sum('amount_paid');
        $this->db->from('installments');
        $this->db->where('booking_id', $booking_id);
        return $this->db->get()->row();
    }
    // get all installments
    public function installments_history($limit, $offset){
        $this->db->select('installments.id,
                            installments.payment_mode,
                            installments.amount_paid,
                            installments.cheque_status,
                            installments.date_added,
                            installments.created_at,
                            bookings.id as booking_id,
                            customers.id as customer_id,
                            customers.customer_name');
        $this->db->from('installments');
        $this->db->join('bookings', 'bookings.id = installments.booking_id', 'left');
        $this->db->join('customers', 'bookings.customer = customers.id', 'left');
        $this->db->order_by('installments.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // get installment detail for updating cheque status
    public function installment_detail($installment_id){
        return $this->db->select('id, date_added, cheque_status')->from('installments')->where(array('id' => $installment_id))->get()->row();
    }
    // update installment detail by ID, chanage trx date and cheque status
    public function update_cheque_status($installment_id, $data){
        $this->db->where('id', $installment_id);
        $this->db->update('installments', $data);
        return true;
    }
    // search installments history
    public function search_installment_history($search){
        $this->db->select('installments.id,
                            installments.payment_mode,
                            installments.amount_paid,
                            installments.cheque_status,
                            installments.date_added,
                            installments.created_at,
                            bookings.id as booking_id,
                            customers.id as customer_id,
                            customers.customer_name');
        $this->db->from('installments');
        $this->db->join('bookings', 'bookings.id = installments.booking_id', 'left');
        $this->db->join('customers', 'bookings.customer = customers.id', 'left');
        $this->db->like('customers.customer_name', $search);
        $this->db->or_like('installments.payment_mode', $search);
        $this->db->or_like('installments.cheque_status', $search);
        $this->db->or_like('installments.amount_paid', $search);
        $this->db->order_by('installments.created_at', 'DESC');
        return $this->db->get()->result();
    }
}

<?php defined('BASEPATH') OR exit('No directi script access allowed!');
/*
* Custom pagination helper.
*/
function paginate($url, $rowscount, $limit) {
	$ci = & get_instance();
	$ci->load->library('pagination');
	$config = array();
	$config["base_url"] = base_url($url);
	$config["total_rows"] = $rowscount;
	$config["per_page"] = $limit;
	$config["uri_segment"] = 3;
	$config['next_link']        = 'Next';
	$config['prev_link']        = 'Prev';
	$config['first_link']       = false;
	$config['last_link']        = false;
	$config['full_tag_open']    = '<ul class="pagination justify-content-center">';
	$config['full_tag_close']   = '</ul>';
	$config['attributes']       = ['class' => 'page-link'];
	$config['first_tag_open']   = '<li class="page-item">';
	$config['first_tag_close']  = '</li>';
	$config['prev_tag_open']    = '<li class="page-item">';
	$config['prev_tag_close']   = '</li>';
	$config['next_tag_open']    = '<li class="page-item">';
	$config['next_tag_close']   = '</li>';
	$config['last_tag_open']    = '<li class="page-item">';
	$config['last_tag_close']   = '</li>';
	$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
	$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
	$config['num_tag_open']     = '<li class="page-item">';
	$config['num_tag_close']    = '</li>';
	$ci->pagination->initialize($config);
}

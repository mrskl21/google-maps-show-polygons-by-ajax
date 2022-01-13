<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct(){
        parent::__construct();
        $this->load->model('table_lingkungan_lat_long');
        $this->load->model('table_location');
    }
	
	public function index()
	{
		$title = "Home";

		$this->load->view('maps', compact('title'));
	}

	public function get_data()
	{
		$data['location']	= $this->table_location->all();
		$data['polygon'] 	= $this->table_lingkungan_lat_long->all();
		
		// echo "<pre>";
		// echo print_r(
		// 	compact(
		// 		'data'
		// 	)
		// );
		// echo "</pre>";
		// die();
		echo json_encode($data);

	}
}

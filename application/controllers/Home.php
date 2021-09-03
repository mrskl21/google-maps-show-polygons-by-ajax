<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends CI_Controller {
	
	function __construct(){
        parent::__construct();
        $this->load->model('table_street_lights');
    }
	
	public function index()
	{
		$title = "Home";
		$data = $this->table_street_lights->all();

		$this->load->view('maps', compact('title','data'));
	}

	public function upload()
	{
		$config['upload_path']      = './assets/uploads/files/';
        $config['allowed_types']    = 'xls|xlsx|csv';
        $config['max_size']         = 5000;

        
  		$this->load->library('upload', $config);
  		$this->upload->initialize($config);

  		if($this->upload->do_upload('file')){
  			$cek_size_file = $this->upload->data('file_size');
  			$cek_nama_file = $this->upload->data('file_name');
  			$cek_type_file = $this->upload->data('file_type');
  			if ($cek_size_file < 2048) {
                $dokumen = array('upload_data' => $this->upload->data());

                $dokumen = array('file' => $this->upload->data());

                if('csv' == $cek_type_file){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }

                $spreadsheet = $reader->load($dokumen['file']['full_path']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                
                $data = array();

				for($i=1;$i<count($sheetData);$i++){
					if($sheetData[$i][1] == "" || $sheetData[$i][2] == "" || $sheetData[$i][3] == ""){
						break;
					}
					$data[$i]['id_survey']      = $sheetData[$i][1];
					$data[$i]['id_pju']         = $sheetData[$i][2];
					$data[$i]['ulp']         	= $sheetData[$i][3];
					$data[$i]['pemda']         	= $sheetData[$i][4];
					$data[$i]['kecamatan']      = $sheetData[$i][5];
					$data[$i]['lat']         	= $sheetData[$i][6];
					$data[$i]['lng']         	= $sheetData[$i][7];
				}

				// echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                // die();
                
                $this->table_street_lights->add_batch($data);
                // $this->session->set_flashdata('success',"Berhasil! Data Terupload.");
                redirect("home",'refresh');

            }else{
                $this->session->set_flashdata('error',"Gagal! File Terlalu Besar.");
                redirect("home",'refresh');
            }
  		}else{
            $this->session->set_flashdata('error',"Gagal! Data tidak terinput.");
            redirect("home",'refresh');
        }

        // echo print_r(compact('reg','witel','sto','device'));
	}
}

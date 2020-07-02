<?php

 /**
 * Author: Amirul Momenin
 * Desc:Attendance Controller
 *
 */
class Attendance extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Attendance_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of attendance table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['attendance'] = $this->Attendance_model->get_limit_attendance($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/attendance/index');
		$config['total_rows'] = $this->Attendance_model->get_count_attendance();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/attendance/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save attendance
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'employee_users_id' => html_escape($this->input->post('employee_users_id')),
'date_attendance' => html_escape($this->input->post('date_attendance')),
'time_attendance' => html_escape($this->input->post('time_attendance')),
'date_departure' => html_escape($this->input->post('date_departure')),
'time_departure' => html_escape($this->input->post('time_departure')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['attendance'] = $this->Attendance_model->get_attendance($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Attendance_model->update_attendance($id,$params);
				$this->session->set_flashdata('msg','Attendance has been updated successfully');
                redirect('admin/attendance/index');
            }else{
                $data['_view'] = 'admin/attendance/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $attendance_id = $this->Attendance_model->add_attendance($params);
				$this->session->set_flashdata('msg','Attendance has been saved successfully');
                redirect('admin/attendance/index');
            }else{  
			    $data['attendance'] = $this->Attendance_model->get_attendance(0);
                $data['_view'] = 'admin/attendance/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details attendance
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['attendance'] = $this->Attendance_model->get_attendance($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/attendance/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting attendance
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $attendance = $this->Attendance_model->get_attendance($id);

        // check if the attendance exists before trying to delete it
        if(isset($attendance['id'])){
            $this->Attendance_model->delete_attendance($id);
			$this->session->set_flashdata('msg','Attendance has been deleted successfully');
            redirect('admin/attendance/index');
        }
        else
            show_error('The attendance you are trying to delete does not exist.');
    }
	
	/**
     * Search attendance
	 * @param $start - Starting of attendance table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('employee_users_id', $key, 'both');
$this->db->or_like('date_attendance', $key, 'both');
$this->db->or_like('time_attendance', $key, 'both');
$this->db->or_like('date_departure', $key, 'both');
$this->db->or_like('time_departure', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['attendance'] = $this->db->get('attendance')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/attendance/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('employee_users_id', $key, 'both');
$this->db->or_like('date_attendance', $key, 'both');
$this->db->or_like('time_attendance', $key, 'both');
$this->db->or_like('date_departure', $key, 'both');
$this->db->or_like('time_departure', $key, 'both');

		$config['total_rows'] = $this->db->from("attendance")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/attendance/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export attendance
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'attendance_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $attendanceData = $this->Attendance_model->get_all_attendance();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Employee Users Id","Date Attendance","Time Attendance","Date Departure","Time Departure"); 
		   fputcsv($file, $header);
		   foreach ($attendanceData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $attendance = $this->db->get('attendance')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/attendance/print_template.php');
			$html = ob_get_clean();
			include(APPPATH."third_party/mpdf60/mpdf.php");					
			$mpdf=new mPDF('','A4'); 
			//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
			//$mpdf->mirrorMargins = true;
		    $mpdf->SetDisplayMode('fullpage');
			//==============================================================
			$mpdf->autoScriptToLang = true;
			$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
			$mpdf->autoVietnamese = true;
			$mpdf->autoArabic = true;
			$mpdf->autoLangToFont = true;
			$mpdf->setAutoBottomMargin = 'stretch';
			$stylesheet = file_get_contents(APPPATH."third_party/mpdf60/lang2fonts.css");
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			//$mpdf->AddPage();
			$mpdf->Output($filePath);
			$mpdf->Output();
			//$mpdf->Output( $filePath,'S');
			exit;	
	  }
	   
	}
}
//End of Attendance controller
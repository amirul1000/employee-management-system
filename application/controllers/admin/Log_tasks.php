<?php

 /**
 * Author: Amirul Momenin
 * Desc:Log_tasks Controller
 *
 */
class Log_tasks extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Log_tasks_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of log_tasks table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['log_tasks'] = $this->Log_tasks_model->get_limit_log_tasks($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/log_tasks/index');
		$config['total_rows'] = $this->Log_tasks_model->get_count_log_tasks();
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
		
        $data['_view'] = 'admin/log_tasks/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save log_tasks
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'employee_users_id' => html_escape($this->input->post('employee_users_id')),
'start_date' => html_escape($this->input->post('start_date')),
'end_date' => html_escape($this->input->post('end_date')),
'total_hrs' => html_escape($this->input->post('total_hrs')),
'task' => html_escape($this->input->post('task')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['log_tasks'] = $this->Log_tasks_model->get_log_tasks($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Log_tasks_model->update_log_tasks($id,$params);
				$this->session->set_flashdata('msg','Log_tasks has been updated successfully');
                redirect('admin/log_tasks/index');
            }else{
                $data['_view'] = 'admin/log_tasks/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $log_tasks_id = $this->Log_tasks_model->add_log_tasks($params);
				$this->session->set_flashdata('msg','Log_tasks has been saved successfully');
                redirect('admin/log_tasks/index');
            }else{  
			    $data['log_tasks'] = $this->Log_tasks_model->get_log_tasks(0);
                $data['_view'] = 'admin/log_tasks/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details log_tasks
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['log_tasks'] = $this->Log_tasks_model->get_log_tasks($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/log_tasks/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting log_tasks
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $log_tasks = $this->Log_tasks_model->get_log_tasks($id);

        // check if the log_tasks exists before trying to delete it
        if(isset($log_tasks['id'])){
            $this->Log_tasks_model->delete_log_tasks($id);
			$this->session->set_flashdata('msg','Log_tasks has been deleted successfully');
            redirect('admin/log_tasks/index');
        }
        else
            show_error('The log_tasks you are trying to delete does not exist.');
    }
	
	/**
     * Search log_tasks
	 * @param $start - Starting of log_tasks table's index to get query
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
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('total_hrs', $key, 'both');
$this->db->or_like('task', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['log_tasks'] = $this->db->get('log_tasks')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/log_tasks/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('employee_users_id', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('total_hrs', $key, 'both');
$this->db->or_like('task', $key, 'both');

		$config['total_rows'] = $this->db->from("log_tasks")->count_all_results();
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
		$data['_view'] = 'admin/log_tasks/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export log_tasks
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'log_tasks_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $log_tasksData = $this->Log_tasks_model->get_all_log_tasks();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Employee Users Id","Start Date","End Date","Total Hrs","Task"); 
		   fputcsv($file, $header);
		   foreach ($log_tasksData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $log_tasks = $this->db->get('log_tasks')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/log_tasks/print_template.php');
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
//End of Log_tasks controller
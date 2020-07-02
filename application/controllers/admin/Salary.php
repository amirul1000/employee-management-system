<?php

 /**
 * Author: Amirul Momenin
 * Desc:Salary Controller
 *
 */
class Salary extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Salary_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of salary table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['salary'] = $this->Salary_model->get_limit_salary($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/salary/index');
		$config['total_rows'] = $this->Salary_model->get_count_salary();
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
		
        $data['_view'] = 'admin/salary/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save salary
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'employee_users_id' => html_escape($this->input->post('employee_users_id')),
'date_paid' => html_escape($this->input->post('date_paid')),
'amount' => html_escape($this->input->post('amount')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['salary'] = $this->Salary_model->get_salary($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Salary_model->update_salary($id,$params);
				$this->session->set_flashdata('msg','Salary has been updated successfully');
                redirect('admin/salary/index');
            }else{
                $data['_view'] = 'admin/salary/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $salary_id = $this->Salary_model->add_salary($params);
				$this->session->set_flashdata('msg','Salary has been saved successfully');
                redirect('admin/salary/index');
            }else{  
			    $data['salary'] = $this->Salary_model->get_salary(0);
                $data['_view'] = 'admin/salary/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details salary
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['salary'] = $this->Salary_model->get_salary($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/salary/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting salary
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $salary = $this->Salary_model->get_salary($id);

        // check if the salary exists before trying to delete it
        if(isset($salary['id'])){
            $this->Salary_model->delete_salary($id);
			$this->session->set_flashdata('msg','Salary has been deleted successfully');
            redirect('admin/salary/index');
        }
        else
            show_error('The salary you are trying to delete does not exist.');
    }
	
	/**
     * Search salary
	 * @param $start - Starting of salary table's index to get query
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
$this->db->or_like('date_paid', $key, 'both');
$this->db->or_like('amount', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['salary'] = $this->db->get('salary')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/salary/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('employee_users_id', $key, 'both');
$this->db->or_like('date_paid', $key, 'both');
$this->db->or_like('amount', $key, 'both');

		$config['total_rows'] = $this->db->from("salary")->count_all_results();
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
		$data['_view'] = 'admin/salary/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export salary
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'salary_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $salaryData = $this->Salary_model->get_all_salary();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Employee Users Id","Date Paid","Amount"); 
		   fputcsv($file, $header);
		   foreach ($salaryData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $salary = $this->db->get('salary')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/salary/print_template.php');
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
//End of Salary controller
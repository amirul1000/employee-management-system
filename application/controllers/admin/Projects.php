<?php

 /**
 * Author: Amirul Momenin
 * Desc:Projects Controller
 *
 */
class Projects extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Projects_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of projects table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['projects'] = $this->Projects_model->get_limit_projects($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/projects/index');
		$config['total_rows'] = $this->Projects_model->get_count_projects();
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
		
        $data['_view'] = 'admin/projects/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save projects
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'name' => html_escape($this->input->post('name')),
'start_date' => html_escape($this->input->post('start_date')),
'end_date' => html_escape($this->input->post('end_date')),
'project_cost' => html_escape($this->input->post('project_cost')),
'description' => html_escape($this->input->post('description')),
'status' => html_escape($this->input->post('status')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['projects'] = $this->Projects_model->get_projects($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Projects_model->update_projects($id,$params);
				$this->session->set_flashdata('msg','Projects has been updated successfully');
                redirect('admin/projects/index');
            }else{
                $data['_view'] = 'admin/projects/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $projects_id = $this->Projects_model->add_projects($params);
				$this->session->set_flashdata('msg','Projects has been saved successfully');
                redirect('admin/projects/index');
            }else{  
			    $data['projects'] = $this->Projects_model->get_projects(0);
                $data['_view'] = 'admin/projects/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details projects
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['projects'] = $this->Projects_model->get_projects($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/projects/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting projects
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $projects = $this->Projects_model->get_projects($id);

        // check if the projects exists before trying to delete it
        if(isset($projects['id'])){
            $this->Projects_model->delete_projects($id);
			$this->session->set_flashdata('msg','Projects has been deleted successfully');
            redirect('admin/projects/index');
        }
        else
            show_error('The projects you are trying to delete does not exist.');
    }
	
	/**
     * Search projects
	 * @param $start - Starting of projects table's index to get query
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
$this->db->or_like('name', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('project_cost', $key, 'both');
$this->db->or_like('description', $key, 'both');
$this->db->or_like('status', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['projects'] = $this->db->get('projects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/projects/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('start_date', $key, 'both');
$this->db->or_like('end_date', $key, 'both');
$this->db->or_like('project_cost', $key, 'both');
$this->db->or_like('description', $key, 'both');
$this->db->or_like('status', $key, 'both');

		$config['total_rows'] = $this->db->from("projects")->count_all_results();
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
		$data['_view'] = 'admin/projects/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export projects
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'projects_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $projectsData = $this->Projects_model->get_all_projects();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Name","Start Date","End Date","Project Cost","Description","Status"); 
		   fputcsv($file, $header);
		   foreach ($projectsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $projects = $this->db->get('projects')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/projects/print_template.php');
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
//End of Projects controller
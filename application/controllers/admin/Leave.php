<?php

 /**
 * Author: Amirul Momenin
 * Desc:Leave Controller
 *
 */
class Leave extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Leave_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of leave table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['leave'] = $this->Leave_model->get_limit_leave($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/leave/index');
		$config['total_rows'] = $this->Leave_model->get_count_leave();
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
		
        $data['_view'] = 'admin/leave/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save leave
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'employee_users_id' => html_escape($this->input->post('employee_users_id')),
'reason' => html_escape($this->input->post('reason')),
'comment' => html_escape($this->input->post('comment')),
'date_from' => html_escape($this->input->post('date_from')),
'date_to' => html_escape($this->input->post('date_to')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['leave'] = $this->Leave_model->get_leave($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Leave_model->update_leave($id,$params);
				$this->session->set_flashdata('msg','Leave has been updated successfully');
                redirect('admin/leave/index');
            }else{
                $data['_view'] = 'admin/leave/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $leave_id = $this->Leave_model->add_leave($params);
				$this->session->set_flashdata('msg','Leave has been saved successfully');
                redirect('admin/leave/index');
            }else{  
			    $data['leave'] = $this->Leave_model->get_leave(0);
                $data['_view'] = 'admin/leave/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details leave
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['leave'] = $this->Leave_model->get_leave($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/leave/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting leave
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $leave = $this->Leave_model->get_leave($id);

        // check if the leave exists before trying to delete it
        if(isset($leave['id'])){
            $this->Leave_model->delete_leave($id);
			$this->session->set_flashdata('msg','Leave has been deleted successfully');
            redirect('admin/leave/index');
        }
        else
            show_error('The leave you are trying to delete does not exist.');
    }
	
	/**
     * Search leave
	 * @param $start - Starting of leave table's index to get query
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
$this->db->or_like('reason', $key, 'both');
$this->db->or_like('comment', $key, 'both');
$this->db->or_like('date_from', $key, 'both');
$this->db->or_like('date_to', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['leave'] = $this->db->get('leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/leave/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('employee_users_id', $key, 'both');
$this->db->or_like('reason', $key, 'both');
$this->db->or_like('comment', $key, 'both');
$this->db->or_like('date_from', $key, 'both');
$this->db->or_like('date_to', $key, 'both');

		$config['total_rows'] = $this->db->from("leave")->count_all_results();
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
		$data['_view'] = 'admin/leave/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export leave
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'leave_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $leaveData = $this->Leave_model->get_all_leave();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Employee Users Id","Reason","Comment","Date From","Date To"); 
		   fputcsv($file, $header);
		   foreach ($leaveData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $leave = $this->db->get('leave')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/leave/print_template.php');
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
//End of Leave controller
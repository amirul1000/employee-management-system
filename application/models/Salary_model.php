<?php

/**
 * Author: Amirul Momenin
 * Desc:Salary Model
 */
class Salary_model extends CI_Model
{
	protected $salary = 'salary';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get salary by id
	 *@param $id - primary key to get record
	 *
     */
    function get_salary($id){
        $result = $this->db->get_where('salary',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all salary
	 *
     */
    function get_all_salary(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('salary')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit salary
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_salary($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('salary')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count salary rows
	 *
     */
	function get_count_salary(){
       $result = $this->db->from("salary")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new salary
	 *@param $params - data set to add record
	 *
     */
    function add_salary($params){
        $this->db->insert('salary',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update salary
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_salary($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('salary',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete salary
	 *@param $id - primary key to delete record
	 *
     */
    function delete_salary($id){
        $status = $this->db->delete('salary',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}

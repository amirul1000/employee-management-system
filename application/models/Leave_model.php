<?php

/**
 * Author: Amirul Momenin
 * Desc:Leave Model
 */
class Leave_model extends CI_Model
{
	protected $leave = 'leave';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get leave by id
	 *@param $id - primary key to get record
	 *
     */
    function get_leave($id){
        $result = $this->db->get_where('leave',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all leave
	 *
     */
    function get_all_leave(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit leave
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_leave($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('leave')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count leave rows
	 *
     */
	function get_count_leave(){
       $result = $this->db->from("leave")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new leave
	 *@param $params - data set to add record
	 *
     */
    function add_leave($params){
        $this->db->insert('leave',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update leave
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_leave($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('leave',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete leave
	 *@param $id - primary key to delete record
	 *
     */
    function delete_leave($id){
        $status = $this->db->delete('leave',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}

<?php

/**
 * Author: Amirul Momenin
 * Desc:Attendance Model
 */
class Attendance_model extends CI_Model
{
	protected $attendance = 'attendance';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get attendance by id
	 *@param $id - primary key to get record
	 *
     */
    function get_attendance($id){
        $result = $this->db->get_where('attendance',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all attendance
	 *
     */
    function get_all_attendance(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('attendance')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit attendance
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_attendance($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('attendance')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count attendance rows
	 *
     */
	function get_count_attendance(){
       $result = $this->db->from("attendance")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new attendance
	 *@param $params - data set to add record
	 *
     */
    function add_attendance($params){
        $this->db->insert('attendance',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update attendance
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_attendance($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('attendance',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete attendance
	 *@param $id - primary key to delete record
	 *
     */
    function delete_attendance($id){
        $status = $this->db->delete('attendance',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}

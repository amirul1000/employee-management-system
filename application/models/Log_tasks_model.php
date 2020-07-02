<?php

/**
 * Author: Amirul Momenin
 * Desc:Log_tasks Model
 */
class Log_tasks_model extends CI_Model
{
	protected $log_tasks = 'log_tasks';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get log_tasks by id
	 *@param $id - primary key to get record
	 *
     */
    function get_log_tasks($id){
        $result = $this->db->get_where('log_tasks',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all log_tasks
	 *
     */
    function get_all_log_tasks(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('log_tasks')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit log_tasks
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_log_tasks($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('log_tasks')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count log_tasks rows
	 *
     */
	function get_count_log_tasks(){
       $result = $this->db->from("log_tasks")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new log_tasks
	 *@param $params - data set to add record
	 *
     */
    function add_log_tasks($params){
        $this->db->insert('log_tasks',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update log_tasks
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_log_tasks($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('log_tasks',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete log_tasks
	 *@param $id - primary key to delete record
	 *
     */
    function delete_log_tasks($id){
        $status = $this->db->delete('log_tasks',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}

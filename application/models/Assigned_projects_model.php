<?php

/**
 * Author: Amirul Momenin
 * Desc:Assigned_projects Model
 */
class Assigned_projects_model extends CI_Model
{
	protected $assigned_projects = 'assigned_projects';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get assigned_projects by id
	 *@param $id - primary key to get record
	 *
     */
    function get_assigned_projects($id){
        $result = $this->db->get_where('assigned_projects',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all assigned_projects
	 *
     */
    function get_all_assigned_projects(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('assigned_projects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit assigned_projects
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_assigned_projects($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('assigned_projects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count assigned_projects rows
	 *
     */
	function get_count_assigned_projects(){
       $result = $this->db->from("assigned_projects")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new assigned_projects
	 *@param $params - data set to add record
	 *
     */
    function add_assigned_projects($params){
        $this->db->insert('assigned_projects',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update assigned_projects
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_assigned_projects($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('assigned_projects',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete assigned_projects
	 *@param $id - primary key to delete record
	 *
     */
    function delete_assigned_projects($id){
        $status = $this->db->delete('assigned_projects',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}

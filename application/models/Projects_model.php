<?php

/**
 * Author: Amirul Momenin
 * Desc:Projects Model
 */
class Projects_model extends CI_Model
{
	protected $projects = 'projects';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get projects by id
	 *@param $id - primary key to get record
	 *
     */
    function get_projects($id){
        $result = $this->db->get_where('projects',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all projects
	 *
     */
    function get_all_projects(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('projects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit projects
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_projects($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('projects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count projects rows
	 *
     */
	function get_count_projects(){
       $result = $this->db->from("projects")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new projects
	 *@param $params - data set to add record
	 *
     */
    function add_projects($params){
        $this->db->insert('projects',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update projects
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_projects($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('projects',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete projects
	 *@param $id - primary key to delete record
	 *
     */
    function delete_projects($id){
        $status = $this->db->delete('projects',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}

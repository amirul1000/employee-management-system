<a  href="<?php echo site_url('admin/assigned_projects/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Assigned_projects'); ?></h5>
<!--Data display of assigned_projects with id--> 
<?php
	$c = $assigned_projects;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Employee Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['employee_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Projects</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Projects_model');
									   $dataArr = $this->CI->Projects_model->get_projects($c['projects_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Start Date</td><td><?php echo $c['start_date']; ?></td></tr>

<tr><td>End Date</td><td><?php echo $c['end_date']; ?></td></tr>

<tr><td>Task</td><td><?php echo $c['task']; ?></td></tr>


</table>
<!--End of Data display of assigned_projects with id//--> 
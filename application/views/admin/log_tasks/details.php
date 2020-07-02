<a  href="<?php echo site_url('admin/log_tasks/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Log_tasks'); ?></h5>
<!--Data display of log_tasks with id--> 
<?php
	$c = $log_tasks;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Employee Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['employee_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Start Date</td><td><?php echo $c['start_date']; ?></td></tr>

<tr><td>End Date</td><td><?php echo $c['end_date']; ?></td></tr>

<tr><td>Total Hrs</td><td><?php echo $c['total_hrs']; ?></td></tr>

<tr><td>Task</td><td><?php echo $c['task']; ?></td></tr>


</table>
<!--End of Data display of log_tasks with id//--> 
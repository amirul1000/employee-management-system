<a  href="<?php echo site_url('admin/leave/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Leave'); ?></h5>
<!--Data display of leave with id--> 
<?php
	$c = $leave;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Employee Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['employee_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Reason</td><td><?php echo $c['reason']; ?></td></tr>

<tr><td>Comment</td><td><?php echo $c['comment']; ?></td></tr>

<tr><td>Date From</td><td><?php echo $c['date_from']; ?></td></tr>

<tr><td>Date To</td><td><?php echo $c['date_to']; ?></td></tr>


</table>
<!--End of Data display of leave with id//--> 
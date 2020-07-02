<a  href="<?php echo site_url('admin/attendance/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Attendance'); ?></h5>
<!--Data display of attendance with id--> 
<?php
	$c = $attendance;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Employee Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['employee_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Date Attendance</td><td><?php echo $c['date_attendance']; ?></td></tr>

<tr><td>Time Attendance</td><td><?php echo $c['time_attendance']; ?></td></tr>

<tr><td>Date Departure</td><td><?php echo $c['date_departure']; ?></td></tr>

<tr><td>Time Departure</td><td><?php echo $c['time_departure']; ?></td></tr>


</table>
<!--End of Data display of attendance with id//--> 
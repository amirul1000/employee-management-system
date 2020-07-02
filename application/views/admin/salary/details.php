<a  href="<?php echo site_url('admin/salary/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Salary'); ?></h5>
<!--Data display of salary with id--> 
<?php
	$c = $salary;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Employee Users</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['employee_users_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Date P</td><td><?php echo $c['date_paid']; ?></td></tr>

<tr><td>Amount</td><td><?php echo $c['amount']; ?></td></tr>


</table>
<!--End of Data display of salary with id//--> 
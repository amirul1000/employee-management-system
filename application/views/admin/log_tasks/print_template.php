<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Log_tasks'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide">
</htmlpageheader>

<htmlpageheader name="otherpages" class="hide">
    <span class="float_left"></span>
    <span  class="padding_5"> &nbsp; &nbsp; &nbsp;
     &nbsp; &nbsp; &nbsp;</span>
    <span class="float_right"></span>         
</htmlpageheader>      
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" /> 
   
<htmlpagefooter name="myfooter"  class="hide">                          
     <div align="center">
               <br><span class="padding_10">Page {PAGENO} of {nbpg}</span> 
     </div>
</htmlpagefooter>    

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of log_tasks-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Employee Users</th>
<th>Start Date</th>
<th>End Date</th>
<th>Total Hrs</th>
<th>Task</th>

    </tr>
	<?php foreach($log_tasks as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Users_model');
									   $dataArr = $this->CI->Users_model->get_users($c['employee_users_id']);
									   echo $dataArr['email'];?>
									</td>
<td><?php echo $c['start_date']; ?></td>
<td><?php echo $c['end_date']; ?></td>
<td><?php echo $c['total_hrs']; ?></td>
<td><?php echo $c['task']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of log_tasks//--> 
<a  href="<?php echo site_url('admin/attendance/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Attendance'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/attendance/save/'.$attendance['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Employee Users" class="col-md-4 control-label">Employee Users</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Users_model'); 
             $dataArr = $this->CI->Users_model->get_all_users(); 
          ?> 
          <select name="employee_users_id"  id="employee_users_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($attendance['employee_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                       <label for="Date Attendance" class="col-md-4 control-label">Date Attendance</label> 
            <div class="col-md-8"> 
           <input type="text" name="date_attendance"  id="date_attendance"  value="<?php echo ($this->input->post('date_attendance') ? $this->input->post('date_attendance') : $attendance['date_attendance']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="Time Attendance" class="col-md-4 control-label">Time Attendance</label> 
          <div class="col-md-8"> 
           <input type="text" name="time_attendance" value="<?php echo ($this->input->post('time_attendance') ? $this->input->post('time_attendance') : $attendance['time_attendance']); ?>" class="form-control" id="time_attendance" /> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="Date Departure" class="col-md-4 control-label">Date Departure</label> 
            <div class="col-md-8"> 
           <input type="text" name="date_departure"  id="date_departure"  value="<?php echo ($this->input->post('date_departure') ? $this->input->post('date_departure') : $attendance['date_departure']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="Time Departure" class="col-md-4 control-label">Time Departure</label> 
          <div class="col-md-8"> 
           <input type="text" name="time_departure" value="<?php echo ($this->input->post('time_departure') ? $this->input->post('time_departure') : $attendance['time_departure']); ?>" class="form-control" id="time_departure" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($attendance['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->	
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>  			
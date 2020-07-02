<a  href="<?php echo site_url('admin/leave/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Leave'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/leave/save/'.$leave['id'],array("class"=>"form-horizontal")); ?>
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($leave['employee_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Reason" class="col-md-4 control-label">Reason</label> 
          <div class="col-md-8"> 
           <input type="text" name="reason" value="<?php echo ($this->input->post('reason') ? $this->input->post('reason') : $leave['reason']); ?>" class="form-control" id="reason" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Comment" class="col-md-4 control-label">Comment</label> 
          <div class="col-md-8"> 
           <textarea  name="comment"  id="comment"  class="form-control" rows="4"/><?php echo ($this->input->post('comment') ? $this->input->post('comment') : $leave['comment']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="Date From" class="col-md-4 control-label">Date From</label> 
            <div class="col-md-8"> 
           <input type="text" name="date_from"  id="date_from"  value="<?php echo ($this->input->post('date_from') ? $this->input->post('date_from') : $leave['date_from']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
                                       <label for="Date To" class="col-md-4 control-label">Date To</label> 
            <div class="col-md-8"> 
           <input type="text" name="date_to"  id="date_to"  value="<?php echo ($this->input->post('date_to') ? $this->input->post('date_to') : $leave['date_to']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($leave['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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
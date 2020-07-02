<a  href="<?php echo site_url('admin/projects/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Projects'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/projects/save/'.$projects['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
          <label for="Name" class="col-md-4 control-label">Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $projects['name']); ?>" class="form-control" id="name" /> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="Start Date" class="col-md-4 control-label">Start Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="start_date"  id="start_date"  value="<?php echo ($this->input->post('start_date') ? $this->input->post('start_date') : $projects['start_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
                                       <label for="End Date" class="col-md-4 control-label">End Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="end_date"  id="end_date"  value="<?php echo ($this->input->post('end_date') ? $this->input->post('end_date') : $projects['end_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="Project Cost" class="col-md-4 control-label">Project Cost</label> 
          <div class="col-md-8"> 
           <input type="text" name="project_cost" value="<?php echo ($this->input->post('project_cost') ? $this->input->post('project_cost') : $projects['project_cost']); ?>" class="form-control" id="project_cost" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Description" class="col-md-4 control-label">Description</label> 
          <div class="col-md-8"> 
           <textarea  name="description"  id="description"  class="form-control" rows="4"/><?php echo ($this->input->post('description') ? $this->input->post('description') : $projects['description']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Status" class="col-md-4 control-label">Status</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('projects','status'); 
           ?> 
           <select name="status"  id="status"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($projects['status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($projects['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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
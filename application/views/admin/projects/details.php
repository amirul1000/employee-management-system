<a  href="<?php echo site_url('admin/projects/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Projects'); ?></h5>
<!--Data display of projects with id--> 
<?php
	$c = $projects;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Name</td><td><?php echo $c['name']; ?></td></tr>

<tr><td>Start Date</td><td><?php echo $c['start_date']; ?></td></tr>

<tr><td>End Date</td><td><?php echo $c['end_date']; ?></td></tr>

<tr><td>Project Cost</td><td><?php echo $c['project_cost']; ?></td></tr>

<tr><td>Description</td><td><?php echo $c['description']; ?></td></tr>

<tr><td>Status</td><td><?php echo $c['status']; ?></td></tr>


</table>
<!--End of Data display of projects with id//--> 
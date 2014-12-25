<?php
//database connection
	require_once 'resources/dynamics/_dbconnector.php';
//custom functions
	require_once 'resources/dynamics/functions.php';
//Topbar header
	include_once 'resources/header.php';
// Leftside sidepanel
	include_once 'resources/sidepanel.php';
?>
<!--main content start-->
<section id="main-content">
  <section class="wrapper"> 
    <!-- page start-->
    <div class="row">
    <!-------LEVEL MANAGE TABLE-------->
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading"><h5>VA Levels management </h5>
          <span class="tools pull-right">
          <a href="#myModal-1" data-toggle="modal" class="btn btn-primary" style="color:#fff;">
                <i class="fa fa-plus"></i> Add new level
             </a>
          <a href="javascript:;" class="fa fa-chevron-down"></a> <a href="javascript:;" class="fa fa-cog"></a> <a href="javascript:;" class="fa fa-times"></a> </span> 
          </header>
          <div class="panel-body">            
          <?php
          	// fetching data from database 
						$get = pull_data("vish_levels"); $i=1;
						if(mysqli_num_rows($get)==0){ ?>
							<h4>No data available in this table</h4>
						<?php }else {
		  ?>
   				<table class="table table-hover general-table" id="level_table" data-tablename="vish_levels" data-date="level_madeon">
                <thead>
                <tr>
                	<th>S. no.</th>
                    <th>Level name</th>
                    <th>Tagline</th>
                    <th>Brief</th>
                    <th>Page link</th>                    
                    <th>Modified on</th>
                    <th>Position</th>
                    <th>Active</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>    
                	<?php 						
						while($fetch = mysqli_fetch_assoc($get)){ 					
					?>
						<tr id="<?php echo $fetch['level_id']; ?>" data-id="level_id">
                        	<td><?php echo $i; ?></td>
                            <td data-colname="level_name" data-action="edit"><?php echo $fetch['level_name']; ?></td>
                            <td data-colname="level_tagline" data-action="edit"><?php echo $fetch['level_tagline']; ?></td>
                            <td data-colname="level_intro" data-action="edit"><?php echo $fetch['level_intro']; ?></td>
                            <td data-colname="level_pagelink" data-action="edit"><?php echo $fetch['level_pagelink']; ?></td>
                            <td>
                            	<abbr title="<?php echo $ts = $fetch['level_madeon']; ?>">
									<?php echo time_ago($ts); ?>
                                </abbr>
                            </td>
                            <td data-colname="level_sort" data-action="edit"><?php echo $fetch['level_sort']; ?></td>
                            <td data-colname="level_status" data-action="edit">
								<?php
									 if($fetch['level_status'] == 1){
										 echo "<span class='badge badge-info' data-toggle='tooltip' data-placement='bottom' title='Active'><i class='fa fa-check'></i>
</span>";
									 } else if($fetch['level_status'] == 0){
										 echo "<span class='badge'><i class='fa fa-times' data-toggle='tooltip' data-placement='bottom' title='Not Active'></i></span>";
									 } else{
										 echo "<span class='badge badge-error' data-toggle='tooltip' data-placement='bottom' title='Invalid value'><i class='fa fa-warning'></i></span>";
									 }
								 ?>
                            </td>
                            <td>
                            	<button id="trasher" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete this row">
                                	<i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                    	</tr>									
					<?php $i++; }						
					?>              
                </tbody>
            </table>
            <?php } ?>
          </div>
        </section>
      </div>
      
    <!-------CATAGORIES MANAGE TABLE-------->
      <div class="col-sm-6">
        <section class="panel">
          <header class="panel-heading"><h5>Catagories management </h5>
          <span class="tools pull-right">
          <a href="#newcat" data-toggle="modal" class="btn btn-primary" style="color:#fff;">
                <i class="fa fa-plus"></i> Add new Catagory
             </a>
          <a href="javascript:;" class="fa fa-chevron-down"></a> <a href="javascript:;" class="fa fa-cog"></a> <a href="javascript:;" class="fa fa-times"></a> </span> 
          </header>
          <div class="panel-body">            
          <?php
          	// fetching data from database 
						$get = pull_data("vish_cats"); $i=1;
						if(mysqli_num_rows($get)==0){ ?>
							<h4>No data available in this table</h4>
						<?php }else {
		  ?>
   				<table class="table table-hover general-table" id="cat_table" data-tablename="vish_cats" data-date="cat_madeon">
                <thead>
                <tr>
                	<th>#</th>
                    <th>catagory name</th>                
                    <th>Active</th>
                    <th>Modified on</th>
                    <th>Position</th> 
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>    
                	<?php 						
						while($fetch = mysqli_fetch_assoc($get)){ 					
					?>
						<tr id="<?php echo $fetch['cat_id']; ?>" data-id="cat_id">
                        	<td><?php echo $i; ?></td>
                            <td data-colname="cat_name" data-action="edit"><?php echo $fetch['cat_name']; ?></td>
                            <td data-colname="cat_status" data-action="edit">
								<?php
									 if($fetch['cat_status'] == 1){
										 echo "<span class='badge badge-info' data-toggle='tooltip' data-placement='bottom' title='Active'><i class='fa fa-check'></i>
</span>";
									 } else if($fetch['cat_status'] == 0){
										 echo "<span class='badge'><i class='fa fa-times' data-toggle='tooltip' data-placement='bottom' title='Not Active'></i></span>";
									 } else{
										 echo "<span class='badge badge-error' data-toggle='tooltip' data-placement='bottom' title='Invalid value'><i class='fa fa-warning'></i></span>";
									 }
								 ?>
                            </td>
                            <td>
                            	<abbr title="<?php echo $ts = $fetch['cat_madeon']; ?>">
									<?php echo time_ago($ts); ?>
                                </abbr>
                            </td>
                            <td data-colname="cat_sort" data-action="edit"><?php echo $fetch['cat_sort']; ?></td>                            
                            <td>
                            	<button id="trasher" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete this row">
                                	<i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                    	</tr>									
					<?php $i++; }						
					?>              
                </tbody>
            </table>
            <?php } ?>
          </div>
        </section>
      </div>
    </div>
    <!-- page end--> 
  </section>
</section>
<!--Modal to add level-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Form Tittle</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form role="form" name="add_level" id="add_level">
                                            <div class="form-group">
                                                <label for="level_name">Level Name</label>
                                                <input type="text" class="form-control" name="level_name" id="level_name" placeholder="New level name">
                                            </div>
                                            <div class="form-group">
                                                <label for="level_tagline">Tagline</label>
                                                <input type="text" class="form-control" id="level_tagline" name="level_tagline" placeholder="tagline">
                                            </div>
                                            <div class="form-group">
                                                <label for="level_link">Pagelink</label>
                                                <input type="text" class="form-control" name="level_link" id="level_link" placeholder="url to redirect" />
                                            </div>
                                            <div class="form-group">
                                                <label for="level_brief">Intro</label>
                                                <textarea class="form-control" name="level_brief" id="level_brief" placeholer="Brief about this level">
                                                </textarea>
                                            </div> 
                                                                        
                                          <div class="form-group">
                                                <input type="checkbox" name="bcourse_active" id="level_status" checked data-on-label="Active" data-off-label="NO">
                                            </div>
                                                                                  
                                            <button type="submit" name="add_level" id="add_level" class="btn btn-primary"><i class="fa fa-plus"></i> Add New level</button>
                                           
                                           
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--Modal to add catagories-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="newcat" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add new catagory</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form role="form" name="add_level" id="add_level">
                                            <div class="form-group">
                                                <label for="cat_name">catagory Name</label>
                                                <input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="New catagory name">
                                            </div>                                                                        
                                          <div class="form-group">
                                                <input type="checkbox" name="bcourse_active" id="cat_status" checked data-on-label="Active" data-off-label="NO">
                                            </div>
                                                                                  
                                            <button type="submit" name="add_cat" id="add_cat" class="btn btn-primary"><i class="fa fa-plus"></i> Add New catagory</button>
                                           
                                           
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--main content end-->
<script src="assets/js/custom/custom.js"></script>
<script src="assets/js/custom/data_renew.js"></script>
<script src="assets/js/custom/data_trash.js"></script>
<?php 
	include 'resources/rightpanel.php';	
	include 'resources/footer.php';
?>

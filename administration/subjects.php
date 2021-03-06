<?php
	//database connection
	require_once 'resources/dynamics/_dbconnector.php';
	//custom functions
	require_once 'resources/dynamics/functions.php';
	// adding new course
	if(isset($_POST['add_bcourse'])){
		$levelid = $_POST['level_id'];
		$get = pull_data("vish_levels","level_id='$levelid'");
		$fetch = mysqli_fetch_assoc($get);
		$level_name = $fetch['level_name'];
		$catid = $_POST['cat_id'];
		$bcrs_name = $_POST['bcourse_name'];
		$breakname = explode(" ",$bcrs_name);
		$bcrs_url = $level_name.'/'.strtolower(implode("-",$breakname)).'.php';
		//$bcrs_url = $level_name.'/'.$_POST['bcourse_url'];
		$bcrs_title = $_POST['bcourse_title'];
		if(isset($_POST['bcourse_active']) && $_POST['bcourse_active'] == true ){ $bcrs_status =1;} else {$bcrs_status =0;}		
		//Image variables
		$name = $_FILES['coursepic']['name'];
		$name = date('ymdhms').".jpg";
		$tmp_name = $_FILES['coursepic']['tmp_name'];	
		// IMAGE UPLOAD
		if($name){
			// start upload process 
			$location = "../assets/images/$name";
			move_uploaded_file($tmp_name,$location) or die("Error in location syntax");		
		}
			$location = "$name";
			date_default_timezone_set("Asia/Kolkata"); 
			$cur_date = date("Y-m-d H:i:s");
			$insert = push_data("vish_subjects","level_id,cat_id,subj_name,subj_redirect_to,subj_img,subj_title,subj_status,subj_madeon","'$levelid','$catid','$bcrs_name','$bcrs_url','$location','$bcrs_title','$bcrs_status','$cur_date'");
		if($insert){
			// make a folder at frontend
			$subj_dir_name = strtolower(space_to_hyphens($bcrs_name));
			$subj_lvl_dir = $level_name;
			$subj_dir_path = "../".$subj_lvl_dir."/".$subj_dir_name;
			if(!is_dir($subj_dir_path)){
				$create_dir = mkdir($subj_dir_path);
				echo 'Directory created for this subject';
			}else{
				echo 'Directory already exists with name "'.$subj_dir_name.'"';
			}
		}
	}
?>

<?php
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
          <header class="panel-heading"><h5>Subjects management </h5>
          
          <div class="tools pull-right col-lg-7">          	
            <div class="col-lg-4">
            	<select class="form-control" name="sort_level" id="sort_level">
                	<option data-id="0">Show All levels</option>
                    <?php $get = pull_data("vish_levels");
						while($fetch = mysqli_fetch_assoc($get)){ ?>
                        <option data-id="<?php echo $fetch['level_id']; ?>"><?php echo $fetch['level_name']; ?></option>							
					<?php }?>
                </select>
			</div>
            <div class="col-lg-5">
            	<select class="form-control" name="sort_cat"id="sort_cat">
                	<option data-id="">Show All catagories</option>
                    <?php $get = pull_data("vish_cats");
						while($fetch = mysqli_fetch_assoc($get)){ ?>
                        <option data-id="<?php echo $fetch['cat_id']; ?>"><?php echo $fetch['cat_name']; ?></option>							
					<?php }?>
                </select>
			</div>
            <div class="col-lg-3">
                  <a href="#addsubject" data-toggle="modal" class="btn btn-primary" style="color:#fff;">
                        <i class="fa fa-plus"></i> Add new Subject
                  </a>             
          	</div>
         </div> 
          </header>
          <div class="panel-body">            
         	<div class="col-lg-12 col-md-12">
            	<?php $n=1; 
					$get = pull_data("vish_subjects");
					if(mysqli_num_rows($get) == 0){ ?>
						<h4 class="text-muted">Here is nothing. Add your First Course</h4>
					<?php }
					while($fetch = mysqli_fetch_assoc($get)){
				?>
                <!---subject--->
            	<div class="col-lg-3 col-md-3 subj" id="subjects<?php echo $n; ?>" data-tablename="vish_subjects" data-date="subj_madeon">
                	<img src="<?php echo USERS_PATH ?>assets/images/<?php echo $fetch['subj_img'] ?>" id="imgsrc<?php echo $n ?>" name="imgsrc" />
                    <div class="subjcontent subjgrab<?php echo $n; ?>" id="<?php echo $fetch['subj_id']; ?>" data-id="subj_id">                    	
                    	<div class="topstrip">
                        	<?php
								// datetime of the uploads
								$date = $fetch['subj_madeon'];
								$levelid = $fetch['level_id'];
								$catid = $fetch['cat_id'];
								//fetching level
								$get_lvl = pull_data("vish_levels","level_id='$levelid'");
								$level = mysqli_fetch_assoc($get_lvl);
								//fetching cats
								$get_cat = pull_data("vish_cats","cat_id='$catid'");
								$cat = mysqli_fetch_assoc($get_cat);		
							?>
                        	<span class="subjinfo"> <?php echo $level['level_name']; ?> / <?php echo $cat['cat_name']; ?> /</span>
                        </div>
                        <div class="subjname" id="subj_name<?php  echo $n ;?>" data-colname="subj_name" data-action="edit"  data-subjtitle="<?php echo $fetch['subj_title']; ?>">
                        	<a href="<?php echo SITE_PATH ?>videos.php?subj=<?php echo $fetch['subj_id']; ?>" title="click to manage its videos" data-toggle="tooltip" data-placement="bottom">
								<?php echo $fetch['subj_name']; ?>
                            </a>
                        </div>
                        <div class="bottomstrip">                        	                       
                            <ul>                           
                            <li>
                        	<a href="#subjectupdate" data-call="tooltip" id="subj_editr" data-toggle="modal" data-placement="top" title="Edit"><i class="fa fa-pencil" onClick="test('<?php  echo $n; ?>');"></i></a>
                            </li>
                            <li>
                            <a href="#" id="subj_trashr" onClick="trash_subject(<?php echo $n; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>
                            </li>
                            <li>
                            <!--hAVE TO MAKE THE LINK DYNAMIC-->
                            <a href="#" data-toggle="tooltip" data-placement="top" title="visit"><i class="fa fa-globe"></i></a>
                            </li>
                             <li>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo time_ago($date) ?>"><i class="fa fa-clock-o"></i></a>
                            </li>
                             <li>
                            	<a href="#" data-toggle="tooltip"
                                <?php if($fetch['subj_status'] == 1) { ?>
                                title="Active" style="color:#CC3" data-status="1" <?php } else {?>
                                title="Not Active"  data-status="0"<?php } ?>
                                data-placement="top" id="subjstatus<?php echo $n ?>"><i class="fa fa-power-off"></i></a>
                            </li>
                            </ul>
                            <?php // Other materials we can contain here ?>
                            <input type="hidden" name="sublevel" id="sublevel<?php echo $n; ?>" value="<?php echo $level['level_id']; ?>" /> 
                            <input type="hidden" name="subcat" id="subcat<?php echo $n; ?>" value="<?php echo $cat['cat_id']; ?>" /> 
                        </div>
                    </div>
                </div>
                <?php $n++; } ?>                                       	    	
            </div>
          </div>
        </section>
      </div>      
    </div>
    <!-- page end--> 
  </section>
</section>
<!--Modal to add level-->
<!--ADD New Subject MODAL-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addsubject" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
                                        <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add new Course for BEGINNERS</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form role="form" name="bcourse" id="bcourse" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'].'?send' ?>">			
                                        
                                          <div class="form-group">
                                           <label for="new_level_name">Select Level of new subject</label>
                                           <select class="form-control" name="level_id" id="level_id">
                                                <?php $get = pull_data("vish_levels");
                                                    while($fetch = mysqli_fetch_assoc($get)){ ?>
                                                    <option value="<?php echo $fetch['level_id']; ?>"><?php echo $fetch['level_name']; ?></option>							
                                                <?php }?>
                                            </select>
                                            </div>                            
                                             <div class="form-group">
                                                <label for="new_level_name">Select catagory of new subject</label>
                                           <select class="form-control" name="cat_id" id="cat_id">
                                                <?php $get = pull_data("vish_cats");
                                                    while($fetch = mysqli_fetch_assoc($get)){ ?>
                                                    <option value="<?php echo $fetch['cat_id']; ?>"><?php echo $fetch['cat_name']; ?></option>							
                                                <?php }?>
                                            </select>
                                            </div>                            
                                            <div class="form-group">
                                                <label for="new_level_name">New Course name</label>
                                                <input type="text" class="form-control" name="bcourse_name" id="bcourse_name" placeholder="New course name & page url">
                                            </div>                                             
                                            <div class="form-group">
                                                <label for="new_level_name">Subject title</label>
                                                <input type="text" class="form-control" name="bcourse_title" id="bcourse_title" placeholder="i.e.. HTML in Hindi">
                                            </div>
                                            <div class="form-group last">
                                <label class="control-label col-md-3">Image Upload</label>
                                <div class="col-md-9">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="assets/images/va/AAAAAA&text=no+image.gif" alt="" />
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <div>
                                                   <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                   <input type="file"  name="coursepic" class="default" />
                                                   </span>
                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                    <span class="label label-danger">NOTE!</span>
                                             <span>	156X192px </span>
                                </div>
                            </div>                                            
                                            <div class="form-group">
                                                <input type="checkbox" name="bcourse_active" id="label-switch" class="switch-small" checked data-on-label="Active" data-off-label="NO" value="1">
                                            </div>
                                            <button type="submit" name="add_bcourse" id="add_bcourse" class="btn btn-danger">Add course</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--ADD New Subject MODAL-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="subjectupdate" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
                                        <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add new Course for BEGINNERS</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form role="form" name="bcourse" id="bcourse" method="post" enctype="multipart/form-data" action="<?php // echo $_SERVER['PHP_SELF'].'?send' ?>">			
                                        
                                          <div class="form-group">
                                           <label for="new_level_name">Select Level of new subject</label>
                                           <select class="form-control" name="newlevel" id="newlevel">
                                                <?php $get = pull_data("vish_levels");
                                                    while($fetch = mysqli_fetch_assoc($get)){ ?>
                                                    <option value="<?php echo $fetch['level_id']; ?>"><?php echo $fetch['level_name']; ?></option>							
                                                <?php }?>
                                            </select>
                                            </div>                            
                                             <div class="form-group">
                                                <label for="new_level_name">Select catagory of new subject</label>
                                           <select class="form-control" name="newcat" id="newcat">
                                                <?php $get = pull_data("vish_cats");
                                                    while($fetch = mysqli_fetch_assoc($get)){ ?>
                                                    <option value="<?php echo $fetch['cat_id']; ?>"><?php echo $fetch['cat_name']; ?></option>							
                                                <?php }?>
                                            </select>
                                            </div>                            
                                            <div class="form-group">
                                                <label for="new_level_name">Course name</label>
                                                <input type="text" class="form-control" name="udt_coursename" id="udt_coursename" placeholder="New course name & page url">
                                            </div>                                             
                                            <div class="form-group">
                                                <label for="new_level_name">Subject title</label>
                                                <input type="text" class="form-control" name="udt_coursetitle" id="udt_coursetitle" placeholder="i.e.. HTML in Hindi">
                                            </div>
                                            <div class="form-group last">
                                <label class="control-label col-md-3">Image Upload</label>
                                <div class="col-md-9">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <img alt="" id="udt_newimage" name="udt_newimage" />
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <div>
                                                   <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                   <input type="file"  name="coursepic" class="default" />
                                                   </span>
                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                    <span class="label label-danger">NOTE!</span>
                                             <span>	156X192px </span>
                                </div>
                            </div>                                            
                                            <div class="form-group">
                                                <input type="checkbox" name="newstatus" id="newstatus" class="switch-small" data-on-label="Active" data-off-label="NO" value="1">
                                            </div>
                                            <button type="submit" name="update_subject" id="update_subject" class="btn btn-danger" >Update course</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

<!---->
<!--main content end-->
<script src="assets/js/custom/custom.js"></script>
<script src="assets/js/custom/data_renew.js"></script>
<script src="assets/js/custom/data_trash.js"></script>

<?php 
	include 'resources/rightpanel.php';	
	include 'resources/footer.php';
?>

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
			echo $cur_date = date("Y-m-d H:i:s");
		$query = "INSERT INTO vish_subjects (level_id,cat_id,subj_name,subj_redirect_to,subj_img,subj_title,subj_status,subj_madeon) 				VALUES('$levelid','$catid','$bcrs_name','$bcrs_url','$location','$bcrs_title','$bcrs_status','$cur_date')";
		$fire = mysqli_query($dbcon,$query) or die('Error in firing your insert query');
		if($fire){//
//			// Admin side page creation
//			$newfilepath = $bcrs_url;			
//			$newfile = fopen($newfilepath, "w") or die("Unable to open file!");
//			$txt = "Here is how it will work\n";
//			fwrite($newfile, $txt);
//			fclose($newfile);
//			$sourcefile = "vidmanage_blueprint.php";
//			$destfile = $bcrs_url;
//			copy($sourcefile,$destfile);
//			//client side page creation
//			$url_videopage = '../'.$bcrs_url;
//			$make_videopage = fopen($url_videopage, "w") or die("Unable to create / open video page file!");
//			$vidtxt = "Here is new video page \n";
//			fwrite($make_videopage, $vidtxt);
//			fclose($make_videopage);
//			//$vid_sourcefile = "../".$level_name."/"."raw_videofile.php";
//			//$vid_destfile = $url_videopage;
//			//copy($vid_sourcefile,$vid_destfile) or die('can not copy file') ;
//			//Everything done !! Redirecting back
//			header('Location:'.$_SERVER['PHP_SELF']);
			echo "Time to create dynamic pages";
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
                        <i class="fa fa-plus"></i> Add new level
                  </a>             
          	</div>
         </div> 
          </header>
          <div class="panel-body">            
         	<div class="col-lg-12 col-md-12">
            	<?php 
					$get = pull_data("vish_subjects");
					if(mysqli_num_rows($get) == 0){ ?>
						<h4 class="text-muted">Here is nothing. Add your First Course</h4>
					<?php }
					while($fetch = mysqli_fetch_assoc($get)){
				?>
            	<div class="col-lg-3 col-md-3 subj">
                	<img src="<?php echo USERS_PATH ?>assets/images/<?php echo $fetch['subj_img'] ?>" />
                    <div class="subjcontent">                    	
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
                        <div class="subjname">                       	
                        		<span><?php echo $fetch['subj_name']; ?></span>
                        </div>
                        <div class="bottomstrip">
                        	                       
                            <ul>                           
                            <li>
                        	<a href="#" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                            </li>
                            <li>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>
                            </li>
                            <li>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="visit"><i class="fa fa-globe"></i></a>
                            </li>
                             <li>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo time_ago($date) ?>"><i class="fa fa-clock-o"></i></a>
                            </li>
                             <li>
                            	<a href="#" data-toggle="tooltip"
                                <?php if($fetch['subj_status'] == 1) { ?>
                                title="Active" style="color:#CC3" <?php } else {?>
                                title="Not Active" <?php } ?>
                                data-placement="top"><i class="fa fa-power-off"></i></a>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>                                       	    	
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
<!---->
<!--main content end-->
<script src="assets/js/custom/custom.js"></script>
<script src="assets/js/custom/data_renew.js"></script>
<script src="assets/js/custom/data_trash.js"></script>

<?php 
	include 'resources/rightpanel.php';	
	include 'resources/footer.php';
?>

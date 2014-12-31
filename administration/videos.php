<?php
	//database connection
	require_once 'resources/dynamics/_dbconnector.php';
	//custom functions
	require_once 'resources/dynamics/functions.php';
?>
<?php
//Topbar header
	include_once 'resources/header.php';
// Leftside sidepanel
	include_once 'resources/sidepanel.php';
?>
<script>
	document.title = "Vishac video management";
</script>
<!--main content start-->
<section id="main-content">
  <section class="wrapper"> 
    <!-- page start-->
    <div class="row">
    <!-------LEVEL MANAGE TABLE-------->
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading"><h5><i class="fa fa-video"></i> Videos management </h5>
          <div class="tools pull-right col-lg-10">          	
            <div class="col-lg-2">
            	<select class="form-control" name="sort_level" id="sort_level">
                	<option data-id="0">Levels</option>
                    <?php $get = pull_data("vish_levels");
						while($fetch = mysqli_fetch_assoc($get)){ ?>
                        <option data-id="<?php echo $fetch['level_id']; ?>" value="<?php echo $fetch['level_id']; ?>"><?php echo $fetch['level_name']; ?></option>							
					<?php }?>
                </select>
			</div>
            <div class="col-lg-3">
            	<select class="form-control" name="sort_cat"id="sort_cat">
                	<option data-id="">Catagories</option>
                    <?php $get = pull_data("vish_cats");
						while($fetch = mysqli_fetch_assoc($get)){ ?>
                        <option data-id="<?php echo $fetch['cat_id']; ?>" value="<?php echo $fetch['cat_id']; ?>"><?php echo $fetch['cat_name']; ?></option>							
					<?php }?>
                </select>
			</div>
             <div class="col-lg-3">
            	<select class="form-control" name="sort_subj"id="sort_subj">
                	<option data-id="">Subjects</option>
                    <?php $get = pull_data("vish_subjects");
						while($fetch = mysqli_fetch_assoc($get)){ ?>
                        <option data-id="<?php echo $fetch['subj_id']; ?>" value="<?php echo $fetch['subj_id']; ?>">
							<?php echo $fetch['subj_name']; ?>
                        </option>							
					<?php }?>
                </select>
			</div>
            <div class="col-lg-2">
                  <a href="#topic_modal" data-toggle="modal" class="btn btn-primary" style="color:#fff;">
                        <i class="fa fa-plus"></i> Add new topic
                  </a>    
          	</div>
            <div class="col-lg-2">
                  <a href="#video_modal" data-toggle="modal" class="btn btn-primary" style="color:#fff;">
                        <i class="fa fa-plus"></i> Add new Video
                  </a>    
          	</div>
         </div> 
          </header>
          <div class="panel-body">            
         	<div class="col-lg-12 col-md-12">
            	<!--<h4 class="text-muted">No topic and video available for this course</h4>-->                
                <ul>
                	<?php $get_topics = pull_data("vish_topics");
						while($topics = mysqli_fetch_assoc($get_topics)){?>
						<li><a href="#"> <?php echo $topics['topic_name']; ?> </a></li>
                        <ol>
                        	<?php 
							$topic_id = $topics['topic_id'];
							$get_videos = pull_data("vish_videodata","topic_id='$topic_id'"); 
                            while($videos = mysqli_fetch_assoc($get_videos)){ ?>
                        		<li><?php echo $videos['vid_Ename']; ?></li>
                            <?php } ?>
                        </ol>
					<?php } ?>                	
                </ul>
            </div>
          </div>
        </section>
      </div>      
    </div>
    <!-- page end--> 
  </section>
</section>
<!--main content end-->
<!--ADD TOPIC MODAL-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="topic_modal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
                                        <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add new Topic in this playlist </h4>
                                    </div>
                                    <div class="modal-body">

                                        <form role="form" name="add_new_menu" id="add_new_manu" method="post" action="<?php // echo $_SERVER['PHP_SELF'].'?send' ?>">
                                        
                                        	<p class="text-primary">  
                                            	You are going to add topic in » <b>level_name » Subject_name</b>
                                            </p>
                                            <div class="form-group">
                                                <label for="topic_name">Topic Name</label>
                                                <input type="text" class="form-control error" name="topic_name" id="topic_name" placeholder="new topic name" minlength="2" value="" />                                              
                                            </div>                                            
                                            <div class="form-group">
                                                <label for="new_menu_url"></label>
                                                <input type="checkbox" name="topic_status" id="topic_status" class="switch-small" checked data-on-label="Active" data-off-label="NO" value="1">
                                            </div>
                                            <button type="submit" name="add_topic" id="add_topic" class="btn btn-primary"><i class="fa fa-plus"></i> Add Topic</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>                                     
<!--ADD VIDEO MODAL-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="video_modal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
                                        <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add new video in this playlist </h4>
                                    </div>
                                    <div class="modal-body">                                                         	
                            <form name="addvid_form" id="addvid_form" enctype="multipart/form-data" class="form-horizontal" method="post" action="">  
                              		<div class="form-group">                                        
                                        <label class="col-lg-3 control-label">choose topic</label>
                                        <div class="col-lg-8">
                                         <select name="topic_id" id="topic_id" class="form-control m-bot15">
                                        <?php $getrow = pull_data("vish_topics");
										 while($topicrow = mysqli_fetch_assoc($getrow)){ ?>											
                                         	<option name="<?php echo $topicrow['topic_id'] ?>" value="<?php echo $topicrow['topic_id'] ?>" ><?php echo $topicrow['topic_name'] ?></option>                          
                                         <?php } ?>                  
                                         </select>                                         
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Eng title</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="entitle" id="entitle" class="form-control" placeholder="English title of new video">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Hin title</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="hintitle" id="hintitle" class="form-control" placeholder="Hindi title of new video">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Youtube</label>
                                        <div class="col-lg-8">
                                            <input type="text"  name="yturl" id="yturl" class="form-control" placeholder="8xEssIHsBHk Youtube URL of new video">
                                        </div>
                                    </div>                       
                              		<div class="form-group">
                                        <label class="col-lg-3 control-label">Page Description 
                                        	<a href="#" data-toggle="tooltip" data-placement="bottom" title="will be used for meta description for SEO of this page"><span class="badge badge-primary" style="text-align:left;">?</span></a>
                                        </label>
                                        <div class="col-lg-8">
                                           <textarea name="vid_seo_desc" id="vid_seo_desc" class="form-control" rows="6"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                                <label for="new_menu_url"></label>
                                                <input type="checkbox" name="video_status" id="video_status" class="switch-small" checked data-on-label="Active" data-off-label="NO" value="1">
                                            </div>
                                    <div class="form-group">
                                    	<div class="col-lg-8">
                                          <button id="add_video" class="btn btn-primary" name="add_video" type="submit"><i class="fa fa-plus"></i> Add video</button>
                                        </div>	
                                    </div>                                                           
                             
                        	
                        </form> <!--=-=-=ADD VIdeo form ends here-=-=-=--->
                    </div>
                </div>
            </div>
        </div>
<script src="assets/js/custom/custom.js"></script>
<script src="assets/js/custom/data_renew.js"></script>
<script src="assets/js/custom/data_trash.js"></script>
<?php 
	include 'resources/rightpanel.php';	
	include 'resources/footer.php';
?>

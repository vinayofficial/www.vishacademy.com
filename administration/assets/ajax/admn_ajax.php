<?php include_once '../../resources/dynamics/_dbconnector.php'; ?>
<?php include_once '../../resources/dynamics/functions.php'; ?>

<?php 
////////
//ADDING VISH LEVELS 
	if(isset($_POST['name']) && isset($_POST['pagelink']) && isset($_POST['tagline']) && isset($_POST['level_brief']) && isset($_POST['level_status'])){
	$levelname = protect_it($_POST['name']);
	$pagelink = $_POST['pagelink'];
	$tagline = protect_it($_POST['tagline']);
	$brief = protect_it($_POST['level_brief']);
	$status = protect_it($_POST['level_status']);
	//-- Remove space from level name(if available) and 
	//-- replace with hyphens			
	$level_dir = strtolower(space_to_hyphens($levelname));
	if($levelname != "" || $levelname != null){
		$send = push_data("vish_levels","level_name,level_tagline,level_intro,level_pagelink,level_dir,level_status,level_madeon","'$levelname','$tagline','$brief','$pagelink','$level_dir','$status',now()");
		if($send){
			// Level created, Now creating directory
			// for this level @ front end			
			//-- Now create directory
			$mkdir = mkdir("../../../".$level_dir."",0777,true);
			if($mkdir){
				echo "New level created and folder created";
			}else{			
				echo "A new level has added successfully !! but Folder not created";
			}
		} else{
			die("Level not added into database because....".mysqli_error($dbcon));
		}
	}else{
		echo "Level name is required to add new lavel";
	}
}
//------------------------
//ADDING VISH Catagories 
//------------------------
	if(isset($_POST['catname'])){
	$catname = protect_it($_POST['catname']);
	$status = protect_it($_POST['cat_status']);
	if($catname != "" || $catname != null){
		$send = push_data("vish_cats",null,"null,'$catname','$status',now(),null");
		if($send){
			echo "A new catagory has added successfully !!";
		} else{
			die("catagory not added into database because....".mysqli_error($dbcon));
		}
	}else{
		echo "catagory name is required to add new catagory";
	}
}

//------------------------
//ADDING VISH Topics 
//------------------------
	if(isset($_POST['topic_name']) && isset($_POST['topic_status']) && isset($_POST['level_name']) && isset($_POST['cat_name']) && isset($_POST['subj_name'])){	
	$level_id = protect_it($_POST['level_name']);		
	$cat_id = protect_it($_POST['cat_name']);		
	$subj_id = protect_it($_POST['subj_name']);	
	$topicname = protect_it($_POST['topic_name']);
	$status = protect_it($_POST['topic_status']);	
	if($topicname != "" || $topicname != null){		
		$send = push_data("vish_topics",null,"null,'$level_id','$cat_id','$subj_id','$topicname','$status',null,now()");
		if($send){
			echo "A new Topic has added successfully !!";
		} else{
			die("Topic not added into database because....".mysqli_error($dbcon));
		}
	}else{
		echo "Topic name is required to add new catagory";
	}
}

//------------------------
// ADDING VISH video data 
//------------------------
	if(isset($_POST['vid_entitle']) && isset($_POST['vid_hintitle']) && isset($_POST['youtube_url']) && isset($_POST['seo_desc'])){	
	$level_id = protect_it($_POST['level_id']);		
	$cat_id = protect_it($_POST['cat_id']);		
	$subj_id = protect_it($_POST['subj_id']);	
	$topic_id = protect_it($_POST['topic_id']);	
	$vid_entitle = protect_it($_POST['vid_entitle']);
	$vid_hintitle = protect_it($_POST['vid_hintitle']);
	$youtube_url = protect_it($_POST['youtube_url']);
	$seo_desc = protect_it($_POST['seo_desc']);	
	$video_status = protect_it($_POST['video_status']);
	if($vid_entitle != "" || $vid_entitle != null){		
		$send = push_data("vish_videodata",null,"null,'$level_id','$cat_id','$subj_id','$topic_id','$vid_entitle','$vid_hintitle','$youtube_url',null,null,null,null,null,'$video_status',now(),null");
		if($send){			
			//fetching levelname of this video
			$level = fetch_rows("vish_levels","level_id='$level_id'");
			$level_name = $level['level_name'];
			//fetching subjectname of this video
			$subj = fetch_rows("vish_subjects","subj_id='$subj_id'");
			$subj_name = $subj['subj_name'];
			//convert file name to hyphens
			$filename = trim(space_to_hyphens($vid_entitle)).".php";
			// Creating the php file for this video			
			$filepath = "../../../".$level_name."/".$subj_name."/".$filename;
			$create_php_file = fopen($ourFileName, 'w') or die("can't open file");
			fclose($ourFileHandle);
			if($create_php_file){
				echo "php file created for this";
			}
			echo "A new Video has added successfully inside";
		} else{
			die("Video not added into database because....".mysqli_error($dbcon));
		}
	}else{
		echo "Video name is required to add new catagory";
	}
}

?>
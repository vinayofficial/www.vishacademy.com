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
	$topicname = protect_it($_POST['topic_name']);
	$status = protect_it($_POST['topic_status']);	
	$level_name = protect_it($_POST['level_name']);		
	$cat_name = protect_it($_POST['cat_name']);		
	$subj_name = protect_it($_POST['subj_name']);
	// fetch level id
	$get_level = fetch_rows("vish_levels","level_name='$level_name'");
	$level_id = $get_level['level_id'];
	// fetch cat id
	$get_cat = fetch_rows("vish_cats","cat_name='$cat_name'");
	$cat_id = $get_cat['cat_id'];
	// fetch subj id
	$get_subj = fetch_rows("vish_subjects","subj_name='$subj_name'");
	$subj_id = $get_subj['subj_id'];	
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
?>
?>

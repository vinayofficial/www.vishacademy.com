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
	//if($pagelink == "" || $pagelink=null){ $pagelink = '<i>not available</i>';}
	//if($tagline == "" || $tagline=null){ $tagline = '<i>not available</i>';}
	//if($brief == "" || $brief=null){ $brief = '<i>not available</i>';}
	if($levelname != "" || $levelname != null){
		$send = push_data("vish_levels","level_name,level_tagline,level_intro,level_pagelink,level_status,level_madeon","'$levelname','$tagline','$brief','$pagelink','$status',now()");
		if($send){
			echo "A new level has added successfully !!";
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
?>
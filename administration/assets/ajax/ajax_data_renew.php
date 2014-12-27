<?php include_once '../../resources/dynamics/_dbconnector.php'; ?>
<?php include_once '../../resources/dynamics/functions.php'; ?>

<?php
		//Update Inline editable values in table
		// timezone declaration
		date_default_timezone_set("Asia/Kolkata");
		//
		if(isset($_POST['newval']) && isset($_POST['field']) && isset($_POST['dbtable']) && isset($_POST['row_id'])){
			$oldvalue = trim($_POST['oldvalue']);
			$newval = trim($_POST['newval']);
			$field = trim($_POST['field']);
			$tblname = trim($_POST['dbtable']);
			$row_id = trim($_POST['row_id']);
			$id_colname = trim($_POST['id_field']);
			$date = trim($_POST['date_colname']);			
			//echo $id_colname." ::: ".$row_id; die;
			//echo $id." : ".$id_val;
			$update = renew_data("$tblname","$field='$newval',$date=now()","$id_colname='$row_id'") or die('can not update data');
			if($update){
				//Check if we update level name
				if(trim($tblname=='vish_levels') && $field=='level_name'){		
					level_dir_update($newval);													
				}
			} 
		}	
?>
<?php
	// DELETE ANY ROW DATA USING AJAX
	if(isset($_POST['dbtable']) && isset($_POST['row_id']) && isset($_POST['id_colname'])){
		$table = protect_it($_POST['dbtable']);
		$field = protect_it($_POST['id_colname']);
		$value = protect_it($_POST['row_id']);	
		$trasher = trash_data("$table","$field='$value'");
		if($trasher){
			//DELETE LEVEL FOLDER
			//if(trim($table=='vish_levels') && $field=='level_id'){				
//				$value = fetch_rows("vish_levels","level_id='$value'");
//				$dir_name = $value['level_dir'];			
//				$dir_path = '../../../'.$dir_name."/";				
//				if(is_dir($dir_path)){					
//					$remove_dir = rmdir($dir_path);
//					if($remove_dir){
//						echo "Directory '".$dir_name."' has deleted from frontend !!";
//					}
//				}else { echo "There is no folder found with name '".$dir_name."' at front end"; }
//			}
			echo "Data deleted from database";
		}
	}
?>
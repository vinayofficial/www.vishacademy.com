<?php include_once '../../resources/dynamics/_dbconnector.php'; ?>
<?php include_once '../../resources/dynamics/functions.php'; ?>

<?php
		//Update Inline editable values in table
		// timezone declaration
		date_default_timezone_set("Asia/Kolkata");
		//
		if(isset($_POST['newval']) && isset($_POST['field']) && isset($_POST['dbtable']) && isset($_POST['row_id'])){						
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
				echo "data updated successfully";
			} else{
				die(mysqli_error($dbcon));
			}
		}	
?>
<?php
	// DELETE ANY ROW DATA SUING AJAX
	if(isset($_POST['dbtable']) && isset($_POST['row_id']) && isset($_POST['id_colname'])){
		$table = protect_it($_POST['dbtable']);
		$field = protect_it($_POST['id_colname']);
		$value = protect_it($_POST['row_id']);
		$trasher = trash_data("$table","$field='$value'");
		if($trasher){
			echo 'you deleted a row from '.$table;
		}
	}
?>
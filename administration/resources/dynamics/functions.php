<?php
	// timezone declaration
	date_default_timezone_set("Asia/Kolkata");	

//----------------------------------- Insert data function
		
	function push_data($tablename,$fields=null,$values=null){
		global $dbcon;
		if($fields != null){
			$fields = "(".$fields.")";
		}
		$Inserter = "INSERT INTO ".$tablename.$fields." VALUES (".$values.")";			
		
		$pushfire = mysqli_query($dbcon,$Inserter) or die("can not push data. please check provided informations !! <br /> ".mysqli_error($dbcon));		
		
		return $pushfire;
	}
	
//---------------------------------- select and fetch data function
	
	function pull_data($tablename,$condition=null,$sort=null,$limit=null){
		global $dbcon;
		
		//General Query	
		$selector = "SELECT * FROM ".$tablename;
		
		// If condition is given
		if($condition != null) {		
		 	$selector .= " WHERE ".$condition;
		}
		
		// If Sorting is given
		if($sort != null) {		
		 	$selector .= " ORDER BY ".$sort;
		}
		
		// If Limit is given
		if($limit != null) {		
		 	$selector .= " LIMIT ".$limit;
		}
		
		//CONFUSED !!! ECHO THIS QUERY 
		//echo $selector;
		
		$pulldata = mysqli_query($dbcon,$selector) or die("can not pull data. check provided information");
		
		return $pulldata;
	}
	
// ----------------------------------DELETE DATA
	
	function trash_data($tablename=null, $condition=null){
		global $dbcon;
		
		$trash = "DELETE FROM ".$tablename;
		
		if($condition != null){
		 $trash .= " WHERE ".$condition;
		}		
		//echo $trash;
		$trasher = mysqli_query($dbcon,$trash) or die("can not delete this data. check information");		
		
		return $trasher;	
	}
	
// ----------------------------------update DATA

	function renew_data($tablename,$data,$condition=null){
		global $dbcon;
		
		if($tablename != "" && $tablename != null){
			$renew = "UPDATE ".$tablename." ";
		} else{ die('tablename is required'); }
		
		if($data != "" && $data != null){
			$renew .= "SET ".$data." ";
		}
		if($condition != "" && $condition != null){
			$renew .= "WHERE ".$condition." ";
		}
		$renew;
		$renewal = mysqli_query($dbcon,$renew) or die("can not update data. <br />".mysqli_error($dbcon));		
		return $renewal;
	}
// ---------------------------------- Fetch value (single row, NO LOOP)
	function fetch_rows($tablename,$condition=null,$sort=null,$limit=null){
		// Inject select query and fetch data
		$query = pull_data($tablename,$condition,$sort,$limit);
		$result = mysqli_fetch_assoc($query);
		return $result;		
	}
//------------------------ check user login
	function check_login() {
	session_start();	
	if(isset($_SESSION['user']) == false){
		header('location: login.php');
	}
	}
//----------------------- Send secure data
	function protect_it($data){
		 $protected = trim(htmlentities(strip_tags($data)));
		 return $protected;
	}
//----------------------- Change space to hyphens
	function space_to_hyphens($name){
		$convertedname = str_replace(' ', '-', $name);
		return $convertedname;
	}
//-------------------------- Level table directory name update
	function level_dir_update($newval){
		// Fetching old directory name
		$value = fetch_rows("vish_levels","level_name='$newval'");					
		$old_dir_name = $value['level_dir'];
	// manipulating new directory name
		$new_dir_name = space_to_hyphens($newval);							
		$new_dir_name = strtolower($new_dir_name);
	// update new directory name into vish_level table
		$update_dir_name = renew_data("vish_levels","level_dir='$new_dir_name'","level_name='$newval'");
		if($update_dir_name){
	// rename level folder 
			$renameFile = rename("../../../".$old_dir_name."", "../../../".$new_dir_name."");						
			if($renameFile){
				echo "level name and level folder name updated successfully !!";
			}else{
				echo "level name updated but folder name NOT RENAMED";
			}
		}else{
			echo "Directory name not inserted into database ".mysqli_error($dbcon);
		}
	}
?>


<?php

// CLASS FOR CONVERTING TIME TO AGO
class convertToAgo {

    function convert_datetime($str) {
	
   		list($date, $time) = explode(' ', $str);
    	list($year, $month, $day) = explode('-', $date);
    	list($hour, $minute, $second) = explode(':', $time);
    	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    	return $timestamp;
    }

    function makeAgo($timestamp){
	
   		$difference = time() - $timestamp;
   		$periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
   		$lengths = array("60","60","24","7","4.35","12","10");
   		for($j = 0; $difference >= $lengths[$j]; $j++)
   			$difference /= $lengths[$j];
   			$difference = round($difference);
   		if($difference != 1) $periods[$j].= "s";
   			$text = "$difference $periods[$j] ago";
   			return $text;
    }
	
} // END CLASS
////////////phpdevtips Time ago function
function time_ago( $date )
{
    if( empty( $date ) )
    {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $unix_date = strtotime( $date );

    // check validity of date

    if( empty( $unix_date ) )
    {
        return "Bad date";
    }

    // is it future date or past date

    if( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }

    $difference = round( $difference );

    if( $difference != 1 )
    {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";

}
?>
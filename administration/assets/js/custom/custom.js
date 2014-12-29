// JavaScript Document
// ADmin side JS

// default ajax-php file path address
var data_push_file = 'http://localhost/www.vishacademy.com/administration/assets/ajax/admn_ajax.php';
var data_renew_file = 'http://localhost/www.vishacademy.com/administration/assets/ajax/ajax_data_renew.php';
//-------------------------------
//Inline data editing For table data............
//-------------------------------
	var oldvalue;
	// Editing data on dblclick
    $("td[data-action='edit']").on('dblclick',function(){
		var x = $.trim($(this).text());
		oldvalue = x;		
		$(this).attr('contenteditable','true');
		$(this).css({
			'font-weight':'bold',
		});
	});
	//Time to update data on blur table cells
	$("td[data-action='edit']").on('blur',function(){
		$(this).removeAttr('contenteditable');
		$(this).css({'font-weight':'normal',});		
		// 1..database tablename for this data
		var dbtable = $(this).closest('table').attr('data-tablename');
		// 2..Getting database table id column name
		var id_colname = $(this).closest('tr').attr('data-id');
		// 3..Getting database table column id value
		var row_id = $(this).closest('tr').attr('id');
		// 4..database column name of this cell
		var field = $(this).attr('data-colname');				
		// 5..Getting New Value
		var newval = $(this).text();
		// 6..Data field name of database table of this subject
		var date_colname = $(this).closest('table').attr('data-date');	
		
		//Testing all values
		//var cnfirm = confirm("New modification will be made on :: "+dbtable+" > "+id_colname+" : "+row_id+" and "+field+" > "+newval+" and time will be updated into "+date_colname);
		var cnfirm = confirm("Sure about updating data of this cell ?");
		if(cnfirm == true){
			//Finally, updating data into database
			$.post(data_renew_file,{
				dbtable : dbtable,
				id_field : id_colname,
				row_id : row_id,
				field : field,
				newval : newval,
				date_colname : date_colname,
				oldvalue : oldvalue,},
				function(data){
					alert(data);
			});
		} else{
			$(this).text(oldvalue);
		}
		return false;
	});
//-------------------------------
//Inline data Trash for table data............
//-------------------------------

	$('button#trasher').on('click', function(){
		$(this).closest('tr').attr('class','text-danger');
		var the_row = $(this).closest('tr');
		var row_id = $(this).closest('tr').attr('id');		
		var cnfirm = confirm ('Sure about DELETING THIS ROW ?');
		if(cnfirm == true){
			// Prepare to destroy this data
			// 1..database tablename for this data
			var dbtable = $(this).closest('table').attr('data-tablename');
			// 2.. id column name in database
			var id_colname = $(this).closest('tr').attr('data-id');
			//Finally, updating data into database
			$.post(data_renew_file,{
				dbtable : dbtable,
				id_colname : id_colname,				
				row_id : row_id},
				function(data){
					alert(data);
					the_row.html('<td colspan="6"><h2 class="text-danger">YOU SUCCESSFULLY DELETED ME !!</h2></td>');
					the_row.delay('slow').fadeOut('slow');
			});
		} else{
			$(this).closest('tr').removeAttr('class');
		}
	});

//----------------------
//-----Subject data Edit
//----------------------
function test(n){
	var dbtable = $(this).closest('div#subjects').attr('data-tablename');
	var date_field = $(this).closest('div#subjects').attr('data-date');
	var id_field = $(this).closest('div.subjcontent').attr('data-id');
	var row_id = $(this).closest('div.subjcontent').attr('id');
	var subjname = $.trim($('#subj_name'+n).text());
	var subjtitle = $.trim($('#subj_name'+n).attr('data-subjtitle'));
	//fetch image location
	var image_src = $.trim($('#imgsrc'+n).attr('src'));
	// fetching subject status
	var cur_status = $.trim($('a#subjstatus'+n).attr('data-status'));
	// fetching level id and cat id
	var sublevel = $.trim($('#sublevel'+n).val());
	var subcat = $.trim($('#subcat'+n).val());
	// current course level
	var cur_level = $('select#newlevel option[value="'+sublevel+'"]');
	var cur_cat = $('select#newcat option[value="'+subcat+'"]');
	//alert("level id : "+sublevel+" and cat id : "+subcat);
	// add subject status into update modal radio
	if(cur_status == 1){
		// checked
		$('#newstatus').attr('checked','checked');
		$('div.has-switch > div').removeAttr('class');
		var u = $('div.has-switch > div').attr('class','switch-on');		
	} else{
		// unchecked
	var u = $('div.has-switch > div').attr('class','switch-off');
	}
	$('#udt_coursename').val(subjname);
	$('#udt_coursetitle').val(subjtitle);	
	$('#udt_newimage').attr('src',image_src);
	
	$('select#newlevel option').removeAttr("selected");
	$('select#newcat option').removeAttr("selected");
	
	$(cur_level).attr("selected","selected");
	$(cur_cat).attr("selected","selected");
}
//-------------------------------
//Level data insertion............
//-------------------------------
$('button#add_level').on('click', function(){	
	var levelname = $.trim($('#level_name').val());
	var tagline = $.trim($('#level_tagline').val());
	var pagelink = $.trim($('#level_link').val());
	var level_brief = $.trim($('#level_brief').val());
	if($('#level_status').is(':checked')) {
		 level_status = 1;
	} else{
		level_status = 0;
	}
	
	$.post(data_push_file,{
		name : levelname,
		pagelink : pagelink,
		tagline : tagline,
		level_brief : level_brief,
		level_status : level_status},			
		function(data){
			var response = $(data).text();
			alert(data);
			$('#level_name').val('');
			$('#level_tagline').val('');
			$('#level_link').val('');
			$('#level_brief').val('');
			$("button.close").trigger("click");
			setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 0001);
	});		
	return false;
});

//-------------------------------
//catagory data insertion............
//-------------------------------
$('button#add_cat').on('click', function(){	
	var catname = $.trim($('#cat_name').val());
	if($('#cat_status').is(':checked')) {
		 cat_status = 1;
	} else{
		cat_status = 0;
	}
	
	$.post(data_push_file,{
		catname : catname,
		cat_status : cat_status},			
		function(data){
			alert(data);
			$('#cat_name').val('');
			$("button.close").trigger("click");
			setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 0001);
	});		
	return false;
});

//--------------------------------------
//--Video Topics insertion into database
//--------------------------------------
$('button#add_topic').on('click', function(){		
	var topic_name = $.trim($('#topic_name').val());
	if($('#topic_status').is(':checked')) {
		 topic_status = 1;
	} else{
		topic_status = 0;
	}
	// fetch foreign key values
	var level_id = $.trim($('#sort_level').val());
	var cat_id = $.trim($('#sort_cat').val());
	var subj_id = $.trim($('#sort_subj').val());
//	alert(level_id+" : "+cat_id+" : "+subj_id+" name :: "+topic_name+" ( "+topic_status+" )");
//	return false;
	$.post(data_push_file,{
		topic_name : topic_name,
		topic_status : topic_status,
		level_name : level_id,
		cat_name : cat_id,
		subj_name : subj_id},					
		function(data){
			alert(data);
			$('#topic_name').val('');
			$("button.close").trigger("click");
			setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 0001);
	});		
	return false;
});

//$('button#update_subject').on('click',function(e) {
//   var newlevel = $('#newlevel').val();
//    var newcat = $('#newcat').val();
//	var newname = $('#udt_coursename').val();
//	var newtitle = $('#udt_coursetitle').val();		
//	if($('#newstatus').is(':checked')){
//		   var newstatus = 1;	}
//	else { var newstatus = 0;	}
//	alert(newlevel);
//	return false; 
//});

///----------------
///Subject Deletion
//-----------------
function trash_subject(n){
	var dbtable = $('#subjects'+n).attr('data-tablename');
	var id_colname = $('.subjgrab'+n).attr('data-id');
	var row_id = $('.subjgrab'+n).attr('id');
	var cnfirm = confirm('Delete from '+dbtable+ " where "+id_colname+ " : "+row_id);
	if(cnfirm == true){
		// Prepare to delete it
		$.post(data_renew_file,{
			dbtable : dbtable,
			id_colname : id_colname,				
			row_id : row_id},
			function(data){
				alert(data);	
				$('#subjects'+n).html("<div class='text-danger' style='font-size:20px; margin:0 auto; width:80px; font-weight:bold;'><div>Subject</div><i class='fa fa-trash-o fa-5x'></i><div>Deleted</div></div>");
				$('#subjects'+n).delay('slow').fadeOut('slow');
		});
	} else{
		alert("Not Deleted")
	}
}


///--------------
///Test function
//---------------

function testit(){
	if($('#newstatus').is(':checked')){
		alert('ok checked');
		return false;
	}
	else {
		alert('NOT CHECKED');
		return false;
	}
}
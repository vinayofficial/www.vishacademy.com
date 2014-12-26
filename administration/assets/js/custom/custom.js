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
				date_colname : date_colname},
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
					//alert(data);
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
//$('a#subj_editr').on('click', function(){
	function test(n){
	
	var dbtable = $(this).closest('div#subjects').attr('data-tablename');
	var date_field = $(this).closest('div#subjects').attr('data-date');
	var id_field = $(this).closest('div.subjcontent').attr('data-id');
	var row_id = $(this).closest('div.subjcontent').attr('id');
	var subjname = $.trim($('#subj_name'+n).text());
	var subjtitle = $.trim($('#subj_name'+n).attr('data-subjtitle'));
	//$("#addsubject").click();
	alert(subjtitle);
	$('#udt_coursename').val(subjname);
	$('#udt_coursetitle').val(subjtitle);	
//});
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
//Level data insertion............
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




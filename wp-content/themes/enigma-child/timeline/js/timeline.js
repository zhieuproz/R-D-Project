// JavaScript Document
//this sheet is to work for 3 buttons : add, edit , delete in timeline function

// processing for adding button, using jquery
// when clicking open post

"use strict"; //debug from ECMA5 Script
var $ = jQuery.noConflict(); // debug Jquery Conflict



var date = new Date(); //set date automatically
var day = date.getDate();
var month = date.getMonth()+1;
var year = date.getFullYear();
var FinalDay = month+'/'+day+'/'+year;

// change variables day and month to 2 letters 
if(day <10)
{
	day = '0'+day;
}

if( month<10)
{
	month = '0' + month;	
}




	$(document).ready(function() 
	{
		$('#AddingBox').click(function() 
		{
			$("#Adding_Model").modal(); // Call Adding_Model
			$('#Update').hide(); // hide edit button when clicking add a new post !!!
			$('#submit').show();
			$('#TitleOfPost').html('Adding a new Post ');
			
			$("#title").val(''); //remove all content in adding box
			$("#date").val(FinalDay); // set current day to Date box
			$("#content").val('');
			
			
	 		$('#title').focus(); // focus mouse when clicking to add post button
	 

	 
			return false;
	 });
 
});




 // when submitting request to server by ajax technique
// this function will check valuables and process ajax technique before adding a new post
// Ajax Request will be sent to functions.php file in root folder


function CheckPost() 
{
	var T = $("#title").val();
	var D = $("#date").val();
	var C = $("#content").val();
	var F = $('input[name=Feeling]:checked', '#timeline-form').val();//get value from radio input of Feeling
	var A = $('.attitude').html();
	console.log(A);
	if( T == "")
	{
		alert("please input the title");
		$("#title").focus();
		return false;	
	}
	
	else if(D == "")
	{
		alert("Please input the date of post");
		$("#date").focus();
		return false;
	}
	
	else if( C == "")
	{
		alert("Content cannot be null");
		$("#content").focus();	
		return false;
	}
	
	else
	{

	// AJAX	Request
		$.ajax({
			type : 'POST',
			data : {'action' : 'processing', 
					'title' : T,
					'date' : D,
					'content' : C,
					'feeling' : F,
					'attitude' : A
					},
			url : AJAX.url,
			success : function (resp){
				$('#cd-timeline').html(resp);// update content
				
				$('#cd-timeline').show();
				$('#first-time').hide();
				
				$('#title').val('');// reset value of input tags after posting a post
				$('#date').val('') ;
				$('#content').val('') ;
				$('input[name=Feeling]:checked', '#timeline-form').removeAttr("checked"); // remove value of checked radio button 
				
				
				$("#Adding_Model").modal("hide"); // fade out Modal

			}
		});
		return true;
	}
}



$(document).ready(function() { // Editing a post
    $(document).on('click','.id-edit', function(){
		$("#Adding_Model").modal();
        var id = $(this).attr('idEdit');
		
		$('#submit').hide(); // show update button and hide post button 
		$('#Update').show();
		$('#TitleOfPost').html('Editing post');
		
		//$('#AddingPost').fadeIn(300); // show adding box
	 	$('#title').focus(); 
		
		var OldTitle = $(this).attr('titleEdit'); //get current data
		var OldDate = $(this).attr('dateEdit');
		var OldContent = $(this).attr('contentEdit');
		var OldFeeling = $(this).attr('feelingEdit');
		var A = $('.attitude').html();
		
		$("#title").val(OldTitle); //set current data to adding box 
		$("#date").val(OldDate);
		$("#content").val(OldContent);
		$("input[name=Feeling][value=" +OldFeeling + "]").attr('checked', true); //set data with radio type
		
		$(document).on('click','#Update', function()
		{
			var NewTitle = $("#title").val(); // get new data after changing by users to process
			var NewDate = $('#date').val();
			var NewContent = $('#content').val();
			var NewFeeling = $('input[name=Feeling]:checked', '#timeline-form').val();
			
			$.ajax({
				type : 'POST',
				dataType:'text',
				data : {'action' : 'processing',
						'idEdit' : id,
						'TitleUpdate' : NewTitle,
						'DateUpdate' : NewDate,
						'ContentUpdate' : NewContent,
						'FeelingUpdate' : NewFeeling,
						'attitude' : A
						},
				url : AJAX.url,
				success : function (resp){
					$('#cd-timeline').html(resp);// update content
					
					$('#title').val('');// reset value of input tags after posting a post
					$('#date').val('') ;
					$('#content').val('') ;
					$('input[name=Feeling]:checked', '#timeline-form').removeAttr("checked");
					
					$("#Adding_Model").modal("hide");
			   
			}
		});	
		});
    });
});




$(document).ready(function() { // Deleting a post
    $(document).on('click','.id-Del', function(){ // We must use this structure of Jquery cause dynamic element event will not bind directly from 1.8 version onwards
        var id = $(this).attr('idDelete');	
		var A = $('.attitude').html();
		var confirmFromUser = confirm("Do you really want to delete this post ?");
		if(confirmFromUser === true)
		{
		
			$.ajax({
			type : 'POST',
			dataType:'text',
			data : {'action' : 'processing', 
					'deleting' : id,
					'attitude' : A
					},
			url : AJAX.url,
			success : function (resp){
				$('#cd-timeline').html(resp);
			}
			});
		}
    });
	
});







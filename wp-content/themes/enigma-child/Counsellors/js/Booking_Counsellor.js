// JavaScript Document
//this sheet is to work for booking Counsellor function

"use strict";
$('dob').datepicker({
});

$('dob_family').datepicker({
});

$('expiry').datepicker({
});


function Check_Booking()
{
	if($('#firstname').val() == '')
	{
		alert("please input your first name");
		$("#firstname").focus();
		return false;
	}
	
	if($("#last_name").val()== '')
	{
		alert("please input your last name");
		$("#last_name").focus();
		return false;
	}
	
	if(!$("input[name='title']:checked").val()) // check list radio input is checked or not 
	{
		
		alert("please stick your title");
		return false;
	}

	if(!$("input[name='contact']:checked").val())
	{
		alert("please stick your Method Of Contact");
		return false;
	}
	
	if(!$("input[name='ethnic_group']:checked").val())
	{
		if($('#other').val() == '')
		{
			if($('#language').val() == '')
				{
					alert("please fill your ethnic group");
					return false;
				}
		}
	}
	
	if(!$("input[name='Relationship']:checked").val())
	{
		alert("please stick your Relationship");
		return false;
	}

	if(!$("input[name='income']:checked").val())
	{
		alert("please stick your income");
		return false;
	}
	
	if($("#agree").is(':checked'))
	{
		if(confirm("Confirm your booking?"))
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	else
	{
		alert("agree Policy before submitting form");
		return false;
	}

}
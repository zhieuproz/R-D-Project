// JavaScript Document
//this sheet is to work for 3 buttons : add, edit , delete in Counsellor function


"use strict";


$(document).ready(function() 
{
	$('#AddingCounsellor').click(function() // when clicking Add counsellor button
	{
		$("#Counsellor-Update").hide();
		$('#Counsellor-Submit').show();
		$("#Adding_Counsellor").modal(); // Call Adding_Model
		
		$('#Title_Counsellor').html('Adding Counsellor');
		
		$("#First_Name").val(''); //remove all content in adding box
		$("#photo").val('');
		$("#specialty").val('');
		$("#region").val('');
		$("#experience").val('');
		$("#fee").val('');
		$("#information").val('');
		
		

		$('#First_Name').focus(); // focus mouse when clicking to add post button
			
	});

});

function Add_Counsellor()
{
	var Name = $("#First_Name").val();
	var Specialty = $("#specialty").val();
	var Region = $("#region").val();
	var Experience = $("#experience").val();
	var Fee = $("#fee").val();
	var Information = $("#information").val();
		
	if( Name === "")
	{
		alert("please input Counsellor Name");
		$("#First_Name").focus();
		return false;	
	}
	
	else if(Specialty === "")
	{ 
		alert("Please input Counsellor Specialty");
		$("#specialty").focus();
		return false;
	}
	
	else if( Region === "")
	{
		alert("Please input Counsellor Region");
		$("#region").focus();	
		return false;
	}

	else if( Experience === "")
	{
		alert("Please input Counsellor Experience");
		$("#experience").focus();	
		return false;
	}
		
	else if( Fee === "")
	{
		alert("Please input Counsellor Fee");
		$("#fee").focus();	
		return false;
	}
		
	else if( Information === "")
	{
		alert("Please input Counsellor Information");
		$("#information").focus();	
		return false;
	}
	
	else
	{
		
		// AJAX	Request
			$.ajax({
			type : 'POST',
			data : {'action' : 'processing',
					'Counsellor_Name' : Name,
					'Counsellor_Specialty' : Specialty,
					'Counsellor_Region' : Region,
					'Counsellor_Experience' : Experience,
					'Counsellor_Fee' : Fee,
					'Counsellor_Information' : Information,
					},
			url : AJAX.url,
			success : function (resp){
				$('#counsellor-list').html(resp);// update content
				
				$('#counsellor-list').show();
				$('#1st-time').hide();

				
				$("#Adding_Counsellor").modal("hide"); // fade out Modal

			}
		});
		return true;
	}
}

$(document).ready(function() { // Editing a Counsellor
    $(document).on('click','.EditC', function()
	{
		$("#Adding_Counsellor").modal();
        var id = $(this).attr('EditCounsellor');
		
		$('#Counsellor-Submit').hide(); // show update button and hide post button 
		$('#Counsellor-Update').show();
		$('#Title_Counsellor').html('Editing Counsellor');
		
	 	$('#First_Name').focus(); 
		
		var OldName = $(this).attr('EditCName'); //get current data
		var OldSpecialty = $(this).attr('EditCSpecialty');
		var OldRegion = $(this).attr('EditCRegion');
		var OldExperience = $(this).attr('EditCExperience');
		var OldFee = $(this).attr('EditCFee');
		var OldInformation = $(this).attr('EditCInfor');
		
		console.log(id);
		
		$("#First_Name").val(OldName); //set current data to adding box 
		$("#specialty").val(OldSpecialty);
		$("#region").val(OldRegion);
		$("#experience").val(OldExperience);
		$("#fee").val(OldFee);
		$("#information").val(OldInformation);

		$(document).on('click','#Counsellor-Update', function()
		{
			var NewName = $("#First_Name").val(); // get new data after changing by users to process
			var NewSpecialty = $('#specialty').val();
			var NewRegion = $('#region').val();
			var NewExperience = $('#experience').val();
			var NewFee = $('#fee').val();
			var NewInformation = $('#information').val();
			
			$.ajax({
				type : 'POST',
				dataType:'text',
				data : {'action' : 'processing',
						'idEditCounsellor' : id,
						'NameC' : NewName,
						'SpecialtyC' : NewSpecialty,
						'RegionC' : NewRegion,
						'ExperienceC' : NewExperience,
						'FeeC' : NewFee,
						'InforC' : NewInformation
						},
				url : AJAX.url,
				success : function (resp){
					$('#counsellor-list').html(resp);
					
					$("#First_Name").val(''); 
					$("#specialty").val('');
					$("#region").val('');
					$("#experience").val('');
					$("#fee").val('');
					$("#information").val('');
					
					$("#Adding_Counsellor").modal("hide");
			   	
			}
		});	
		});
    });
});



$(document).ready(function() //Deleting Counsellor
{
	$(document).on('click','.DelC', function()
	{
		var iddel = $(this).attr('DelCounsellor');	
		var confirmFromUser = confirm("Do you really want to delete this Counsellor ?");
		
		if(confirmFromUser === true)
		{
		
			$.ajax({
			type : 'POST',
			dataType:'text',
			data : {'action' : 'processing', 
					'DelCounsellor' : iddel
					},
			url : AJAX.url,
			success : function (resp){
				$('#counsellor-list').html(resp);
			}
			});
		}
	});
});
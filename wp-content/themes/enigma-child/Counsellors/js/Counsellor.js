// JavaScript Document
//this sheet is to work for 3 buttons : add, edit , delete in Control Counsellor function


"use strict";


$(document).ready(function() 
{
	$('#AddingCounsellor').click(function() // when clicking Add counsellor button
	{
		$("#Counsellor-Update").hide();
		$('.alert-warning').hide();
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
		$("#Photo").val('');
		$("#Email").val('');
		

		$('#First_Name').focus(); // focus mouse when clicking to add post button
			
	});

});



function Add_Counsellor()
{
	var CheckUpload;
	var Name = $("#First_Name").val();
	var Specialty = $("#specialty").val();
	var Region = $("#region").val();
	var Experience = $("#experience").val();
	var Fee = $("#fee").val();
	var Information = $("#information").val();
	var Email = $("#Email").val();
	
    var PhotoInput = document.getElementById('Photo');
    var PhotoName = PhotoInput.value.split(/(\\|\/)/g).pop(); // get file name of photo
	
	
	var Photo = $('#Photo').prop('files')[0];//get photo 
	var form_data = new FormData();

	form_data.append('file', Photo);
	form_data.append('action', 'UploadPhoto');// add photo and action to form_data
	
	
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
	
	else if(Email === "")
	{ 
		alert("Please input Counsellor Email");
		$("#Email").focus();
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
	else if( PhotoName === "")
	{
		alert("Please Choose Counsellor's Image");
		return false;
	}



	else
	{
		
		// AJAX	Request , In this stage , I create 2 Ajax request : 1 for photo upload and another for counsellor information upload
		
			jQuery.ajax // photo upload 
			({
				url: ajax.url,
				type: 'post',
				contentType: false,
				processData: false,
				data: form_data,
				success: function (resp) 
				{
					$(".alert-info").show();
					$(".alert-info").html(resp);
					setTimeout(function() { $(".alert-info").hide(); }, 10000);
					if($.trim(resp) == "Photo Uploaded Successfully") // Compare return value from Ajax , If Photo can be uploaded , go on to add counsellor to database
					{
						$.ajax({ // Counsellor upload to database 
								type : 'POST',
								data : {'action' : 'processing',
										'Counsellor_Name' : Name,
										'Counsellor_Specialty' : Specialty,
										'Counsellor_Region' : Region,
										'Counsellor_Experience' : Experience,
										'Counsellor_Fee' : Fee,
										'Counsellor_Information' : Information,
										'Counsellor_Photo' : PhotoName,
										'Counsellor_Email' : Email
										},
								url : ajax.url,
								success : function (result){
									$('#counsellor-list').html(result);// update content

									$('#counsellor-list').show();
									$('#1st-time').hide();


									$("#Adding_Counsellor").modal("hide"); // fade out Modal

								}
							});
					}
					
					else
					{
						alert("This Photo is already exist in Database, Please re-name or choose another one!!");
					}
				
				} 

			});
		
		}
		
			//alert("Cannot Upload Photo");
			
		

		return true;
	
}



function EditCounsellor(id) // Editting Counsellor
{
	$(document).ready(function()
	{
		$(document).on('click','.EditC1', function()
		{
			$("#Adding_Counsellor").modal();


			$('.alert-warning').show();
			$('#Counsellor-Submit').hide(); // show update button and hide post button 
			$('#Counsellor-Update').show();
			$('#Title_Counsellor').html('Editing Counsellor');

			$('#First_Name').focus(); 


			var OldName = $('#name-'+id).text(); //get current data
			var OldSpecialty = $('#specialty-'+id).text();
			var OldRegion = $('#region-'+id).text();
			var OldExperience = $('#year-'+id).text();
			var OldFee = $('#fee-'+id).text();
			var OldInformation = $('#infor-'+id).text();
			var OldEmail = $('#email-'+id).text();


			$('#Photo').val('');
			$("#First_Name").val(OldName); //set current data to adding box 
			$("#specialty").val(OldSpecialty);
			$("#region").val(OldRegion);
			$("#experience").val(OldExperience);
			$("#fee").val(OldFee);
			$("#information").val(OldInformation);
			$("#Email").val(OldEmail);

			$('#counsellor-id-row').val(id);	
			var CurrentPhoto = $(this).attr('currentname'); //get current name photo
			$('#counsellor-id-row').attr('CurrentName',CurrentPhoto); // set current name to form edit
		});
	});
}

$(document).ready(function() // Go on Editting Counsellor
{
	$(document).on('click','.EditC', function()
	{
		var NewName = $("#First_Name").val(); // get new data after changing by users to process
		var NewSpecialty = $('#specialty').val();
		var NewRegion = $('#region').val();
		var NewExperience = $('#experience').val();
		var NewFee = $('#fee').val();
		var NewInformation = $('#information').val();
		var NewEmail = $('#Email').val();
		
		
		var NewPhotoInput = document.getElementById('Photo');
		var NewPhotoName = NewPhotoInput.value.split(/(\\|\/)/g).pop(); // get file name of photo

		var Photo = $('#Photo').prop('files')[0];//get photo 
		var form_data = new FormData();

		form_data.append('file', Photo);
		form_data.append('action', 'UploadPhoto');// add photo and action to form_data

		var id = $('#counsellor-id-row').val();
		var currentphoto = $('#counsellor-id-row').attr('CurrentName'); 
		
		if(NewPhotoName == '')
		{
			$.ajax
			({
					type : 'POST',
					dataType:'text',
					data : {'action' : 'processing',
							'idEditCounsellor' : id,
							'NameC' : NewName,
							'SpecialtyC' : NewSpecialty,
							'RegionC' : NewRegion,
							'ExperienceC' : NewExperience,
							'FeeC' : NewFee,
							'InforC' : NewInformation,
							'EmailC' : NewEmail
							},
					url : ajax.url,
					success : function (resp)
				{

						$('#counsellor-list').html(resp);

						$("#First_Name").val(''); 
						$("#specialty").val('');
						$("#region").val('');
						$("#experience").val('');
						$("#fee").val('');
						$("#information").val('');
						$("#Email").val('');

						$("#Adding_Counsellor").modal("hide");

				}
			});	 
		}
		
		else
		{

			jQuery.ajax // photo upload 
			({
				url: ajax.url,
				type: 'post',
				contentType: false,
				processData: false,
				data: form_data,
				success: function (resp) 
				{
					$(".alert-success").show();
					setTimeout(function() { $(".alert-success").hide(); }, 10000);
					if($.trim(resp) == "Photo Uploaded Successfully") // Compare return value from Ajax , If Photo can be uploaded , go on to add counsellor to database
					{
							$.ajax
							({
									type : 'POST',
									dataType:'text',
									data : {'action' : 'processing',
											'idEditCounsellor' : id,
											'NameC' : NewName,
											'SpecialtyC' : NewSpecialty,
											'RegionC' : NewRegion,
											'ExperienceC' : NewExperience,
											'FeeC' : NewFee,
											'InforC' : NewInformation,
											'PhotoC' : NewPhotoName,
											'EmailC' : NewEmail,
											'currentphoto' : currentphoto
											},
									url : ajax.url,
									success : function (resp)
								{

										$('#counsellor-list').html(resp);

										$("#First_Name").val(''); 
										$("#specialty").val('');
										$("#region").val('');
										$("#experience").val('');
										$("#fee").val('');
										$("#information").val('');
										$("#Email").val('');
									
										$("#Adding_Counsellor").modal("hide");

								}
							});	 
						}

						else
						{
							alert("This Photo is already exist in Database, Please re-name or choose another one!!");
						}
					}
			});
		}
	});
});


$(document).ready(function() //Deleting Counsellor
{
	$(document).on('click','.DelC', function()
	{
		var iddel = $(this).attr('DelCounsellor');	
		var confirmFromUser = confirm("Do you really want to delete this Counsellor ?");
		var NamePhoto = $(this).attr('NamePhoto');
		if(confirmFromUser === true)
		{
		
			$.ajax({
			type : 'POST',
			dataType:'text',
			data : {'action' : 'processing', 
					'DelCounsellor' : iddel,
					'namephoto' : NamePhoto
					},
			url : ajax.url,
			success : function (resp){
				$(".alert-danger").show();
				setTimeout(function() { $(".alert-danger").hide(); }, 10000);
				$('#counsellor-list').html(resp);
			}
			});
		}
	});
});





                
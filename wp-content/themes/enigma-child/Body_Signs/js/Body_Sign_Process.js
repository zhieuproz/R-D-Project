// JavaScript Document
//this sheet is to work for Body Signs interaction : Checking condition of Body Signs before calculating , AJAX Process in searching old test


// <!-- Checking --> //

"use strict";

function CheckBodySigns()
{
		//Getting Value from Sliders
		var feeling = $( "#slider-feeling" ).slider( "value" ) ; //	Head Area
		var head = $( "#slider-head" ).slider( "value" ) ;

		
		var neck = $( "#slider-neck" ).slider( "value" ) ; // Body Area
		var chest = $( "#slider-chest" ).slider( "value" ) ;
		var abdomen = $( "#slider-abdomen" ).slider( "value" ) ;
		var shoulder = $( "#slider-shoulder" ).slider( "value" ) ;
		var arm = $( "#slider-arm" ).slider( "value" ) ;
		
		
		var upperarm = $( "#slider-upper-limb" ).slider( "value" ) ; // Limbs Area
		var lowerarm = $( "#slider-lower-limb" ).slider( "value" ) ;
		var leg = $( "#slider-leg" ).slider( "value" ) ;
		var hand = $( "#slider-hand" ).slider( "value" ) ;
		
		
		var lungs = $( "#slider-lungs" ).slider( "value" ) ;	// Internal Area
		var thought = $( "#slider-thought" ).slider( "value" ) ;
		var heart = $( "#slider-heart" ).slider( "value" ) ;
		var stomach = $( "#slider-stomach" ).slider( "value" ) ;
		
		
		var CountOrgans = 0; // Counting how many organs are hurt
		
		
		if(feeling !== 0)
		{
			CountOrgans+= 1 ;
		}
		
		if(head !== 0)
		{
			CountOrgans+= 1 ;
		}
		
		if(neck !== 0)
		{
			CountOrgans+= 1 ;
		}
		
		if(chest !== 0)
		{
			CountOrgans+= 1 ;
		}
		
		if(abdomen !== 0)
		{
			CountOrgans+= 1 ;
		}
		
		if(shoulder !== 0)
		{
			CountOrgans+= 1 ;
		}
				
		if(arm !== 0)
		{
			CountOrgans+= 1 ;
		}
				
		if(upperarm !== 0)
		{
			CountOrgans+= 1 ;
		}
			
		if(lowerarm !== 0)
		{
			CountOrgans+= 1 ;
		}	
		
		if(leg !== 0)
		{
			CountOrgans+= 1 ;
		}
		
		if(hand !== 0)
		{
			CountOrgans+= 1 ;
		}		
		
		if(lungs !== 0)
		{
			CountOrgans+= 1 ;
		}
				
		if(thought !== 0)
		{
			CountOrgans+= 1 ;
		}
				
		if(heart !== 0)
		{
			CountOrgans+= 1 ;
		}
				
		if(stomach !== 0)
		{
			CountOrgans+= 1 ;
		}
		
		if(CountOrgans === 0 )
		{
			alert("Please scale at least 1 organ before calculating");
			return false;
		}
	return true; 
}



// <!-- AJAX PROCESS  --> //


$(document).ready(function()
{
	$('#Search_Old_Test').click(function() // search old body sign test
	{
		var OD = $('#old_date').val();
			$.ajax({
			type : 'POST',
			dataType:'text',
			data : {'action' : 'processing', 
					'search_date' : OD
					},
			url : AJAX.url,
			success : function (resp){
				$('#Old-Result').html(resp);
			}
			});
	});
});



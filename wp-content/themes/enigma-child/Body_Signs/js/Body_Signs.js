// JavaScript Document
//this sheet is to work for Body Signs interaction : Scale Range Slider ,Diretion for each of Body part : Head , Body , limbs

"use strict" ;

$('date').datepicker({
});


var i = 1; // this variable is using for hiding/showing body parts
//Processing for Fade-In / Fade-Out of Body Areas.
$(document).ready(function()
{	
	$('#Internal-Organ').hide();
	$('#Body-Area').hide();
	$('#Limbs-Area').hide();
	$('#Calculate').hide();
	$('#Previous').hide();
	
	$('#external').click(function()
	{
		$('#Internal-Organ').fadeOut(300);	
		$('#External-Organ').fadeIn(300);
		$('#Calculate').fadeOut(300);
		$('#Next').fadeIn(300);
		$('#Previous').fadeOut(300);
		
		$("#Head-Area").fadeIn(300);
		$('#Body-Area').fadeOut(300);
		$('#Limbs-Area').fadeOut(300);
		i = 1 ;
		console.log(i);
	});
	
	
	$('#internal').click(function()
	{
		$('#External-Organ').fadeOut(300);	
		$('#Internal-Organ').fadeIn(300);
		$('#Calculate').fadeIn(300);
		$('#Next').fadeOut(300);
		$('#Previous').fadeIn(300);
		i = 4 ;
		console.log(i);
	});
	
	$(document).on("click", "#ext_1", function () // Checking click event on Multiple elements --  Head Area 
	{
		$("#Head-Area").fadeIn(300);
		$('#Body-Area').fadeOut(300);
		$('#Limbs-Area').fadeOut(300);
		
		$('#Next').fadeIn(300);
		$('#Previous').fadeOut(300);
		i = 1;
		console.log(i);
	});
	
	
	$(document).on("click", "#ext_8, #ext_9, #ext_10 , #ext_14 , #ext_15", function () //Body Area 
	{
		$("#Body-Area").fadeIn(300);
		$('#Head-Area').fadeOut(300);
		$('#Limbs-Area').fadeOut(300);
		
		$('#Next').fadeIn(300);
		$('#Previous').fadeIn(300);
		i = 2;
		console.log(i);
	});
	
	
	$(document).on("click", "#ext_13, #ext_19, #ext_21 , #ext_24", function () //Limbs Area
	{
		$("#Limbs-Area").fadeIn(300);
		$('#Head-Area').fadeOut(300);
		$('#Body-Area').fadeOut(300);
	
		$('#Next').fadeIn(300);
		$('#Previous').fadeIn(300);
		i = 3;
		console.log(i);
	});
		
});


function NextBody()
{
	if(i === 1)
	{
		$("#Body-Area").fadeIn(300);
		$('#Head-Area').fadeOut(300);
		$('#Limbs-Area').fadeOut(300);
		i++;
		console.log(i);
		$('#Previous').fadeIn(300);
		return;
	}

	if(i === 2)
	{
		$('#Previous').fadeIn(300);
		$("#Limbs-Area").fadeIn(300);
		$('#Head-Area').fadeOut(300);
		$('#Body-Area').fadeOut(300);
		i++;
		console.log(i);
		return;
	}
	
	if(i === 3)
	{
		$('#ext_base').hide().animate({'opacity':'0'}, 1000);
		$('#int_base').show().animate({'opacity':'1'}, 1000);
		
		$('#External-Organ').fadeOut(300);	
		$('#Internal-Organ').fadeIn(300);
		$('#Calculate').fadeIn(300);
		$('#Next').fadeOut(300);
		i++;
		console.log(i);
		return;
	}
}

function PreviousBody()
{
	if(i === 2)
	{
		$("#Head-Area").fadeIn(300);
		$('#Body-Area').fadeOut(300);
		$('#Limbs-Area').fadeOut(300);
		i--;
		console.log(i);
		$('#Previous').fadeOut(300);
		return;
	}

	if(i === 3)
	{

		
		$("#Body-Area").fadeIn(300);
		$('#Head-Area').fadeOut(300);
		$('#Limbs-Area').fadeOut(300);
		i--;
		console.log(i);
		$('#Previous').fadeIn(300);
		return;
	}
	
	if(i === 4)
	{
		$('#int_base').hide().animate({'opacity':'0'}, 1000);
		$('#ext_base').show().animate({'opacity':'1'}, 1000);
		
		$('#Internal-Organ').fadeOut(300);	
		$('#External-Organ').fadeIn(300);
		$('#Calculate').fadeOut(300);
		
		i--;
		console.log(i);
		$('#Previous').fadeIn(300);
		$('#Next').fadeIn(300);
		return;
	}
}


// processing for separated object scale range in Body Signs
$(document).ready(function() // Head Area
{

    $( "#slider-head" ).slider({ // Head 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#head" ).val(ui.value );
      }
    });
    $( "#head" ).val($( "#slider-head" ).slider( "value" ) );
	

    $( "#slider-feeling" ).slider({  //Feeling
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#feeling" ).val(ui.value );
      }
    });
    $( "#feeling" ).val($( "#slider-feeling" ).slider( "value" ) );
	
});



$(document).ready(function() // Body Area
{
	   $( "#slider-neck" ).slider({ // Neck 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#neck" ).val(ui.value );
      }
    });
    $( "#neck" ).val($( "#slider-neck" ).slider( "value" ) );
	
	

	   $( "#slider-chest" ).slider({ // Chest 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#chest" ).val(ui.value );
      }
    });
    $( "#chest" ).val($( "#slider-chest" ).slider( "value" ) );
	
	
	
	   $( "#slider-abdomen" ).slider({ // Abdomen 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#abdomen" ).val(ui.value );
      }
    });
    $( "#abdomen" ).val($( "#slider-abdomen" ).slider( "value" ) );
	
	
	
	   $( "#slider-shoulder" ).slider({ // Shoulder 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#shoulder" ).val(ui.value );
      }
    });
    $( "#shoulder" ).val($( "#slider-shoulder" ).slider( "value" ) );
	
	
	$( "#slider-arm" ).slider({ // Arm 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#arm" ).val(ui.value );
      }
    });
    $( "#arm" ).val($( "#slider-arm" ).slider( "value" ) );
});




$(document).ready(function() // Limbs Area
{
	   $( "#slider-upper-limb" ).slider({ // Upper Limb 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#upper-limb" ).val(ui.value );
      }
    });
    $( "#upper-limb" ).val($( "#slider-upper-limb" ).slider( "value" ) );
	
	

	   $( "#slider-lower-limb" ).slider({ // Lower Limb 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#lower-limb" ).val(ui.value );
      }
    });
    $( "#lower-limb" ).val($( "#slider-lower-limb" ).slider( "value" ) );
	
	
	
	   $( "#slider-leg" ).slider({ // leg 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#leg" ).val(ui.value );
      }
    });
    $( "#leg" ).val($( "#slider-leg" ).slider( "value" ) );
	
	
	
	   $( "#slider-hand" ).slider({ // Hand 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#hand" ).val(ui.value );
      }
    });
    $( "#hand" ).val($( "#slider-hand" ).slider( "value" ) );
});





$(document).ready(function() // Internal Organs
{
	   $( "#slider-lungs" ).slider({ // Lungs 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#lungs" ).val(ui.value );
      }
    });
    $( "#lungs" ).val($( "#slider-lungs" ).slider( "value" ) );
	
	
	
	   $( "#slider-heart" ).slider({ // Heart 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#heart" ).val(ui.value );
      }
    });
    $( "#heart" ).val($( "#slider-heart" ).slider( "value" ) );
	
	
	
	   $( "#slider-stomach" ).slider({ // Stomach 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#stomach" ).val(ui.value );
      }
    });
    $( "#stomach" ).val($( "#slider-stomach" ).slider( "value" ) );
	
	
	$( "#slider-thought" ).slider({ // Thought 
      range: "min",
      value: 0,
      min: 0,
      max: 10,
      slide: function( event, ui ) {
        $( "#thought" ).val(ui.value );
      }
    });
    $( "#thought" ).val($( "#slider-thought" ).slider( "value" ) );
});






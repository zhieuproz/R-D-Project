
function isTouchEnabled() {
	return (('ontouchstart' in window)
		|| (navigator.MaxTouchPoints > 0)
		|| (navigator.msMaxTouchPoints > 0));
}
$(document).ready(function(){
	$('#int_base').hide().animate({'opacity':'0'}, 1000);

	$('.go_int').on('click', function(){
		$('#ext_base').hide().animate({'opacity':'0'}, 1000);
		$('#int_base').show().animate({'opacity':'1'}, 1000);
	});
	$('.go_ext').on('click', function(){
		$('#int_base').hide().animate({'opacity':'0'}, 1000);
		$('#ext_base').show().animate({'opacity':'1'}, 1000);
	});
});


$(function(){
	ext_addEvent('ext_1');
	ext_addEvent('ext_2');
	ext_addEvent('ext_3');
	ext_addEvent('ext_4');
	ext_addEvent('ext_5');
	ext_addEvent('ext_6');
	ext_addEvent('ext_7');
	ext_addEvent('ext_8');
	ext_addEvent('ext_9');
	ext_addEvent('ext_10');
	ext_addEvent('ext_11');
	ext_addEvent('ext_12');
	ext_addEvent('ext_13');
	ext_addEvent('ext_14');
	ext_addEvent('ext_15');
	ext_addEvent('ext_16');
	ext_addEvent('ext_17');
	ext_addEvent('ext_18');
	ext_addEvent('ext_19');
	ext_addEvent('ext_20');
	ext_addEvent('ext_21');
	ext_addEvent('ext_22');
	ext_addEvent('ext_23');
	ext_addEvent('ext_24');
	ext_addEvent('ext_25');
	ext_addEvent('ext_26');
	ext_addEvent('ext_27');

	int_addEvent('int_1');
	int_addEvent('int_2');
	int_addEvent('int_3');
	int_addEvent('int_4');
	int_addEvent('int_5');
	int_addEvent('int_6');
	int_addEvent('int_7');
	int_addEvent('int_8');
	int_addEvent('int_9');
	int_addEvent('int_10');
	int_addEvent('int_11');
})


function ext_addEvent(id,relationId){
	var _obj = $('#'+id);
	_obj.attr({'fill':ext_config[id]['upColor'],'fill-opacity':ext_config[id]['upOpacity'],'stroke':ext_config[id]['outlineUpColor'],'stroke-opacity':ext_config[id]['outlineUpOpacity']});
	_obj.attr({'cursor':'default'});
	if(ext_config[id]['enable'] == true){
		if (isTouchEnabled()) {
			_obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+10, y=touch.pageY+15;
				var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(), 
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':ext_config[id]['overColor'],'fill-opacity':ext_config[id]['downOpacity'],'stroke':ext_config[id]['outlineDownColor'],'stroke-opacity':ext_config[id]['outlineDownOpacity']});
				$('#organs-tip').show().html(ext_config[id]['hover']);
				$('#organs-tip').css({left:x, top:y})
			})
			_obj.on('touchend', function(){
				$('#'+id).css({'fill':ext_config[id]['upColor'],'fill-opacity':ext_config[id]['upOpacity'],'stroke':ext_config[id]['outlineUpColor'],'stroke-opacity':ext_config[id]['outlineUpOpacity']});
				if(ext_config[id]['target'] == 'new_window'){
					window.open(ext_config[id]['url']);	
				}else if(ext_config[id]['target'] == 'same_window'){
					window.parent.location.href=ext_config[id]['url'];
				}
			})
		}
		_obj.attr({'cursor':'pointer'});
		_obj.hover(function(){
			$('#organs-tip').show().html(ext_config[id]['hover']);
			_obj.css({'fill':ext_config[id]['overColor'],'fill-opacity':ext_config[id]['overOpacity'],'stroke':ext_config[id]['outlineOverColor'],'stroke-opacity':ext_config[id]['outlineOverOpacity']})
		},function(){
			$('#organs-tip').hide();
			$('#'+id).css({'fill':ext_config[id]['upColor'],'fill-opacity':ext_config[id]['upOpacity'],'stroke':ext_config[id]['outlineUpColor'],'stroke-opacity':ext_config[id]['outlineUpOpacity']});
		})
		_obj.mousedown(function(){
			$('#'+id).css({'fill':ext_config[id]['downColor'],'fill-opacity':ext_config[id]['downOpacity'],'stroke':ext_config[id]['outlineDownColor'],'stroke-opacity':ext_config[id]['outlineDownOpacity']});
		})
		_obj.mouseup(function(){
			$('#'+id).css({'fill':ext_config[id]['overColor'],'fill-opacity':ext_config[id]['overOpacity'],'stroke':ext_config[id]['outlineOverColor'],'stroke-opacity':ext_config[id]['outlineOverOpacity']});
			if(ext_config[id]['target'] == 'new_window'){
				window.open(ext_config[id]['url']);	
			}else if(ext_config[id]['target'] == 'same_window'){
				window.parent.location.href=ext_config[id]['url'];
			}
		})
		_obj.mousemove(function(e){
			var x=e.pageX+10, y=e.pageY+15;
			var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(), 
			x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
			y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
			$('#organs-tip').css({left:x, top:y})
		})
	}	
}
function int_addEvent(id,relationId){
	var _obj = $('#'+id);
	_obj.attr({'fill':int_config[id]['upColor'],'fill-opacity':int_config[id]['upOpacity'],'stroke':int_config[id]['outlineUpColor'],'stroke-opacity':int_config[id]['outlineUpOpacity']});
	_obj.attr({'cursor':'default'});
	if(int_config[id]['enable'] == true){
		if (isTouchEnabled()) {
			_obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+10, y=touch.pageY+15;
				var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(), 
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':int_config[id]['overColor'],'fill-opacity':int_config[id]['downOpacity'],'stroke':int_config[id]['outlineDownColor'],'stroke-opacity':int_config[id]['outlineDownOpacity']});
				$('#organs-tip').show().html(int_config[id]['hover']);
				$('#organs-tip').css({left:x, top:y})
			})
			_obj.on('touchend', function(){
				$('#'+id).css({'fill':int_config[id]['upColor'],'fill-opacity':int_config[id]['upOpacity'],'stroke':int_config[id]['outlineUpColor'],'stroke-opacity':int_config[id]['outlineUpOpacity']});
				if(int_config[id]['target'] == 'new_window'){
					window.open(int_config[id]['url']);	
				}else if(int_config[id]['target'] == 'same_window'){
					window.parent.location.href=int_config[id]['url'];
				}
			})
		}
		_obj.attr({'cursor':'pointer'});
		_obj.hover(function(){
			$('#organs-tip').show().html(int_config[id]['hover']);
			_obj.css({'fill':int_config[id]['overColor'],'fill-opacity':int_config[id]['overOpacity'],'stroke':int_config[id]['outlineOverColor'],'stroke-opacity':int_config[id]['outlineOverOpacity']})
		},function(){
			$('#organs-tip').hide();
			$('#'+id).css({'fill':int_config[id]['upColor'],'fill-opacity':int_config[id]['upOpacity'],'stroke':int_config[id]['outlineUpColor'],'stroke-opacity':int_config[id]['outlineUpOpacity']});
		})
		_obj.mousedown(function(){
			$('#'+id).css({'fill':int_config[id]['downColor'],'fill-opacity':int_config[id]['downOpacity'],'stroke':int_config[id]['outlineDownColor'],'stroke-opacity':int_config[id]['outlineDownOpacity']});
		})
		_obj.mouseup(function(){
			$('#'+id).css({'fill':int_config[id]['overColor'],'fill-opacity':int_config[id]['overOpacity'],'stroke':int_config[id]['outlineOverColor'],'stroke-opacity':int_config[id]['outlineOverOpacity']});
			if(int_config[id]['target'] == 'new_window'){
				window.open(int_config[id]['url']);	
			}else if(int_config[id]['target'] == 'same_window'){
				window.parent.location.href=int_config[id]['url'];
			}
		})
		_obj.mousemove(function(e){
			var x=e.pageX+10, y=e.pageY+15;
			var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(), 
			x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
			y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
			$('#organs-tip').css({left:x, top:y})
		})
	}	
}

//The external spots code
$(function(){
	var points_len = ext_spots['spots'].length;
	if( points_len > 0){
		var xmlns = "http://www.w3.org/2000/svg";
		var tsvg_obj = document.getElementById("ext_spots");
		var svg_circle;
		for(var i=0;i<points_len;i++){
			svg_circle = document.createElementNS(xmlns, "circle");
			svg_circle.setAttributeNS(null, "cx", ext_spots['spots'][i]['pos_X']);
			svg_circle.setAttributeNS(null, "cy", ext_spots['spots'][i]['pos_Y']);
			svg_circle.setAttributeNS(null, "r", ext_spots['spots'][i]['diameter']/2);
			svg_circle.setAttributeNS(null, "fill", ext_spots['spots'][i]['upColor']);
			svg_circle.setAttributeNS(null, "fill-opacity", ext_spots['spots'][i]['upOpacity']);
			svg_circle.setAttributeNS(null, "stroke", ext_spots['spots'][i]['outlineUpColor']);
			svg_circle.setAttributeNS(null, "stroke-opacity", ext_spots['spots'][i]['outlineUpOpacity']);
			svg_circle.setAttributeNS(null, "id",'ext_spots_'+i);
			tsvg_obj.appendChild(svg_circle);
			dynamicext_addEvent(i);
		}
	}
});

function dynamicext_addEvent(id){
	var obj = $('#ext_spots_'+id);

	if(ext_spots['spots'][id]['enable'] == true){
		if (isTouchEnabled()) {
			obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+10, y=touch.pageY+15;
				var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(),
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':ext_spots['spots'][id]['downColor'],'fill-opacity':ext_spots['spots'][id]['downOpacity'],'stroke':ext_spots['spots'][id]['outlineDownColor'],'stroke-opacity':ext_spots['spots'][id]['outlineDownOpacity']});
				$('#organs-tip').show().html(ext_spots['spots'][id]['hover']);
				$('#organs-tip').css({left:x, top:y})
			})
			obj.on('touchend', function(){
				$('#'+id).css({'fill':ext_spots['spots'][id]['upColor'],'fill-opacity':ext_spots['spots'][id]['upOpacity'],'stroke':ext_spots['spots'][id]['outlineUpColor'],'stroke-opacity':ext_spots['spots'][id]['outlineUpOpacity']});
				if(ext_spots['spots'][id]['target'] == 'new_window'){
					window.open(ext_spots['spots'][id]['url']);
				}else if(ext_spots['spots'][id]['target'] == 'same_window'){
					window.parent.location.href=ext_spots['spots'][id]['url'];
				}
			})
		}
		obj.attr({'cursor':'pointer'});
		obj.hover(function(){
			$('#organs-tip').show().html(ext_spots['spots'][id]['hover']);
			obj.css({'fill':ext_spots['spots'][id]['overColor'],'fill-opacity':ext_spots['spots'][id]['overOpacity'],'stroke':ext_spots['spots'][id]['outlineOverColor'],'stroke-opacity':ext_spots['spots'][id]['outlineOverOpacity']})
		},function(){
			$('#organs-tip').hide();
			obj.css({'fill':ext_spots['spots'][id]['upColor'],'fill-opacity':ext_spots['spots'][id]['upOpacity'],'stroke':ext_spots['spots'][id]['outlineUpColor'],'stroke-opacity':ext_spots['spots'][id]['outlineUpOpacity']});
		})
		obj.mousedown(function(){
			obj.css({'fill':ext_spots['spots'][id]['downColor'],'fill-opacity':ext_spots['spots'][id]['downOpacity'],'stroke':ext_spots['spots'][id]['outlineDownColor'],'stroke-opacity':ext_spots['spots'][id]['outlineDownOpacity']});
		})
		obj.mouseup(function(){
			obj.css({'fill':ext_spots['spots'][id]['overColor'],'fill-opacity':ext_spots['spots'][id]['overOpacity'],'stroke':ext_spots['spots'][id]['outlineOverColor'],'stroke-opacity':ext_spots['spots'][id]['outlineOverOpacity']});
			if(ext_spots['spots'][id]['target'] == 'new_window'){
				window.open(ext_spots['spots'][id]['url']);	
			}else if(ext_spots['spots'][id]['target'] == 'same_window'){
				window.parent.location.href=ext_spots['spots'][id]['url'];
			}
		})
		obj.mousemove(function(e){
				var x=e.pageX+10, y=e.pageY+15;
				var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(), 
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#organs-tip').css({left:x, top:y})
		})
	}	
}

//The internal spots code
$(function(){
	var points_len = int_spots['spots'].length;
	if( points_len > 0){
		var xmlns = "http://www.w3.org/2000/svg";
		var tsvg_obj = document.getElementById("int_spots");
		var svg_circle;
		for(var i=0;i<points_len;i++){
			svg_circle = document.createElementNS(xmlns, "circle");
			svg_circle.setAttributeNS(null, "cx", int_spots['spots'][i]['pos_X']);
			svg_circle.setAttributeNS(null, "cy", int_spots['spots'][i]['pos_Y']);
			svg_circle.setAttributeNS(null, "r", int_spots['spots'][i]['diameter']/2);
			svg_circle.setAttributeNS(null, "fill", int_spots['spots'][i]['upColor']);
			svg_circle.setAttributeNS(null, "fill-opacity", int_spots['spots'][i]['upOpacity']);
			svg_circle.setAttributeNS(null, "stroke", int_spots['spots'][i]['outlineUpColor']);
			svg_circle.setAttributeNS(null, "stroke-opacity", int_spots['spots'][i]['outlineUpOpacity']);
			svg_circle.setAttributeNS(null, "id",'int_spots_'+i);
			tsvg_obj.appendChild(svg_circle);
			dynamicint_addEvent(i);
		}
	}
});

function dynamicint_addEvent(id){
	var obj = $('#int_spots_'+id);

	if(int_spots['spots'][id]['enable'] == true){
		if (isTouchEnabled()) {
			obj.on('touchstart', function(e){
				var touch = e.originalEvent.touches[0];
				var x=touch.pageX+10, y=touch.pageY+15;
				var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(),
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#'+id).css({'fill':int_spots['spots'][id]['downColor'],'fill-opacity':int_spots['spots'][id]['downOpacity'],'stroke':int_spots['spots'][id]['outlineDownColor'],'stroke-opacity':int_spots['spots'][id]['outlineDownOpacity']});
				$('#organs-tip').show().html(int_spots['spots'][id]['hover']);
				$('#organs-tip').css({left:x, top:y})
			})
			obj.on('touchend', function(){
				$('#'+id).css({'fill':int_spots['spots'][id]['upColor'],'fill-opacity':int_spots['spots'][id]['upOpacity'],'stroke':int_spots['spots'][id]['outlineUpColor'],'stroke-opacity':int_spots['spots'][id]['outlineUpOpacity']});
				if(int_spots['spots'][id]['target'] == 'new_window'){
					window.open(int_spots['spots'][id]['url']);
				}else if(int_spots['spots'][id]['target'] == 'same_window'){
					window.parent.location.href=int_spots['spots'][id]['url'];
				}
			})
		}
		obj.attr({'cursor':'pointer'});
		obj.hover(function(){
			$('#organs-tip').show().html(int_spots['spots'][id]['hover']);
			obj.css({'fill':int_spots['spots'][id]['overColor'],'fill-opacity':int_spots['spots'][id]['overOpacity'],'stroke':int_spots['spots'][id]['outlineOverColor'],'stroke-opacity':int_spots['spots'][id]['outlineOverOpacity']})
		},function(){
			$('#organs-tip').hide();
			obj.css({'fill':int_spots['spots'][id]['upColor'],'fill-opacity':int_spots['spots'][id]['upOpacity'],'stroke':int_spots['spots'][id]['outlineUpColor'],'stroke-opacity':int_spots['spots'][id]['outlineUpOpacity']});
		})
		obj.mousedown(function(){
			obj.css({'fill':int_spots['spots'][id]['downColor'],'fill-opacity':int_spots['spots'][id]['downOpacity'],'stroke':int_spots['spots'][id]['outlineDownColor'],'stroke-opacity':int_spots['spots'][id]['outlineDownOpacity']});
		})
		obj.mouseup(function(){
			obj.css({'fill':int_spots['spots'][id]['overColor'],'fill-opacity':int_spots['spots'][id]['overOpacity'],'stroke':int_spots['spots'][id]['outlineOverColor'],'stroke-opacity':int_spots['spots'][id]['outlineOverOpacity']});
			if(int_spots['spots'][id]['target'] == 'new_window'){
				window.open(int_spots['spots'][id]['url']);	
			}else if(int_spots['spots'][id]['target'] == 'same_window'){
				window.parent.location.href=int_spots['spots'][id]['url'];
			}
		})
		obj.mousemove(function(e){
				var x=e.pageX+10, y=e.pageY+15;
				var tipw=$('#organs-tip').outerWidth(), tiph=$('#organs-tip').outerHeight(), 
				x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(20*2) : x
				y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
				$('#organs-tip').css({left:x, top:y})
		})
	}	
}

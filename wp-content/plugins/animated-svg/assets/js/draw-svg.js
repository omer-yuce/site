( function ( $ ) {	
	'use strict';
	$.fn.pt_plus_animated_svg = function() {
		return this.each(function() {
			var $self = $(this);
			var data_id=$self.data("id");
			var data_duration=$self.data("duration");
			var data_type=$self.data("type");
			var data_stroke=$self.data("stroke");
			var data_fill_color=$self.data("fill_color");
			if($self.find(".info_box_svg").length > 0){
				$self.find(".info_box_svg > svg").attr("id",data_id);
				new Vivus(data_id, {type: data_type, duration: data_duration,forceRender:false,start: 'inViewport'});
			}else{
				new Vivus(data_id, {type: data_type, duration: data_duration,forceRender:false,start: 'inViewport',onReady: function (myVivus) {
					var c=myVivus.el.childNodes;
					var show_id=document.getElementById(data_id);
					show_id.style.opacity = "1";
					if(data_stroke!=''){
						for (var i = 0; i < c.length; i++) {
							$(c[i]).attr("fill", data_fill_color);
							$(c[i]).attr("stroke",data_stroke);
							var child=c[i];
							var pchildern=child.children;
							if(pchildern != undefined){
								for(var j=0; j < pchildern.length; j++){
									$(pchildern[j]).attr("fill", data_fill_color);
									$(pchildern[j]).attr("stroke",data_stroke);
								}
							}
						}
					}
				} });
			}
		});
	};
	
	
	var drwSvgReload = function(){
		setTimeout(function(){
			$('.pt_plus_row_bg_animated_svg').pt_plus_animated_svg();
			$('.pt_plus_animated_svg,.ts-hover-draw-svg').pt_plus_animated_svg();
			$('body').find('.pt_plus_row_bg_animated_svg').attr('style', 'stroke:black');
		}, 100);
		
		$('.plus-hover-draw-svg .svg_inner_block').on("mouseenter",function() {
			var $self;
			$self = $(this).parent();
			var data_id=$self.data("id");
			var data_duration=$self.data("duration");
			var data_type=$self.data("type");
			new Vivus(data_id, {type: data_type, duration: data_duration,start: 'inViewport'}).reset().play();
		}).on("mouseleave", function() {});
		
	};
	$(document).ready(function() {
		if (typeof drwSvgReload == 'function'){ 
			drwSvgReload(); 
		}
	});
	$(window).load(function() {
		if (typeof drwSvgReload == 'function'){ 
			drwSvgReload(); 
		}
	});
	

	
} ( jQuery ) );
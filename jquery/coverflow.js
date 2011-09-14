// JavaScript Document
$("button").button();
$("img#prev").hide();

$("div.ggpanel:last").addClass("last");
$("div.ggpanel:first").addClass("first");

//coverflow alignment
function coverflow_alignment(){
	if($(window).width() < (315*3)){
		width = 0;
		left = $(window).width() - 36;
		$("#next").css("left", left+"px");
		$("img#arrow-right, img#arrow-left").css("right", "+10000px");
	}else{
		width = ($(window).width() - (315*3)) / 2;
		$(".first").css("margin-left", width+"px");
		left = width + (315*3) - 36 - 15;
		$("#next").css("left", left+"px");
		$("#prev").css("left", width+"px");
		
		$("img#arrow-right").css("left", (left-40)+"px");
		$("img#arrow-left").css("left", (width+75)+"px");
	}
};

coverflow_alignment();
$(window).resize(function(e) {
	coverflow_alignment();
});
//end of coverflow alignment

//back and forth
$("img#prev").click(function(){
	$(this).hide();
	$("img#next").hide();
	
	$("div.panel_inactive").css("opacity", "1");
	$(".ggpanel").animate({"left": "+=315px"}, "normal", function(){
		$("div.panel_inactive").css("opacity", "0.3");
		if($("div.panel_active_0").hasClass("first")){
			$("img#prev").hide();
			$("img#next").show();
		}else{
			$("img#next, img#prev").show();
		}
	});
	$("div.panel_active_2").removeClass("panel_active_2").addClass("panel_inactive");
	$("div.panel_active_1").removeClass("panel_active_1").addClass("panel_active_2");
	$("div.panel_active_0").removeClass("panel_active_0").addClass("panel_active_1");
	$("div.panel_active_1").prev().removeClass("panel_inactive").addClass("panel_active_0");
	
});
$("img#next").click(function(){
	$(this).hide();
	$("img#prev").hide();
	
	$("div.panel_inactive").css("opacity", "1");
	$(".ggpanel").animate({"left": "-=315px"}, "normal", function(){
		$("div.panel_inactive").css("opacity", "0.3");
		if($("div.panel_active_2").hasClass("last")){
			$("img#next").hide();
			$("img#prev").show();
		}else{
			$("img#next, img#prev").show();
		}
	});
	$("div.panel_active_0").removeClass("panel_active_0").addClass("panel_inactive");
	$("div.panel_active_1").removeClass("panel_active_1").addClass("panel_active_0");
	$("div.panel_active_2").removeClass("panel_active_2").addClass("panel_active_1");
	$("div.panel_active_1").next().removeClass("panel_inactive").addClass("panel_active_2");
	
});

//check for any opened panel
var count = 0;
var orginial, main_picture;
$("img.other_picture").hover(function(){
	main_picture = $("div.panel_active_0").find("img.option");
	orginial =main_picture.attr("src");
	main_picture.attr("src", $(this).attr("alt"));
},function(){
	main_picture.attr("src", orginial);
}

);
$("img.option, div.title").hover(function(){
	if(($(this).closest("div.ggpanel").hasClass("panel_active_0")||$(this).closest("div.ggpanel").hasClass("panel_active_1")||$(this).closest("div.ggpanel").hasClass("panel_active_2"))&&(count==0)){
		$(this).closest("div.ggpanel").find("div.title").stop().animate({
			height: "27px",
			top: "390px"
		}, 500);
	}
}, function(){
	$(this).closest("div.ggpanel").find("div.title").stop().animate({
		height: "0px",
		top: "420px"
	}, 500);
});

//used when panel is opened
$("div.panel_active_0, div.panel_active_1, div.panel_active_2").live("click", function(){

	if((count == 0)&&(!$(this).is(":animated"))){
		
		if($(this).hasClass("panel_active_0")||$(this).hasClass("panel_active_1")||$(this).hasClass("panel_active_2")){
			$("img#prev, img#next, div.title, img#arrow-left, img#arrow-right").hide();
			
			count ++;
			
			if($(this).hasClass("panel_active_0")){
				$("div.panel_active_1").removeClass("panel_active_1").addClass("panel_inactive").css("opacity", "0.3");
				$("div.panel_active_2").removeClass("panel_active_2").addClass("panel_inactive").css("opacity", "0.3");
				$(this).find("div.description").fadeIn();
				$(this).animate({width:"725px"}, "slow", function(){
					id = $(this);
					
					$(".ggpanel").animate({"left": "+=120px"}, "fast", function(){
						id.find("div.other_pictures").show();
						if(!$(id).hasClass("first"))
							$("img#arrow-left").show();
						$("img#arrow-right").show();
						click_me = 0;
					});
				});
			}else if($(this).hasClass("panel_active_1")){
				$("div.panel_active_0").removeClass("panel_active_0").addClass("panel_inactive").css("opacity", "0.3");
				$("div.panel_active_1").removeClass("panel_active_1").addClass("panel_active_0");
				$("div.panel_active_2").removeClass("panel_active_2").addClass("panel_inactive").css("opacity", "0.3");
				$(this).find("div.description").fadeIn();
				$(this).animate({width:"725px"}, "slow", function(){
					id = $(this);
					$(".ggpanel").animate({"left": "-=195px"}, "fast", function(){
						id.find("div.other_pictures").show();
						$("img#arrow-right, img#arrow-left").show();
						click_me = 0;
					});
				});
			}else if($(this).hasClass("panel_active_2")){
				$("div.panel_active_0").removeClass("panel_active_0").addClass("panel_inactive").css("opacity", "0.3");
				$("div.panel_active_1").removeClass("panel_active_1").addClass("panel_inactive").css("opacity", "0.3");
				$("div.panel_active_2").removeClass("panel_active_2").addClass("panel_active_0");
				
				var panel = $(this);
				$(".ggpanel").animate({"left": "-=510px"}, "slow", function(){
					panel.find("div.description").fadeIn();
					panel.animate({width:"725px"}, "slow", function(){
						panel.find("div.other_pictures").show();
						if(!$(panel).hasClass("last"))
							$("img#arrow-right").show();
						$("img#arrow-left").show();
						click_me = 0;
					});
				});
			}
		}
	}
});

var click_me = 0;

$("img.option").click(function(){
	if($("div.ggpanel").is(":animated"))
		return false;
	
	if(($(this).closest("div.ggpanel").hasClass("panel_active_0") && $(this).closest("div.ggpanel").next().hasClass("panel_inactive"))||($(this).closest("div.ggpanel").hasClass("last") && $(this).closest("div.ggpanel").prev().hasClass("panel_inactive"))){
		$("div.panel_active_0").find("button").click();
	}else{
		
		if((!$("div.ggpanel").is(":animated"))&&(click_me == 0)&&(count!=0)){
			click_me++;
			count++;
			
			$("div.other_pictures, img#prev, img#next, div.title, img#arrow-left, img#arrow-right").hide();
			
			if($(this).closest("div.ggpanel").next().hasClass("panel_active_0")){ //back
				
				$("div.panel_active_0").find("div.description").fadeOut();
				$("div.panel_active_0")
					.removeClass("panel_active_0").addClass("panel_inactive").css("opacity", "0.3")
					.animate({width:"315px"}, "slow")
					.prev().removeClass("panel_inactive").addClass("panel_active_0").css("opacity", "1");
				$("div.panel_active_0").find("div.description").fadeIn();
				$("div.panel_active_0").animate({width:"725px"}, "slow", function(){
					$(".ggpanel").animate({"left": "+=315px"}, "slow", function(){
						$("div.panel_active_0").find("div.other_pictures").show();
						click_me = 0;
						
						if(!$("div.panel_active_0").hasClass("first"))
							$("img#arrow-left").show();
						$("img#arrow-right").show();
						
					});
				});
			}else if($(this).closest("div.ggpanel").prev().hasClass("panel_active_0")&&$(this).closest("div.ggpanel").hasClass("panel_inactive")){ //forth
				
				$("div.panel_active_0").find("div.description").fadeOut();
				$("div.panel_active_0")
					.removeClass("panel_active_0").addClass("panel_inactive").css("opacity", "0.3")
					.animate({width:"315px"}, "slow")
					.next().removeClass("panel_inactive").addClass("panel_active_0").css("opacity", "1");
				$("div.panel_active_0").find("div.description").fadeIn();
				$("div.panel_active_0").animate({width:"725px"}, "slow", function(){
					$(".ggpanel").animate({"left": "-=315px"}, "slow", function(){
						$("div.panel_active_0").find("div.other_pictures").show();
						
						if(!$("div.panel_active_0").hasClass("last"))
							$("img#arrow-right").show();
						$("img#arrow-left").show();
						click_me = 0;
					});
				});
				
			}
		}
	}
});

$("span.x_close").click(function(e) {
	if(!$("div.ggpanel").is(":animated")){
   		$("div.other_pictures, img#prev, img#next, img#arrow-left, img#arrow-right").hide();
		
		id = $("div.panel_active_0");
		id.find("div.description").fadeOut();
		
		if(id.hasClass("last")){
			id.animate({width:"315px"}, "slow", function(){
				$(".ggpanel").animate({"left": "+=510px"}, "slow", function(){
					id.removeClass("panel_active_0").addClass("panel_active_2");
					id.prev().removeClass("panel_inactive").addClass("panel_active_1").css("opacity", "1");
					id.prev().prev().removeClass("panel_inactive").addClass("panel_active_0").css("opacity", "1");
					$("img#prev").show();
				});
			});
		}else if(id.next().hasClass("last")){
			id.animate({width:"315px"}, "slow", function(){
				$(".ggpanel").animate({"left": "+=195px"}, "fast", function(){
					id.removeClass("panel_active_0").addClass("panel_active_1");
					id.next().removeClass("panel_inactive").addClass("panel_active_2").css("opacity", "1");
					id.prev().removeClass("panel_inactive").addClass("panel_active_0").css("opacity", "1");
					$("img#prev").show();
					
				});
			});
		}else{
			id.animate({width:"315px"}, "slow", function(){
				$(".ggpanel").animate({"left": "-=120px"}, "fast", function(){
					id.next().removeClass("panel_inactive").addClass("panel_active_1").css("opacity", "1");
					id.next().next().removeClass("panel_inactive").addClass("panel_active_2").css("opacity", "1");
					if(id.hasClass("first")){
						$("img#next").show();
					}else if(id.next().next().hasClass("last")){
						$("img#prev").show();
					}else{
						$("img#prev, img#next").show();
					}
				});
			});
		}
		count = 0;
		$("div.title").fadeIn();
		
	}
});

(function($){

	$.loadInfoHash = function(){
		var hash = location.hash;
		var listHash = hash.split("/");
		if (listHash[0] == "#centro") {
			// function 
			var id = parseInt(listHash[1].replace("salud-","")); 
			setTimeout(function(){
				cmdNextStep_OnClick(id);
			},1000);
		};
	}

	$.loadInfo = function(data,id){
		var timer = 500;
		var efect = 1000;
		if (jQuery("#pop").is(".active")) {
			timer = 500;
		} else {
			jQuery("#pop").addClass("active");
			timer = 10;
		}

		jQuery("#pop").animate({ left: '-600px'  }, timer, function() { 
			var cont = jQuery(this);
			cont.html(data); 
			setTimeout(function(){
				location.hash = "#centro/salud-" + id; 
				cont.animate({ left: '0px'  }, efect, function() {  
				}); 
			},100);  
		});

	}

	$.closeInfo = function(){
		location.hash = "#home"; 
		jQuery("#pop").animate({ left: '-600px'  }, 1000, function() {  
			jQuery(this).html("");
		}); 	
	}

	$.hideInfo = function(){
		jQuery("#informacion").hide();
	}

	$.showInfo = function(){
		infoHide(); 
		if (jQuery("#informacion").is(":visible")) {
			jQuery("#informacion").hide();
		} else {
			jQuery("#informacion").show();

			$("#informacion").animate({
				marginLeft: "-195px",
			}, 500 , function() {  

				$("#informacion").animate({
					marginLeft: "-205px",
				}, 500 , function() {  
					$("#informacion").animate({
						marginLeft: "-200px",
					}, 500 , function() {  

					});
				});

			});


		}
		
	}

	$.detecMobile = function(){
		var userAgent = navigator.userAgent.toLowerCase();

		jQuery.browser = {
			version: (userAgent.match( /.+(?:rv|it|ra|ie|me)[\/: ]([\d.]+)/ ) || [])[1],
			chrome: /chrome/.test( userAgent ),
			safari: /webkit/.test( userAgent ) && !/chrome/.test( userAgent ),
			iphone: /iphone/.test( userAgent ),
			android: /android/.test( userAgent ),
			ipad: /ipad/.test( userAgent ),
			opera: /opera/.test( userAgent ),
			opera_mini : /opera mini/.test( userAgent ),
			mobile: /mobile/.test( userAgent ),
			msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
			mozilla: /mozilla/.test( userAgent ) && !/(compatible|webkit)/.test( userAgent )
		};

		if (jQuery.browser.iphone || jQuery.browser.android || jQuery.browser.mobile ) {
			setTimeout(function(){  window.scrollTo(0,1); 
				setTimeout(function(){ window.scrollTo(0,1); }, 500); 
			}, 0); 
		};

	}


	$.gracias = function(){
		jQuery("#gracias").show();
		setTimeout(function(){
			jQuery("#gracias").animate({ left: '0px'  }, 1000, function() {  }); 
		}, 1000);
	}
	$.graciasClose = function(){
		jQuery("#gracias").animate({ left: '-600px'  }, 1000, function() {  }); 
	}

	$.loadInfoHash();
	
	jQuery(".btn_normal").live("click",function(){
		$.gracias();
	});
	jQuery(".btn_alto").live("click",function(){
		$.gracias();
	});
	jQuery(".btn_critico").live("click",function(){
		$.gracias();
	});


})(jQuery);

addEventListener("load", function() { 
	$.detecMobile();
}, false);



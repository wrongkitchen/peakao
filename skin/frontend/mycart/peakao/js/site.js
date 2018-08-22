jQuery(function($) {
	
	
			   jQuery(".dropdown-wrap,.dropdown-content").hover(function(){
		          if (jQuery(this).hasClass("disable")){return};
				  jQuery(this).addClass("dropdown-open");  
			   },
				function(){
				  jQuery(this).removeClass("dropdown-open");  
				
			   });
        $( "#price-category" ).selectmenu();
        
        $( "#county-form" ).selectmenu();
    
        $( "#delvery-popup" ).selectmenu();
        $( "#delvery-popup1" ).selectmenu();
        $( "#arrange" ).selectmenu();
        $( "#priority-form" ).selectmenu();
         $( "#price-compaire-form" ).selectmenu(); 
        
        $('.close-popup').on('click',function(){
        $('.popup-wrap').removeClass('pop-home-open');
        })
        
        
        $('.delevery-option').on('click',function(){
        	$('.popup-wrap#delivery').addClass('pop-home-open');
        })
		  $('.currency').on('click',function(){
        	$('.popup-wrap#currency').addClass('pop-home-open');
        })
        
        $('.menu-btn').on('click', function(){
        	$("nav").toggleClass('open');
        	
        })
        	if($('.menu-btn-new').length > 0) {
		$('.menu-btn-new').on('click', function(){
			$('.menu-wrap-new').toggleClass('menu-wrap-new-open');
			$('.wrap-out').toggleClass('wrap-in');
			$('html').toggleClass("body-slide")
		})
	}
        $('.tab-list-content-wrap > div').hide();
         $('.tab-list-content-wrap > div:first').show();
         $('.gird-list-mode > a:first').addClass('active');
         $('.gird-list-mode > a').on('click' , function(e){
         	e.preventDefault();
         	$('.gird-list-mode > a').removeClass('active');
         	$(this).addClass('active');
         	 $('.tab-list-content-wrap > div').hide();
         	var id_val=$(this).attr('href');         	 
         $(id_val).fadeIn(500);
         	
         })
        
        	
        $('.filter-more-btn').on('click',function(){
        	$(this).hide();
        	$('.filter-hide-btn').show();
        	$('.set-option-wrap').addClass('show-anime')
        })
          	$('.filter-hide-btn').on('click',function(){
        	$(this).hide();
        	$('.filter-more-btn').show();
        	$('.set-option-wrap').removeClass('show-anime')
        })
        
        
        
        $('.wrong-pwd').on('click',function(){
        	$('.popup-login').fadeIn(100);
        })
          $('.forget-close').on('click',function(){
        	$('.popup-login').fadeOut(100);
        })
        
        $('.sign').on('click',function(){
        	$('.login-sucess-pop').fadeIn(100);
        });
              $('.signup-msg').on('click',function(){
        	$('.signup-sucess').fadeIn(100);
        });
   
   
   $('.close-compaire').on('click',function(){
   	$('.compaire-diamond-overlay').fadeOut(200);
   	      });
   	       	$('.compaire-diamond-overlay').hide();

   	  
              
        
/* Script For Ring Advisor Page   
$('.tab-article > div').hide();    
$('.tab-article > div:first').show() 
$('.tab-aside ul li:first a').addClass('active');
$('.tab-aside ul li a').click(function(e){
	e.preventDefault();

}) */
	$('.tab-links li').click(function() {
		if ($(window).width() > 767) {
			var ind = $(this).index();
			$(this).siblings().find('a').removeClass('active');
			$(this).find('a').addClass('active');
			$('.tab-article').children('article').hide();
			$('.tab-article > article').eq(ind).show();
		}
		else {
			
		}

	})
	
//	var count_text = 0;
	var copy_0 = $('.tab-article .article-one').clone();
	var copy_1 = $('.tab-article .article-two').clone();
	var copy_2 = $('.tab-article .article-three').clone();

		//var $thistab = $(this).after('<li class="tab_block_box border-none"></li>');
		$('.tab-1').append(copy_0);
		$('.tab-2').append(copy_1);
		$('.tab-3').append(copy_2);
	
	  // ============Accordion function============
	$('.tab-links li a').click(function() { 
		if ($(window).width() < 768) {
		$(this).removeClass('active_block');
		$(this).next().slideUp('normal');
		if ($(this).next().is(':hidden') == true) { 
			$(this).addClass('active_block');
			$(this).next().slideDown('normal');
		}
		}
	});
	$('.main-header nav > ul > li').click(function() {
		$(this).find('a').next().slideToggle();
	}) 
	
	
		if($('.tab-main li').length > 0) {
		$('.tab-main li').click(function(){
			var tab_data = $(this).attr('data-tab');
			$('.tab-content-box').hide();
			$('.'+tab_data).show();
			
			$('.tab-main li').removeClass('active');
			$(this).addClass('active');
		})
	}
	
	
		if ($('.account-section-new .toggle-icon').length > 0) {
		$(".account-section-new .toggle-icon").click(function() {
			$(".account-section-new .aside ul").slideToggle();
			$(this).toggleClass("rotate-toggle");
		})
	}
	var wind_width = $(window).width();

	
	if (wind_width < 768) {
		if ($('.fast-login strong').length > 0) {
		$('.fast-login strong').click(function() {
			$(this).next('.login-new-content').slideToggle();
			$(this).find('.arrow-open-lp').toggleClass('rotate-arrow-lp');

		})
	}
	}
	
	
	
	if($(".dd-link").length > 0) {
		$(".dd-link").click(function(){
			$(this).next().find('.primary-sub-menu').slideToggle();
			$(this).toggleClass('dd-link-close');
		})
	}
	

	
	
		var currentLi;
		$('.prev-btn').on('click', function() {
			console.log(1)
			currentLi = $('.tab-main.tab-main-new ul .active').index();
			$('.tab-main.tab-main-new ul li').removeClass('active');
			$('.tab-content').find('.tab-content-box').css('display', 'none');
			if (currentLi == 0) {
				console.log(11)
				$('.tab-main.tab-main-new ul li').eq($('.tab-main.tab-main-new ul li').length - 1).addClass('active');
				$('.tab-content').find('.tab-content-box').eq($('.tab-content > div').length - 1).css('display', 'block');
			} else {
				console.log(111)
				$('.tab-main.tab-main-new ul li').eq(currentLi - 1).addClass('active');
				$('.tab-content').find('.tab-content-box').eq(currentLi - 1).css('display', 'block');
			}

		})
		$('.next-btn').on('click', function() {
			currentLi = $('.tab-main.tab-main-new ul .active').index();
			$('.tab-main.tab-main-new ul li').removeClass('active');
			$('.tab-content').find('.tab-content-box').css('display', 'none');
			if (currentLi == 2) {
				$('.tab-main.tab-main-new ul li').eq(0).addClass('active');
				$('.tab-content').find('.tab-content-box').eq(0).css('display', 'block');
			} else {
				$('.tab-main.tab-main-new ul li').eq(currentLi + 1).addClass('active');
				$('.tab-content').find('.tab-content-box').eq(currentLi + 1).css('display', 'block');
			}
		})
	

	if($('.tab-main li').length > 0) {
		$('.tab-main li').click(function(){
			var tab_data = $(this).attr('data-tab');
			$('.tab-content-box').hide();
			$('.'+tab_data).show();
			
			$('.tab-main li').removeClass('active');
			$(this).addClass('active');
		})
	}
	
	
	
});
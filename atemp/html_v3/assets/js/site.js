$(function() {
	$("#account").selectmenu();

	$("#cart").selectmenu();
	$("#area").selectmenu();

	$("#price-category").selectmenu();
	$("#address-category").selectmenu();
	$("#county-form").selectmenu();

	$("#delvery-popup").selectmenu();
	$("#delvery-popup1").selectmenu();
	$("#arrange").selectmenu();
	$("#priority-form").selectmenu();
	$("#price-compaire-form").selectmenu();

	$('.close-popup').on('click', function() {
		$('.popup-wrap').removeClass('pop-home-open');
	})

	$('.delevery-option').on('click', function() {
		$('.popup-wrap').addClass('pop-home-open');
	})

	$('.menu-btn').on('click', function() {
		$("nav").toggleClass('open');

	})

	$('.tab-list-content-wrap > div').hide();
	$('.tab-list-content-wrap > div:first').show();
	$('.gird-list-mode > a:first').addClass('active');
	$('.gird-list-mode > a').on('click', function(e) {
		e.preventDefault();
		$('.gird-list-mode > a').removeClass('active');
		$(this).addClass('active');
		$('.tab-list-content-wrap > div').hide();
		var id_val = $(this).attr('href');
		$(id_val).fadeIn(500);

	})

	$('.filter-more-btn').on('click', function() {
		$(this).hide();
		$('.filter-hide-btn').show();
		$('.set-option-wrap').addClass('show-anime')
	})
	$('.filter-hide-btn').on('click', function() {
		$(this).hide();
		$('.filter-more-btn').show();
		$('.set-option-wrap').removeClass('show-anime')
	})

	$('.wrong-pwd').on('click', function() {
		$('.popup-login').fadeIn(100);
	})
	$('.forget-close').on('click', function() {
		$('.popup-login').fadeOut(100);
	})

	$('.sign').on('click', function() {
		$('.login-sucess-pop').fadeIn(100);
	});
	$('.signup-msg').on('click', function() {
		$('.signup-sucess').fadeIn(100);
	});

	$('.close-compaire').on('click', function() {
		$('.compaire-diamond-overlay').fadeOut(200);
	});
	$('.compaire-diamond-overlay').hide();
	$('.compaire').on('click', function() {
		$('.compaire-diamond-overlay').fadeIn(100);
	});

	// Script For Ring Advisor Page
	$('.tab-article > div').hide();
	$('.tab-article > div:first').show()
	$('.tab-aside ul li:first a').addClass('active');
	$('.tab-aside ul li a').click(function(e) {
		e.preventDefault();
		$('.tab-aside ul li a').removeClass('active');
		$(this).addClass('active')
		var ring_tab = $(this).attr('href');
		$('.tab-article > div').hide();
		$(ring_tab).fadeIn(100);
	})

	$('.select-ring ul li .ring1').parents('li').addClass('active');
	$('.select-ring ul li .ring1').parents('.content-2').addClass('open-show1');
	$('.select-ring ul li .ring1').on('click', function() {
		$(this).parents('li').prevAll('li').addClass('active');
		$(this).parents('li').nextAll('li').removeClass('active');

		$(this).parents('li').addClass('active');
		$(this).parents('.content-2').removeClass('open-show2')
		$(this).parents('.content-2').removeClass('open-show3')
		$(this).parents('.content-2').removeClass('open-show4')
		$(this).parents('.content-2').addClass('open-show1')
		// $('.content-product-description-one').show();
		// $('.content-fig-one').show();

	})

	$('.select-ring ul li .ring2').on('click', function() {
		$(this).parents('li').prevAll('li').addClass('active');
		$(this).parents('li').nextAll('li').removeClass('active');
		$(this).parents('li').addClass('active');
		$(this).parents('.content-2').removeClass('open-show1')
		$(this).parents('.content-2').removeClass('open-show3')
		$(this).parents('.content-2').removeClass('open-show4')
		$(this).parents('.content-2').addClass('open-show2')
		// $('.content-product-description-one').show();
		// $('.content-fig-one').show();

	})

	$('.select-ring ul li .ring3').on('click', function() {
		$(this).parents('li').prevAll('li').addClass('active');
		$(this).parents('li').nextAll('li').removeClass('active');
		$(this).parents('li').addClass('active');
		$(this).parents('.content-2').removeClass('open-show2')
		$(this).parents('.content-2').removeClass('open-show1')
		$(this).parents('.content-2').removeClass('open-show4')
		$(this).parents('.content-2').addClass('open-show3')
		// $('.content-product-description-one').show();
		// $('.content-fig-one').show();

	})

	$('.select-ring ul li .ring4').on('click', function() {
		$(this).parents('li').prevAll('li').addClass('active');
		$(this).parents('li').nextAll('li').removeClass('active');
		$(this).parents('li').addClass('active');
		$(this).parents('.content-2').removeClass('open-show3')
		$(this).parents('.content-2').removeClass('open-show2')
		$(this).parents('.content-2').removeClass('open-show1')
		$(this).parents('.content-2').addClass('open-show4')
		// $('.content-product-description-one').show();
		// $('.content-fig-one').show();

	})

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
}); 
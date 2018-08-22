(function($) {
	$(document).ready(function() {

	$('input[data-custom="check-box"]').wrap('<div class="check-box"></div>'); //target checkbox with custom data attribute

	$.fn.toggleCheckbox = function () {
		this.attr('checked', !this.attr('checked'));
	}
	$(document).on("click", ".check-box", function() {
		$(this).find(':checkbox').toggleCheckbox();
		$(this).toggleClass('checkedBox');
	 });
 
 	}); //end doc ready
})(jQuery);
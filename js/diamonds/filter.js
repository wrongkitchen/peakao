

var filter;
jQuery(
function(){	
	jQuery("#apply-filter-button").click(function(){
		var resultContainer = jQuery("#diamonds-filter-results");
		var updateUrl = jQuery("#diamonds-filter-form").attr("action");
		
		filter = new IkD.Filter(updateUrl, resultContainer);
		filter.setAttribute('price',{ mass : [23555,150]});
		filter.updateResults();
		
	});
	
});
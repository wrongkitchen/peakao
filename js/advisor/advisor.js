
Advisor ={
      
       	  
	
};
Advisor.Updata =function(d,s){
	
}
Advisor.Complete = function (url){
	   jQuery.ajax({
            url			: url,
			type : "POST",
            dataType	: "html",
            data		: {
				"settings" : Advisor.Helper.setting,
				"diamonds" : Advisor.Helper.caratdiamond
			},
            beforeSend	: function(){
               Advisor.Helper.startPreloader();
            },
            complete	: function(){

                Advisor.Helper.finishPreloader();
            },
            success		: function(data) {
			     jQuery('#qualitytab').removeClass('active');
				 jQuery('#recommendtab').addClass('active');

				 jQuery('.tab-article > div').hide(); 
				 jQuery('.tab-article > #recommend_result').show(); 
				 jQuery('#recommend_result').html(data);
				 jQuery(jQuery('#recommendtab').attr("href")).fadeIn(100).click();
	            
            }
        });
}
Advisor.Helper = {
    startPreloader	: function(){
        jQuery(".overlayBlock").show();		
    },
	
    finishPreloader	: function(){
        jQuery(".overlayBlock").hide();		
    },
	
	diamond : new Array(),
	
	setting : new Array(),
	
	caratdiamond : new Array(),
	
	caratsetting : new Array()
};
Advisor.caratFilter = function (caraturl){
	this.caraturl = caraturl;
	this.filters = new Array();
	this.getfilterData = function(element){
		
		var el = jQuery( "#"+element+"_slider" );
		var values = new Array();
		values.push ( el.slider("values", 0));
			 values.push (  el.slider("values", 1));
	
		if (values[0]==el.slider("option", "min") && values[1]==el.slider("option", "max")){
		return "null";
		}
		else return values[0]+","+values[1];
	};
}
Advisor.caratFilter.prototype ={
	addfilter : function(filtername){
		
		 this.filters.push(
		 {
			 name : filtername
		 }
		 )
	},
	resetall : function(){
        
		for(var i=0 ; i <this.filters.length ;i++){
			this.resetfilter(this.filters[i].name);
		}
	},

	resetfilter :function(element){
	var el = jQuery( "#"+element+"_slider" );
		   el.removeClass("disable");
		  var min = el.slider("option","min");
		   var max = el.slider("option","max");
		
          el.slider(
			"values", 
		     0, 
			  min
			  ); 
			el.slider(
		    "values", 
		     1, 
			 max
			);
	},
	applyfilter : function() {
		
	  var attr = {};
         for(var i =0; i < this.filters.length ;i++){	
		  if (this.getfilterData(this.filters[i].name)!="null"){
     
		        attr[this.filters[i].name] = this.getfilterData(this.filters[i].name);
		  }	
	    }
	  var diamonds = Advisor.Helper.diamond;
	  if(Object.keys(attr).length==0 && diamonds.length==0){
       	
		return;
	  }
       if(Object.keys(attr).length>0){
		   jQuery("#caratreset").removeClass("grey-btn");
	   }else{
		  jQuery("#caratreset").addClass("grey-btn"); 
		   
	   }
	   jQuery.ajax({
            url			: this.caraturl,
			type : "POST",
            dataType	: "json",
            data		: {
				"attr" : attr,
				"diamonds" : diamonds
			},
            beforeSend	: function(){
               Advisor.Helper.startPreloader();
            },
            complete	: function(){

                Advisor.Helper.finishPreloader();
            },
            success		: function(data) {
			     Advisor.Helper.caratdiamond = data.diamond;
                 jQuery("#ringtab2 carat").html(data.carat);
            }
        });
	}
	
}
Advisor.styleFilter = function(filterurl){
	this.filterurl = filterurl;
	this.filters = new Array();
    this.getfilterData = function(element){
		var data = "";
		if (element=="budget"){
		  var min = jQuery("#budget #minPrice").val();
		  var max = jQuery("#budget #maxPrice").val();
		  
		  var symbol = jQuery("#budget #minPrice").attr("symbol");
		  
			if (min == jQuery("#minPrice").attr("value") && max==jQuery("#maxPrice").attr("value")){
				data ="";
			}			
			else {data =  min.replace(symbol,"")+','+max.replace(symbol,"");}
		}
		else{
	   	jQuery("#"+element).children(".filter.active").each(function(){
			data +=( jQuery(this).attr("data-filter"))+",";
		});
		}
		return (data=="") ? "null" : data;
	};
	
	this.dataresult = function(data){
         alert(Object.keys( data).length);
	}
}
Advisor.styleFilter.prototype={
	addfilter : function(filtername){
		 this.filters.push(
		 {
			 name : filtername,			
		 }
		 )
	},
	resetall : function(){

		for(var i=0 ; i <this.filters.length ;i++){
			this.resetfilter(this.filters[i].name);
		}
	},

	resetfilter :function(element){
	
		  if (element=="budget"){
		    jQuery("#"+element).removeClass("disable");
			 var symbol = jQuery("#budget #minPrice").attr("symbol");
		    var min = jQuery("#budget #minPrice").val(jQuery("#minPrice").attr("value"));
		    var max = jQuery("#budget #maxPrice").val(jQuery("#maxPrice").attr("value"));
			jQuery("#price_slider").slider(
			"values", 
			jQuery("#minPrice").data("index"), 
			  jQuery("#minPrice").attr("value").replace(symbol,"")
			  );
			jQuery("#price_slider").slider(
				"values", 
			 jQuery("#maxPrice").data("index"), 
			 jQuery("#maxPrice").attr("value").replace(symbol,"")
			);
		}
		  else{
	     	jQuery("#"+element).children(".filter").each(function(){
			 jQuery(this).removeClass("disable active");
             jQuery(this).children(".active").removeClass("active");		 
		  });
		}
	},
	applyfilter : function(){
	  var attr = {};var names = new Array();
         for(var i =0; i < this.filters.length ;i++){
                names.push(this.filters[i].name);		 
		  if (this.getfilterData(this.filters[i].name)!="null"){
     
		        attr[this.filters[i].name] = this.getfilterData(this.filters[i].name);
		  }	
	  }
	  if(Object.keys(attr).length==0){
		  	  jQuery("#stylereset").addClass("grey-btn");
			  jQuery("#nextqltstep").addClass("grey-btn");
		  jQuery("input.slider-value").attr('disabled', false);
			jQuery( "#price_slider" ).slider( "enable" );
	for (var i =0 ; i<names.length ;i++){
		jQuery("#"+names[i]).children(".filter").removeClass("disable");
			
          	}					
		return;
	  }
	  jQuery("#nextqltstep").removeClass("grey-btn");
          jQuery("#stylereset").removeClass("grey-btn");
	   jQuery.ajax({
            url			: this.filterurl,
			type : "POST",
            dataType	: "json",
            data		: {
				"attr" : attr
			},
            beforeSend	: function(){
               Advisor.Helper.startPreloader();
            },
            complete	: function(){

                Advisor.Helper.finishPreloader();
            },
            success		: function(data) {
               if(data.diamond) {Advisor.Helper.diamond = data.diamond }
			   if(data.setting) {Advisor.Helper.setting = data.setting }
			   var info = new Array();
			     for(var o in attr){  
                       info .push( o);
                  }  
				for (var i =0 ; i<names.length ;i++){

					if(jQuery.inArray(names[i],info)!=-1){
						continue;
					}
					else{
						if(data[names[i]]){
							data[names[i]] = data[names[i]]+"";
					
							var results = data[names[i]].split(",");
							if(names[i]=="budget"){
								
								jQuery("input.slider-value").attr('disabled', false);
								jQuery( "#price_slider" ).slider( "enable" );	
							}
				 
							jQuery("#"+names[i]).children(".filter").each(function(index,el){
						
								if(jQuery.inArray(
								jQuery(el).attr("data-filter"),
								results
								)== -1){
									jQuery(el).addClass("disable");
								}
								else {
									
									jQuery(el).removeClass("disable");
									
									}
							})
						}
						else {
							jQuery("#"+names[i]).children(".filter").addClass("disable");
							if(names[i]=="budget"){
								jQuery("input.slider-value").attr('disabled', 'disabled');
								jQuery( "#price_slider" ).slider( "disable" );

							}
							}
					}
				}  
			  
			       
            }
        });
	}
}
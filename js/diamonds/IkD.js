IkD = {};



IkD = {

    constructUrl	: '/diamonds/constructor/diamond', 
		
    addDiamondToRing	: function(diamondId){
        jQuery.ajax({
            url			: this.constructUrl,
            dataType	: "text",
            data		: {
                diamondId : diamondId
            },
            beforeSend	: function(){
                jQuery("#diamonds-filter-load").addClass("load");
            },
            complete	: function(){
                jQuery("#diamonds-filter-load").removeClass("load");
            },
            success		: function(data) {
                console.log("success");
            //IkD.Helper.redirect('http://google.com/');
            }
        });
			
    }
	
		
		
		
};



/*
 * IkD Helper
 */

IkD.Helper = {
    redirect	: function(url){
        window.location.href = url;
    },
	
    startPreloader	: function(){
        jQuery(".overlayBlock").show();		
    },
	
    finishPreloader	: function(){
        jQuery(".overlayBlock").hide();		
    }
};





/*
 * Diamonds filter( ajax loading results )
 * @package Ikantam_Diamonds
 * @author isxam 
 */
IkD.Filter = function(updateUrl, resultContainer){
    this.attributes = {};
	
    this.metadata = new Array();
	
    this.isLoading = false;
    this.updateUrl = updateUrl;
    this.resultContainer = resultContainer;
    this.filters = new Array();
};


IkD.Filter.prototype = {
	
    registerFilter	: function(filterName, getData, reset){
		
        this.filters.push({
            name	: filterName,
            getData	: getData,
            reset	: reset,
            isActive	: true
        });
		
    },
	
    unActiveFilter : function(filterName){
		
        for( var i=0;i<this.filters.length;i++){
            var _filter = this.filters[i];
            if(_filter.name == filterName){
                _filter.isActive = false;
                return;
            }
        }
    },
	
    activeFilter	: function(filterName){
        for( var i=0;i<this.filters.length;i++){
            var _filter = this.filters[i];
            if(_filter.name == filterName){
                _filter.isActive = true;
                return;
            }
        }		
    },
	
    registerMetadata : function(code, getData){
		
        for(var i=0;i<this.metadata.length;i++){
            var meta = this.metadata[i];
            if(meta.code == code){
                meta.getData = getData;
                return;
            }
        }
		
        this.metadata.push({
            code	: code,
            getData	: getData
        });
		
    },
	
    _getMetadata	: function(){
        var data = {};
        for(var i=0;i<this.metadata.length;i++){
            var meta = this.metadata[i];
            data[meta.code] = meta.getData();
        }
		
        return data;		
    },
	
    _getMetadataByCode	: function(code){
        for(var i=0;i<this.metadata.length;i++){
            var meta = this.metadata[i];
            if(meta.code == code){
                var data = meta.getData();
                return data;
            }
        }
        return "";
		
    },
	
    updateResults	: function (){
        this.attributes = {};
        for( var i=0;i<this.filters.length;i++){
            var _filter = this.filters[i];
            if(!_filter.isActive){
                continue;
            }
            var _data = _filter.getData();
            if(_data != '__all'){
                this._setAttribute(_filter.name, _data);
            }			
        }
		
        this._updateResults();
		
    },
	
    resetFilters	: function(){
        /*this.isLoading = true;*/
        this.filters = new Array(); 
        /*for( var i=0;i<this.filters.length;i++){
            var _filter = this.filters[i];
            _filter.reset();
        }*/		
        /*this.isLoading = false;*/
        
	

        location.reload();
        /*this.updateResults();*/
    },
	
    setResultContainer	: function(container){
        this.resultContainer = container;
    },
		
	
    /*
	 * Set attribute value for filter
	 * value must be 
	 * - string|number => equals
	 * - object =>
	 * 			available conditions
	 * 			- max => max value of attribute
	 * 			- min => min value of attribute
	 * 			- mass=> attr value in array
	 * @example :
	 * 	setAttribute('price', { max : 200 });
	 *  setAttribute('shape', { mass : ['Heart','Triangle','Emerald'] });
	 * @param string attrCode
	 * @param object value 
	 * 
	 * */
    _setAttribute	: function(attrCode, value){
        for(var _i = 0;_i < this.attributes.length; _i++ ){
            var attribute = this.attributes[_i];
            if(attribute.code == attrCode){
                attribute.value = value;
                return;
            }
        }
        this._addAttribute(attrCode, value);
		
    },
	
    _addAttribute	: function(attrCode, value){
        this.attributes[attrCode] = value;
    },
	
    /*
	 * update filter results by setted attribute values
	 * 
	 * */
    _updateResults	: function(){
        if(this.isLoading){
            return;
        }

        var self = this;
		
        jQuery.ajax({
            url			: this.updateUrl,
            dataType	: "html",
            data		: { 
                attributes 	: this.attributes,
                limit	: this._getMetadataByCode("limit"),
                order	: this._getMetadataByCode("order"),
                dir		: this._getMetadataByCode("dir"),
                mode	: this._getMetadataByCode("mode"),
				cat     : this._getMetadataByCode("cat"),
                //is_fancy: this._getMetadataByCode("is_fancy"),
                p		: this._getMetadataByCode("p")
            },
            beforeSend	: function(){
                jQuery("#diamonds-filter-load").addClass("load");
                self.isLoading = true;
                IkD.Helper.startPreloader();
            },
            complete	: function(){
                jQuery("#diamonds-filter-load").removeClass("load");
                self.isLoading = false;
                IkD.Helper.finishPreloader();
            },
            success		: function(data) {
                self.resultContainer.html(data);
            }
        });
		
		
    }
		
};



/* -- Popuper for comparison mode product list view -- */


var Popuper = function(container, prefix){

    this.container = container;
    this.fields = [];
    this.prefix = prefix;

    this.nowShowing = null;
	
};


Popuper.prototype = {

    init	: function(){
        var products = jQuery(this.container);
        console.log(products);
        for(var i=0;i<products.length;i++){
            var productId = jQuery(products[i]).attr("data-product-id");
            var popupHtml = jQuery("#" + this.prefix + "popup_html_"+productId).html();
            var popupBlock = jQuery('<div class="bl" id="' + this.prefix + 'popup'+productId+'" >'+popupHtml+'</div>');
            jQuery(this.container).append(popupBlock);
            this.addField(productId, products[i], popupBlock);
        }

        var popuper = this;
        products.on("mouseover", function(){
            var id = jQuery(this).attr("data-product-id");
            popuper.showPopup(id);
        });	

        products.on("mouseout", function(){
            var id = jQuery(this).attr("data-product-id");
            popuper.hidePopup(id);
        });

        jQuery(".close-but").on("click", function(){
            var id = jQuery(this).parent().attr("data-product-id");
            popuper.hidePopup(id);
        });
		
    },

    addField	: function(productId,fieldBlock, popupBlock){

		

        this.fields.push({
            id			: productId,
            fieldBlock	: fieldBlock,
            popupBlock	: popupBlock
        });

    },

    getField	: function(id){

        for(var i=0;i<this.fields.length;i++){
            if(this.fields[i].id == id){
                return this.fields[i];
            }
        }

    },

    showPopup	: function(id){

        if(this.nowShowing == id){
            return false;
        }
        if(this.nowShowing != null){
            this.hidePopup(this.nowShowing);
        }
		
		
        var field = this.getField(id);
        var ppBlock = field.popupBlock;
        var positionField = jQuery(field.fieldBlock).offset();
        var width = jQuery(field.fieldBlock).width();
        var height = jQuery(field.fieldBlock).height();
        ppBlock.css({
            opacity:1, 
            display:"block"
        });
        ppBlock.offset({
            top: positionField.top - 200 + height/2, 
            left : positionField.left + width
        });
        ppBlock.css({
            opacity:1, 
            display:"none"
        });
        ppBlock.fadeIn(200);

        this.nowShowing = id;
    },

    hidePopup	: function(id){
        for(var i=0;i<this.fields.length;i++){
            var field = this.fields[i];
            var ppBlock = field.popupBlock;
            ppBlock.css({
                opacity:1, 
                display:"none"
            });
            this.nowShowing = null;
        }	
    }

		
};


IkD.compareAjax = function(selector){

    this.selector = selector;
    this.elements = jQuery(selector).find("input");
    this.init();

};


IkD.compareAjax.prototype = {

    init	: function(){
        var self = this;
        for(var i=0;i<this.elements.length;i++){
            var el = jQuery(this.elements[i]);
            el.change(function(e){
                self.onChange(self,el);
				e.stopPropagation();
            });
        }

    },


    onChange	: function(self,el){
        var el = jQuery(el);
        if(el.is(':checked')){
            self.setCompare(el,true);
			jQuery('.select-dimaond span span').html(parseInt(jQuery('.select-dimaond span span').html())+1);
        } else {
            self.setCompare(el,false);
				jQuery('.select-dimaond span span').html(parseInt(jQuery('.select-dimaond span span').html())-1);
        }
		

    },

    showLoading	: function(el, isShowing){
        var loader = el.parent().find("img");
        var input = el;
        if(isShowing){
            el.hide();
            loader.show();
        } else {
            loader.hide();
           // el.show();
        }			
    },

    setCompare	: function(el, state){

        var url, success;
        var listContainer = jQuery('#compare-list');
		
        var self = this;
        if(state){
            url = el.attr("data-add-url");
            success = function(data){
                self.showLoading(el,false);
                if(listContainer){
                    listContainer.html(data);
                }
            };
        } else {
            url = el.attr("data-remove-url");
            success = function(data){
                self.showLoading(el,false);
                if(listContainer){
                    listContainer.html(data);
                }
            };
        }
		
        jQuery.ajax({
            url			: url,
            dataType	: "html",
            data		: { },
            beforeSend	: function(){
                self.showLoading(el,true);
            },
            success		: success
        });

    }


};

IkD.compareAjax.removeProduct = function (url, listContainer){
	
    jQuery.ajax({
        url			: url,
        dataType	: "html",
        data		: {
            return_list	: true
        },
        beforeSend	: function(){
            IkD.Helper.startPreloader();
        },
        success		: function(data){
            listContainer.html(data);
            IkD.Helper.finishPreloader();
        }
    });
	
	
};


/*

IkD.AjaxSettingView = {
		
		
	init	: function(){
		
		jQuery(".setting-link").click(IkD.AjaxSettingView.showSetting);
		
	},
	
	showSetting	: function(e){
		
		var url = jQuery(this).attr("data-ajax-view");
		jQuery.ajax({
			url			: url,
			dataType	: "html",
			data		: {},
			beforeSend	: function(){
				IkD.Helper.startPreloader();
			},
			success		: function(data){
				jQuery("#ring-list").html(data);
			},
			complete	: function(){
				IkD.Helper.finishPreloader();
			}
		});
		
		e.preventDefault();
		
	}
		
		
		
}
*/
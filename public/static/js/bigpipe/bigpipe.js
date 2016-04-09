/**
 * Author : Alva Wu  alva.wu@qq.com
 * Date :	2012.6.11
 * Ver : 0.1
 */
(function ($) {
	"use strict";
	$.fn.extend({
		bigPipe:function(opts){
			var bind = $(this), url = opts.url || '', cbk = opts.onLoaded, dtp = opts.dataType || 'html';
			var self = this;
			self.p = 2;
			self.loading = false;
			$(window).bind("scroll", function(){
				var c = $(window).scrollTop(), d = c + $(window).height(), a = bind.position().top + bind.height();
			    if ( a > c && a < d && self.loading === false) {
			    	self.loading = true;
			    	$('#loading').css('display', 'block').css('top', c + 'px');
			    	$.ajax({
			    		type: "GET",
			    		url: url,
			    		data: { page: self.p },
			    		dataType: dtp,
			    		success: function(response){
			    			if( typeof(cbk) == 'function'){
			    				cbk(response, bind);
			    			}else{
			    				bind.append($(response));
			    			}
			    			self.p++;
			    			self.loading = false;
			    			$('#loading').css('display', 'none')
			    		},
			    		error: function(){
			    			self.loading = false;
			    			$('#loading').css('display', 'none')
			    		},
			    		timeoutNumber: function(){
			    			self.loading = false;
			    			$('#loading').css('display', 'none')
			    		}
			    	})
			    }
				
			})
			
		}
	});
	$(document).ready(function(){
		$('body').prepend('<div id="loading" style="display:none;position:absolute;overflow:auto;width:98%;height:100%;"><img style="position:absolute;top:50%;left:50%;" src="/static/js/bigpipe/ajax-loader.gif"/></div>');
	})
})(jQuery)
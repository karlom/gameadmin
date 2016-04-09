/**
 * Author : Alva Wu  alva.wu@qq.com
 * Date :	2012.3.12
 * Ver : 0.1
 */
(function ($) {
	"use strict";
	$.extend({
		autolist: function (options) {
			// html construction
			var id = options.bind, bind = $('#' + id), alID = 'al_' + id;
			if ($('#' + alID).length > 0) return;
			var html =  '<div class="autoMain">';
			html += 	'<div align="right" class="autoClose"><a id="autoReSet_'+id+'" href="javascript:void(0);">清除重选</a>&nbsp;&nbsp;<a id="autoClose_'+id+'" href="javascript:void(0);">关闭</a></div>';
			html += 	'<ul class="autoList" id="' + alID + '">';
			for (var key in options.options) {
				if (options.options.hasOwnProperty(key)){
					html += '<li id="autoListItem_' + id + '_' + key + '">' + key + ' | ' + options.options[key] + '</li>';
				}
			}
			html +=	'</ul>';
			html +=	'</div>';
			var container = $(html);
			bind.after(container);
			container.css('left', bind.position().left + 'px');

			
			// event binding
			var id_prefix = 'autoListItem_' + id + '_';
			$('#' + alID + ' > li').each(function () {
				var key = $(this).attr('id').substring(id_prefix.length);
				if (typeof(options.onItemClick) === 'function'){ 
					$(this).bind('click',function(e){ options.onItemClick(key, $(this), bind); container.hide();})
				}
				else
				{ 
					$(this).click(function(){ bind.val(key); container.hide();});
				}
			})
			bind.keyup(function(){
				var keyword = $(this).val();
				if(keyword == ''){ 
					$('#' + alID + ' > li').show();
				}else{
				$('#' + alID + ' > li').each(function(){
					if ($(this).text().indexOf(keyword)>=0)
						$(this).show();
					else
						$(this).hide();
				});
				}
			}).focusin( function(e){
				container.show();
				$(this).trigger('keyup')
			})
			$('#autoClose_'+id).click( function(){container.hide();if(typeof(options.onClose) === 'function'){ options.onClose() } });
			$('#autoReSet_'+id).click( function(){bind.val('');if(typeof(options.onReset) === 'function'){ options.onReset(); } bind.trigger('keyup') });
	　　}
	})
})(jQuery)

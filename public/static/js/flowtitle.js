$(document).ready(function(){
	var tl = new Array();
	$('.flowtitle').each(function(i,e){
		tl[i] = $(this).parents('table');
		$(this).css('width', tl[i].width())
		thList = $(this).find('th');
		tl[i].find('tr:last-child').find('td').each(function(index, element){
			$(thList[index]).css('width', $(this).width());
		})
		
	})
	$(window).scroll(function(){
		$('.flowtitle').each(function(i, e){
			if( $(window).scrollTop() > tl[i].offset().top && $(window).scrollTop() < tl[i].offset().top + tl[i].height())
			{
				$(this).css('position', 'absolute').css('top', $(window).scrollTop());
			}
			else if($(window).scrollTop() < $(this).parent().offset().top)
			{
				$(this).css('position', '')
			}
			
		})
	})
})
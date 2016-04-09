$(function()
{
  var hideDelay = 500;  
  var currentID;
  var hideTimer = null;

  // One instance that's reused to show info for the current person
  var container = $('<div id="personPopupContainer">'
      + '<table width="" border="0" cellspacing="0" cellpadding="0" align="center" class="personPopupPopup">'
      + '<tr>'
      + '   <td class="corner topLeft"></td>'
      + '   <td class="top"></td>'
      + '   <td class="corner topRight"></td>'
      + '</tr>'
      + '<tr>'
      + '   <td class="left">&nbsp;</td>'
      + '   <td><div id="personPopupContent"></div></td>'
      + '   <td class="right">&nbsp;</td>'
      + '</tr>'
      + '<tr>'
      + '   <td class="corner bottomLeft">&nbsp;</td>'
      + '   <td class="bottom">&nbsp;</td>'
      + '   <td class="corner bottomRight"></td>'
      + '</tr>'
      + '</table>'
      + '</div>');

  $('body').append(container);
  var results = new Array(); 
  $('.cmenu').live('mouseenter', function(e)
  {
 //     if (requesting) return ;
//      console.log(requestingName)
      // format of 'rel' tag: pageid,personguid
  //    var settings = $(this).attr('rel').split(',');
  //    var pageID = settings[0];
      var role_name = $(this).attr('title');
  //    currentID = settings[1];

      // If no guid in url rel tag, don't popup blank
    /*  if (currentID == '')
          return;
*/

      if (hideTimer)
          clearTimeout(hideTimer);

      var pos = $(this).offset();
      var width = $(this).width();
      container.css({
          left: (e.pageX + 25) + 'px',
          top: e.pageY + 'px'
      });

      $('#personPopupContent').html('获取信息中...');
//      requesting = true;
      if(results[role_name] != null)
      {
         $('#personPopupContent').html(results[role_name]);
       
      }
      else
      {
        $.ajax({
            type: 'GET',
            url: '/module/player/player_status.php',
            data: 'simple=1&role[role_name]=' + encodeURIComponent(role_name),
            success: function(data)
            {
                // Verify that we're pointed to a page that returned the expected results.
                /*
                if (data.indexOf('personPopupResult') < 0)
                {
                    $('#personPopupContent').html('<span >Page ' + pageID + ' did not return a valid result for person ' + currentID + '.<br />Please have your administrator check the error log.</span>');
                }

                // Verify requested person is this person since we could have multiple ajax
                // requests out if the server is taking a while.
                if (data.indexOf(currentID) > 0)
                {                  
                    var text = $(data).find('.personPopupResult').html();
                    $('#personPopupContent').html(text);
                }*/
                results[role_name] = data;
                $('#personPopupContent').html(data);
            },
            timeout: function(){
            },
            error: function(){
            }
        });
      }
      container.css('display', 'block');
  });

  $('.personPopupTrigger').live('mouseout', function()
  {
      if (hideTimer)
          clearTimeout(hideTimer);
      hideTimer = setTimeout(function()
      {
          container.css('display', 'none');
      }, hideDelay);
  });

  // Allow mouse over of details without hiding details
  $('#personPopupContainer').mouseover(function()
  {
      if (hideTimer)
          clearTimeout(hideTimer);
  });

  // Hide after mouseout
  $('#personPopupContainer').mouseout(function()
  {
      if (hideTimer)
          clearTimeout(hideTimer);
      hideTimer = setTimeout(function()
      {
          container.css('display', 'none');
      }, hideDelay);
  });
});
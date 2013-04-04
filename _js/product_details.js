$(function() {
  $('.swatches li').each(function() {
    var parent = $(this);
    $(this).find('a').click(function() {
      $('.swatches li.selected').removeClass('selected');
      $(parent).addClass('selected');
      $('h4.color-name').html('<span>color:</span> '+$(this).attr('title').toLowerCase());
      return false;
    });
  });
});

MagicZoomPlus.options ={
  'zoom-position':'custom',
  'zoom-width':'334',
  'zoom-height':'345',
  'zoom-fade':'true',
  'zoom-fade-in-speed': 600,
  'zoom-fade-out-speed':300,
  'smoothing-speed':40,
  'show-title':'false',
  'opacity-reverse':'true',
  'background-color':'#ffffff',
  'background-opacity':50,
  'selectors-effect':'false', 
  'selectors-effect-speed':200, 
  'opacity-reverse':'false', 
  'opacity':50 
 }; // set display style to MagicZoomPlus
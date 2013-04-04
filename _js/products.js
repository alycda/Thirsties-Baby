$(function() {
  $('#item_list .item').each(function() {
    var parent = $(this);
    var swatches = $(this).find('.swatches > li');
    swatches.each(function() {
      var img = $(parent).find('img:first');
      $(this).find('a').click(function() {
        swatches.removeClass('selected');
        $(this).parent().addClass('selected');
        img.attr('src', $(this).attr('href'));
        return false;
      });
    });
  });
  $('#item_list .item').each(function() {
    $(this).find('.swatches > li:first a').click();
  });
  
  $('form').submit(function() {
    if ($(this).find('input:checked').length > 1) {
      return true;
    } else {
      return false;
    }
  });
  
});
$(function() {
  $('.product-images img').each(function(i) {
    var img = $(this);
    var swatch_cell = $('.product-swatches > td:eq('+i+')');
    $('a', swatch_cell).click(function() {
      $('li', swatch_cell).removeClass('selected');
      $(this).parent().addClass('selected');
      img.attr('src', $(this).attr('href'));
      return false;
    });
  });
});
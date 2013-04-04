$(function() {
  var viewport = $('.slider .slides');

  viewport.find('.slide').eq(0).siblings().find('.info').hide();

  if (Browser.isWebkit && Browser.supportsTouch) {
    var controller = new Ashworth.TouchSlider();
  } else {
    var controller = new Ashworth.Slider();
  }

  $('.slider .previous').hide();
	if ($('.slide', viewport).length < 2) {
		$('.slider .next').hide();
		$(viewport).find('.slide .info').show();
	}
  // Main Slider
  controller.init(viewport, {
    next: $('.slider .next'), 
    previous: $('.slider .previous')
  });
  controller.subscribe('transition_end', function(c) {
    var page_num = c.page(c.current_x);
    var current = viewport.find('.slide').eq(page_num);
    var box = $('.viewing-boxes > a').removeClass('current').eq(page_num);
		box.addClass('current');
    var overlay = current.find('.info');
    if (!overlay.is(':visible')) {
      current.siblings(':visible').find('.info').hide();
      overlay.fadeIn();
    }
    var image = current.find('img:eq(0)');
		$('.viewing-caption').html(image.attr('title'));
		
    toggleArrows(c, {hide: true});
  });
  controller.subscribe('end_no_move', function(c) {
    unBindEvent(c.element[0], 'webKitTransitionEnd', c);
  });
  	
  function toggleArrows(controller, opts) {
    var opts = jQuery.extend({hide: false}, opts);

    var page_num = controller.page(controller.current_x);
    if (page_num === controller.structure.item_count - 1) {
      if (opts.hide) {
        controller.opts.next.css({display: 'none'});
      } else {
        controller.opts.next.css('opacity', 0.25);
      }
    } else {
      if (opts.hide) {
        controller.opts.next.css({display: 'block'});
      } else {
        controller.opts.next.css('opacity', 1);
      }
    }
    if (page_num === 0) {
      if (opts.hide) {
        controller.opts.previous.css({display: 'none'});
      } else {
        controller.opts.previous.css('opacity', 0.25);
      }
    } else {
      if (opts.hide) {
        controller.opts.previous.css({display: 'block'});
      } else {
        controller.opts.previous.css('opacity', 1);
      }
    }
  }
	
	var image = viewport.find('.slide').eq(0).find('img:eq(0)');
	$('.viewing-caption').html(image.attr('title'));
	
	// Viewing Boxes
  for(var i = 0; i < viewport.find('.slide').size(); i++) {
    var box = $('<a href="#"></a>');
		if (i==0)
			box.addClass('current');
		box.click(function() {
			var index = $(this).index();
			controller.current_x = controller.pageX(index);
			controller.update(controller.current_x);
			return false;
		});
    $('.viewing-boxes').append(box);
  }

  // Autoslide the Features slider
  var ap_count = 1;
  var autoplay = setInterval(function() {
    if (ap_count < $('.slider .slides > .slide').size()) { 
      controller.current_x = controller.limitXBounds(controller.nextPageX(controller.current_x));
      controller.update(controller.current_x, true);
      controller.runHook('move', controller);
      ap_count += 1;
    } else {
      clearInterval(autoplay);
    }
  }, 7000);
  
  $('.slider .next,.slider .previous').click(function() { clearTimeout(autoplay); });
  if (Browser.isWebkit && Browser.supportsTouch) {
    window.addEventListener('scroll', function() { clearTimeout(autoplay); }, false);
  }
  controller.subscribe('first_move', function(c) { clearTimeout(autoplay); });

});

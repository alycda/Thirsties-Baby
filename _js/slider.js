/****

"Standing on other people's shoulders, not their toes."

Borrowed from the awesome guys at McKinney (mckinney.com)

****/
(function(window) {
  var Slider = function() {};

  Slider.prototype.init = function(element, opts) {
    this.element = element;
    this.structure = this.structure(element);
    this.current_x = 0;
    this.current_y = 0;
    this.hooks = {};

    this.opts = jQuery.extend({
      next: undefined, 
      previous: undefined, 
      limit_left: false,
      limit_right: false, 
      use_margin: false,
      init: undefined
    }, opts);
    
    var self = this;
    if (this.opts.next) {
      this.opts.next.bind('click', function() {
        var previous = self.current_x;
        self.current_x = self.limitXBounds(self.nextPageX(self.current_x));
        if (self.current_x !== previous) {
          self.update(self.current_x, true);
          self.runHook('move', self);
        }

        return false;
      });
    }

    if (this.opts.previous) {
      this.opts.previous.bind('click', function() {
        var previous = self.current_x;
        self.current_x = self.limitXBounds(self.previousPageX(self.current_x));
        if (self.current_x !== previous) {
          self.update(self.current_x, true);
          self.runHook('move', self);
        }

        return false;
      });
    }

    if (this.opts.init !== undefined) {
      this.opts.init(this); 
    }
  };

  Slider.prototype.structure = function(element) {
    var structure = {};
    var first = element.find('.slide').eq(0);

    structure.item_count = element.find('.slide').size();
    structure.item_width = parseInt(first.width());
    structure.item_height = parseInt(first.height());
    var margin_right = first.css('marginRight');
    structure.item_spacing = (margin_right !== undefined) ? parseInt(margin_right.replace('px', '')) : 0;
    structure.container_width = (structure.item_spacing + structure.item_width);

    return structure;
  };

  Slider.prototype.subscribe = function(hook, fn) {
    if (this.hooks[hook] === undefined) {
      this.hooks[hook] = [];
    }
    this.hooks[hook].push(fn);
  };

  Slider.prototype.runHook = function(hook) {
    if (this.hooks[hook] !== undefined) {
      var args = Array().slice.call(arguments);
      var self = this;
      this.hooks[hook].forEach(function(fn) {
        fn.apply(self, args.slice(1));
      });
    }
  };

  Slider.prototype.page = function(current_x) {
    return Math.abs(Math.round(current_x / this.structure.container_width));
  };

  Slider.prototype.nearestPageX = function(current_x) {
    return Math.round(current_x / this.structure.container_width) * this.structure.container_width;
  };

  Slider.prototype.pageX = function(index) {
    var flip = (this.opts.reverse) ? 1 : -1;
    return flip * index * this.structure.container_width;
  };

  Slider.prototype.nextPageX = function(current_x) {
    if (this.page(current_x) + 1 <= this.structure.item_count - 1) {
      current_x = current_x - this.structure.container_width;
    }
    return current_x;
  };

  Slider.prototype.previousPageX = function(current_x) {
    if (this.page(current_x) >= 0) {
      current_x = current_x + this.structure.container_width;
    }
    return current_x;
  };

  Slider.prototype.limitXBounds = function(current_x) {
    var total_width = this.structure.container_width * this.structure.item_count;
    if (this.opts.reverse) {
      current_x = (current_x > total_width - this.structure.container_width) ? total_width - this.structure.container_width : current_x;
      current_x = (current_x < 0) ? 0 : current_x;
    } else {
      current_x = (current_x < -total_width + this.structure.container_width) ? -total_width + this.structure.container_width : current_x;
      current_x = (current_x > 0) ? 0 : current_x;
    }

    if ((this.current_x - current_x > 0 && this.opts.limit_right) || 
        (this.current_x - current_x < 0 && this.opts.limit_left)) {
      current_x = this.current_x;
    }
    return current_x;
  };

  Slider.prototype.update = function(current_x) {
    var self = this;
    this.element.animate({'margin-left': current_x + 'px'}).queue(function() {
      self.runHook('transition_end', self);
      $(this).dequeue();
    });
    this.runHook('update', this);
  };


  var TouchSlider = function() {};
  TouchSlider.prototype = new Slider();
  TouchSlider.superobject = Slider.prototype;

  TouchSlider.prototype.init = function(element, structure, opts) {
    TouchSlider.superobject.init.call(this, element, structure, opts);

    this.gesturing = false;
    element[0].addEventListener('touchstart', this, false);
    element[0].addEventListener('webkitTransitionEnd', this, false);
  };

  TouchSlider.prototype.beforeMove = function() {
    this.element.css({'-webkit-transition-duration': '0s'});
    this.element.css({'-webkit-transition-property': 'none'});
  };

  TouchSlider.prototype.beforeUpdate = function() {
    this.element.css({'-webkit-transition-duration': '0.4s'});
    if (this.opts.use_margin) {
      this.element.css({'-webkit-transition-property': 'margin-left'});
    } else {
      this.element.css({'-webkit-transition-property': '-webkit-transform'});
    }
  };

  TouchSlider.prototype.update = function(current_x, opts) {
    var opts = jQuery.extend({animate: true, call_hook: true}, opts);
    if (opts.animate) { this.beforeUpdate(); }

    if (this.opts.use_margin) {
      this.element.css({'margin-left': current_x + 'px'}); 
    } else {
      this.element.css({'-webkit-transform': 'translate3d(' + current_x + 'px, 0, 0)'}); 
    }
    
    if (opts.call_hook) { this.runHook('update', this); }
  };

  TouchSlider.prototype.handleEvent = function(e) {
    this[e.type](e);
  };

  TouchSlider.prototype.click = function(e) {
    if (this.moved) { e.preventDefault(); }
    this.element[0].removeEventListener('click', this, false);
    return false;
  };

  TouchSlider.prototype.touchstart = function(e) {
    this.current_target = e.currentTarget;
    this.start_x = e.touches[0].pageX - this.current_x;
    this.start_y = e.touches[0].pageY - this.current_y;
    this.moved = false;

    window.addEventListener('gesturestart', this, false);
    window.addEventListener('gestureend', this, false);
    window.addEventListener('touchmove', this, false);
    window.addEventListener('touchend', this, false);
    this.element[0].addEventListener('click', this, false);

    this.beforeMove();

    this.runHook('start', this);

    return false;
  };

  TouchSlider.prototype.touchmove = function(e) {
    if (this.gesturing) {
      return false;
    }

    if (!this.moved) {
      var delta_y = e.touches[0].pageY - this.start_y;
      var delta_x = e.touches[0].pageX - this.start_x;
      if (Math.abs(delta_y) < 15) {
        e.preventDefault();
      }

      this.runHook('first_move', this);
    }

    this.moved = true;
    this.last_x = this.current_x;
    this.last_move_time = new Date();

    this.current_x = this.limitXBounds(e.touches[0].pageX - this.start_x);

    this.update(this.current_x);
    this.runHook('move', this);

    return false;
  };

  TouchSlider.prototype.touchend = function(e) {
    window.removeEventListener('gesturestart', this, false);
    window.removeEventListener('gestureend', this, false);
    window.removeEventListener('touchmove', this, false);
    window.removeEventListener('touchend', this, false);

    if (this.moved) {
      var dx = this.current_x - this.last_x;
      var dt = (new Date()) - this.last_move_time + 1; 
      
      var tossed_x = this.limitXBounds(this.current_x + dx * 100 / dt);
      this.current_x = this.nearestPageX(tossed_x);

      this.update(this.current_x);
      this.runHook('move', this);
    } else {
      this.runHook('end_no_move', this);
    }

    this.current_target = undefined;

    return false;  
  };

  TouchSlider.prototype.webkitTransitionEnd = function(e) {
    this.runHook('transition_end', this);
  };

  TouchSlider.prototype.gesturestart = function(e) { this.gesturing = true; };
  TouchSlider.prototype.gestureend = function(e) { this.gesturing = false; };

  Ashworth.Slider = Slider;
  Ashworth.TouchSlider = TouchSlider;
})(window);
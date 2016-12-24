(function(document, window) {
  'use strict';

  window.AppForum = App.extend({
    run: function(next) {
      next();
    }
  });
})(document, window);

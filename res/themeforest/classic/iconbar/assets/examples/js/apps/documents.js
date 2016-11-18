/*!
 * remark (http://getbootstrapadmin.com/remark)
 * Copyright 2016 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
// (function(document, window, $) {
//   'use strict';
//   window.AppDocuments = App.extend({
//     scrollHandle: function() {
//       $('body').scrollspy({
//         target: '#articleSticky',
//         offset: 80
//       });
//     },
//     run: function(next) {
//       this.scrollHandle();
//
//       next();
//     }
//   });
//
//   $(document).ready(function() {
//     AppDocuments.run();
//     $('#articleSticky').Stickyfill();
//
//     $(window).on('resize orientationchange', function() {
//       if ($(this).width() > 767) {
//         Stickyfill.init();
//       } else {
//         Stickyfill.stop();
//       }
//     }).resize();
//   });
// })(document, window, jQuery);

$(document).ready(function() {
  AppDocuments.run();
});

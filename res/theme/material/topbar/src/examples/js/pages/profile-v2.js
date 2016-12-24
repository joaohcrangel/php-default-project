(function(document, window, $) {
  'use strict';
  var Site = window.Site;
  $(document).ready(function($) {
    Site.run();
    $(".user-posts .user-posts-list").slick({
      dots: false,
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      adaptiveHeight: true,
      arrows: false,
      autoplay: true,
      swipeToSlide: true
    });
  });

})(document, window, jQuery);

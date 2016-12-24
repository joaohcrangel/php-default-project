$.components.register("floatThead", {
  mode: "default",
  defaults: {
    scrollingTop: function() {
      return $('.site-navbar').outerHeight();
    },
    useAbsolutePositioning: true
  }
});

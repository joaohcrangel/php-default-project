module.exports = function () {
  "use strict";

  return {
    options: {
      browsers: '<%= config.autoprefixerBrowsers %>'
    },
    bootstrap: {
      options: {
        map: true
      },
      src: '<%= config.destination.css %>/bootstrap.css'
    },
    extend: {
      options: {
        map: true
      },
      src: '<%= config.destination.css %>/bootstrap-extend.css'
    },
    site: {
      options: {
        map: true
      },
      src: '<%= config.destination.css %>/site.css'
    },
    fonts: {
      options: {
        map: false
      },
      src: ['<%= config.destination.fonts %>/*/*.css', '!<%= config.destination.fonts %>/*/*.min.css']
    },
    vendor: {
      options: {
        map: false
      },
      src: ['<%= config.destination.vendor %>/*/*.css', '!<%= config.destination.vendor %>/*/*.min.css']
    },
    skins: {
      options: {
        map: false
      },
      src: ['<%= config.destination.skins %>/*.css', '!<%= config.destination.skins %>/*.min.css']
    },
    examples: {
      options: {
        map: false
      },
      src: ['<%= config.destination.css %>/*/*.css', '!<%= config.destination.css %>/*/*.min.css']
    }
  };
};

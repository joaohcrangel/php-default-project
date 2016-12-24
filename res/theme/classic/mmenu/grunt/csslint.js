module.exports = function () {
  "use strict";

  return {
    options: {
      csslintrc: '<%= config.source.sass %>/.csslintrc'
    },
    dist: ['<%= config.destination.css %>/*.css', '!<%= config.destination.css %>/*.min.css']
  };
};

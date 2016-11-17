module.exports = function () {
  "use strict";

  return {
    options: {
      config: '<%= config.source.less %>/.csscomb.json'
    },
    dist: {
      expand: true,
      cwd: '<%= config.destination.css %>',
      src: ['*.css', '!*.min.css'],
      dest: '<%= config.destination.css %>/'
    },
    fonts: {
      expand: true,
      cwd: '<%= config.destination.fonts %>',
      src: ['*/*.css', '!*/*.min.css'],
      dest: '<%= config.destination.fonts %>'
    },
    vendor: {
      expand: true,
      cwd: '<%= config.destination.vendor %>',
      src: ['*/*.css', '!*/*.min.css'],
      dest: '<%= config.destination.vendor %>'
    },
    skins: {
      expand: true,
      cwd: '<%= config.destination.skins %>',
      src: ['*.css', '!*.min.css'],
      dest: '<%= config.destination.skins %>'
    },
    examples: {
      expand: true,
      cwd: '<%= config.destination.css %>/examples',
      src: ['*/*.css', '!*/*.min.css'],
      dest: '<%= config.destination.css %>/examples',
    }
  };
};

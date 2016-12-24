module.exports = function () {
  "use strict";

  return {
    options: {
      // TODO: disable `zeroUnits` optimization once clean-css 3.2 is released
      //    and then simplify the fix for https://github.com/twbs/bootstrap/issues/14837 accordingly
      compatibility: 'ie8',
      keepSpecialComments: '*',
      advanced: false
    },
    minifyBootstrap: {
      src: '<%= config.destination.css %>/bootstrap.css',
      dest: '<%= config.destination.css %>/bootstrap.min.css'
    },
    minifyExtend: {
      src: '<%= config.destination.css %>/bootstrap-extend.css',
      dest: '<%= config.destination.css %>/bootstrap-extend.min.css'
    },
    minifySite: {
      src: '<%= config.destination.css %>/site.css',
      dest: '<%= config.destination.css %>/site.min.css'
    },
    fonts: {
      files: [
        {
          expand: true,
          cwd: '<%= config.destination.fonts %>',
          src: ['*/*.css', '!*/*.min.css'],
          dest: '<%= config.destination.fonts %>',
          ext: '.min.css',
          extDot: 'last'
        }
      ]
    },
    vendor: {
      files: [
        {
          expand: true,
          cwd: '<%= config.destination.vendor %>',
          src: ['*/*.css', '!*/*.min.css'],
          dest: '<%= config.destination.vendor %>',
          ext: '.min.css',
          extDot: 'last'
        }
      ]
    },
    skins: {
      files: [
        {
          expand: true,
          cwd: '<%= config.destination.skins %>',
          src: ['*.css', '!*.min.css'],
          dest: '<%= config.destination.skins %>',
          ext: '.min.css',
          extDot: 'last'
        }
      ]
    },
    examples: {
      files: [
        {
          expand: true,
          cwd: '<%= config.destination.css %>',
          src: ['*/*.css', '!*/*.min.css'],
          dest: '<%= config.destination.css %>',
          ext: '.min.css',
          extDot: 'last'
        }
      ]
    }
  };
};

module.exports = function () {
  "use strict";

  return {
    options: {
      precision: 6,
      sourcemap: 'auto',
      outputStyle: 'expanded',
      trace: true,
      bundleExec: true,
      includePaths: [
        '<%= config.source.sass %>',
        '<%= config.bootstrap.sass %>',
        '<%= config.bootstrap.mixins %>'
      ]
    },
// @ifdef processCss
    compileBootstrap: {
      src: '<%= config.source.sass %>/bootstrap.scss',
      dest: '<%= config.destination.css %>/bootstrap.css'
    },
    compileExtend: {
      src: '<%= config.source.sass %>/bootstrap-extend.scss',
      dest: '<%= config.destination.css %>/bootstrap-extend.css'
    },
    compileSite: {
      src: '<%= config.source.sass %>/site.scss',
      dest: '<%= config.destination.css %>/site.css'
    },
// @endif
// @ifdef processSkins
    skins: {
      options: {
        strictMath: true,
        includePaths: [
          '<%= config.source.skins %>/scss',
          '<%= config.source.sass %>',
          '<%= config.bootstrap.sass %>',
          '<%= config.bootstrap.mixins %>'
        ]
      },
      files: [
        {
          expand: true,
          cwd: '<%= config.source.skins %>',
          src: ['*.scss'],
          dest: '<%= config.destination.skins %>',
          ext: '.css',
          extDot: 'last'
        }
      ]
    },
// @endif
// @ifdef processExamples
    examples: {
      files: [
        {
          expand: true,
          cwd: '<%= config.source.examples %>/scss',
          src: ['**/*.scss'],
          dest: '<%= config.destination.examples %>/css',
          ext: '.css',
          extDot: 'last'
        }
      ]
    },
// @endif
// @ifdef processFonts
    fonts: {
      files: [
        {
          expand: true,
          cwd: '<%= config.source.fonts %>',
          src: ['*/*.scss', '!*/_*.scss'],
          dest: '<%= config.destination.fonts %>',
          ext: '.css',
          extDot: 'last'
        }
      ]
    },
// @endif
// @ifdef processVendor
    vendor: {
      files: [
        {
          expand: true,
          cwd: '<%= config.source.vendor %>',
          src: ['*/*.scss', '!*/settings.scss'],
          dest: '<%= config.destination.vendor %>',
          ext: '.css',
          extDot: 'last'
        }
      ]
    },
// @endif
  };
};

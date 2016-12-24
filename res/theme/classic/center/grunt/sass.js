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
        '<%= config.global.sass %>',
        '<%= config.bootstrap.sass %>',
        '<%= config.bootstrap.mixins %>'
      ]
    },
    compileSite: {
      src: '<%= config.source.sass %>/site.scss',
      dest: '<%= config.destination.css %>/site.css'
    },
    skins: {
      options: {
        strictMath: true,
        includePaths: [
          '<%= config.source.skins %>/scss',
          '<%= config.global.skins %>',
          '<%= config.source.sass %>',
          '<%= config.global.sass %>',
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
    examples: {
      files: [
        {
          expand: true,
          cwd: '<%= config.source.examples %>/scss',
          src: ['*/*.scss'],
          dest: '<%= config.destination.examples %>/css',
          ext: '.css',
          extDot: 'last'
        }
      ]
    },
  };
};

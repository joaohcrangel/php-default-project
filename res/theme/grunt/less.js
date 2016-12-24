module.exports = function () {
  "use strict";

  return {
    options: {
      strictMath: false,
      paths: [
        '<%= config.source.less %>',
        '<%= config.bootstrap.less %>',
        '<%= config.bootstrap.mixins %>'
      ]
    },
    compileBootstrap: {
      options: {
        strictMath: true
      },
      src: '<%= config.source.less %>/bootstrap.less',
      dest: '<%= config.destination.css %>/bootstrap.css'
    },
    compileExtend: {
      options: {
        strictMath: true
      },
      src: '<%= config.source.less %>/bootstrap-extend.less',
      dest: '<%= config.destination.css %>/bootstrap-extend.css'
    },
    compileSite: {
      options: {
        strictMath: true
      },
      src: '<%= config.source.less %>/site.less',
      dest: '<%= config.destination.css %>/site.css'
    },
    fonts: {
      expand: true,
      cwd: '<%= config.source.fonts %>',
      src: ['*/*.less', '!*/_*.less'],
      dest: '<%= config.destination.fonts %>',
      ext: '.css',
      extDot: 'last'
    },
    vendor: {
      expand: true,
      cwd: '<%= config.source.vendor %>',
      src: ['*/*.less', '!*/settings.less'],
      dest: '<%= config.destination.vendor %>',
      ext: '.css',
      extDot: 'last'
    },
    skins: {
      options: {
        strictMath: true,
        paths: [
          '<%= config.source.skins %>/less',
          '<%= config.source.less %>',
          '<%= config.bootstrap.less %>',
          '<%= config.bootstrap.mixins %>'
        ]
      },
      expand: true,
      cwd: '<%= config.source.skins %>',
      src: ['*.less'],
      dest: '<%= config.destination.skins %>',
      ext: '.css',
      extDot: 'last'
    },
    examples: {
      expand: true,
      cwd: '<%= config.source.less %>/examples',
      src: ['*/*.less'],
      dest: '<%= config.destination.css %>',
      ext: '.css',
      extDot: 'last'
    }
  };
};

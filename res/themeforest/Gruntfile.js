
module.exports = function(grunt) {
  'use strict';

  var path = require('path');

  require('load-grunt-config')(grunt, {
    // path to task.js files, defaults to grunt dir
    configPath: path.join(process.cwd(), 'grunt'),

    // auto grunt.initConfig
    init: true,

    // data passed into config.  Can use with <%= test %>
    data: {
      pkg: grunt.file.readJSON('package.json'),
      config: grunt.file.readJSON('config.json'),
      color: grunt.file.readYAML('color.yml'),
      banner: '/*!\n' +
            ' * <%= pkg.name %> v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
            ' * Copyright <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>\n' +
            ' * Licensed under the <%= pkg.license %>\n' +
            ' */\n'
    },

    // can optionally pass options to load-grunt-tasks.
    // If you set to false, it will disable auto loading tasks.
    loadGruntTasks: {
      pattern: 'grunt-*',
      config: require('./package.json'),
      scope: ['devDependencies' ,'dependencies']
    }
  });

  // HTML validation task
  grunt.registerTask('validate-html', ['bootlint', 'htmllint']);

  // lint task
  grunt.registerTask('lint', ['csslint', 'jshint']);

  // Clean task.
  grunt.registerTask('clean-dist', ['clean:css', 'clean:fonts', 'clean:vendor']);

  // JS distribution task.
  grunt.registerTask('dist-js', ['concat:components', 'concat:js', 'uglify:min']);

  // CSS distribution task.
  grunt.registerTask('less-compile', ['less:compileBootstrap', 'less:compileExtend', 'less:compileSite']);
  grunt.registerTask('dist-css', ['less-compile', 'autoprefixer:bootstrap', 'autoprefixer:extend', 'autoprefixer:site', 'csscomb:dist', 'cssmin:minifyBootstrap', 'cssmin:minifyExtend', 'cssmin:minifySite']);

  // Skins distribution task.
  grunt.registerTask('dist-skins', ['less:skins', 'autoprefixer:skins', 'csscomb:skins', 'cssmin:skins']);

  // Vendor distribution task.
  grunt.registerTask('dist-vendor', ['less:vendor', 'autoprefixer:vendor', 'csscomb:vendor', 'cssmin:vendor']);

  // Fonts distribution task.
  grunt.registerTask('dist-fonts', ['less:fonts', 'autoprefixer:fonts', 'csscomb:fonts', 'cssmin:fonts']);

  // Full distribution task.
  grunt.registerTask('dist-examples', ['less:examples', 'autoprefixer:examples', 'csscomb:examples', 'cssmin:examples']);

  // Full distribution task.
  grunt.registerTask('dist', ['clean-dist', 'dist-css', 'dist-js', 'dist-vendor', 'dist-skins', 'dist-fonts', 'dist-examples']);

  // Default task.
  grunt.registerTask('default', ['clean:css', 'dist-css']);
};

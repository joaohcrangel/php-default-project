module.exports = function (grunt) {
  "use strict";

// @ifdef processJs
  var plugins = grunt.file.readJSON('plugins.json');
  var pluginsSrc = [];

  for(var plugin in plugins) {
    if(plugins[plugin]){
      pluginsSrc.push('<%= config.source.js %>/plugins/'+plugin+'.js');
    }
  }
// @endif

  return {
    options: {
      banner: '<%= banner %>',
      stripBanners: false
    },
// @ifdef processJs
    js: {
      expand: true,
      cwd: '<%= config.source.js %>',
      src: ['**/*.js'],
      dest: '<%= config.destination.js %>',
    },
    plugins: {
      src: pluginsSrc,
      dest: '<%= config.destination.js %>/plugins.js'
    },
// @endif
// @ifdef processExamples
    examples: {
      expand: true,
      cwd: '<%= config.source.examples %>/js',
      src: ['**/*.js'],
      dest: '<%= config.destination.examples %>/js',
    }
// @endif
  };
};

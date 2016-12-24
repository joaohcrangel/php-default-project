var gulp       = require('gulp');
var plumber    = require('gulp-plumber');
var header     = require('gulp-header');
var uglify     = require('gulp-uglify');
var rename     = require("gulp-rename");
var concat     = require('gulp-concat');

// config
var config = require('../../../config.json');

// options
var options = require('../../options/scripts');

// plugins
var plugins = require('../../../plugins.json');
var pluginsSrc = [];

for(var plugin in plugins) {
  if(plugins[plugin]){
    pluginsSrc.push(config.source.js + '/plugin/' + plugin + '.js');
  }
}

module.exports = function () {
  return gulp.src(pluginsSrc)
    .pipe(plumber())
    .pipe(concat('plugin.js'))
    .pipe(header(options.banner))
    .pipe(gulp.dest(config.destination.js))

    .pipe(uglify())
    .pipe(header(options.banner))
    .pipe(rename({
      extname: '.min.js'
    }))
    .pipe(gulp.dest(config.destination.js));

};

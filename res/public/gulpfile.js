var fs      = require('fs'),
    gulp    = require('gulp'),
    sass    = require('gulp-sass'),
    rename  = require('gulp-rename'),
    cssmin  = require('gulp-cssmin'),
    jshint  = require('gulp-jshint'),
    jsmin   = require('gulp-jsmin'),
    concat  = require('gulp-concat'),
    uglify  = require('gulp-uglify'),
    addsrc  = require('gulp-add-src'),
    watch   = require('gulp-watch'),
    htmlmin = require('gulp-htmlmin');

gulp.task('styles', function() {
    gulp.src('style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('styles.css'))
        .pipe(gulp.dest('./styles-dist'));
});
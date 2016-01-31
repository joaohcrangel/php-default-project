var gulp    = require('gulp'),
    sass    = require('gulp-sass'),
    rename  = require('gulp-rename'),
    cssmin  = require('gulp-cssmin'),
    jshint  = require('gulp-jshint'),
    jsmin   = require('gulp-jsmin'),
    concat  = require('gulp-concat'),
    uglify  = require('gulp-uglify'),
    addsrc  = require('gulp-add-src'),
    watch   = require('gulp-watch');

gulp.task('styles', function() {
    gulp.src('sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('css'));
});

gulp.task('cssmin', function() {

	gulp.src('css/**/*.css')
		.pipe(concat('all.min.css'))
	    //.pipe(stripCssComments({all: true}))
	    .pipe(cssmin())
	    .pipe(gulp.dest('./css/'));;



});

gulp.task('javascript', function() {

	gulp.src('scripts/**/*.js')
		.pipe(jshint())
		.pipe(uglify())
		.pipe(jsmin())
		.pipe(concat('./../js/scripts.js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('js'));

});

gulp.task('default', function() {
	gulp.watch('sass/**/*.scss',['styles']);
	gulp.watch('css/**/*.css',['cssmin']);
	gulp.watch('scripts/**/*.js',['javascript']);
});
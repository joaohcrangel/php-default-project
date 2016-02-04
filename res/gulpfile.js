var fs      = require('fs'),
    gulp    = require('gulp'),
    sass    = require('gulp-sass'),
    rename  = require('gulp-rename'),
    cssmin  = require('gulp-cssmin'),
    jshint  = require('gulp-jshint'),
    jsmin   = require('gulp-jsmin'),
    concat  = require('gulp-concat'),
    uglify  = require('gulp-uglify'),
    watch   = require('gulp-watch'),
    htmlmin = require('gulp-htmlmin');

gulp.task('styles', function() {
    gulp.src('sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('css'));
});

gulp.task('cssmin', function() {

    if (fs.existsSync('css/all.css')) {
        fs.unlinkSync('css/all.css');
    }

    gulp.src([
        'css/**/*.css', 
        'vendors/bootstrap/css/bootstrap.min.css',
        'vendors/font-awesome/css/font-awesome.min.css'
    ])
		.pipe(concat('all.css'))
	    .pipe(cssmin({
	    	keepSpecialComments:0
	    }))
	    .pipe(gulp.dest('./css/'));

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

gulp.task('minify', function() {
  return gulp.src('html/*.html')
    .pipe(htmlmin({
    	collapseWhitespace: true,
    	removeComments: true,
    	removeOptionalTags: true
    }))
    .pipe(gulp.dest('tpl'))
});

gulp.task('default', function() {
	gulp.watch('sass/**/*.scss',['styles', 'cssmin']);
	gulp.watch('scripts/**/*.js',['javascript']);
	gulp.watch('html/**/*.html',['minify']);
});
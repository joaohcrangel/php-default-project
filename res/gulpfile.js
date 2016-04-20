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
    htmlmin = require('gulp-htmlmin'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    imageop = require('gulp-image-optimization');

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
        'vendors/bootstrap/css/bootstrap.min.css',
        'vendors/font-awesome/css/font-awesome.min.css',
        'vendors/owl-carousel/owl.carousel.css',
        'css/style.css'
    ])
        .pipe(concat('all.css'))
        .pipe(cssmin({
            keepSpecialComments:0
        }))
        .pipe(gulp.dest('./css/'));

});

gulp.task('javascript-libs', function() {

    gulp.src([
        './vendors/jquery/jquery-1.11.1.js',
        './vendors/bootstrap/js/bootstrap.js',
        './vendors/owl-carousel/owl.carousel.js'
    ])
        .pipe(jshint())
        .pipe(uglify())
        .pipe(jsmin())
        .pipe(concat('./../js/libs.js', {newLine: ';'}))
        .pipe(gulp.dest('js'));

});

gulp.task('javascript', function() {

	gulp.src([
        './scripts/**/*.js'
    ])
		.pipe(jshint())
		.pipe(uglify())
		.pipe(jsmin())
		.pipe(rename({suffix: '.min'}))
        .pipe(concat('./../js/scripts.js', {newLine: ';'}))
		.pipe(gulp.dest('js'));

});

gulp.task('minify', function() {
    gulp.src('html/*.html')
    .pipe(htmlmin({
    	collapseWhitespace: true,
    	removeComments: true,
    	removeOptionalTags: true
    }))
    .pipe(gulp.dest('tpl'));
    
    gulp.src('html/admin/*.html')
    .pipe(htmlmin({
        collapseWhitespace: true,
        removeComments: true,
        removeOptionalTags: true
    }))
    .pipe(gulp.dest('tpl/admin'));
});
 
gulp.task('images', function(cb) {
    gulp.src(['images/**/*.png','images/**/*.jpg','images/**/*.gif','images/**/*.jpeg']).pipe(imageop({
        optimizationLevel: 5,
        progressive: true,
        interlaced: true
    })).pipe(gulp.dest('img')).on('end', cb).on('error', cb);
});

gulp.task('default', function() {
	gulp.watch('sass/**/*.scss',['styles', /*'cssmin'*/]);
    gulp.watch('vendors/**/*.js',['javascript-libs']);
	gulp.watch('scripts/**/*.js',['javascript']);
    gulp.watch('html/**/*.html',['minify']);
	gulp.watch('images_originals/**/*.*',['images']);
});
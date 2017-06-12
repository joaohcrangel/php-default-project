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
        .pipe(concat('styles.css'))
        .pipe(gulp.dest('css'));

    gulp.src([
        './css/theme.css', './css/styles.css'
    ])
    .pipe(concat('all.css'))
    .pipe(gulp.dest('css'));
});

gulp.task('cssmin', function() {

    if (fs.existsSync('css/all.css')) {
        fs.unlinkSync('css/all.css');
    }

    gulp.src([
        './theme/material/global/css/bootstrap.min.css',
        './theme/material/global/css/bootstrap-extend.min.css',
        './theme/material/base/assets/css/site.css',
        './vendors/owl-carousel/owl.carousel.css',
        './theme/material/global/vendor/animsition/animsition.css',
        './theme/material/global/vendor/asscrollable/asScrollable.css',
        './theme/material/global/vendor/switchery/switchery.css',
        './theme/material/global/vendor/intro-js/introjs.css',
        './theme/material/global/vendor/slidepanel/slidePanel.css',
        './theme/material/global/vendor/flag-icon-css/flag-icon.css',
        './theme/material/global/vendor/waves/waves.css',
        './theme/material/global/vendor/waves/waves.css',
        './theme/material/global/vendor/summernote/summernote.css',
        './theme/material/global/vendor/select2/select2.min.css',
        './theme/material/global/vendor/chartist/chartist.css',
        './theme/material/global/vendor/jvectormap/jquery-jvectormap.css',
        './theme/material/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css',
        './theme/material/base/assets/examples/css/dashboard/v1.css',
        './theme/material/global/fonts/material-design/material-design.min.css',
        './theme/material/global/fonts/brand-icons/brand-icons.min.css',
        './theme/material/global/fonts/web-icons/web-icons.min.css',
        './theme/material/global/fonts/Roboto/Roboto.min.css',
        './theme/material/global/fonts/font-awesome/font-awesome.min.css',
        './theme/material/global/vendor/bootstrap-sweetalert/sweetalert.css',
        './theme/material/global/vendor/toastr/toastr.css',
        './theme/material/global/vendor/alertify/alertify.css',
        './theme/material/global/vendor/notie/notie.css',
        './theme/assets/examples/css/advanced/alertify.css',
        './theme/material/global/vendor/nestable/nestable.css',
        './theme/material/global/vendor/html5sortable/sortable.css',
        './theme/material/global/vendor/tasklist/tasklist.css',
        './theme/material/global/vendor/icheck/icheck.css',
        './theme/material/global/vendor/bootstrap-treeview/bootstrap-treeview.css',
        './theme/material/global/vendor/jstree/jstree.min.css',
        './theme/material/global/vendor/chartist/chartist.css',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload.css',
        './theme/material/global/vendor/dropify/dropify.css',
        './theme/material/global/vendor/fullcalendar/fullcalendar.css',
        './theme/material/base/assets/examples/css/apps/calendar.css',
        './theme/material/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css',
        './css/slide-panel.css'
    ])
        .pipe(concat('theme.css'))
        .pipe(cssmin({
            keepSpecialComments:0
        }))
        .pipe(gulp.dest('./css/'));

    gulp.src([
        './css/theme.css', './css/styles.css'
    ])
    .pipe(concat('all.css'))
    .pipe(gulp.dest('css'));

});

gulp.task('scripts-admin', function() {

    gulp.src([
        //Plugins
        './theme/material/global/vendor/babel-external-helpers/babel-external-helpers.js',
        './theme/material/global/vendor/jquery/jquery.js',
        './theme/material/global/vendor/tether/tether.js',
        './theme/material/global/vendor/bootstrap/bootstrap.js',
        './theme/material/global/vendor/animsition/animsition.js',
        './theme/material/global/vendor/mousewheel/jquery.mousewheel.js',
        './theme/material/global/vendor/asscrollbar/jquery-asScrollbar.js',
        './theme/material/global/vendor/asscrollable/jquery-asScrollable.js',
        './theme/material/global/vendor/ashoverscroll/jquery-asHoverScroll.js',
        './theme/material/global/vendor/waves/waves.js',
        './theme/material/global/vendor/switchery/switchery.min.js',
        './theme/material/global/vendor/intro-js/intro.js',
        './theme/material/global/vendor/screenfull/screenfull.js',
        './theme/material/global/vendor/slidepanel/jquery-slidePanel.js',
        './theme/material/global/vendor/summernote/summernote.min.js',
        './theme/material/global/vendor/matchheight/jquery.matchHeight-min.js',
        './theme/material/global/vendor/peity/jquery.peity.min.js',
        './theme/material/global/vendor/bootbox/bootbox.js',
        './theme/material/global/vendor/bootstrap-sweetalert/sweetalert.js',
        './theme/material/global/vendor/toastr/toastr.js',
        './theme/material/global/vendor/alertify/alertify.js',
        './theme/material/global/vendor/notie/notie.js',
        './theme/material/global/vendor/html5sortable/html.sortable.js',
        './theme/material/global/vendor/nestable/jquery.nestable.js',
        './theme/material/global/vendor/bootstrap-treeview/bootstrap-treeview.min.js',
        './theme/material/global/vendor/jstree/jstree.min.js',
        './theme/assets/vendor/handlebars/handlebars-v4.0.5.js',
        './theme/material/global/vendor/aspaginator/jquery.asPaginator.min.js',
        './theme/material/global/vendor/jquery-placeholder/jquery.placeholder.js',
        './theme/material/global/vendor/select2/select2.min.js',

        './theme/material/global/vendor/jquery-ui/jquery-ui.js',
        './theme/material/global/vendor/blueimp-tmpl/tmpl.js',
        './theme/material/global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js',
        './theme/material/global/vendor/blueimp-load-image/load-image.all.min.js',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload.js',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload-process.js',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload-image.js',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload-audio.js',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload-video.js',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload-validate.js',
        './theme/material/global/vendor/blueimp-file-upload/jquery.fileupload-ui.js',
        './theme/material/global/vendor/dropify/dropify.js',
        // Scripts
        './theme/material/global/js/State.js',
        './theme/material/global/js/Component.js',
        './theme/material/global/js/Plugin.js',
        './theme/material/global/js/Base.js',
        './theme/material/global/js/Config.js',
        './theme/material/base/assets/js/Section/Menubar.js',
        './theme/material/base/assets/js/Section/GridMenu.js',
        './theme/material/base/assets/js/Section/Sidebar.js',
        './theme/material/base/assets/js/Section/PageAside.js',
        './theme/material/base/assets/js/Plugin/menu.js',
        './theme/material/global/js/config/colors.js',
        './theme/material/base/assets/js/config/tour.js',
        // Page
        './theme/material/base/assets/js/Site.js',
        './theme/material/global/js/Plugin/asscrollable.js',
        './theme/material/global/js/Plugin/select2.js',
        './theme/material/global/js/Plugin/slidepanel.js',
        './theme/material/global/js/Plugin/bootstrap-tokenfield.js',
        './theme/material/global/js/Plugin/bootstrap-tagsinput.js',
        './theme/material/global/js/Plugin/bootstrap-select.js',
        './theme/material/global/js/Plugin/bootstrap-maxlength.js',
        './theme/material/global/js/Plugin/jquery-knob.js',
        './theme/material/global/js/Plugin/switchery.js',
        './theme/material/global/js/Plugin/summernote.js',
        './theme/material/global/js/Plugin/matchheight.js',
        './theme/material/global/js/Plugin/peity.js',
        './theme/material/global/js/Plugin/asselectable.js',        
        './theme/material/global/js/Plugin/editlist.js',
        './theme/material/global/js/Plugin/animate-list.js',
        './theme/material/global/js/Plugin/aspaginator.js',
        './theme/material/global/js/Plugin/sticky-header.js',
        './theme/material/global/js/Plugin/action-btn.js',        
        './theme/material/global/js/Plugin/jquery-placeholder.js',        
        './theme/material/global/js/Plugin/selectable.js',
        './theme/material/global/js/Plugin/bootbox.js',        
        './theme/material/global/js/Plugin/material.js',
        './theme/material/global/js/Plugin/html5sortable.js',
        './theme/material/global/js/Plugin/nestable.js',
        './theme/material/global/js/Plugin/tasklist.js',
        './theme/material/global/js/Plugin/panel.js',
        './theme/material/global/js/Plugin/icheck.js',
        './theme/material/global/js/Plugin/bootstrap-treeview.js',
        './theme/material/global/js/Plugin/jstree.js',
        './theme/material/global/js/Plugin/input-group-file.js',
        './theme/material/global/js/Plugin/dropify.js',
        './theme/material/global/js/Plugin/asrange.js',
        './theme/material/global/js/Plugin/asspinner.js',
        './theme/material/global/js/Plugin/jquery-labelauty.js',
        './theme/material/global/js/Plugin/masonry.js',
        './theme/assets/vendor/sly/sly.min.js',
        './theme/material/global/vendor/imagesloaded/imagesloaded.pkgd.js',
        './theme/material/global/vendor/masonry/masonry.pkgd.min.js',
        './theme/material/global/vendor/moment/moment.min.js',
        
        './theme/material/global/vendor/fullcalendar/fullcalendar.js',
        './theme/material/global/vendor/fullcalendar/locale/pt-br.js',
        './theme/material/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js',
        './theme/material/global/vendor/bootstrap-datepicker/bootstrap-datepicker.pt-BR.min.js',
        './theme/material/global/js/Plugin/bootstrap-datepicker.js',

        //Others Plugins
        './js/jrangel/jquery.core.js',
        './js/jrangel/jquery.btnload.js',
        './js/jrangel/jquery.btnrest.js',
        './js/jrangel/jquery.modal.js',
        './js/jrangel/jquery.store.js',
        './js/jrangel/jquery.combobox.js',
        './js/jrangel/jquery.form.js',
        './js/jrangel/jquery.upload.js',
        './js/jrangel/jquery.table.js',
        './js/jrangel/jquery.arquivos.js',
        './js/jrangel/jquery.panel.js',
        './js/jrangel/jquery.picker.js',
        './js/aribeiro/selecionar.js'
    ])
        .pipe(jshint())
        .pipe(uglify())
        //.pipe(jsmin())
        .pipe(concat('./../js/libs.js'))
        .pipe(gulp.dest('js'));

});

gulp.task('scripts', function() {

	gulp.src([
        './scripts/**/*.js'
    ])
		.pipe(jshint())
		.pipe(uglify())
		.pipe(jsmin())
		.pipe(rename({suffix: '.min'}))
        .pipe(concat('./../js/scripts.js'))
		.pipe(gulp.dest('js'));

    gulp.src([
        './js/libs.js', './js/scripts.js'
    ])
    .pipe(concat('all.js'))
    .pipe(gulp.dest('./js/'));

});

gulp.task('html', function() {
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

    gulp.src('html/install/*.html')
    .pipe(htmlmin({
        collapseWhitespace: true,
        removeComments: true,
        removeOptionalTags: true
    }))
    .pipe(gulp.dest('tpl/install'));

    gulp.src('html/admin/panel/*.html')
    .pipe(htmlmin({
        collapseWhitespace: true,
        removeComments: true,
        removeOptionalTags: true
    }))
    .pipe(gulp.dest('tpl/admin/panel'));
});
 
gulp.task('images', function(cb) {
    gulp.src(['images/**/*.png','images/**/*.jpg','images/**/*.gif','images/**/*.jpeg']).pipe(imageop({
        optimizationLevel: 5,
        progressive: true,
        interlaced: true
    })).pipe(gulp.dest('img')).on('end', cb).on('error', cb);
});

gulp.task('default', function() {
    gulp.watch('sass/**/*.scss',['styles']);
	gulp.watch('theme/material/**/*.css',['cssmin']);
    gulp.watch('theme/material/**/*.js',['scripts-admin']);
	gulp.watch('scripts/**/*.js',['scripts']);
    gulp.watch('html/**/*.html',['html']);
	gulp.watch('images_originals/**/*.*',['images']);
});
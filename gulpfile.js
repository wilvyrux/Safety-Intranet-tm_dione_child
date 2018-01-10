const gulp = require('gulp');
const sass = require('gulp-sass');
const cssnano = require('gulp-cssnano');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();
const copy = require('gulp-copy');

gulp.task('sass', function(){
    var sass_src = [
        './wx-assets/**/*.scss',
    ];
    return gulp.src(sass_src)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(gulp.dest('./css'))
        .pipe(cssnano())
        .pipe(sourcemaps.write())
        .pipe(rename(function(p){ p.extname = '.min.css' }))
        .pipe(gulp.dest('./css'))
        .pipe(browserSync.stream());
});


//CSS
gulp.task('plugin-css', function(){
    var sass_src =
        [
            'bower_components/dist/assets/owl.carousel.css',
            'bower_components/owl.theme.default.css',
            'bower_components/font-awesome/css/font-awesome.css',
            'bower_components/bootstrap/dist/css/bootstrap.min.css',
        ];
    return gulp.src(sass_src)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(concat('wx-plugin.css'))
        .pipe(gulp.dest('./css'))
        .pipe(cssnano())
        .pipe(sourcemaps.write())
        .pipe(rename(function(p){ p.extname = '.min.css' }))
        .pipe(gulp.dest('./css'))
        .pipe(browserSync.stream());
});


//JS
gulp.task('plugin-js', function(){
    var script_src =
        [
            'bower_components/owl.carousel/dist/owl.carousel.js',
            'bower_components/bootstrap/dist/js/bootstrap.min.js',
        ];
    return gulp.src(script_src)
        .pipe(sourcemaps.init())
        .pipe(concat('wx-plugin.js'))
        .pipe(gulp.dest('./js'))
        .pipe(sourcemaps.write())
        .pipe(rename(function(p){ p.extname = '.min.js' }))
        .pipe(gulp.dest('./js'));
});





gulp.task('fonts', function() {
    return gulp.src([
        './bower_components/**/fonts/**/*.*'
    ])
        .pipe(copy('./fonts', {prefix: 99}));
});


gulp.task('serve', ['sass'], function() {

    browserSync.init({
        injectChanges: true,
        host: 'localhost',
        proxy: 'localhost/foldername',
    });

    gulp.watch("./wx-assets/**/*.scss", ['sass']);
    gulp.watch("./**/*.html").on('change', browserSync.reload);
});



gulp.task('sass:watch', function(){
     gulp.watch('./wx-assets/**/*.scss', ['sass']);
});


gulp.task('build', function(){
     gulp.run(['plugin-css','plugin-js','fonts','sass']);
});



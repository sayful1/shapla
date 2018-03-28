const gulp = require('gulp');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const sassOptions = {
    errLogToConsole: true,
    outputStyle: 'compressed'
};
const autoprefixerOptions = {
    browsers: ['last 5 versions', '> 5%', 'Firefox ESR']
};

gulp.task('sass', function () {
    gulp.src('./assets/scss/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('sass-main', function () {
    gulp.src('./assets/scss/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest('.'));
});

gulp.task('js', function () {
    gulp.src('./assets/js/src/*.js')
        .pipe(concat('script.js'))
        .pipe(gulp.dest('./assets/js'))
        .pipe(concat('script.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./assets/js'));
});

gulp.task('customize-js', function () {
    gulp.src('./assets/js/customize/*.js')
        .pipe(concat('customize.js'))
        .pipe(gulp.dest('./assets/js'))
        .pipe(concat('customize.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./assets/js'));
});

gulp.task('polyfill', function () {
    gulp.src('./assets/js/polyfill/*.js')
        .pipe(concat('polyfill.js'))
        .pipe(gulp.dest('./assets/js'))
        .pipe(concat('polyfill.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./assets/js'));
});

gulp.task('watch', function () {
    gulp.watch('./assets/scss/*.scss', ['sass']);
    gulp.watch('./assets/scss/style.scss', ['sass-main']);
    gulp.watch('./assets/js/src/*.js', ['js']);
    gulp.watch('./assets/js/customize/*.js', ['customize-js']);
    gulp.watch('./assets/js/polyfill/*.js', ['polyfill']);
});

gulp.task('default', ['sass', 'sass-main', 'js', 'customize-js', 'polyfill', 'watch']);

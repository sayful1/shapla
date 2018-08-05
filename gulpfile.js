const gulp = require('gulp');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const livereload = require('gulp-livereload');
const rollup = require('rollup');
const buble = require('rollup-plugin-buble');
const file = require('gulp-file');

const sassOptions = {
    errLogToConsole: true,
    outputStyle: 'compressed'
};

const autoprefixerOptions = {
    browsers: ['last 5 versions', '> 5%', 'Firefox ESR']
};

gulp.task('sass', function () {
    gulp.src('./assets/scss/**/**/.scss')
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/css'))
        .pipe(livereload());
});

gulp.task('sass-main', function () {
    gulp.src('./assets/scss/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('.'))
        .pipe(livereload());
});

gulp.task('customize-js', function () {
    gulp.src('./assets/js/customize/*.js')
        .pipe(concat('customize.js'))
        .pipe(gulp.dest('./assets/js'))
        .pipe(concat('customize.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./assets/js'))
        .pipe(livereload());
});

gulp.task('bundle', function () {
    return rollup.rollup({
        input: './assets/js/public/main.js',
        plugins: [buble()]
    }).then(function (bundle) {
        return bundle.generate({
            format: 'umd'
        });
    }).then(function (gen) {
        return file('temp.js', gen.code, {src: true})
            .pipe(concat('script.js'))
            .pipe(gulp.dest('./assets/js/'))
            .pipe(concat('script.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('./assets/js/'))
            .pipe(livereload());
    });
});

gulp.task('watch', function () {
    livereload.listen();
    gulp.watch('./assets/scss/**/**/*.scss', ['sass']);
    gulp.watch('./assets/scss/style.scss', ['sass-main']);
    gulp.watch('./assets/js/customize/*.js', ['customize-js']);
    gulp.watch('./assets/js/public/*.js', ['bundle']);
});

gulp.task('default', ['sass', 'sass-main', 'customize-js', 'bundle', 'watch']);

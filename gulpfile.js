var gulp = require('gulp'),
    clean = require('gulp-clean'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    minifyCSS = require('gulp-minify-css');

gulp.task('styles', function () {
    return gulp.src([
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'resources/assets/css/main.css'
    ])
        .pipe(concat('styles.min.css'))
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/css'));
});

gulp.task('scripts', function () {
    var js = gulp.src([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/tether/dist/js/tether.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'resources/assets/js/script.js'
    ])
        .pipe(concat('all.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/js'));
});

gulp.task('clean', function () {
    return gulp.src([
            'public/css',
            'public/js'
        ], {
            read: false
        }
    ).pipe(clean());
});

gulp.task('watch', function () {
    gulp.watch('resources/assets/css/main.css', ['styles']);
    gulp.watch('resources/assets/js/script.js', ['scripts']);
});

gulp.task('default', ['clean'], function () {
    gulp.start('styles', 'scripts');
});


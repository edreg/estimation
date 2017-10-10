var requireDir = require('require-dir'),
    gulp = require('gulp'),
    sass = require('gulp-sass'),
    runSequence  = require('run-sequence'),
    sourceMaps = require('gulp-sourcemaps'),
    concat = require('gulp-concat'),
    typescript = require('gulp-typescript'),
    uglify = require('gulp-uglify'),
    clean = require('gulp-clean');

requireDir('module/Estimation/assets/gulp-tasks');

// Default task -> gulp
gulp.task('default', ['default-estimation']);
gulp.task(
    'default-estimation', function(callback)
    {
        runSequence(
            'init-estimation',
            callback
        )
    }
);
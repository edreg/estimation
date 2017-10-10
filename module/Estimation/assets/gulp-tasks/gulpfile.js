var gulp = require('gulp'),
    sass = require('gulp-sass'),
    runSequence  = require('run-sequence'),
    sourceMaps = require('gulp-sourcemaps'),
    //rename = require('gulp-rename'),
    //watch = require('gulp-watch'),
    concat = require('gulp-concat'),
    //util = require('gulp-util'),
    typescript = require('gulp-typescript'),
    //changed = require('gulp-changed'),
    uglify = require('gulp-uglify'),
    clean = require('gulp-clean'),
    //gulpIf = require('gulp-if'),
    path = require('path'),
    process = require('process'),
    //foreach = require('gulp-foreach'),
    typeScriptProject = typescript.createProject({
        removeComments: false,
        target: 'ES5',
        noResolve: false,
        noImplicitAny: false,
        "moduleResolution": "classic",
        "module": "system"
    }),
    config = {
        typings: './public/typings',
        customTypings: './public/typings',
        typeScriptTaskList: {
            estimationExample: {
                typeScript: {
                    source: './module/Estimation/assets/ts/Estimation/'
                }
            }
        }
    };

/**
 *
 * @param taskName
 * @returns {JQueryPromise<any>|T|*}
 */
function compileWithTsConfig(taskName)
{
    var taskConfiguration = config['typeScriptTaskList'][taskName].typeScript;
    var typeScriptProject = typescript.createProject(
        path.join(taskConfiguration.source, 'tsconfig.json')
    );

    return typeScriptProject.src()
        .pipe(typeScriptProject())
        .js
        .pipe(gulp.dest(process.cwd()));
}

gulp.task(
    'init-estimation', function(callback)
    {
        runSequence(
            'clean-estimation',
            'css-estimation',
            'css-estimation-copy',
            'js-estimation',
            'img-counting-app',
            'ts-estimation-typings-concat',
            'ts-estimation',
            'ts-estimation-example',
            callback
        );
    }
);

gulp.task('ts-estimation-typings-concat', function()
{
    return gulp.src(['./module/Estimation/assets/typings/partial/*.d.ts'])
        .pipe(concat('index.d.ts'))
        .pipe(gulp.dest('./module/Estimation/assets/typings'));
});

gulp.task('clean-estimation', function()
{
    return gulp.src(['./public/module/Estimation'], {read: false})
        .pipe(clean());
});

gulp.task('ts-estimation-example', function()
{
    return compileWithTsConfig('estimationExample');
});

gulp.task('ts-estimation', function() {
    return gulp.src(
        [
            './module/Estimation/assets/ts/*.ts'
        ])
        .pipe(sourceMaps.init())
        .pipe(typeScriptProject())
        .pipe(sourceMaps.write('./'))
        .pipe(gulp.dest('./public/module/Estimation/assets/js'))
});

gulp.task('css-estimation', function()
{
    return gulp.src(['./module/Estimation/assets/scss/estimation.scss'])
        .pipe(sourceMaps.init())
        .pipe(sass({}).on('error', sass.logError))
        .pipe(concat('estimation.css'))
        .pipe(sourceMaps.write('./'))
        .pipe(gulp.dest('./public/module/Estimation/assets/css'));
});

gulp.task('css-estimation-copy', function() {
    return gulp.src('./module/Estimation/assets/css/*.css')
        .pipe(gulp.dest('./public/module/Estimation/assets/css'))
});

gulp.task('js-estimation', function()
{
    return gulp.src('./module/Estimation/assets/js/*.js')
        .pipe(sourceMaps.init())
        .pipe(uglify())
        .pipe(sourceMaps.write('./'))
        .pipe(gulp.dest('./public/module/Estimation/assets/js'));
});

gulp.task('img-counting-app', function()
{
    return gulp.src(['./module/Estimation/assets/img/*.*'])
        .pipe(gulp.dest('./public/module/Estimation/assets/img'));
});
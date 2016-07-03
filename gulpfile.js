
/* General variables */
var dist       = './';

/* Dependencies */  
var autoprefixer    = require('gulp-autoprefixer'),
    browserSync     = require('browser-sync'),
    es              = require('event-stream'),
    fs              = require('fs')
    gulp            = require('gulp'),
    header          = require('gulp-header');
    inject          = require('gulp-inject');
    less            = require('gulp-less'); 
    minifyCSS       = require('gulp-minify-css'); 
    notify          = require('gulp-notify'),
    pkg             = require('./package.json'),
    realFavicon     = require('gulp-real-favicon'),
    reload          = browserSync.reload,
    rename          = require('gulp-rename'),
    replace         = require('gulp-replace'),
    rimraf          = require('gulp-rimraf'),
    series          = require('stream-series'),
    uglify          = require('gulp-uglify'),
    watch           = require('gulp-watch');

/* Prepare banner text */
var banner = ['/**',
  ' * Project: <%= pkg.name %> ',
  ' * Version: v<%= pkg.version %>.2',
  ' * Description: <%= pkg.description %>',
  ' * Author: <%= pkg.author.name %>',
  ' * Author email: <%= pkg.author.email %>',
  ' * Licence: <%= pkg.license %>',
  ' * Web: <%= pkg.homepage %>',
  ' */',
  ''].join('\n');

/* Favicon */
var dist_inject_path_slice    = dist.length - 2,
    favicon_data_file         = dist + 'faviconData.json',
    favicon_master_img        = dist + 'assets/img/default/favicon.png',
    favicon_output_path       = dist + 'assets/img/favicon/',
    favicon_icon_path         = '<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon/'; //Prepared to wordpress


/* Task to compile less */
gulp.task('less', function() {  
  gulp.src('./assets/less/style.less')
    .pipe(less())
    .pipe(header(banner, {pkg: pkg}))
    .pipe(gulp.dest('./'));
});

/* Task to watch less changes */
gulp.task('watch-less', ['less'], function() {  
  gulp.watch('./assets/less/*.less' , ['less']);
});

/* Task to minify css */
gulp.task('min', ['less'], function() {  
  gulp.src('./*.css')
    .pipe(minifyCSS())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest( './assets/styles/min/' ));
});

/* Task when running `gulp` from terminal */
gulp.task('serve', ['watch-less']);

/* Task when running `gulp build` from terminal */
gulp.task('build', ['min']);  





/* Clean favicon on /dev && /dist
 *
 ***********************************/
gulp.task('clean:favicon', [], function() {
    console.log("Clean all files in dist folder");
    return gulp.src([ dist + 'assets/img/favicon/**/*'], { read: false }).pipe(rimraf());
});



/* Create favicon on /dev
 *  
 ***********************************/
gulp.task('generate-favicon', ['clean:favicon'], function(done) {
    realFavicon.generateFavicon({
        masterPicture: favicon_master_img,
        dest: favicon_output_path,
        iconsPath: favicon_icon_path,
        design: {
            ios: {
                pictureAspect: 'backgroundAndMargin',
                backgroundColor: '#ffffff',
                margin: '49%'
            },
            desktopBrowser: {},
            windows: {
                pictureAspect: 'noChange',
                backgroundColor: '#da532c',
                onConflict: 'override'
            },
            androidChrome: {
                pictureAspect: 'backgroundAndMargin',
                margin: '42%',
                backgroundColor: '#ffffff',
                themeColor: '#ffffff',
                manifest: {
                    name: 'WP-DC',
                    display: 'browser',
                    orientation: 'notSet',
                    onConflict: 'override',
                    declared: true
                }
            },
            safariPinnedTab: {
                pictureAspect: 'silhouette',
                themeColor: '#d55b5b'
            }
        },
        settings: {
            scalingAlgorithm: 'Mitchell',
            errorOnImageTooSmall: false
        },
        markupFile: favicon_data_file
    }, function() {
        done();
    });
});


/* Copy favicon && Inject markup in /dev && /dist
 *  
 ***********************************/
gulp.task('favicon', ['generate-favicon'], function() {
    gulp.src([dist + 'header.php'])
        .pipe(realFavicon.injectFaviconMarkups(JSON.parse(fs.readFileSync(favicon_data_file)).favicon.html_code))
        .pipe(replace('</div></body></html>', '')) // Fix to separate in two php files
        .pipe(replace('</div></body>', '')) // Fix to separate in two php files
        .pipe(gulp.dest(dist));
});
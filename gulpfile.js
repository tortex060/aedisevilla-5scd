
/* VARIABLES
 *
 ***********************************/
// Project configuration
var project         = 'aedisevilla5scd',
    url             = 'http://5scd.aedisevilla.es/',
    bower           = './bower_components/',
    node            = './node_modules/',
    dist            = './' //Where you have put the project's main root
    flexdir         = './assets/less/flexboxer/', //Where watch for changes in less files
    flexfile        = './assets/less/style.less', //File with list of less modules
    pluginsdir      = 'assets/plugins/', // Don't put the './' because this is combined with 'dist' var

    sliderdir       = './assets/img/slider/', //Slider image-linker build with Flickity. See Slider task below for more info
    slidertarget    = 'home.php', //File where you have insert <!-- inject:slider -->

    dist_basic_files = [ // Files to copy on dist
        dist + '*.php',
        dist + 'style.css',
        dist + 'plugins/**/*',
        dist + 'img/**/*',
        '!'+dist+'img/RAW/**/*',
        dist + 'screenshot.png'
    ],

    min_files_css = [ // CSS Archives to minimize
        dist + 'plugins/**/*.css',
        '!' + dist + 'plugins/**/*.min.css'
    ],

    min_files_js = [ // JS Archives to minimize
        dist + pluginsdir +'**/*.js',
        '!' + dist + pluginsdir +'**/*.min.js'
    ],

    css_minimized_files = [ // CSS Archives to copy
        node + 'flickity/dist/flickity.min.css'
    ],

    js_minimized_files_node = [ // JS Archives to copy
        node + 'flickity/dist/flickity.pkgd.min.js',
        node + 'd3/*.min.js'
    ],

    js_minimized_files_bower = [ // JS Archives to copy
        bower + 'chroma-js/*.min.js'
    ];

/* Dependencies */  
var autoprefixer    = require('gulp-autoprefixer'),
    browserSync     = require('browser-sync'),
    es              = require('event-stream'),
    fs              = require('fs'),
    gulp            = require('gulp'),
    header          = require('gulp-header'),
    inject          = require('gulp-inject'),
    less            = require('gulp-less'), 
    minifyCSS       = require('gulp-minify-css'),
    notify          = require('gulp-notify'),
    pkg             = require('./package.json'),
    realFavicon     = require('gulp-real-favicon'),
    reload          = browserSync.reload,
    rename          = require('gulp-rename'),
    replace         = require('gulp-replace'),
    rimraf          = require('gulp-rimraf'),
    series          = require('stream-series'),
    uglify          = require('gulp-uglify'),
    uglifycss       = require('gulp-uglifycss'), 
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

/*---------------------------------------------------------*/



/* DEFAULT Task
 *  
 ***********************************/
gulp.task('default', function() {

});





/* LESS Tasks
 *
 ***********************************/
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






/* JS & CSS BUILD & INJECT Tasks
 *  
 ***********************************/
gulp.task('build', ['inject:js:dist', 'inject:css:dist']);






/* CSS BUILD & INJECT Tasks
 *
 ***********************************/
/* Copy CSS already minimized from modules */
gulp.task('copy:cssminimized:dist', function() {
    return gulp.src(css_minimized_files, { base: node }).pipe(gulp.dest(dist+pluginsdir, { overwrite: true })); });

/* Copy & minimize CSS from /dist && node_module */
gulp.task('min:csstominimize:dist', function() {
    return gulp.src(min_files_css)
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglifycss({ maxLineLen: 80 }))
        .pipe(gulp.dest(dist + pluginsdir, { overwrite: true }));
});

/* Inject all CSS to header.php */
gulp.task('inject:css:dist', ['min:csstominimize:dist', 'copy:cssminimized:dist'], function() {
    return gulp.src(dist + 'header.php')
        .pipe(inject(
            gulp.src([dist + pluginsdir +'**/*.css'], { read: false }), {
                transform: function(filepath) {
                    //  if (filepath.slice(-5) === '.docx') {
                    return '<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>' + filepath + '"/>';
                    //  }
                    // Use the default transform as fallback: 
                    //return inject.transform.apply(inject.transform, arguments);
                }
            }
        ))
        .pipe(gulp.dest(dist));
});







/* JS BUILD & INJECT Tasks
 *
 ***********************************/
/* Copy JS already minimized from modules */
gulp.task('copy:jsminimizednode:dist', function() {
    return gulp.src(js_minimized_files_node, { base: node }).pipe(gulp.dest(dist + pluginsdir, { overwrite: true })); });
gulp.task('copy:jsminimizedbower:dist', ['copy:jsminimizednode:dist'], function() {
    return gulp.src(js_minimized_files_bower, { base: bower }).pipe(gulp.dest(dist + pluginsdir, { overwrite: true })); });

/* Copy & minimize JS from /dist && node_modules */
gulp.task('min:jstominimize:dist', function() {
    return gulp.src(min_files_js)
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest(dist + pluginsdir, { overwrite: true }));
});


/* Inject JS to footer.php */
gulp.task('inject:js:dist', ['min:jstominimize:dist', 'copy:jsminimizedbower:dist'], function() {
    var firstStream = gulp.src([dist + pluginsdir +'**/d3.min.js'], { read: false });
    var lastStream = gulp.src([dist + pluginsdir +'**/*.min.js', '!'+ dist + pluginsdir + '**/d3.min.js'], { read: false });
    return gulp.src(dist + 'footer.php')
        .pipe(inject( series(firstStream, lastStream), {
                        transform: function(filepath) {
                            return '<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>' + filepath + '"></script>';
                        }
                    } ))
        .pipe(gulp.dest(dist))
        .pipe(notify({ message: 'Build dist complete', onLast: true }));
});







/* SLIDER BUILD & INJECT Tasks
 *
 ***********************************/
/* Inject all images to home.php */
gulp.task('slider', function() {
    return gulp.src(dist + 'home.php')
        .pipe(inject(
            gulp.src([sliderdir +'*.jpg'], { read: false }), {
                starttag: '<!-- inject:slider -->',
                transform: function(filepath) {
                    //  if (filepath.slice(-5) === '.docx') {
                    return '<div class="carousel-cell js-imagefill"><img src="<?php echo get_template_directory_uri(); ?>' + filepath + '"/></div>';
                    //  }
                    // Use the default transform as fallback: 
                    //return inject.transform.apply(inject.transform, arguments);
                }
            }
        ))
        .pipe(gulp.dest(dist));
});





/* FAVICON Task
 *
 ***********************************/
gulp.task('clean:favicon', [], function() {
    console.log("Clean all files in dist folder");
    return gulp.src([ dist + 'assets/img/favicon/**/*'], { read: false }).pipe(rimraf());
});

/* Create favicon */
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

/* Copy favicon && Inject markup in dist */
gulp.task('favicon', ['generate-favicon'], function() {
    gulp.src([dist + 'header.php'])
        .pipe(realFavicon.injectFaviconMarkups(JSON.parse(fs.readFileSync(favicon_data_file)).favicon.html_code))
        .pipe(replace('</div></body></html>', '')) // Fix to separate in two php files
        .pipe(replace('</div></body>', '')) // Fix to separate in two php files
        .pipe(gulp.dest(dist));
});
// Temporary (I hope...) Bash on Ubuntu on Windows fix for networking BS
try {
  require('os').networkInterfaces()
} catch (e) {
  require('os').networkInterfaces = () => ({})
}

/*
	Grab Gulp packages
*/
var gulp  = require('gulp'),
	util = require('gulp-util'),
	plumber = require('gulp-plumber'),
	notify = require("gulp-notify"),
	watch = require('gulp-watch'),
	browserSync = require('browser-sync').create(),
	php = require('gulp-connect-php'),
	rsync = require('gulp-rsync'),
	replace = require('gulp-replace'),
	rename = require('gulp-rename'),
	sourcemaps = require("gulp-sourcemaps"),
	babel = require("gulp-babel"),
	concat = require("gulp-concat"),
	uglify = require('gulp-uglify'),
	minifyCss = require('gulp-minify-css'),
	htmlreplace = require('gulp-html-replace'),
	exec = require('child_process').exec,
	execSync = require('child_process').execSync,
	autoprefixer = require('gulp-autoprefixer'),
	runSequence = require('run-sequence'),
	clean = require('gulp-clean'),
	sass = require('gulp-sass'),
	fs = require('fs'),
	path = require('path'),
	prompt = require('gulp-prompt'),
	glob = require('glob');


var env = {
	dev: {
		user: 'www-data',
		host: 'guroot.nine.ch',
		path: '/home/www-data/www/dev.getunik.net/bleedhd-camp/',
	},
//	prod: {
//		user: 'www-data',
//		host: 'gushare01.nine.ch',
//		path: '/home/www-data/www/demo-one.getunik.com/',
//		prompt: true,
//	},
};

/*
	Configuration Options
*/
var config = {

	// General
	'basePath': './',     // Base path (relative from gulpfile.js)
	'srcPath': './src/',    // Src path (relative from gulpfile.js)
	'distPath': './kirby/',     // Dist path (relative from gulpfile.js)
	'serverPath': './kirby/', // Server path for local PHP on-demand server (relative from gulpfile.js)

	// JS
	'jsFiles': [
		'bower_components/jquery/dist/jquery.js',
		'bower_components/jquery.easing/js/jquery.easing.js',
		'bower_components/tether/dist/js/tether.js',
		'bower_components/bootstrap/dist/js/bootstrap.js',
		'bower_components/svg-injector/svg-injector.js',
		'bower_components/anzeixer/dist/anzeixer.js',
		'bower_components/eventEmitter/EventEmitter.js',
		'bower_components/slick-carousel/slick/slick.js',
		'bower_components/matchHeight/jquery.matchHeight.js',
		'bower_components/selectize/dist/js/standalone/selectize.js',
		'kirby/site/plugins/getutils/assets/getu-data-layer.js',
		'kirby/site/constructs/campaign/assets/js/boiler-modules/_*.js',
		'kirby/site/constructs/campaign/assets/js/boiler-modules/*.js',
		'kirby/site/constructs/campaign/assets/js/widget-modules/*.js',
		'kirby/site/constructs/*/components/*/*.js',
		'src/js/_*.js',
		'src/js/*.js',
	],
	'jsDistPathKirby': 'kirby/assets/js/',
	'jsDistFileName': 'all.js',
	'jsDistFileNameMin': 'all.min.js',
	// CSS
	'cssDistPathKirby': 'kirby/assets/css/',
	'cssDistFileName': 'styles.css',
	'cssDistFileNameMin': 'styles.min.css',

	'sass': {
		aggregators: {
			'__constructs-helpers': (cb) => {
				cb({ contents: ['kirby/site/constructs/campaign/assets/sass/helpers.scss'].map((f) => {
					return '@import "../../' + f + '";';
				}).join('\n') });
			},
			'__constructs-base': (cb) => {
				cb({ contents: ['kirby/site/constructs/campaign/assets/sass/base.scss'].map((f) => {
					return '@import "../../' + f + '";';
				}).join('\n') });
			},
			'__components': (cb) => {
				glob('kirby/site/constructs/campaign/components/*/*.scss', {}, (err, files) => {
					cb({ contents: files.map((f) => {
						var componentPath = '../../' + f.split('/').slice(0, 6).join('/');
						return '$componentPath: "' + componentPath + '"; @import "../../' + f.slice(0, -path.extname(f).length) + '";';
					}).join('\n') });
				});
			},
		},
	},

	// Fonts
	'fontsDistPath': 'dist/fonts/',
	'fontsDistPathKirby': 'kirby/assets/fonts/',

	// Images
	'imagesDistPath': 'dist/images/',
	'imagesDistPathKirby': 'kirby/assets/images/',

	// Videos
	'videosDistPath': 'dist/video/',
	'videosDistPathKirby': 'kirby/assets/video/',

	'deployment': {
		paths: {
			webroot: 'kirby/',
			content: 'kirby/content/',
			accounts: 'kirby/site/accounts/',
		},
		plainRsyncOptions: {
			'r': true, // recursive
			'd': true, // transfer directories without recursing
			't': true, // preserve modification times
			'z': true, // compression
			delete: false,
			progress: true,
			exclude: [
				'.DS_Store',
				'.git',
				'.gitignore',
				'.gitmodules',
				'submissions/',
			]
		},
		gulpRsyncOptions: {
			progress: true,
			recursive: true,
			clean: true,
			emptyDirectories: true,
			times: true,
			compress: true,
			exclude: [
				'.DS_Store',
				'.git',
				'.gitignore',
				'.gitmodules',
				'.htpasswd',
				'content/',
				'site/accounts/',
				'site/cache/',
				'thumbs'
			]
		},
	},
}


/*
	Custom Error Logging
*/
function logError(error) {
	notify.onError({
				title:    "Gulp Error",
				message:  "<%= error.message %>"
		})(error);

	this.emit('end'); // emit the end event, to properly end the task
}

/**
 * Executes an rsync job with the given configuration and calls the
 * callback function when done.
 */
function rsyncJob(jobConfig, callback) {
	// using gulp-rsync internals here to avoid even more dependencies
	var log = require('gulp-rsync/log'),
			rsync = require('gulp-rsync/rsync'),
			handler = function(data) {
				data.toString().split('\r').forEach(function(chunk) {
					chunk.split('\n').forEach(function(line, j, lines) {
						log('rsync:', line, (j < lines.length - 1 ? '\n' : ''));
					});
				});
			};


	// default options for rsync
	var job = rsync({
		options: Object.assign({}, config.deployment.plainRsyncOptions, {
			delete: jobConfig.clean,
		}),
		source: jobConfig.source,
		destination: jobConfig.destination,
		stdoutHandler: handler,
		stderrHandler: handler,
	});

	job.execute(callback);
}

/**
 * Helper function to create tasks within JS loops. It binds the given data
 * to the task function closure.
 */
function loopTask(name, data, task) {
	gulp.task(name, (callback) => task(data, callback));
}

/**
 * Helper function to make paths relative to the declared deployment webroot
 */
function pathFromWebroot(origPath) {
	return path.relative(config.deployment.paths.webroot, origPath) + '/';
}


/*
	Gulp Tasks
*/

// Local Server Stuff
gulp.task('php', function() {
	return php.server({
		base: config.serverPath,
		port: 8010,
		// it seems that this path needs to be absolute on certain systems (OSX with PHP 5.6?)
		router: __dirname + '/' + config.serverPath + 'kirby-router.php',
		keepalive: true,
	});
});

gulp.task('browser-sync',['php'], function() {
	return browserSync.init({
		logLevel: 'info',
		proxy: '127.0.0.1:8010',
		port: 3000,
		open: true,
		notify: true // browser popover notifications
	});
});

gulp.task('clean', function() {
	return gulp.src(config.cleanStuff, {read: false})
		.pipe(plumber({errorHandler: logError}))
		.pipe(clean({
			force: true
		}));
});

gulp.task('sass', function() {
	return gulp.src(config.srcPath + 'sass/styles.scss')
		.pipe(plumber({errorHandler: logError}))
		.pipe(sass({
			importer: (url, prev, done) => {
				if (config.sass.aggregators[url] === undefined) {
					// fall back to default import resolution
					return null;
				} else {
					config.sass.aggregators[url](done);
				}
			},
		}))
		.pipe(autoprefixer({ browsers: ['last 3 versions'] }))
		.pipe(sourcemaps.init())
		.pipe(minifyCss())
		.pipe(rename(config.cssDistFileNameMin))
		.pipe(sourcemaps.write("."))
		.pipe(gulp.dest(config.cssDistPathKirby))
		.pipe(browserSync.stream({match: '**/*.css'}))
});

gulp.task("images", function() {
	return gulp.src(config.srcPath + 'images/**/*')
		.pipe(plumber({errorHandler: logError}))
		.pipe(gulp.dest(config.imagesDistPathKirby))
});

gulp.task("videos", function() {
	return gulp.src(config.srcPath + 'video/**/*')
		.pipe(plumber({errorHandler: logError}))
		.pipe(gulp.dest(config.videosDistPathKirby))
});

gulp.task("thumbs", function() {
	exec('mkdir kirby/thumbs; chmod 777 kirby/thumbs');
});

gulp.task("fonts", function() {
	return gulp.src([
			config.srcPath + 'fonts/*.*',
			'bower_components/bootstrap/fonts/*.*',
			'bower_components/font-awesome/fonts/*.*',
		])
		.pipe(plumber({errorHandler: logError}))
		.pipe(gulp.dest(config.fontsDistPathKirby))
});

gulp.task("js", function () {
	return gulp.src(config.jsFiles)
		.pipe(plumber({errorHandler: logError}))
		//.pipe(babel())
		.pipe(concat(config.jsDistFileName))
		.pipe(gulp.dest(config.jsDistPathKirby))
		.pipe(sourcemaps.init())
		.pipe(uglify({
			compress: {
				drop_console: false
			}
		}))
		.pipe(rename(config.jsDistFileNameMin))
		.pipe(sourcemaps.write("."))
		.pipe(gulp.dest(config.jsDistPathKirby))
		.pipe(browserSync.stream({match: '**/*.js'}))
});

/**
 * Dummy-Task to force browser-sync reload on Kirby file changes
 */
gulp.task('kirby', (done) => {
	browserSync.reload();
	done();
});

gulp.task('watch', ['browser-sync'], function () {
		gulp.watch([
			config.srcPath + 'sass/**/*.scss',
			'./kirby/site/constructs/campaign/assets/sass/*.scss',
			'./kirby/site/constructs/campaign/components/*/*.scss',
		], ['sass']);

		gulp.watch(config.jsFiles, ['js']);

		gulp.watch([
			config.srcPath + 'images/**/*'
		], ['images']);
});

gulp.task('default', function(callback) {
	runSequence('build', 'watch', callback);
});

gulp.task('build', ['images', 'videos', 'thumbs', 'fonts', 'sass', 'js']);


for (var target in env) {

	loopTask(['deploy', target].join(':'), env[target], (target, callback) => {
		var opts = Object.assign({}, config.deployment.gulpRsyncOptions, {
			root: config.deployment.paths.webroot,
			hostname: target.host,
			username: target.user,
			destination: target.path,
		});

		return gulp.src(config.serverPath + '.')
			.pipe(target.prompt ? prompt.confirm('You are about to deploy to the PRODUCTION server. Are you sure?') : util.noop())
			.pipe(plumber({errorHandler: logError}))
			.pipe(rsync(opts));
	});

	loopTask(['content', 'pull', target].join(':'), env[target], (target, callback) => {
		rsyncJob({
			source: target.user + '@' + target.host + ':' + target.path + pathFromWebroot(config.deployment.paths.content),
			destination: config.deployment.paths.content,
			clean: true,
		}, callback);
	});

	loopTask(['content', 'push', target].join(':'), env[target], (target, callback) => {
		rsyncJob({
			source: config.deployment.paths.content,
			destination: target.user + '@' + target.host + ':' + target.path + pathFromWebroot(config.deployment.paths.content),
			clean: true,
		}, callback);
	});

	loopTask(['accounts', 'pull', target].join(':'), env[target], (target, callback) => {
		rsyncJob({
			source: target.user + '@' + target.host + ':' + target.path + pathFromWebroot(config.deployment.paths.accounts),
			destination: config.deployment.paths.accounts,
			clean: true,
		}, callback);
	});

	loopTask(['accounts', 'push', target].join(':'), env[target], (target, callback) => {
		rsyncJob({
			source: config.deployment.paths.accounts,
			destination: target.user + '@' + target.host + ':' + target.path + pathFromWebroot(config.deployment.paths.accounts),
			clean: true,
		}, callback);
	});

}

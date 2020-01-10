var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');
var gulpWebpack = require('webpack-stream');
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var sourcemaps = require('gulp-sourcemaps');

gulp.task( 'sass', function(){
	return gulp.src( 'src/styles/**/*.scss' )
	.pipe(sourcemaps.init())
	.pipe( sass().on( 'error', sass.logError ) )
	.pipe(sourcemaps.write())
	.pipe( gulp.dest( 'assets/css' ) )
} );

gulp.task( 'css', gulp.series( 'sass', function () {
	var plugins = [
		autoprefixer( { grid : 'autoplace' } ),
		cssnano()
	];
	return gulp.src( './assets/css/*.css' )
	.pipe( sourcemaps.init() )
	.pipe( postcss( plugins ) )
	.pipe(sourcemaps.write( '/sourcemaps' ) )
	.pipe( gulp.dest( './assets/css' ) );
} ) );

gulp.task( 'webpack', function() {
	return gulp.src( 'src/scripts/public.js' )
	.pipe( webpack( { config : require('./webpack.config.js') } ))
	.on('error', function handleError() {
		this.emit('end'); // Recover from errors
	})
	.pipe( gulp.dest( 'assets/js' ) );
} );

gulp.task( 'webpack:admin', function() {
	return gulp.src( 'src/scripts/admin.js' )
	.pipe( gulpWebpack( { config : require('./webpack.config.js') }, require('webpack') ))
	.on('error', function handleError() {
		this.emit('end'); // Recover from errors
	})
	.pipe( gulp.dest( 'assets/js' ) );
} );

gulp.task( 'webpack:public', function() {
	return gulp.src( 'src/scripts/public.js' )
	.pipe( gulpWebpack( { config : require('./webpack.config.js') }, require('webpack') ))
	.on('error', function handleError( e ) {
		this.emit( 'end' ); // Recover from errors
	})
	.pipe( gulp.dest( 'assets/js' ) );
} );

gulp.task( 'js:admin', gulp.series( 'webpack:admin', function(){
	return gulp.src( [ 'src/scripts/external/*.js', 'src/scripts/external/admin/*.js', 'assets/js/admin.js' ] )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'admin.js' ) )
		.pipe( gulp.dest('assets/js') )
		.pipe( uglify() )
		.pipe( sourcemaps.write('./') )
		.pipe( gulp.dest('assets/js') );
} ) );

gulp.task( 'js:public', gulp.series( 'webpack:public', function(){
	return gulp.src( [ 'src/scripts/external/*.js', 'src/scripts/external/public/*.js', 'assets/js/public.js' ] )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'public.js' ) )
		.pipe( gulp.dest('assets/js') )
		.pipe( uglify() )
		.pipe( sourcemaps.write('./') )
		.pipe( gulp.dest('assets/js') );
} ) );

gulp.task( 'watch', function(){
	gulp.watch( 'src/styles/**/*.scss', gulp.series( 'css' ) );
	gulp.watch( 'src/scripts/admin.js', gulp.series( [ 'js:admin' ] ) );
	gulp.watch( 'src/scripts/public.js', gulp.series( [ 'js:public' ] ) );
	gulp.watch( 'src/scripts/include/*.js', gulp.series( [ 'js:public', 'js:admin' ] ) );
});

gulp.task('default', gulp.series( [ 'watch' ] ));
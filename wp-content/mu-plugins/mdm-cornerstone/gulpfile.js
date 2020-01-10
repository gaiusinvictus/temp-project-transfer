var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var cssnano = require('cssnano');
var webpack = require('webpack-stream');
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var sourcemaps = require('gulp-sourcemaps');

gulp.task( 'sass', function(){
	return gulp.src( 'src/styles/**/*.scss' )
	.pipe(sourcemaps.init())
	.pipe( sass().on( 'error', sass.logError ) )
	.pipe(sourcemaps.write())
	.pipe( gulp.dest( 'assets/css' ) )
});

gulp.task( 'css', gulp.series( 'sass', function () {
    var plugins = [
        autoprefixer( { grid : 'autoplace', browsers : ['last 3 version'] } ),
        cssnano()
    ];
    return gulp.src( './assets/css/*.css' )
    .pipe( sourcemaps.init() )
    .pipe( postcss( plugins ) )
    .pipe(sourcemaps.write( '/sourcemaps' ) )
    .pipe( gulp.dest( './assets/css' ) );
}));

gulp.task( 'webpack', function() {
	return gulp.src( 'src/scripts/public.js' )
	.pipe( webpack( { config : require('./webpack.config.js') } ))
    .pipe( gulp.dest( 'assets/js' ) );
});

gulp.task( 'js:admin', function(){
    return gulp.src( [ 'src/scripts/bundle/*.js', 'src/scripts/bundle/admin/*.js', 'assets/js/admin.js' ] )
        .pipe( sourcemaps.init() )
        .pipe( concat( 'admin.js' ) )
        .pipe( gulp.dest('assets/js') )
        .pipe( uglify() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('assets/js') );
});

gulp.task( 'js:public', function(){
    return gulp.src( [ 'src/scripts/bundle/*.js', 'src/scripts/bundle/public/*.js', 'assets/js/public.js' ] )
        .pipe( sourcemaps.init() )
        .pipe( concat( 'public.js' ) )
        .pipe( gulp.dest('assets/js') )
        .pipe( uglify() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('assets/js') );
});

gulp.task( 'watch', function(){
	gulp.watch( 'src/styles/**/*.scss', gulp.series( 'css' ) );
	gulp.watch( 'src/scripts/admin.js', gulp.series( [ 'webpack', 'js:admin' ] ) );
	gulp.watch( 'src/scripts/public.js', gulp.series( [ 'webpack', 'js:public' ] ) );
	gulp.watch( 'src/scripts/require/*.js', gulp.series( [ 'webpack', 'js:public', 'js:admin' ] ) );
});

gulp.task('default', gulp.series( [ 'watch' ] ));
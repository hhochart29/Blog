'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function () {
	return gulp.src('./assets/web/*.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('./assets/web'));
});

gulp.task('sass:watch', function () {
	gulp.watch('./assets/web/*.scss', ['sass']);
});
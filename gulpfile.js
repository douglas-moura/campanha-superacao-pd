const gulp = require('gulp'),
    stylus = require('gulp-stylus')

gulp.task('stylus',
  () => gulp.src(['./assets/styl/*.styl', '!./assets/styl/_*.styl'])
     .pipe(stylus())
     .pipe(gulp.dest('./assets/css/'))
)

gulp.task('default',
  () => gulp.watch(['./assets/styl/**/*.styl'],['stylus'])
)

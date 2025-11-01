// before gulp run this: npm link gulp del, etc modules
console.log('\x1b[41m%s\x1b[0m', 'npm link gulp del');  //cyan
var gulp = require('gulp');
var del = require('del');

// To clean files/directories before git files
gulp.task('clean:assets', function () {
  console.log('\x1b[42m%s\x1b[0m', 'Del started');  //cyan
  del([
    'assets/**/bin',
    'assets/**/scss',
    'assets/**/external',
    'assets/**/src',
    'assets/**/examples',
    'assets/**/build',
    'assets/**/docs',
    'assets/**/Gruntfile.js',
    'assets/**/gulpfile.js',
    'assets/**/component.json',
    'assets/**/.hsdoc',
    'assets/*/js',
    'assets/*/Lib',
    'assets/*/Src',
    'assets/*/Tests',
    '!assets/dist/**/*'
  ]);
  console.log('\x1b[42m%s\x1b[0m', 'Del completed');  //cyan
  return true;
});

gulp.task('default', ['clean:assets']);

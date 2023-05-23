const { src, dest, watch, series } = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const postcss = require("gulp-postcss");
const cssNano = require("cssnano");
const terser = require("gulp-terser");
const rename = require("gulp-rename");

//Views for Site
function copyPhtml() {
  return src("../dev/**/*.phtml").pipe(dest("../html/Modules/"));
}

//Views for Site
function copyPhp() {
  return src("../dev/**/*.php").pipe(dest("../html/Modules/"));
}

//Views for Site
function copyJson() {
  return src("../dev/**/*.json").pipe(dest("../html/Modules/"));
}

function copyImages() {
  return src("../dev/**/*.{gif,png,jpg,jpeg,svg}")
    .pipe(
      rename(function (path) {
        path.dirname = path.dirname.toLowerCase();
        path.basename = path.basename.toLowerCase();
        path.extname = path.extname.toLowerCase();
      })
    )
    .pipe(dest("../html/public/"));
}

function scssTask() {
  return src("../dev/**/*.scss")
    .pipe(sass())
    .pipe(postcss([cssNano()]))
    .pipe(
      rename(function (path) {
        path.dirname = path.dirname.toLowerCase();
        path.basename = path.basename.toLowerCase();
        path.extname = path.extname.toLowerCase();
      })
    )
    .pipe(dest("../html/public/"));
}

function jsTask() {
  return src("../dev/**/*.js")
    .pipe(terser())
    .pipe(
      rename(function (path) {
        path.dirname = path.dirname.toLowerCase();
        path.basename = path.basename.toLowerCase();
        path.extname = path.extname.toLowerCase();
      })
    )
    .pipe(dest("../html/public/"));
}

function watchTask() {
  watch("../dev/**/*.phtml", copyPhtml);
  watch("../dev/**/*.php", copyPhp);
  watch("../dev/**/*.json", copyJson);
  watch("../dev/**/*.{gif,png,jpg,jpeg,svg}", copyImages);
  watch("../dev/**/*.scss", scssTask);
  watch("../dev/**/*.js", jsTask);
}

exports.default = series(
  copyPhtml,
  copyPhp,
  copyJson,
  copyImages,
  scssTask,
  jsTask,
  watchTask
);

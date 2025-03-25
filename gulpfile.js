import path from "path";
import fs from "fs";
import { glob } from "glob";
import { src, dest, watch, series } from "gulp";
import * as dartSass from "sass";
import gulpSass from "gulp-sass";
import terser from "gulp-terser";
import sharp from "sharp";

const sass = gulpSass(dartSass);

/* objeto que indica la ubicacion de los archivos a comprimir, le indicamos 
   donde estaran los archivos css y donde estaran los archivos js 
*/
const paths = {
  scss: "src/scss/**/*.scss",
  js: "src/js/**/*.js",
};

// funcion que procesa y comprime los archivos css
export function css(done) {
  src(paths.scss, { sourcemaps: true })
    .pipe(
      sass({
        outputStyle: "compressed",
      }).on("error", sass.logError)
    )
    .pipe(dest("./public/build/css", { sourcemaps: "." }));
  done();
}

// funcion que procesa y comprime los archivos js
export function js(done) {
  src(paths.js).pipe(terser()).pipe(dest("./public/build/js"));
  done();
}

export async function imagenes(done) {
  // ruta donde estan las imagenes a comprimir
  const srcDir = "./src/img";
  // ruta donde se guardaran dichas imagenes despues de la compresion
  const buildDir = "./public/build/img";
  const images = await glob("./src/img/**/*");

  images.forEach((file) => {
    // sacamos la ruta relativa
    const relativePath = path.relative(srcDir, path.dirname(file));
    // unimos las ruta
    const outputSubDir = path.join(buildDir, relativePath);
    procesarImagenes(file, outputSubDir);
  });
  done();
}

function procesarImagenes(file, outputSubDir) {
  if (!fs.existsSync(outputSubDir)) {
    fs.mkdirSync(outputSubDir, { recursive: true });
  }
  const baseName = path.basename(file, path.extname(file));
  const extName = path.extname(file);

  if (extName.toLowerCase() === ".svg") {
    // If it's an SVG file, move it to the output directory
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
    fs.copyFileSync(file, outputFile);
  } else {
    // For other image formats, process them with sharp
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
    const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`);
    const outputFileAvif = path.join(outputSubDir, `${baseName}.avif`);
    const options = { quality: 80 };

    sharp(file).jpeg(options).toFile(outputFile);
    sharp(file).webp(options).toFile(outputFileWebp);
    sharp(file).avif().toFile(outputFileAvif);
  }
}

export function dev() {
  watch(paths.scss, css);
  watch(paths.js, js);
  watch("src/img/**/*.{png,jpg}", imagenes);
}
/* opcion a cambiar
export function dev() {
    watch( paths.scss, css );
    watch( paths.js, js );
    watch('src/img/*.{png,jpg}', imagenes)
}
*/

/* opcion original*/
//export function dev() {
//  watch(paths.scss, css);
//  watch(paths.js, js);
//  watch("src/img/**/*.{png,jpg}", imagenes);
//}

export default series(js, css, imagenes, dev);

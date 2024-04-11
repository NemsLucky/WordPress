// @ts-check
const { resolve } = require("path");
const { build } = require("esbuild");
const {sassPlugin} = require("esbuild-sass-plugin");
const postCssPlugin  = require("esbuild-style-plugin");

const dev = process.env.NODE_ENV !== "production";

build({
  entryPoints: [
    {
      in: resolve(__dirname, "../src/index.ts"),
      out: resolve(__dirname, "../dist/script"),
    },
    {
      in: resolve(__dirname, "../src/styles/index.scss"),
      out: resolve(__dirname, "../dist/style"),
    },
  ],
  target: ["chrome58", "firefox57", "safari11", "edge16"],
  bundle: true,
  sourcemap: dev,
  minify: !dev,
  tsconfig: resolve(__dirname, "../tsconfig.json"),
  outdir: resolve(__dirname, "../dist"),
  plugins: [ sassPlugin(), postCssPlugin({
    postcss: {
      plugins: [require('tailwindcss'), require('autoprefixer')],
    },
  })],
});

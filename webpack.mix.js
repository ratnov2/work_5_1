const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

mix
  .js("resources/js/app.js", "public/js")
  .sass("resources/sass/app.scss", "public/css")
  .postCss("resources/css/tailwind.css", "public/css", [
    tailwindcss("./tailwind.config.js"),
  ])
  .babelConfig({
    plugins: ["@babel/plugin-syntax-dynamic-import"],
  })
  .version();

mix
  .postCss("resources/css/tailwind-admin.css", "public/css", [
    tailwindcss("./tailwind-admin.config.js"),
  ])
  .version();

mix.disableNotifications();

if (mix.inProduction()) {
  mix.version();
}

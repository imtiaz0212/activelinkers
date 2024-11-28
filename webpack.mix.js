let mix = require('laravel-mix');


mix.postCss("resources/css/app.css", "public/css", [
    require("tailwindcss"),
]).postCss("resources/css/frontend.css", "public/css", [
    require("tailwindcss"),
]);

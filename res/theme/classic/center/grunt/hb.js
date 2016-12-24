module.exports = function () {
  "use strict";

  return {
    options: {
      property: 'data.frontMatter',
      data: [
        '<%= config.templates.data %>/**/*.{js,json}'
      ],
      helpers: [
        './node_modules/handlebars-layouts/index.js',
        '<%= config.templates.helpers %>/*.js'
      ],
      partials: '<%= config.templates.partials %>/**/*.hbs',
      file: true,
      debug: false
    },
    html: {
      files: [{
        expand: true,
        cwd: '<%= config.templates.pages %>',
        src: [
        '**/*.html',
        ],
        dest: '<%= config.html %>'
      }]
    },
    hb: {
      files: [{
        expand: true,
        cwd: '<%= config.templates.pages %>',
        src: [
        '**/*.tpl',
        ],
        dest: '<%= config.html %>'
      }]
    }
  };
};

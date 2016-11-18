module.exports = function () {
  "use strict";

  return {
    options: {
      sourceMap: false,
      presets: ["es2015"],
      sourceRoot: '<%= config.source.es %>',
      moduleRoot: '',
      moduleIds: true,
      presets: ["es2015"],
      plugins: [["transform-es2015-modules-umd", {
        "globals": {
          "jquery": "jQuery",
          "GridMenu": "SectionGridMenu",
          "Menubar": "SectionMenubar",
          "PageAside": "SectionPageAside",
          "Sidebar": "SectionSidebar"
        }
      }], "external-helpers"]
    },
    js: {
      files: [{
        expand: true,
        cwd: '<%= config.source.es %>',
        src: ['**/*.js'],
        dest: '<%= config.destination.js %>'
      }]
    }
  };
};

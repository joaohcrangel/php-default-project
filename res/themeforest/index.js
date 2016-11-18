#!/usr/bin/env node
var program = require('commander');
var inquirer = require("inquirer");
var fse = require('fs-extra-promise')
var path = require('path');
var glob = require('globby');
var extend = require('extend');
var Applause = require('applause');
var pp = require('preprocess');
var requireFolderTree = require('require-folder-tree');
var treeify = require('treeify');
var Promise = require('bluebird');
var loadJsonFile = require('load-json-file');
var writeJsonFile = require('write-json-file');
// https://www.npmjs.com/package/applause

program
 .version('1.0.0')
 .parse(process.argv);

var defaults = {
  directory: 'generated',
  includeSkins: true,
  includeSource: true,
  includeExamples: true
};

var questions = [
  {
    type: "input",
    name: "directory",
    message: "Which directory do you want generated to",
    default: defaults.directory,
    validate: function( value ) {
      if(fse.existsSync(value)){
        return 'The directory ' + value + ' exists. Please remove the directory. Or typping another directory.';
      }
      return true;
    },
  },
  {
    type: "list",
    name: "style",
    message: "Which style?",
    choices: [ {
      name: "Classic",
      value: 'classic'
    },{
      name: "Material",
      value: 'material',
      checked: true
    }],
    validate: function( answer ) {
      if ( answer.length < 1 ) {
        return "You must choose at least one.";
      }
      return true;
    }
  },
  {
    type: "list",
    name: "layout",
    message: "Which layout?",
    choices: [
      {
        name: "Base",
        value: 'base',
        checked: true
      },
      {
        name: "Center",
        value: 'center'
      },
      {
        name: "Iconbar",
        value: 'iconbar'
      },
      {
        name: "Mmenu",
        value: 'mmenu'
      },
      {
        name: "Topbar",
        value: 'topbar'
      },
      {
        name: "Topicon",
        value: 'topicon'
      }
    ]
  },
  {
    type: "list",
    name: "buildSystem",
    message: "Which build system",
    choices: [
      {
        name: "Grunt",
        value: 'grunt',
        checked: true
      },
      {
        name: "Gulp",
        value: 'gulp'
      },
      {
        name: "None",
        value: 'none'
      }
    ]
  },
  {
    type: "confirm",
    name: "includeSkins",
    message: "Use skins?",
    default: defaults.includeSkins
  },
  {
    type: "confirm",
    name: "includeExamples",
    message: "Include examples files?",
    default: defaults.includeExamples
  },
  {
    type: "confirm",
    name: "includeSource",
    message: "Include Source files?",
    when: function( answers ) {
      return answers.buildSystem === 'none';
    },
    default: defaults.includeSource
  },
  {
    type: "checkbox",
    name: "includeSources",
    message: "What sources to include?",
    choices: function(answers){
      var choices = [
        {
          name: "Javascript",
          value: 'js',
          checked: true
        },
        {
          name: "Sass",
          value: 'css',
          checked: true
        },
        {
          name: "Vendor's sass",
          value: 'vendor',
          checked: false
        },
        {
          name: "Fonts's sass",
          value: 'fonts',
          checked: false
        },
        {
          name: "Html layout system",
          value: 'html',
          checked: true
        }
      ];

      if(answers.includeSkins) {
        choices.push({
          name: "Skins's sass",
          value: 'skins',
          checked: true
        });
      }

      if(answers.includeExamples) {
        choices.push({
          name: "Examples's javascript & sass",
          value: 'examples',
          checked: true
        });
      }

      return choices;
    },
    when: function( answers ) {
      return answers.includeSource !== false;
    },
    validate: function( answer ) {
      if ( answer.indexOf('css') == -1 && answer.indexOf('skins') != -1 ) {
        return "You must choose 'Sass' as Skins's sass dependency.";
      }

      if ( answer.indexOf('css') == -1 && answer.indexOf('examples') != -1 ) {
        return "You must choose 'Sass' as Examples's dependency.";
      }

      if ( answer.indexOf('js') == -1 && answer.indexOf('examples') != -1 ) {
        return "You must choose 'Javascript' as Examples's dependency.";
      }

      if ( answer.indexOf('css') == -1 && answer.indexOf('vendor') != -1 ) {
        return "You must choose 'Sass' as Vendor's dependency.";
      }

      if ( answer.indexOf('css') == -1 && answer.indexOf('fonts') != -1 ) {
        return "You must choose 'Sass' as Fonts's dependency.";
      }

      if ( answer.indexOf('html') == -1 && answer.indexOf('examples') != -1 ) {
        return "You must choose 'Html layout system' as Examples's dependency.";
      }

      return true;
    }
  }
];

inquirer.prompt( questions).then(function( answers ) {
  answers = extend(defaults, answers);

  var sourcePath = path.join(answers.style, answers.layout);
  var destPath = answers.directory;
  var globalPath = path.join(answers.style, 'global');

  /**
   * Global
   */
  var globalAssets = [
    'css',
    'fonts',
    'js',
    'vendor',
  ];

  if(answers.includeExamples) {
    globalAssets = globalAssets.concat([
      'photos',
      'portraits'
    ]);
  }

  glob(globalAssets, {
    cwd: globalPath
  }).then(function(filePaths){
    filePaths.forEach(function(filePath){
      fse.copySync(path.join(globalPath, filePath), path.join(destPath, 'assets', filePath));
    });
  });

  var globalSource = [];

  if(answers.includeSource) {
    if(answers.includeSources.indexOf('js') == -1) {
      globalSource = globalSource.concat([
        '!src/js/**/*',
        '!src/es/**/*',
      ]);
    } else {
      globalSource = globalSource.concat([
        'src/js/**/*',
        'src/es/**/*',
        'plugins.json'
      ]);
    }

    if(answers.includeSources.indexOf('css') == -1) {
      globalSource = globalSource.concat([
        '!src/scss/**/*',
      ]);
    } else {
      globalSource = globalSource.concat([
        'src/scss/**/*',
      ]);
    }

    if(answers.includeSources.indexOf('skins') == -1) {
      globalSource = globalSource.concat([
        '!src/skins/**/*',
      ]);
    } else {
      globalSource = globalSource.concat([
        'src/skins/**/*',
      ]);
    }

    if(answers.includeSources.indexOf('vendor') == -1) {
      globalSource = globalSource.concat([
        '!src/vendor/**/*',
      ]);
    } else {
      globalSource = globalSource.concat([
        'src/vendor/**/*',
      ]);
    }

    if(answers.includeSources.indexOf('fonts') == -1) {
      globalSource = globalSource.concat([
        '!src/fonts/**/*',
      ]);
    } else {
      globalSource = globalSource.concat([
        'src/fonts/**/*',
      ]);
    }

    glob(globalSource, {
      cwd: globalPath
    }).then(function(filePaths){
      filePaths.forEach(function(filePath){
        fse.copySync(path.join(globalPath, filePath), path.join(destPath, filePath));
      });


      /**
       * Layout
       */
      var patterns = [
        '.editorconfig',
        '.gitattributes',
        '.gitignore',
        'assets/css/**/*',
        'assets/js/**/*',
        'assets/images/**/*'
      ];

      if(answers.includeSource) {
        patterns = patterns.concat([
          '.csscomb.json',
          '.csslintrc',
          '.jshintrc',
          'bower.json',
          'color.yml',
        ]);
      }

      if(answers.includeExamples) {
        patterns = patterns.concat([
          'assets/examples/css/**/*',
          'assets/examples/images/**/*',
          //'assets/data/**/*',
        ]);
      } else {
        patterns = patterns.concat([
          '!html/**/*',
          '!assets/examples/css/**/*',
          '!assets/examples/images/**/*',
          '!assets/data/**/*',
        ]);
      }

      if(answers.includeSkins) {
        patterns = patterns.concat([
          'assets/skins/**/*',
        ]);
      } else {
        patterns = patterns.concat([
          '!assets/skins/**/*',
        ]);
      }

      if(answers.includeSource) {
        if(answers.includeSources.indexOf('js') == -1) {
          patterns = patterns.concat([
            '!src/js/**/*',
            '!src/es/**/*',
          ]);
        } else {
          patterns = patterns.concat([
            'src/js/**/*',
            'src/es/**/*',
          ]);
        }

        if(answers.includeSources.indexOf('css') == -1) {
          patterns = patterns.concat([
            '!src/scss/**/*',
          ]);
        } else {
          patterns = patterns.concat([
            'src/scss/**/*',
          ]);
        }

        if(answers.includeSources.indexOf('skins') == -1) {
          patterns = patterns.concat([
            '!src/skins/**/*',
          ]);
        } else {
          patterns = patterns.concat([
            'src/skins/**/*',
          ]);
        }

        if(answers.includeSources.indexOf('html') == -1) {
          patterns = patterns.concat([
            '!src/templates/**/*',
          ]);
        } else {
          // patterns = patterns.concat([
          //   'src/templates/**/*',
          // ]);
        }

        if(answers.includeSources.indexOf('examples') == -1) {
          patterns = patterns.concat([
            '!src/examples/scss/**/*',
            '!src/templates/pages/*/*',
          ]);
        } else {
          patterns = patterns.concat([
            'src/examples/scss/**/*',
            'src/examples/js/**/*'
            //'src/templates/pages/*/*',
          ]);
        }
      }

      glob(patterns, {
        cwd: sourcePath
      }).then(function(files){
        files.forEach(function(file){
          var filePath = path.join(sourcePath, file);
          if(!fse.lstatSync(filePath).isDirectory()){
            fse.copySync(filePath, path.join(destPath, file));
          }
        });
      });
    });
  }



  var replaceCopy = function(file, applause) {
    var filePath = path.join(sourcePath, file);

    if(!fse.lstatSync(filePath).isDirectory()){
      var content = fse.readFileSync(filePath, 'utf8');
      var result = applause.replace(content).content;

      if (result === false ){
        result = content;
      }

      fse.outputFileSync(path.join(destPath, file), result);
    }
  }

  var replace_patterns = ['html/**/*'];

  if(answers.includeExamples) {
    replace_patterns = replace_patterns.concat([
      'assets/data/**/*',
      'assets/examples/js/**/*',
    ]);
  }

  if(answers.includeSource) {
    if(answers.includeSources.indexOf('examples') == -1) {
      replace_patterns = replace_patterns.concat([
        'src/examples/js/**/*',
      ]);
    }
  }

  var applause = Applause.create({
    patterns: [
      {
        match: '../global/css',
        replacement: 'assets/css'
      },
      {
        match: '../global/fonts',
        replacement: 'assets/fonts'
      },
      {
        match: '../global/photos',
        replacement: 'assets/photos'
      },
      {
        match: '../global/js',
        replacement: 'assets/js'
      },
      {
        match: '../global/portraits',
        replacement: 'assets/portraits'
      },
      {
        match: '../global/vendor',
        replacement: 'assets/vendor'
      }
    ],
    usePrefix: false
  });

  glob(replace_patterns, {
    cwd: sourcePath
  }).then(function(files){
    files.forEach(function(file){
      replaceCopy(file, applause);
    });
  });

  if(answers.includeSource) {
    var applause_src = Applause.create({
      patterns: [
        {
          match: '{{global}}',
          replacement: '{{assets}}'
        }
      ],
      usePrefix: false
    });

    var template_patterns = [];

    if(answers.includeSources.indexOf('html') == -1) {
      template_patterns = template_patterns.concat([
        '!src/templates/**/*',
      ]);
    } else {
      template_patterns = template_patterns.concat([
        'src/templates/**/*',
      ]);
    }

    if(answers.includeSources.indexOf('examples') == -1) {
      template_patterns = template_patterns.concat([
        '!src/templates/pages/*/*',
      ]);
    } else {
      template_patterns = template_patterns.concat([
        'src/templates/pages/*/*',
      ]);
    }

    glob(template_patterns, {
      cwd: sourcePath
    }).then(function(files){
      files.forEach(function(file){
        replaceCopy(file, applause_src);
      });
    });
  }

  if(answers.buildSystem !== 'none') {
    var buildSource = '.src';
    var context = {};

    if(answers.includeSources.indexOf('js') !== -1) {
      context.processJs = true;
      context.processLint = true;
    }
    if(answers.includeSources.indexOf('css') !== -1) {
      context.processCss = true;
      context.processLint = true;
    }

    if(answers.includeSources.indexOf('skins') !== -1) {
      context.processSkins = true;
    }
    if(answers.includeSources.indexOf('html') !== -1) {
      context.processHtml = true;
    }
    if(answers.includeSources.indexOf('examples') !== -1) {
      context.processExamples = true;
    }
    if(answers.includeSources.indexOf('vendor') !== -1) {
      context.processVendor = true;
    }
    if(answers.includeSources.indexOf('fonts') !== -1) {
      context.processFonts = true;
    }

    var preprocessCopy = function(srcFile, destFile, options){
      if(typeof destFile === 'object') {
        options = destFile;
        destFile = srcFile;
      }
      if(typeof destFile === 'undefined') {
        destFile = srcFile;
      }

      return fse.copyAsync(path.join(buildSource, srcFile), path.join(destPath, destFile)).then(function(){
        pp.preprocessFileSync(path.join(destPath, destFile), path.join(destPath, destFile), context, options);
      });
    }

    var justCopy = function(srcFile, destFile) {
      if(typeof destFile === 'undefined') {
        destFile = srcFile;
      }
      return fse.copy(path.join(buildSource, srcFile), path.join(destPath, destFile));
    }

    switch(answers.buildSystem){
      case 'grunt':
        preprocessCopy('package.json.grunt', 'package.json', {type: 'js'});
        preprocessCopy('Gruntfile.js');
        preprocessCopy('npm-shrinkwrap.json');

        preprocessCopy(path.join('grunt', 'clean.js'));

        if(context.processHtml) {
          preprocessCopy(path.join('grunt', 'bootlint.js'));
          preprocessCopy(path.join('grunt', 'hb.js'));
          preprocessCopy(path.join('grunt', 'htmllint.js'));
          preprocessCopy(path.join('grunt', 'prettify.js'));
        }

        if(context.processJs || context.processExamples){
          preprocessCopy(path.join('grunt', 'concat.js'));
          preprocessCopy(path.join('grunt', 'babel.js'));
          preprocessCopy(path.join('grunt', 'uglify.js'));
          preprocessCopy(path.join('grunt', 'jshint.js'));
          preprocessCopy('.babelrc');
        }

        if(context.processCss || context.processExamples || context.processSkins || context.processVendor || context.processFonts) {
          preprocessCopy(path.join('grunt', 'autoprefixer.js'));
          preprocessCopy(path.join('grunt', 'csscomb.js'));
          preprocessCopy(path.join('grunt', 'csslint.js'));
          preprocessCopy(path.join('grunt', 'cssmin.js'));
          preprocessCopy(path.join('grunt', 'sass.js'));
        }

        preprocessCopy(path.join('grunt', 'notify.js'));

        break;
      case 'gulp':
        preprocessCopy('package.json.gulp', 'package.json', {type: 'js'});
        preprocessCopy('gulpfile.js');
        justCopy(path.join('gulp', 'utils'));

        if(context.processHtml) {
          justCopy(path.join('gulp', 'options', 'html.js'));
          justCopy(path.join('gulp', 'recipes', 'html'));
        }

        if(context.processExamples) {
          justCopy(path.join('gulp', 'options', 'examples.js'));
          justCopy(path.join('gulp', 'recipes', 'examples'));
        }

        if(context.processSkins) {
          justCopy(path.join('gulp', 'options', 'skins.js'));
          justCopy(path.join('gulp', 'recipes', 'skins'));
        }

        if(context.processFonts) {
          justCopy(path.join('gulp', 'options', 'fonts.js'));
          justCopy(path.join('gulp', 'recipes', 'fonts'));
        }

        if(context.processVendor) {
          justCopy(path.join('gulp', 'options', 'vendor.js'));
          justCopy(path.join('gulp', 'recipes', 'vendor'));
        }

        if(context.processJs) {
          justCopy(path.join('gulp', 'options', 'scripts.js'));
          justCopy(path.join('gulp', 'recipes', 'scripts'));

          justCopy(path.join('gulp', 'options', 'jshint.js'));
          justCopy(path.join('gulp', 'recipes', 'jshint.js'));
          preprocessCopy('.babelrc');
        }

        if(context.processCss) {
          justCopy(path.join('gulp', 'options', 'styles.js'));
          justCopy(path.join('gulp', 'recipes', 'styles'));

          justCopy(path.join('gulp', 'options', 'csslint.js'));
          justCopy(path.join('gulp', 'recipes', 'csslint.js'));
        }

        break;
    }


    var configObj = {
      "assets": "assets",
      "destination": {},
      "source": {}
    };
    if(context.processHtml) {
      configObj.html = "html";
      configObj.templates = {
        "data": "src/templates/data",
        "helpers": "src/templates/helpers",
        "partials": "src/templates/partials",
        "pages": "src/templates/pages"
      }

    }

    if(context.processCss) {
      configObj.destination.css = "assets/css";
      configObj.source.sass = "src/scss";
      configObj.bootstrap = {
        "sass": "src/scss/bootstrap",
        "mixins": "src/scss/mixins"
      };
      configObj.autoprefixerBrowsers = [
        "Android 2.3",
        "Android >= 4",
        "Chrome >= 20",
        "Firefox >= 24",
        "Explorer >= 8",
        "iOS >= 6",
        "Opera >= 12",
        "Safari >= 6"
      ];
    }

    if(context.processJs) {
      configObj.destination.js = "assets/js";
      configObj.source.js = "src/js";
      configObj.source.es = "src/es";
    }

    if(context.processSkins) {
      configObj.destination.skins = "assets/skins";
      configObj.source.skins = "src/skins";
    }

    if(context.processExamples) {
      configObj.destination.examples = "assets/examples";
      configObj.source.examples = "src/examples";
    }

    if(context.processFonts) {
      configObj.destination.fonts = "assets/fonts";
      configObj.source.fonts = "src/fonts";
    }

    if(context.processVendor) {
      configObj.destination.vendor = "assets/vendor";
      configObj.source.vendor = "src/vendor";
    }

    writeJsonFile(path.join(destPath, 'config.json'), configObj);

    // console.log(
    //   treeify.asTree(requireFolderTree(destPath), true)
    // );
  }

  console.log('Success');
});

// config
var config = require('../../config.json');
var styles = require('./styles');

styles.sass.includePaths = [
  config.source.skins + '/scss',
  config.global.skins,
  config.source.sass,
  config.global.sass,
  config.bootstrap.sass,
  config.bootstrap.mixins
];

module.exports = styles;

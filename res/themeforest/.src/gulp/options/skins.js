// config
var config = require('../../config.json');
var styles = require('./styles');

styles.sass.includePaths = [
  config.source.skins + '/scss',
  config.source.sass,
  config.bootstrap.sass,
  config.bootstrap.mixins
];

module.exports = styles;

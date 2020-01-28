'use strict';

const HtmlWebpackPlugin = require("html-webpack-plugin");
const path = require('path');

const htmlPlugin = (baseDir) => {
  return new HtmlWebpackPlugin({
    template: path.resolve(baseDir, "!!handlebars-loader!public/html/index.hbs"),
    inject: false,
    hash: true
  })
};

module.exports = htmlPlugin;

'use strict';

const HtmlWebpackPlugin = require('html-webpack-plugin');
const path = require('path');

const htmlPlugin = (baseDir) => {
  return new HtmlWebpackPlugin({
    template: '!!handlebars-loader!' + path.resolve(baseDir, 'public/html/index.handlebars'),
    inject: true,
    hash: true,
    xhtml: true,
    meta: {
      viewport: 'width=device-width, initial-scale=1, shrink-to-fit=no'
    },
    title: 'Scuba Diving'
  })
};

module.exports = htmlPlugin;

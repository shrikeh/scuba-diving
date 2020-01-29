'use strict';

const htmlPlugin = require('./plugins/html-webpack-plugin');
const cspHtmlWebpackPlugin = require('./plugins/content-security-policy');
const subresourceIntegrityPlugin = require('./plugins/subresource-integrity');

export default (baseDir) => {
  return [
    htmlPlugin(baseDir),
    cspHtmlWebpackPlugin(),
    subresourceIntegrityPlugin
  ];
};

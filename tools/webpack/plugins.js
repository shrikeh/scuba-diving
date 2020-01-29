'use strict';

const htmlPlugin = require('./plugins/html-webpack-plugin');
const cspHtmlWebpackPlugin = require('./plugins/content-security-policy');
const subresourceIntegrityPlugin = require('./plugins/subresource-integrity');
const ResourceHintWebpackPlugin = require('resource-hints-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

export default (baseDir) => {
  return [
    htmlPlugin(baseDir),
    cspHtmlWebpackPlugin(),
    subresourceIntegrityPlugin,
    new ResourceHintWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: "[name]-styles.css",
      chunkFilename: "[id].css"
    })
  ];
};

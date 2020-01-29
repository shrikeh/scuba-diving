'use strict';

const path = require('path');
const htmlPlugin = require('./plugins/html-webpack-plugin');
const cspHtmlWebpackPlugin = require('./plugins/content-security-policy');
const subresourceIntegrityPlugin = require('./plugins/subresource-integrity');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const FaviconsWebpackPlugin = require('favicons-webpack-plugin');

export default (baseDir) => {
  return [
    htmlPlugin(baseDir),
    new FaviconsWebpackPlugin(path.resolve(baseDir, 'public/img/icon.png')),
    cspHtmlWebpackPlugin(),
    subresourceIntegrityPlugin,
    new MiniCssExtractPlugin({
      filename: "[name]-styles.css",
      chunkFilename: "[id].css"
    })
  ];
};

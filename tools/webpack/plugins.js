"use strict";

const htmlPlugin = require("./plugins/html-webpack-plugin");
const cspHtmlWebpackPlugin = require("./plugins/content-security-policy");
const subresourceIntegrityPlugin = require("./plugins/subresource-integrity");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const favicon = require("./plugins/favicon");

export default (baseDir) => {
  return [
    htmlPlugin(baseDir),
    favicon(baseDir),
    //cspHtmlWebpackPlugin(),
    subresourceIntegrityPlugin,
    new MiniCssExtractPlugin({
      filename: "css/[name]-styles.css",
      chunkFilename: "css/[name][id].css"
    })
  ];
};

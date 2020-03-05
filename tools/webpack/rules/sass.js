"use strict";

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const autoprefixer = require("autoprefixer");

module.exports = {
  test: /\.(scss|css)$/,
  use: [
    { loader: "cache-loader" },
    MiniCssExtractPlugin.loader,
    {
      loader: "css-loader",
      options: {
        sourceMap: true
      }
    },
    {
      loader: "postcss-loader",
      options: {
        autoprefixer: {
          browsers: ["last 2 versions"]
        },
        sourceMap: true,
        plugins: () => [
          autoprefixer
        ]
      },
    },
    {
      loader: "sass-loader",
      options: {
        sourceMap: true
      }
    }
  ]
};

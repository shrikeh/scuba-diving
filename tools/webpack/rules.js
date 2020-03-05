"use strict";

const htmlLoader = require("./rules/html-loader");
const imageWebPackLoader = require("./rules/image-webpack-loader");
const sassLoader = require("./rules/sass");

export default () => {
  return [
    htmlLoader,
    {
      test: /\.tsx$/,
      use: [
        { loader: "cache-loader" },
        {
          loader: "babel-loader",
          options: {
            cacheDirectory: true
          }
        },
        { loader: "ts-loader" }
      ]
    },
    {
      test: /\.ts$/,
      exclude: /node_modules/,
      use: [
        { loader: "cache-loader" },
        { loader: "awesome-typescript-loader" }
      ]
    },
    {
      test: /\.jsx?$/,
      exclude: /node_modules/,
      use: {
        loader: "babel-loader",
        options: {
          cacheDirectory: true,
          cacheCompression: false,
          envName: "development"
        }
      }
    },
    { test: /\.handlebars$/, loader: "handlebars-loader" },
    imageWebPackLoader,
    sassLoader,
    // All output ".js' files will have any sourcemaps re-processed by 'source-map-loader".
    {
      enforce: "pre",
      test: /\.js$/,
      loader: "source-map-loader"
    }
  ]
};

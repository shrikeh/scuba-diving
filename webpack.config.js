'use strict';

const path = require('path');

const htmlLoader = require('./tools/webpack/rules/html-loader');
const imageWebPackLoader = require('./tools/webpack/rules/image-webpack-loader');

import plugins from './tools/webpack/plugins';


module.exports = {
  mode: 'development',
  entry: path.resolve(__dirname, 'public/js/src/index.tsx'),
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'js/bundle.js',
    publicPath: "/",
    crossOriginLoading: 'anonymous'
  },
  // Enable sourcemaps for debugging webpack's output.
  devtool: "source-map",

  resolve: {
    alias: {
      '@app': path.resolve(__dirname, 'public/js/src')
    },
    // Add '.ts' and '.tsx' as resolvable extensions.
    extensions: ['.ts', '.tsx', '.js', '.jsx']
  },

  module: {
    rules: [
      htmlLoader,
      {
        test: /\.tsx$/,
        loader: 'babel-loader!ts-loader',
      },
      {
        test: /\.ts$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'awesome-typescript-loader'
          }
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
            envName: 'development'
          }
        }
      },
      imageWebPackLoader,
      // All output '.js' files will have any sourcemaps re-processed by 'source-map-loader'.
      {
        enforce: 'pre',
        test: /\.js$/,
        loader: 'source-map-loader'
      }
    ]
  },
  plugins: plugins(__dirname)
};

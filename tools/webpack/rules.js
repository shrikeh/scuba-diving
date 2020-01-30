'use strict';

const htmlLoader = require('./rules/html-loader');
const imageWebPackLoader = require('./rules/image-webpack-loader');
const sassLoader = require('./rules/sass');

export default () => {
  return [
    htmlLoader,
    {
      test: /\.tsx$/,
      use: [
        { loader: 'babel-loader' },
        { loader: 'ts-loader' },
        { loader: 'cache-loader' }
      ]
    },
    {
      test: /\.ts$/,
      exclude: /node_modules/,
      use: [
        { loader: 'awesome-typescript-loader' },
        { loader: 'cache-loader' }
      ]
    },
    {
      test: /\.jsx?$/,
      exclude: /node_modules/,
      use: {
        loader: 'babel-loader',
        options: {
          cacheDirectory: true,
          cacheCompression: false,
          envName: 'development'
        }
      }
    },
    imageWebPackLoader,
    sassLoader,
    // All output '.js' files will have any sourcemaps re-processed by 'source-map-loader'.
    {
      enforce: 'pre',
      test: /\.js$/,
      loader: 'source-map-loader'
    }
  ]
};

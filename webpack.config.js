'use strict';

const path = require('path');

import rules from './tools/webpack/rules';
import plugins from './tools/webpack/plugins';

module.exports = {
  mode: 'development',
  entry: path.resolve(__dirname, 'public/js/src/index.tsx'),
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'js/[name].[contenthash].js',
    publicPath: "/",
    crossOriginLoading: 'anonymous'
  },
  optimization: {
    moduleIds: 'hashed',
    runtimeChunk: 'single',
    splitChunks: {
      cacheGroups: {
        styles: {
          name: 'styles',
          test: /\.css$/,
          chunks: 'all',
          enforce: true,
        },
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendors',
          chunks: 'all',
        },
      },
    },
  },
  // Enable sourcemaps for debugging webpack's output.
  //devtool: "source-map",
  resolve: {
    alias: {
      'scss/main.scss': path.resolve(__dirname, 'public/scss/main.scss'),
      '@app': path.resolve(__dirname, 'public/js/src')
    },
    // Add '.ts' and '.tsx' as resolvable extensions.
    extensions: ['.ts', '.tsx', '.js', '.jsx']
  },

  module: {
    rules: rules(__dirname)
  },
  plugins: plugins(__dirname)
};

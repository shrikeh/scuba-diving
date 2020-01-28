'use strict';

module.exports = {
  test: /\.html$/,
    use: [
  // apply multiple loaders and options
  "htmllint-loader",
  {
    loader: "html-loader"
  }
]};

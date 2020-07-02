"use strict";

const cspHtmlWebpackPlugin = require("csp-html-webpack-plugin");

module.exports = () => {
  return new cspHtmlWebpackPlugin({
    "base-uri": "self",
    "object-src": "none",
    "script-src": ["unsafe-inline", "self", "unsafe-eval"],
    "style-src": ["unsafe-inline", "self", "unsafe-eval"]
  }, {
    enabled: true,
    hashingMethod: "sha256",
    hashEnabled: {
      "script-src": true,
      "style-src": true
    },
    nonceEnabled: {
      "script-src": true,
      "style-src": true
    }
  });
};

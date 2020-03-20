"use strict";

const { resolve } = require("path");
const { defaults } = require("jest-config");

const jestTestPath = resolve(__dirname, "tests/jest");

module.exports = {
  verbose: true,
  bail: true,
  moduleFileExtensions: [...defaults.moduleFileExtensions, "ts", "tsx"],
  rootDir: __dirname,
  roots: [
    "public/js/src",
  ],
  testMatch: [
    "**/*.test.[jt]s?(x)"
  ],
  transform: {
    "^.+\\.tsx?$": "ts-jest"
  },
  setupFiles: [
    resolve(jestTestPath, "bootstrap.ts")
  ],
  setupFilesAfterEnv: [
    "@testing-library/jest-dom/extend-expect"
  ],
  "automock": false
};

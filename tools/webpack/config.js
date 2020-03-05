"use strict";

const fs = require("fs");
const path = require("path");
const directoryPath = path.resolve(__dirname, "configs");

export const configurator = (baseDir, webpack) => {

  fs.readdir(directoryPath, function (err, configs) {
    //handling error
    if (err) {
      return console.log("Unable to scan directory: " + err);
    }
    //listing all files using forEach
    configs.forEach(function (configFile) {
      // Do whatever you want to do with the file
      let config = require(configFile);

      config(baseDir, webpack);
    });
  });

  return webpack;
};



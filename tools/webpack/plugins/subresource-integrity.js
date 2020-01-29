'use strict';

import SriPlugin from 'webpack-subresource-integrity';

module.exports = new SriPlugin({
  hashFuncNames: ['sha256', 'sha384'],
  // enabled: process.env.NODE_ENV === 'production',
  enabled: true
});

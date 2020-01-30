'use strict';

import * as React from "react";
import { render } from "react-dom";
import CssBaseline from '@material-ui/core/CssBaseline';
import { ThemeProvider } from '@material-ui/core/styles';
import { Item } from "@app/components/Kit/Item";
import theme from './theme';

import 'scss/main.scss';

render(
  <ThemeProvider theme={theme}>
  {/* CssBaseline kickstart an elegant, consistent, and simple baseline to build upon. */}
  <CssBaseline />
  <Item />
  </ThemeProvider>,
  document.querySelector('#scuba-diving')
);

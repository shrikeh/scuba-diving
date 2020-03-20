"use strict";

import * as React from "react";
import { render } from "react-dom";
import CssBaseline from "@material-ui/core/CssBaseline";
import { ThemeProvider } from "@material-ui/core/styles";

import { Provider } from 'react-redux';

import theme from "@app/theme";
import { store } from '@app/store';

import "scss/main.scss";
import { App } from "@app/components/App";

const store = ;

render(
  <Provider store={store}>
    <ThemeProvider theme={theme}>
      {/* CssBaseline kickstart an elegant, consistent, and simple baseline to build upon. */}
      <CssBaseline />
      <App />
    </ThemeProvider>
  </Provider>,
  document.querySelector("#scuba-diving")
);

"use strict";

import { createStore, applyMiddleware } from "redux";

import thunk from "redux-thunk";
import createLogger from "redux-logger";
import Reducers from "@app/reducers/root";

const loggerMiddleware = createLogger();

export function store(initState) {
  return createStore(
    Reducers,
    initState,
    applyMiddleware(
      loggerMiddleware,
      thunk
    )
  )
}
